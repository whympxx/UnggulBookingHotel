<?php
session_start();
// Ganti cara ambil agent_id sesuai sistem login kamu
$agent_id = $_SESSION['agent_id'] ?? 'AGENT1'; // Default AGENT1 untuk testing

$data = [];
if (file_exists('orders_data.json')) {
    $json = file_get_contents('orders_data.json');
    $data = json_decode($json, true);
}

$hotels = [];
$booked_rooms = [];
foreach ($data as $item) {
    if ($item['agent_id'] === $agent_id) {
        // Riwayat hotel: unik per hotel
        $found = false;
        foreach ($hotels as $h) {
            if ($h['hotel_name'] === $item['hotel_name']) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $hotels[] = [
                'hotel_name' => $item['hotel_name'],
                'location' => $item['location'],
                'description' => $item['description'],
                'hotel_image' => $item['hotel_image']
            ];
        }
        // Kamar terbooking
        $booked_rooms[] = [
            'hotel_name' => $item['hotel_name'],
            'room_number' => $item['room_number'],
            'customer_name' => $item['customer_name'],
            'booking_date' => $item['booking_date']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode([
    'hotels' => $hotels,
    'booked_rooms' => $booked_rooms
]); 