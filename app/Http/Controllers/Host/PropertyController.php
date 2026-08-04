<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyStoreRequest;
use App\Http\Requests\PropertyUpdateRequest;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Host-facing CRUD for their own listings.
 *
 * OWNERSHIP: every action that touches a specific property routes
 * through ownedOrFail(), which 404s (not 403s) on someone else's
 * listing - a 403 would confirm the id exists.
 *
 * Photos live in storage/app/public/properties/{property_id}/ and
 * property_images.image_url stores the disk-relative path, e.g.
 * "properties/7/a1b2c3.jpg".
 */
class PropertyController extends Controller
{
    public function index(): View
    {
        $properties = auth()->user()->properties()
            ->with('coverImage')
            ->latest()
            ->get();

        return view('host.properties.index', compact('properties'));
    }

    public function create(): View
    {
        return view('host.properties.create');
    }

    public function store(PropertyStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $property = DB::transaction(function () use ($data, $request) {
            $property = auth()->user()->properties()->create([
                'title'          => $data['title'],
                'description'    => $data['description'],
                'neighborhood'   => $data['neighborhood'],
                'stay_type'      => $data['stay_type'],
                'approx_price'   => $data['approx_price'],
                'ical_feed_url'  => $data['ical_feed_url'] ?? null,
                // Set by us, never by the host:
                'listing_status' => Property::STATUS_PENDING,
                'is_verified'    => false,
                'is_visible'     => false,
            ]);

            $this->storePhotos($property, $request->file('photos', []), (int) $data['cover_index']);

            return $property;
        });

        return redirect()->route('host.properties.index')
            ->with('status', '“'.$property->title.'” was submitted for review.');
    }

    public function show(Property $property): View
    {
        $property = $this->ownedOrFail($property);
        $property->load('images');

        return view('host.properties.show', compact('property'));
    }

    public function edit(Property $property): View
    {
        $property = $this->ownedOrFail($property);
        $property->load('images');

        return view('host.properties.edit', compact('property'));
    }

    public function update(PropertyUpdateRequest $request, Property $property): RedirectResponse
    {
        $property = $this->ownedOrFail($property);
        $data = $request->validated();

        DB::transaction(function () use ($property, $request, $data) {
            $property->fill([
                'title'         => $data['title'],
                'description'   => $data['description'],
                'neighborhood'  => $data['neighborhood'],
                'stay_type'     => $data['stay_type'],
                'approx_price'  => $data['approx_price'],
                'ical_feed_url' => $data['ical_feed_url'] ?? null,
            ]);

            // A rejected listing that has been edited goes back into the
            // queue for another look, and the old reason is cleared.
            // An approved listing stays approved - see the report note.
            if ($property->listing_status === Property::STATUS_REJECTED) {
                $property->listing_status   = Property::STATUS_PENDING;
                $property->rejection_reason = null;
            }

            $property->save();

            // Delete any existing image the host did not tick to keep.
            $keepIds = $data['existing_image_ids'] ?? [];
            $removed = $property->images()->whereNotIn('id', $keepIds ?: [0])->get();
            foreach ($removed as $image) {
                Storage::disk('public')->delete($image->image_url);
                $image->delete();
            }

            $newFiles = $request->file('photos', []);
            $coverIndex = $request->filled('cover_index') ? (int) $request->input('cover_index') : null;

            if ($newFiles) {
                $this->storePhotos($property, $newFiles, $coverIndex, false);
            }

            $this->settleCover($property, $data['cover_image_id'] ?? null, $newFiles, $coverIndex);
        });

        return redirect()->route('host.properties.index')
            ->with('status', '“'.$property->title.'” was updated.');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $property = $this->ownedOrFail($property);
        $title = $property->title;

        DB::transaction(function () use ($property) {
            // Remove the whole photo folder, then the row. The
            // property_images rows go via ON DELETE CASCADE.
            Storage::disk('public')->deleteDirectory('properties/'.$property->id);
            $property->delete();
        });

        return redirect()->route('host.properties.index')
            ->with('status', '“'.$title.'” was deleted.');
    }

    /* ------------------------------------------------------------------ */

    /**
     * 404 unless the listing belongs to the signed-in host.
     */
    private function ownedOrFail(Property $property): Property
    {
        abort_unless($property->host_id === auth()->id(), 404);

        return $property;
    }

    /**
     * Persist uploaded files and create the matching image rows.
     *
     * @param  array<int, UploadedFile>  $files
     */
    private function storePhotos(Property $property, array $files, ?int $coverIndex, bool $markCover = true): void
    {
        foreach (array_values($files) as $i => $file) {
            $path = $file->store('properties/'.$property->id, 'public');

            PropertyImage::create([
                'property_id' => $property->id,
                'image_url'   => $path,
                'is_cover'    => $markCover && $coverIndex === $i,
            ]);
        }
    }

    /**
     * Guarantee exactly one cover image survives an edit.
     *
     * Priority: a newly uploaded photo the host picked > an existing
     * photo the host picked > whatever image is left first.
     *
     * @param  array<int, UploadedFile>  $newFiles
     */
    private function settleCover(Property $property, ?int $coverImageId, array $newFiles, ?int $coverIndex): void
    {
        $images = $property->images()->orderBy('id')->get();

        if ($images->isEmpty()) {
            return;
        }

        $target = null;

        if ($newFiles && $coverIndex !== null) {
            // The new uploads are the most recently inserted rows, in order.
            $target = $images->slice(-count($newFiles))->values()->get($coverIndex);
        }

        if (! $target && $coverImageId) {
            $target = $images->firstWhere('id', $coverImageId);
        }

        if (! $target) {
            $target = $images->firstWhere('is_cover', true) ?? $images->first();
        }

        $property->images()->where('id', '!=', $target->id)->update(['is_cover' => false]);
        $target->forceFill(['is_cover' => true])->save();
    }
}
