<?php
// Include data from admin_properties.php to get hotel information
include_once 'admin_properties.php';

// Calculate total locations (unique locations)
$locations = array_unique(array_map(function($h) { return $h['location']; }, $hotels));
$totalLocations = count($locations);

// Calculate total properties
$totalProperty = count($hotels);

// Calculate total agents (unique agents)
$agents = [];
foreach ($hotels as $hotel) {
    foreach ($hotel['rooms'] as $room) {
        if (isset($room['agent'])) {
            $agents[$room['agent']] = true;
        }
    }
}
$totalAgent = 5; // We have 5 fixed agents in the system

// Calculate total rooms and room status
$totalKamar = 36; // Total rooms as set in admin_dashboard.php
$kamarTersedia = 0;
$kamarDipakai = 0;

// Calculate available and occupied rooms
foreach ($hotels as $hotel) {
    foreach ($hotel['rooms'] as $room) {
        $kamarTersedia += $room['available'];
        $kamarDipakai += $room['occupied'];
    }
}

// Get orders data
$ordersFile = 'orders_data.json';
$orders = file_exists($ordersFile) ? json_decode(file_get_contents($ordersFile), true) : [];
$totalOrders = is_array($orders) ? count($orders) : 0;

// Prepare room data per hotel
$kamarPerHotel = [];
foreach ($hotels as $hotel) {
    $tersedia = 0;
    $dipakai = 0;
    foreach ($hotel['rooms'] as $room) {
        $tersedia += $room['available'];
        $dipakai += $room['occupied'];
    }
    $kamarPerHotel[] = [
        'hotel' => $hotel['name'],
        'tersedia' => $tersedia,
        'dipakai' => $dipakai
    ];
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode([
    'locations' => $totalLocations,
    'property' => $totalProperty,
    'orders' => $totalOrders,
    'agent' => $totalAgent,
    'kamar' => $totalKamar,
    'kamar_tersedia' => $kamarTersedia,
    'kamar_dipakai' => $kamarDipakai,
    'kamar_per_hotel' => $kamarPerHotel
]);

