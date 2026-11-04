<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\User;
use App\Support\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Halaman "Location" admin. Versi lama menyimpan data di $_SESSION sehingga
 * perubahan hilang saat logout dan tidak muncul di halaman lain.
 */
class HotelController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.hotels', [
            'hotels' => Hotel::with('agent')->orderBy('name')->get(),
            'agents' => User::where('role', User::ROLE_AGENT)->orderBy('name')->get(),
            'editing' => $request->filled('edit') ? Hotel::find($request->integer('edit')) : null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, true);
        $hotel = Hotel::create($data);
        $hotel->roomTypes()->createMany(RoomType::DEFAULTS);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel ditambahkan.');
    }

    public function update(Request $request, Hotel $hotel): RedirectResponse
    {
        $data = $this->validated($request, false, $hotel);
        $hotel->update($data);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel diperbarui.');
    }

    public function destroy(Hotel $hotel): RedirectResponse
    {
        ImageUpload::delete($hotel->image);
        $hotel->delete();

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel dihapus.');
    }

    private function validated(Request $request, bool $creating, ?Hotel $hotel = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'location' => ['required', 'string', 'max:150'],
            'price' => ['required', 'integer', 'min:10000'],
            'rating' => ['required', 'numeric', 'between:0,5'],
            'description' => ['nullable', 'string', 'max:5000'],
            'agent_id' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'in:active,inactive'],
            'image' => [$creating ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
        ]);

        if ($request->hasFile('image')) {
            ImageUpload::delete($hotel?->image);
            $data['image'] = ImageUpload::store($request->file('image'), 'hotels');
        } else {
            unset($data['image']);
        }

        return $data;
    }
}
