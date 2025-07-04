<?php
session_start();
// Daftar gambar agent yang tersedia
$agent_images = [
    'larrynaves.png', 'robert.png', 'Jessica.png', 'jefrinichol.png', 'marcovanbasten.png'
];
// Data default agent
$default_agents = [
    [
        'name' => 'Larry Naves',
        'image' => 'larrynaves.png',
        'description' => 'Dengan pengalaman lebih dari 5 tahun di industri properti dan perhotelan, Larry Naves merupakan profesional yang berfokus pada penyewaan hotel untuk kebutuhan bisnis dan pariwisata.',
        'location' => 'Perumahan Graha Blok J No 21, Bojong Rawa, Bekasi Barat, Kota Bekasi',
        'phone' => '+62-0852-2890-7619',
        'email' => 'navesld@gmail.com',
        'social' => [
            'facebook' => '#',
            'instagram' => '#',
            'x' => '#'
        ]
    ],
    [
        'name' => 'Robert',
        'image' => 'robert.png',
        'description' => 'Seorang agen berpengalaman dengan fokus pada properti komersial.',
        'location' => 'Jakarta',
        'phone' => '+62-812-3456-7890',
        'email' => 'robert@example.com',
        'social' => [
            'facebook' => '#',
            'instagram' => '#',
            'x' => '#'
        ]
    ],
    [
        'name' => 'Jessica',
        'image' => 'Jessica.png',
        'description' => 'Agen properti terkemuka di bidang perumahan mewah.',
        'location' => 'Surabaya',
        'phone' => '+62-812-9876-5432',
        'email' => 'jessica@example.com',
        'social' => [
            'facebook' => '#',
            'instagram' => '#',
            'x' => '#'
        ]
    ],
    [
        'name' => 'Jefri Nichol',
        'image' => 'jefrinichol.png',
        'description' => 'Spesialis properti liburan di Bali dan sekitarnya.',
        'location' => 'Bali',
        'phone' => '+62-878-1122-3344',
        'email' => 'jefri@example.com',
        'social' => [
            'facebook' => '#',
            'instagram' => '#',
            'x' => '#'
        ]
    ],
    [
        'name' => 'Marco Van Basten',
        'image' => 'marcovanbasten.png',
        'description' => 'Konsultan properti ahli untuk investasi jangka panjang.',
        'location' => 'Bandung',
        'phone' => '+62-896-5544-3322',
        'email' => 'marco@example.com',
        'social' => [
            'facebook' => '#',
            'instagram' => '#',
            'x' => '#'
        ]
    ]
];
// Load agents dari session, jika belum ada pakai default
if (!isset($_SESSION['agents'])) {
    $_SESSION['agents'] = $default_agents;
}
$agents = $_SESSION['agents'];
// Handle aksi tambah/edit/hapus
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $image = isset($_POST['image']) ? $_POST['image'] : $agent_images[0];
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $location = isset($_POST['location']) ? trim($_POST['location']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $social = [
        'facebook' => isset($_POST['facebook']) ? trim($_POST['facebook']) : '#',
        'instagram' => isset($_POST['instagram']) ? trim($_POST['instagram']) : '#',
        'x' => isset($_POST['x']) ? trim($_POST['x']) : '#',
    ];

    $edit_index = isset($_POST['edit_index']) ? intval($_POST['edit_index']) : -1;
    if ($name && $image && $description && $location && $phone && $email) {
        $new_agent = [
            'name' => $name,
            'image' => $image,
            'description' => $description,
            'location' => $location,
            'phone' => $phone,
            'email' => $email,
            'social' => $social
        ];
        if ($edit_index >= 0 && isset($agents[$edit_index])) {
            // Edit
            $agents[$edit_index] = $new_agent;
        } else {
            // Tambah
            $agents[] = $new_agent;
        }
        $_SESSION['agents'] = $agents;
        header('Location: admin_agents.php');
        exit;
    }
}
if (isset($_GET['delete'])) {
    $del = intval($_GET['delete']);
    if (isset($agents[$del])) {
        array_splice($agents, $del, 1);
        $_SESSION['agents'] = $agents;
        header('Location: admin_agents.php');
        exit;
    }
}
$edit_data = null;
$edit_index = -1;
if (isset($_GET['edit'])) {
    $edit_index = intval($_GET['edit']);
    if (isset($agents[$edit_index])) {
        $edit_data = $agents[$edit_index];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Agents - Unggul Booking Hotel</title>
    <link rel="stylesheet" href="admin_agents.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <span class="sidebar-title">Admin Panel</span>
            </div>
            <nav class="sidebar-menu">
                <ul>
                    <li><a href="admin_dashboard.php" style="color:inherit;text-decoration:none;"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="admin_properties.php" style="color:inherit;text-decoration:none;"><i class="fa fa-building"></i> Property Selection</a></li>
                    <li><a href="website_setting.php" style="color:inherit;text-decoration:none;"><i class="fa fa-cog"></i> Website Setting</a></li>
                    <li><a href="orders.php" style="color:inherit;text-decoration:none;"><i class="fa fa-shopping-cart"></i> Orders</a></li>
                    <li class="active"><a href="admin_agents.php" style="color:inherit;text-decoration:none;"><i class="fa fa-user"></i> Agent</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <header class="main-header">
                <img src="images/logo.png" alt="Logo" class="logo">
                <span class="brand-title">Unggul Booking Hotel</span>
            </header>
            <section class="agent-section">
                <div class="agent-header">
                    <h2>Manage Agents</h2>
                    <button class="add-btn" onclick="showForm()"><i class="fa fa-plus"></i> Add New</button>
                </div>
                <div id="agent-form-container" style="display:<?= $edit_data ? 'block' : 'none' ?>;margin-bottom:18px;">
                    <form method="post" class="agent-form" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;background:#f0f6ff;padding:12px 16px;border-radius:6px;">
                        <input type="text" name="name" placeholder="Agent Name" value="<?php echo isset($edit_data['name']) ? htmlspecialchars($edit_data['name']) : ''; ?>" required style="padding:6px 10px;border-radius:4px;border:1px solid #ccc;min-width:120px;">
                        <select name="image" required style="padding:6px 10px;border-radius:4px;border:1px solid #ccc;">
                            <?php foreach ($agent_images as $img): ?>
                                <option value="<?= $img ?>" <?= (isset($edit_data['image']) && $edit_data['image'] === $img) ? 'selected' : '' ?>><?= $img ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="location" placeholder="Location" value="<?php echo isset($edit_data['location']) ? htmlspecialchars($edit_data['location']) : ''; ?>" required style="padding:6px 10px;border-radius:4px;border:1px solid #ccc;min-width:120px;">
                        <input type="text" name="phone" placeholder="Phone" value="<?php echo isset($edit_data['phone']) ? htmlspecialchars($edit_data['phone']) : ''; ?>" required style="padding:6px 10px;border-radius:4px;border:1px solid #ccc;min-width:120px;">
                        <input type="email" name="email" placeholder="Email" value="<?php echo isset($edit_data['email']) ? htmlspecialchars($edit_data['email']) : ''; ?>" required style="padding:6px 10px;border-radius:4px;border:1px solid #ccc;min-width:120px;">
                        <input type="text" name="facebook" placeholder="Facebook" value="<?php echo isset($edit_data['social']['facebook']) ? htmlspecialchars($edit_data['social']['facebook']) : ''; ?>" style="padding:6px 10px;border-radius:4px;border:1px solid #ccc;min-width:100px;">
                        <input type="text" name="instagram" placeholder="Instagram" value="<?php echo isset($edit_data['social']['instagram']) ? htmlspecialchars($edit_data['social']['instagram']) : ''; ?>" style="padding:6px 10px;border-radius:4px;border:1px solid #ccc;min-width:100px;">
                        <input type="text" name="x" placeholder="X (Twitter)" value="<?php echo isset($edit_data['social']['x']) ? htmlspecialchars($edit_data['social']['x']) : ''; ?>" style="padding:6px 10px;border-radius:4px;border:1px solid #ccc;min-width:100px;">
                        <textarea name="description" placeholder="Description" required style="padding:6px 10px;border-radius:4px;border:1px solid #ccc;min-width:180px;min-height:38px;resize:vertical;"><?php echo isset($edit_data['description']) ? htmlspecialchars($edit_data['description']) : ''; ?></textarea>

                        <?php if ($edit_data): ?>
                            <input type="hidden" name="edit_index" value="<?= $edit_index ?>">
                        <?php endif; ?>
                        <button type="submit" class="add-btn" style="margin:0;min-width:90px;"><i class="fa fa-save"></i> <?= $edit_data ? 'Update' : 'Add' ?></button>
                        <button type="button" onclick="hideForm()" class="delete-btn" style="margin:0;">Cancel</button>
                    </form>
                </div>
                <div class="table-container">
                    <table class="agent-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($agents as $i => $agent): ?>
                            <tr>
                                <td><?= $i+1 ?></td>
                                <td><img src="images/<?= $agent['image'] ?>" alt="<?= htmlspecialchars($agent['name']) ?>" class="agent-photo"></td>
                                <td><?= htmlspecialchars($agent['name']) ?></td>
                                <td><?= htmlspecialchars($agent['location']) ?></td>
                                <td><?= htmlspecialchars($agent['phone']) ?></td>
                                <td><?= htmlspecialchars($agent['email']) ?></td>
                                <td>
                                    <a href="?edit=<?= $i ?>" class="edit-btn" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a href="?delete=<?= $i ?>" class="delete-btn" title="Delete" onclick="return confirm('Delete this agent?')"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
<script>
function showForm() {
    document.getElementById('agent-form-container').style.display = 'block';
}
function hideForm() {
    window.location.href = 'admin_agents.php';
}
</script>
</html> 