<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Promo;
use App\Models\Review;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /** Agent bawaan (sebelumnya di-hardcode di agents.php, admin_agents.php, admin_dashboard.php). */
    private const AGENTS = [
        ['name' => 'Larry Naves', 'email' => 'navesld@gmail.com', 'avatar' => 'images/larrynaves.png', 'phone' => '+62-0852-2890-7619',
            'location' => 'Perumahan Graha Blok J No 21, Bojong Rawa, Bekasi Barat, Kota Bekasi',
            'bio' => 'Dengan pengalaman lebih dari 5 tahun di industri properti dan perhotelan, Larry Naves merupakan profesional yang berfokus pada penyewaan hotel untuk kebutuhan bisnis dan pariwisata.'],
        ['name' => 'Robert', 'email' => 'robert@example.com', 'avatar' => 'images/robert.png', 'phone' => '+62-812-3456-7890',
            'location' => 'Jakarta', 'bio' => 'Seorang agen berpengalaman dengan fokus pada properti komersial.'],
        ['name' => 'Jessica', 'email' => 'jessica@example.com', 'avatar' => 'images/Jessica.png', 'phone' => '+62-812-9876-5432',
            'location' => 'Surabaya', 'bio' => 'Agen properti terkemuka di bidang perumahan mewah.'],
        ['name' => 'Jefri Nichol', 'email' => 'jefri@example.com', 'avatar' => 'images/jefrinichol.png', 'phone' => '+62-878-1122-3344',
            'location' => 'Bali', 'bio' => 'Spesialis properti liburan di Bali dan sekitarnya.'],
        ['name' => 'Marco Van Basten', 'email' => 'marco@example.com', 'avatar' => 'images/marcovanbasten.png', 'phone' => '+62-896-5544-3322',
            'location' => 'Bandung', 'bio' => 'Konsultan properti ahli untuk investasi jangka panjang.'],
    ];

    private const FACILITIES = [
        'Hotel Santika Prime' => ['Free Wi-Fi', 'Swimming Pool', 'Fitness Center', 'Restaurant'],
        'Royal Ambarrukmo' => ['Free Wi-Fi', 'Spa', 'Restaurant', 'Meeting Rooms'],
        'Hotel Novotel' => ['Free Wi-Fi', 'Swimming Pool', 'Bar', 'Family Rooms'],
        'Hotel Fairfield' => ['Beach Access', 'Outdoor Pool', 'Restaurant', 'Spa'],
        'Hotel Kempinski' => ['Luxury Spa', 'Rooftop Pool', 'Fine Dining', 'Executive Lounge'],
        'Hotel Raffles' => ['Free Wi-Fi', 'Luxury Spa', 'Fine Dining', 'Butler Service', 'Swimming Pool'],
        'The Ritz-Carlton' => ['Free Wi-Fi', 'Luxury Spa', 'Rooftop Bar', 'Swimming Pool', 'Business Center'],
    ];

    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@unggulhotel.com'], [
            'name' => 'Administrator', 'password' => 'password', 'role' => User::ROLE_ADMIN,
        ]);

        $customer = User::updateOrCreate(['email' => 'user@unggulhotel.com'], [
            'name' => 'Wahyu Marga Pratama', 'password' => 'password', 'role' => User::ROLE_USER, 'phone' => '+62 812 3456 7890',
        ]);

        $agents = [];
        foreach (self::AGENTS as $agent) {
            $agents[$agent['name']] = User::updateOrCreate(['email' => $agent['email']], $agent + [
                'password' => 'password', 'role' => User::ROLE_AGENT, 'agency' => 'Unggul Property Agency',
                'social' => ['facebook' => '#', 'instagram' => '#', 'x' => '#'],
            ]);
        }

        $data = json_decode(file_get_contents(database_path('data/hotels.json')), true);
        foreach ($data as $row) {
            $hotel = Hotel::updateOrCreate(['name' => $row['name']], [
                'agent_id' => $agents[$row['agent']]->id ?? null,
                'location' => $row['location'],
                'description' => $row['description'],
                'price' => $row['price'],
                'rating' => $row['rating'],
                'image' => $row['image'] ? 'images/'.$row['image'] : null,
                'gallery' => array_map(fn ($g) => 'images/'.$g, $row['gallery']),
                'facilities' => self::FACILITIES[$row['name']] ?? ['Free Wi-Fi', 'Restaurant', 'Swimming Pool'],
                'status' => 'active',
            ]);

            if ($hotel->roomTypes()->doesntExist()) {
                $hotel->roomTypes()->createMany(RoomType::DEFAULTS);
            }
        }

        // Contoh pesanan (dipindahkan dari orders_data.json lama)
        if (Booking::doesntExist()) {
            $samples = [
                ['Hotel Santika Prime', now()->subDays(1), now()->addDays(1), 'paid'],
                ['Hotel Fairfield', now()->addDays(5), now()->addDays(7), 'pending'],
                ['Hotel Santika Prime', now()->addDays(10), now()->addDays(18), 'pending'],
            ];
            foreach ($samples as [$name, $in, $out, $status]) {
                $hotel = Hotel::where('name', $name)->first();
                $room = $hotel->roomTypes()->first();
                Booking::create(Booking::quote($room, Carbon::parse($in), Carbon::parse($out)) + [
                    'user_id' => $customer->id,
                    'hotel_id' => $hotel->id,
                    'room_type_id' => $room->id,
                    'customer_name' => $customer->name,
                    'customer_email' => $customer->email,
                    'customer_phone' => $customer->phone,
                    'check_in' => $in->toDateString(),
                    'check_out' => $out->toDateString(),
                    'guests' => 2,
                    'status' => $status,
                ]);
            }
        }

        $this->seedPromos();
        $this->seedReviews();
    }

    private function seedPromos(): void
    {
        $promos = [
            ['code' => 'WELCOME10', 'description' => 'Diskon 10% untuk pengguna baru', 'type' => 'percent', 'value' => 10, 'max_discount' => 500000, 'min_amount' => 0],
            ['code' => 'HEMAT50K', 'description' => 'Potongan Rp 50.000 min. transaksi Rp 500.000', 'type' => 'fixed', 'value' => 50000, 'min_amount' => 500000],
            ['code' => 'LIBURAN25', 'description' => 'Diskon 25% liburan (maks. Rp 1.000.000)', 'type' => 'percent', 'value' => 25, 'max_discount' => 1000000, 'min_amount' => 2000000, 'max_uses' => 100],
        ];
        foreach ($promos as $promo) {
            Promo::updateOrCreate(['code' => $promo['code']], $promo + ['active' => true, 'expires_at' => now()->addYear()]);
        }
    }

    /** Tamu demo yang sudah menginap + ulasannya (juga mengisi grafik pendapatan). */
    private function seedReviews(): void
    {
        if (Review::exists()) {
            return;
        }

        $guests = collect([
            ['Siti Rahma', 'siti@example.com'], ['Andi Pratama', 'andi@example.com'],
            ['Dewi Lestari', 'dewi@example.com'], ['Rizky Ramadhan', 'rizky@example.com'],
        ])->map(fn ($g) => User::updateOrCreate(['email' => $g[1]], ['name' => $g[0], 'password' => 'password', 'role' => User::ROLE_USER]));

        $comments = [
            5 => ['Pelayanan luar biasa, kamar bersih dan wangi. Pasti kembali lagi!', 'Pemandangannya indah sekali, sarapan enak dan staf ramah.', 'Pengalaman menginap terbaik tahun ini, sangat direkomendasikan.'],
            4 => ['Lokasi strategis, kamar nyaman. Check-in sedikit antri.', 'Fasilitas lengkap, harga sepadan dengan kualitas.'],
            3 => ['Cukup baik, tapi AC kamar agak berisik.'],
        ];

        $i = 0;
        foreach (Hotel::with('roomTypes')->get() as $hotel) {
            foreach ($guests->shuffle()->take(2) as $guest) {
                $room = $hotel->roomTypes->first();
                $in = now()->subMonths($i % 6)->subDays(10 + $i);
                $out = $in->copy()->addDays(2);
                $booking = Booking::create(Booking::quote($room, $in, $out) + [
                    'user_id' => $guest->id, 'hotel_id' => $hotel->id, 'room_type_id' => $room->id,
                    'customer_name' => $guest->name, 'customer_email' => $guest->email, 'customer_phone' => '081200000000',
                    'check_in' => $in->toDateString(), 'check_out' => $out->toDateString(), 'guests' => 2, 'status' => 'completed',
                ]);
                $booking->forceFill(['created_at' => $in->copy()->subDays(3)])->saveQuietly();

                $rating = [5, 5, 4, 5, 4, 5][$i % 6];
                $review = Review::create([
                    'user_id' => $guest->id, 'hotel_id' => $hotel->id, 'rating' => $rating,
                    'comment' => $comments[$rating][$i % count($comments[$rating])],
                ]);
                $review->forceFill(['created_at' => $out->copy()->addDay(), 'updated_at' => $out->copy()->addDay()])->saveQuietly();
                $i++;
            }
        }
    }
}
