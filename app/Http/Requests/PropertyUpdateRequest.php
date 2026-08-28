<?php

namespace App\Http\Requests;

use App\Models\Property;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

/**
 * Editing an existing listing.
 *
 * Differs from PropertyStoreRequest in how photos work: the host may
 * keep some existing images, delete others, and add new ones. So
 * 'photos' becomes optional and two extra fields appear:
 *
 *   existing_image_ids[] - ids of currently-stored images to KEEP
 *   cover_image_id       - id of an existing image to use as cover
 *
 * The 15-photo cap spans both sources, so it has to be checked in
 * withValidator() rather than as a rule on either field alone. The same
 * applies to "at least one photo must survive".
 */
class PropertyUpdateRequest extends FormRequest
{
    public const MAX_PHOTOS = 15;

    /**
     * Ownership is checked HERE, not only in the controller.
     *
     * Laravel resolves and validates a FormRequest before the controller
     * body runs, so a foreign host POSTing an invalid payload would
     * otherwise get a 422/redirect with validation errors - which
     * confirms the listing exists. Aborting 404 up front keeps every
     * response for someone else's listing identical to "no such thing".
     */
    public function authorize(): bool
    {
        $property = $this->route('property');

        abort_unless($property && $property->host_id === $this->user()?->id, 404);

        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'max:150'],
            'description'   => ['required', 'string', 'min:20', 'max:5000'],
            'neighborhood'  => ['required', 'string', Rule::in(Property::NEIGHBORHOODS)],
            'stay_type'     => ['required', 'string', Rule::in(Property::STAY_TYPES)],
            'approx_price'  => ['required', 'integer', 'min:100', 'max:1000000'],
            'max_guests'    => ['required', 'integer', 'min:1', 'max:20'],
            'bedrooms'      => ['required', 'integer', 'min:1', 'max:10'],
            'bathrooms'     => ['required', 'integer', 'min:1', 'max:10'],
            'ical_feed_url' => ['nullable', 'url', 'max:255'],

            'photos'        => ['nullable', 'array', 'max:'.self::MAX_PHOTOS],
            'photos.*'      => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

            'existing_image_ids'   => ['nullable', 'array'],
            'existing_image_ids.*' => ['integer'],

            'cover_image_id' => ['nullable', 'integer'],
            'cover_index'    => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v) {
            $kept = count($this->input('existing_image_ids', []));
            $new  = count($this->file('photos') ?? []);

            if ($kept + $new === 0) {
                $v->errors()->add('photos', 'A listing needs at least one photo. Upload a new one before removing them all.');
            }

            if ($kept + $new > self::MAX_PHOTOS) {
                $v->errors()->add('photos', sprintf(
                    'That would be %d photos. The maximum is %d - remove some existing photos first.',
                    $kept + $new,
                    self::MAX_PHOTOS
                ));
            }

            $index = $this->input('cover_index');
            if (is_numeric($index) && $new > 0 && (int) $index >= $new) {
                $v->errors()->add('cover_index', 'Please choose one of the uploaded photos as the cover image.');
            }
        });
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return [
            'approx_price'  => 'approximate price',
            'ical_feed_url' => 'external calendar / iCal URL',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'photos.max'      => 'You can upload a maximum of '.self::MAX_PHOTOS.' photos.',
            'photos.*.max'    => 'Each photo must be 5 MB or smaller.',
            'photos.*.mimes'  => 'Photos must be JPG, PNG or WebP files.',
            'description.min' => 'Please write at least 20 characters describing your property.',
        ];
    }
}
