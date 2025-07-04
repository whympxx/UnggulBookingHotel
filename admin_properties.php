<?php
// admin_properties.php
// Dummy data for demonstration (replace with DB in production)
$hotels = [
    [
        'id' => 1,
        'name' => 'Hotel Santika Prime',
        'location' => 'Harapan Indah Bekasi',
        'price' => 688750,
        'image' => 'hotelsantika.jpg',
        'rating' => 4.5,
        'facilities' => ['Free Wi-Fi', 'Swimming Pool', 'Fitness Center', 'Restaurant'],
        'rooms' => [
            ['type' => 'Standard', 'count' => 5, 'available' => 4, 'occupied' => 1],
            ['type' => 'Deluxe', 'count' => 2, 'available' => 2, 'occupied' => 0],
        ],
        'room_images' => [
            'santika-room1.jpg',
            'santika-room2.jpg',
            'santika-room3.jpg',
            'santika-room4.jpg',
        ]
    ],
    [
        'id' => 2,
        'name' => 'Hotel Royal Ambarukmo',
        'location' => 'Jogjakarta',
        'price' => 1588755,
        'image' => 'royal-ambarukmo.jpg',
        'rating' => 4.8,
        'facilities' => ['Free Wi-Fi', 'Spa', 'Restaurant', 'Meeting Rooms'],
        'rooms' => [
            ['type' => 'Suite', 'count' => 2, 'available' => 2, 'occupied' => 0],
            ['type' => 'Deluxe', 'count' => 3, 'available' => 2, 'occupied' => 1],
        ],
        'room_images' => [
            'royal-room1.jpg',
            'royal-room2.jpg',
            'royal-room3.jpg',
            'royal-room4.jpg',
        ]
    ],
    [
        'id' => 3,
        'name' => 'Hotel Novotel',
        'location' => 'Bandung',
        'price' => 853801,
        'image' => 'hotelnovotel.jpg',
        'rating' => 4.6,
        'facilities' => ['Free Wi-Fi', 'Indoor & Outdoor Pool', 'Fitness Center', 'Spa', 'Rooftop Bar', 'Business Center'],
        'rooms' => [
            ['type' => 'Standard', 'count' => 8, 'available' => 7, 'occupied' => 1],
            ['type' => 'Suite', 'count' => 2, 'available' => 1, 'occupied' => 1],
        ],
        'room_images' => [
            'novotel-room1.jpg',
            'novotel-room2.jpg',
            'novotel-room3.jpg',
            'novotel-room4.jpg',
        ]
    ],
    [
        'id' => 4,
        'name' => 'Spencer Green Hotel',
        'location' => 'Malang, Batu',
        'price' => 403603,
        'image' => 'spencer_green_hotel.jpg',
        'rating' => 4.2,
        'facilities' => ['Free Wi-Fi', 'Swimming Pool', 'Restaurant', 'Meeting Rooms'],
        'rooms' => [
            ['type' => 'Standard', 'count' => 5, 'available' => 4, 'occupied' => 1],
            ['type' => 'Deluxe', 'count' => 1, 'available' => 1, 'occupied' => 0],
        ],
        'room_images' => [
            'spencer_green_hotel.jpg',
        ]
    ],
    [
        'id' => 5,
        'name' => 'Hotel Trikora Beach',
        'location' => 'Bintan Regency, Riau',
        'price' => 900000,
        'image' => 'hoteltrikorabeach.jpg',
        'rating' => 4.0,
        'facilities' => ['Free Wi-Fi', 'Beachfront', 'Spa', 'Restaurant'],
        'rooms' => [
            ['type' => 'Standard', 'count' => 4, 'available' => 3, 'occupied' => 1],
            ['type' => 'Suite', 'count' => 1, 'available' => 1, 'occupied' => 0],
        ],
        'room_images' => [
            'hoteltrikorabeach.jpg',
        ]
    ],
    [
        'id' => 6,
        'name' => 'Hotel Continental',
        'location' => 'Badung, Bali',
        'price' => 850000,
        'image' => 'hotelcontinental.jpg',
        'rating' => 4.3,
        'facilities' => ['Free Wi-Fi', 'Swimming Pool', 'Restaurant', 'Bar'],
        'rooms' => [
            ['type' => 'Standard', 'count' => 12, 'available' => 11, 'occupied' => 1],
            ['type' => 'Deluxe', 'count' => 5, 'available' => 5, 'occupied' => 0],
        ],
        'room_images' => [
            'hotelcontinental.jpg',
        ]
    ],
    [
        'id' => 7,
        'name' => 'Hotel Raffles',
        'location' => 'Jakarta',
        'price' => 4700000,
        'image' => 'raffles.jpg',
        'rating' => 4.8,
        'facilities' => ['Free Wi-Fi', 'Luxury Spa', 'Fine Dining', 'Butler Service', 'Swimming Pool', 'Fitness Center'],
        'rooms' => [
            ['type' => 'Suite', 'count' => 3, 'available' => 2, 'occupied' => 1],
            ['type' => 'Presidential Suite', 'count' => 1, 'available' => 1, 'occupied' => 0],
        ],
        'room_images' => [
            'raffles.jpg',
        ]
    ],
    [
        'id' => 8,
        'name' => 'The Ritz-Carlton Jakarta',
        'location' => 'Jakarta',
        'price' => 8000000,
        'image' => 'ritz-carlton.jpg',
        'rating' => 4.9,
        'facilities' => ['Free Wi-Fi', 'Luxury Spa', 'Multiple Restaurants', 'Rooftop Bar', 'Swimming Pool', 'Fitness Center', 'Business Center'],
        'rooms' => [
            ['type' => 'Deluxe', 'count' => 8, 'available' => 6, 'occupied' => 2],
            ['type' => 'Suite', 'count' => 4, 'available' => 3, 'occupied' => 1],
            ['type' => 'Presidential Suite', 'count' => 1, 'available' => 1, 'occupied' => 0],
        ],
        'room_images' => [
            'ritz-carlton.jpg',
        ]
    ],
    [
        'id' => 9,
        'name' => 'Hotel Kempinski',
        'location' => 'Jakarta',
        'price' => 3500000,
        'image' => 'kempinski.jpg',
        'rating' => 4.7,
        'facilities' => ['Free Wi-Fi', 'Luxury Spa', 'Fine Dining', 'Swimming Pool', 'Fitness Center', 'Business Center'],
        'rooms' => [
            ['type' => 'Deluxe', 'count' => 10, 'available' => 8, 'occupied' => 2],
            ['type' => 'Suite', 'count' => 3, 'available' => 2, 'occupied' => 1],
        ],
        'room_images' => [
            'kempinski.jpg',
        ]
    ],
    [
        'id' => 10,
        'name' => 'Fairfield Hotel',
        'location' => 'Jakarta',
        'price' => 1200000,
        'image' => 'fairfield.jpg',
        'rating' => 4.4,
        'facilities' => ['Free Wi-Fi', 'Swimming Pool', 'Restaurant', 'Fitness Center', 'Business Center'],
        'rooms' => [
            ['type' => 'Standard', 'count' => 15, 'available' => 12, 'occupied' => 3],
            ['type' => 'Deluxe', 'count' => 5, 'available' => 4, 'occupied' => 1],
        ],
        'room_images' => [
            'fairfield.jpg',
        ]
    ],
    // Add more hotels as needed
];

