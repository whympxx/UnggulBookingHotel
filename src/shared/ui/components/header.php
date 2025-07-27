<?php
/**
 * Shared Header Component
 * Used across all pages in the application
 */

function renderHeader($title = "Unggul Booking Hotel", $showAuthButtons = true) {
    $auth = new AuthProvider();
    $isLoggedIn = $auth->isLoggedIn();
    $currentUser = $auth->getCurrentUser();
    
    ob_start();
?>
<header class="main-header">
    <div class="header-left">
        <button id="sidebarToggle" class="sidebar-toggle" aria-label="Toggle Menu" title="Toggle Menu (Ctrl + M)">
            <i class="fas fa-bars"></i>
        </button>
        <span class="company-name"><?php echo htmlspecialchars($title); ?></span>
    </div>
    
    <div class="header-right">
        <?php if ($showAuthButtons): ?>
            <?php if ($isLoggedIn): ?>
                <div class="user-menu">
                    <span class="welcome-text">Welcome, <?php echo htmlspecialchars($currentUser['name']); ?></span>
                    <div class="user-dropdown">
                        <button class="user-avatar-btn">
                            <i class="fas fa-user-circle"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="/profile.php" class="dropdown-item">
                                <i class="fas fa-user"></i> Profile
                            </a>
                            <a href="/settings.php" class="dropdown-item">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="/logout.php" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <a href="Register.php" class="register-btn">Registrasi</a>
                <a href="user_selection.php" class="login-btn">Login</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</header>
<?php
    return ob_get_clean();
}

function renderNavigation() {
    $auth = new AuthProvider();
    $currentUser = $auth->getCurrentUser();
    
    ob_start();
?>
<nav class="sidebar-nav">
    <a href="profile.php" class="sidebar-nav-link">
        <i class="fas fa-user"></i> Profile
    </a>
    <a href="index.php" class="sidebar-nav-link">
        <i class="fas fa-home"></i> Beranda
    </a>
    <a href="cart.php" class="sidebar-nav-link">
        <i class="fas fa-cart-plus"></i> Keranjang Saya
    </a>
    <a href="layanan.php" class="sidebar-nav-link">
        <i class="fas fa-bell-concierge"></i> Layanan
    </a>
    <a href="properties.php" class="sidebar-nav-link">
        <i class="fas fa-building"></i> Properties
    </a>
    <a href="agents.php" class="sidebar-nav-link">
        <i class="fas fa-headset"></i> Agent
    </a>
    <a href="contact_admin.php" class="sidebar-nav-link">
        <i class="fas fa-question-circle"></i> Contact Admin
    </a>
    <a href="settings.php" class="sidebar-nav-link">
        <i class="fas fa-screwdriver-wrench"></i> Setting
    </a>
    
    <?php if ($currentUser && $currentUser['role'] === 'admin'): ?>
        <div class="nav-divider"></div>
        <div class="nav-section-title">Admin Panel</div>
        <a href="admin_dashboard.php" class="sidebar-nav-link">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="admin_properties.php" class="sidebar-nav-link">
            <i class="fas fa-building"></i> Manage Properties
        </a>
        <a href="admin_agents.php" class="sidebar-nav-link">
            <i class="fas fa-users"></i> Manage Agents
        </a>
    <?php elseif ($currentUser && $currentUser['role'] === 'agent'): ?>
        <div class="nav-divider"></div>
        <div class="nav-section-title">Agent Panel</div>
        <a href="agent_dashboard.php" class="sidebar-nav-link">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    <?php endif; ?>
</nav>
<?php
    return ob_get_clean();
}
?>
