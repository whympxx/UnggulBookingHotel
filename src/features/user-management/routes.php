<?php
/**
 * User Management Routes
 * Handles user registration, authentication, and profile management
 */

// User Registration
$router->get('/register', function() {
    include __DIR__ . '/view/register.php';
});

$router->post('/register', function() {
    // Handle user registration
    $auth = new AuthProvider();
    
    $data = Utils::sanitize($_POST);
    $errors = Utils::validateRequired($data, ['name', 'email', 'password']);
    
    if (empty($errors)) {
        if ($auth->register($data)) {
            Utils::redirect('/login', 'Registration successful! Please login.', 'success');
        } else {
            Utils::redirect('/register', 'Registration failed. Email may already exist.', 'error');
        }
    } else {
        Utils::redirect('/register', implode(', ', $errors), 'error');
    }
});

// User Login
$router->get('/login', function() {
    include __DIR__ . '/view/login.php';
});

$router->post('/login', function() {
    // Handle user login
    $auth = new AuthProvider();
    
    $email = Utils::sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if ($auth->login($email, $password)) {
        Utils::redirect('/', 'Login successful!', 'success');
    } else {
        Utils::redirect('/login', 'Invalid credentials.', 'error');
    }
});

// User Logout
$router->get('/logout', function() {
    $auth = new AuthProvider();
    $auth->logout();
    Utils::redirect('/', 'Logged out successfully.', 'success');
});

// User Profile
$router->get('/profile', function() {
    $auth = new AuthProvider();
    $auth->requireAuth();
    
    $user = $auth->getCurrentUser();
    include __DIR__ . '/view/profile.php';
});

$router->post('/profile', function() {
    $auth = new AuthProvider();
    $auth->requireAuth();
    
    // Handle profile update
    // Implementation will be added later
    Utils::redirect('/profile', 'Profile updated successfully!', 'success');
});
?>
