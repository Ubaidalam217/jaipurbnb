<?php

namespace App\Http\Requests;

use App\Models\Amenity;
use App\Models\Property;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

/**
 * New listing submission.
 *
 * This is the first place the Property value constants become
 * load-bearing: neighborhood and stay_type are plain string columns
 * with no DB constraint, so Rule::in() here is the only thing keeping
 * junk out of them.
 *
 * host_id, listing_status, is_verified, is_visible and max_guests are
 * deliberately NOT accepted from input - the controller sets them.
 * max_guests in particular is derived from max_adults + max_children
 * (infants do not count), never trusted from the client.
 */
class PropertyStoreRequest extends FormRequest
{
    public const MAX_PHOTOS = 15;

    public function authorize(): bool
    {
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
            'max_adults'    => ['required', 'integer', 'min:1', 'max:16'],
            'max_children'  => ['required', 'integer', 'min:0', 'max:10'],
            'max_infants'   => ['required', 'integer', 'min:0', 'max:10'],
            'bedrooms'      => ['required', 'integer', 'min:1', 'max:10'],
            'bathrooms'     => ['required', 'integer', 'min:1', 'max:10'],
            'ical_feed_url' => ['nullable', 'url', 'max:255'],

            'is_pet_friendly' => ['sometimes', 'boolean'],

            'latitude'      => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'     => ['nullable', 'numeric', 'between:-180,180'],

            'full_address'  => ['required', 'string', 'max:2000'],
            'city'          => ['required', 'string', 'max:100'],
            'state'         => ['required', 'string', 'max:100'],
            'pincode'       => ['required', 'string', 'max:10'],

            'amenities'     => ['nullable', 'array'],
            'amenities.*'   => ['integer', Rule::exists(Amenity::class, 'id')],

            'photos'        => ['required', 'array', 'min:1', 'max:'.self::MAX_PHOTOS],
            'photos.*'      => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

            'cover_index'   => ['required', 'integer', 'min:0'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v) {
            $photos = $this->file('photos') ?? [];
            $index  = $this->input('cover_index');

            // cover_index must point at a photo that was actually uploaded.
            if (is_numeric($index) && count($photos) > 0 && (int) $index >= count($photos)) {
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
            'cover_index'   => 'cover photo',
            'max_adults'    => 'maximum adults',
            'max_children'  => 'maximum children',
            'max_infants'   => 'maximum infants',
            'full_address'  => 'full address',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'photos.required' => 'Please upload at least one photo of your property.',
            'photos.max'      => 'You can upload a maximum of '.self::MAX_PHOTOS.' photos.',
            'photos.*.max'    => 'Each photo must be 5 MB or smaller.',
            'photos.*.mimes'  => 'Photos must be JPG, PNG or WebP files.',
            'description.min' => 'Please write at least 20 characters describing your property.',
        ];
    }
}
