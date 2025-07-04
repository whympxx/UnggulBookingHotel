<?php
include 'hotel_data.php';

$search = isset($_GET['search']) ? strtolower($_GET['search']) : '';
$location = isset($_GET['location']) ? strtolower($_GET['location']) : 'all';

$filtered = array_filter($hotels, function($hotel) use ($search, $location) {
    $name = strtolower($hotel['name']);
    $loc = strtolower($hotel['location']);
    $matchName = strpos($name, $search) !== false;
    $matchLocation = ($location === 'all') || (strpos($loc, $location) !== false);
    return $matchName && $matchLocation;
});

header('Content-Type: application/json');
echo json_encode(array_values($filtered)); 