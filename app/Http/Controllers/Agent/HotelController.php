<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Support\ImageUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * CRUD hotel milik agent. Versi lama: get_hotels.php tidak mendukung ?id=,
 * update_hotel.php & delete_hotel.php tidak ada, dan agent_id hotel baru
 * diisi acak ("agent_" . uniqid()) sehingga hotel tidak terhubung ke agent.
 */
class HotelController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'rating' => ['nullable', 'integer', 'between:1,5'],
        ]);

        $hotels = $request->user()->hotels()
            ->search($request->query('search'))
            ->when($request->filled('rating'), fn ($q) => $q->whereBetween('rating', [(int) $request->rating, (int) $request->rating + 0.99]))
            ->latest()
            ->get()
            ->map(fn (Hotel $h) => $this->present($h));

        return response()->json(['success' => true, 'data' => $hotels, 'total' => $hotels->count()]);
    }

    public function show(Request $request, Hotel $hotel): JsonResponse
    {
        $this->authorizeOwner($request, $hotel);

        return response()->json(['success' => true, 'data' => $this->present($hotel)]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules(imageRequired: true));
        $data['image'] = ImageUpload::store($request->file('image'), 'hotels');
        $data['status'] = 'active';

        $hotel = $request->user()->hotels()->create($data);
        $hotel->roomTypes()->createMany(RoomType::DEFAULTS);

        return response()->json([
            'success' => true,
            'message' => 'Hotel berhasil ditambahkan!',
            'data' => $this->present($hotel),
        ], 201);
    }

    public function update(Request $request, Hotel $hotel): JsonResponse
    {
        $this->authorizeOwner($request, $hotel);

        $data = $request->validate($this->rules(imageRequired: false));
        if ($request->hasFile('image')) {
            ImageUpload::delete($hotel->image);
            $data['image'] = ImageUpload::store($request->file('image'), 'hotels');
        } else {
            unset($data['image']);
        }

        $hotel->update($data);

        return response()->json(['success' => true, 'message' => 'Hotel berhasil diperbarui!', 'data' => $this->present($hotel)]);
    }

    public function destroy(Request $request, Hotel $hotel): JsonResponse
    {
        $this->authorizeOwner($request, $hotel);

        if ($hotel->bookings()->whereIn('status', ['pending', 'paid', 'confirmed'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Hotel masih memiliki pesanan aktif, tidak bisa dihapus.',
            ], 422);
        }

        ImageUpload::delete($hotel->image);
        $hotel->delete();

        return response()->json(['success' => true, 'message' => 'Hotel berhasil dihapus.']);
    }

    private function rules(bool $imageRequired): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'location' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:5000'],
            'price' => ['required', 'integer', 'min:10000'],
            'rating' => ['required', 'numeric', 'between:1,5'],
            'phone' => ['nullable', 'string', 'max:30'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
        ];
    }

    private function authorizeOwner(Request $request, Hotel $hotel): void
    {
        abort_unless($hotel->agent_id === $request->user()->id, 403, 'Hotel ini bukan milik Anda.');
    }

    private function present(Hotel $hotel): array
    {
        return [
            'id' => $hotel->id,
            'name' => $hotel->name,
            'location' => $hotel->location,
            'description' => (string) $hotel->description,
            'price' => $hotel->price,
            'price_label' => $hotel->formattedPrice(),
            'rating' => $hotel->rating,
            'phone' => $hotel->phone,
            'image' => $hotel->imageUrl(),
            'status' => $hotel->status,
        ];
    }
}