// Handle add/edit room (dummy, not persistent)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // In production, update DB here
    $msg = 'Fitur tambah/edit kamar hanya demo (tidak tersimpan permanen).';
}

$hotel_labels = [];
$hotel_room_counts = [];
$hotel_available_counts = [];
$hotel_occupied_counts = [];
$total_available = 0;
$total_occupied = 0;
foreach ($hotels as $hotel) {
    $hotel_labels[] = $hotel['name'];
    $total_rooms = 0;
    $available = 0;
    $occupied = 0;
    foreach ($hotel['rooms'] as $room) {
        $total_rooms += $room['count'];
        $available += $room['available'];
        $occupied += $room['occupied'];
    }
    $hotel_room_counts[] = $total_rooms;
    $hotel_available_counts[] = $available;
    $hotel_occupied_counts[] = $occupied;
    $total_available += $available;
    $total_occupied += $occupied;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Property Management</title>
    <link rel="stylesheet" href="admin_properties.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-properties-container">
        <a href="admin_dashboard.php" class="back-btn" style="display:inline-block;margin-bottom:18px;background:#1e3c72;color:#fff;padding:8px 20px;border-radius:5px;text-decoration:none;font-weight:600;transition:background 0.2s;"><i class="fa fa-arrow-left"></i> Kembali</a>
        <h1>Admin Property Management</h1>
        <?php if (!empty($msg)): ?>
            <div class="admin-msg"><?php echo $msg; ?></div>
        <?php endif; ?>
        <table class="property-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Price/Night</th>
                    <th>Rating</th>
                    <th>Facilities</th>
                    <th>Rooms</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hotels as $hotel): ?>
                <tr>
                    <td><img src="images/<?php echo $hotel['image']; ?>" alt="<?php echo $hotel['name']; ?>" class="hotel-thumb"></td>
                    <td><?php echo $hotel['name']; ?></td>
                    <td><?php echo $hotel['location']; ?></td>
                    <td>Rp. <?php echo number_format($hotel['price'], 0, ',', '.'); ?></td>
                    <td><?php echo $hotel['rating']; ?></td>
                    <td>
                        <ul>
                        <?php foreach ($hotel['facilities'] as $f): ?>
                            <li><?php echo $f; ?></li>
                        <?php endforeach; ?>
                        </ul>
                    </td>
                    <td>
                        <ul>
                        <?php foreach ($hotel['rooms'] as $idx => $room): ?>
                            <li>
                                <?php echo $room['type'] . ': ' . $room['count']; ?>
                                <button class="edit-btn" style="margin-left:8px;padding:2px 10px;font-size:0.9em;" onclick="showEditForm(<?php echo $hotel['id']; ?>, <?php echo $idx; ?>, '<?php echo htmlspecialchars($room['type'], ENT_QUOTES); ?>', <?php echo $room['count']; ?>)"><i class="fa fa-edit"></i> Edit</button>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </td>
                    <td>
                        <button class="add-btn" onclick="showAddRoomForm(<?php echo $hotel['id']; ?>)"><i class="fa fa-plus"></i> Add Room</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Edit Room Modal -->
        <div id="editRoomModal" class="modal">
            <div class="modal-content">
                <span class="close-modal" onclick="closeModal('editRoomModal')">&times;</span>
                <h2>Edit Room</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="hotel_id" id="edit_hotel_id">
                    <input type="hidden" name="room_index" id="edit_room_index">
                    <div class="form-group">
                        <label for="edit_room_type">Room Type</label>
                        <input type="text" name="room_type" id="edit_room_type" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_room_count">Room Count</label>
                        <input type="number" name="room_count" id="edit_room_count" min="1" required>
                    </div>
                    <button type="submit" class="save-btn">Save</button>
                </form>
                <div style="margin-top:10px;color:#e67e22;font-size:0.95em;">Fitur edit kamar hanya demo (tidak tersimpan permanen).</div>
            </div>
        </div>
        <!-- Add Room Modal -->
        <div id="addRoomModal" class="modal">
            <div class="modal-content">
                <span class="close-modal" onclick="closeModal('addRoomModal')">&times;</span>
                <h2>Add Room</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="hotel_id" id="add_hotel_id">
                    <div class="form-group">
                        <label for="add_room_type">Room Type</label>
                        <input type="text" name="room_type" id="add_room_type" required>
                    </div>
                    <div class="form-group">
                        <label for="add_room_count">Room Count</label>
                        <input type="number" name="room_count" id="add_room_count" min="1" required>
                    </div>
                    <button type="submit" class="save-btn">Add</button>
                </form>
            </div>
        </div>

        <h2>Grafik Kamar Tersedia & Dipakai per Hotel (Realtime)</h2>
        <canvas id="roomsStatusChart" width="300" height="120" style="margin-bottom:30px;"></canvas>
        <h2>Grafik Jumlah Kamar Tersedia & Dipakai (Realtime)</h2>
        <canvas id="totalRoomsPie" width="300" height="120" style="margin-bottom:30px;"></canvas>
        <h2>Grafik Jumlah Kamar per Hotel</h2>
        <canvas id="roomsChart" width="300" height="120" style="margin-bottom:30px;"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Grafik Kamar Tersedia & Dipakai per Hotel
    const ctxStatus = document.getElementById('roomsStatusChart').getContext('2d');
    const roomsStatusChart = new Chart(ctxStatus, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($hotel_labels); ?>,
            datasets: [
                {
                    label: 'Tersedia',
                    data: <?php echo json_encode($hotel_available_counts); ?>,
                    backgroundColor: 'rgba(46, 204, 113, 0.7)',
                    borderColor: 'rgba(46, 204, 113, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Dipakai',
                    data: <?php echo json_encode($hotel_occupied_counts); ?>,
                    backgroundColor: 'rgba(231, 76, 60, 0.7)',
                    borderColor: 'rgba(231, 76, 60, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
    // Grafik Jumlah Kamar Tersedia & Dipakai (Total)
    const ctxPie = document.getElementById('totalRoomsPie').getContext('2d');
    const totalRoomsPie = new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Tersedia', 'Dipakai'],
            datasets: [{
                data: [<?php echo $total_available; ?>, <?php echo $total_occupied; ?>],
                backgroundColor: [
                    'rgba(46, 204, 113, 0.7)',
                    'rgba(231, 76, 60, 0.7)'
                ],
                borderColor: [
                    'rgba(46, 204, 113, 1)',
                    'rgba(231, 76, 60, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
    // Grafik Jumlah Kamar per Hotel (lama)
    const ctx = document.getElementById('roomsChart').getContext('2d');
    const roomsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($hotel_labels); ?>,
            datasets: [{
                label: 'Jumlah Kamar',
                data: <?php echo json_encode($hotel_room_counts); ?>,
                backgroundColor: 'rgba(30, 60, 114, 0.7)',
                borderColor: 'rgba(30, 60, 114, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
    function showEditForm(hotelId, roomIndex, roomType, roomCount) {
        document.getElementById('edit_hotel_id').value = hotelId;
        document.getElementById('edit_room_index').value = roomIndex;
        document.getElementById('edit_room_type').value = roomType;
        document.getElementById('edit_room_count').value = roomCount;
        document.getElementById('editRoomModal').style.display = 'block';
    }
    function showAddRoomForm(hotelId) {
        document.getElementById('add_hotel_id').value = hotelId;
        document.getElementById('addRoomModal').style.display = 'block';
    }
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
    </script>
</body>
</html> 