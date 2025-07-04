<?php
// user_selection.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Selection - Hotel Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            background: url('images/bg-hotel.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing: border-box;
        }
        *, *:before, *:after {
            box-sizing: inherit;
        }
        .header-bg {
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logo img {
            height: 40px;
            width: auto;
        }
        .logo span {
            color: #fff;
            font-size: 1.5em;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .user-selection-title {
            color: #fff;
            font-size: 1.8em;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .selection-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
            margin-top: 60px;
            padding: 0 20px;
            flex-wrap: wrap;
            width: 100%;
            box-sizing: border-box;
        }
        .selection-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            width: 300px;
            max-width: 90vw;
            padding: 2rem 1rem;
            text-align: center;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
            box-sizing: border-box;
        }
        .selection-box:hover {
            transform: translateY(-10px);
        }
        .selection-box span {
            display: block;
            color: #fff;
            font-size: 1.4em;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .selection-box a {
            display: block;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            margin: 10px 0;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .selection-box a:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        .selection-box.agent {
            background: rgba(209, 176, 176, 0.15);
        }
        @media (max-width: 1024px) {
            .selection-container {
                gap: 20px;
                margin-top: 40px;
            }
            .selection-box {
                width: 260px;
                padding: 1.5rem 0.5rem;
            }
        }
        @media (max-width: 768px) {
            .selection-container {
                flex-direction: column;
                gap: 20px;
                margin-top: 30px;
                padding: 0 5vw;
            }
            .selection-box {
                width: 100%;
                max-width: 400px;
                padding: 1.2rem 0.5rem;
            }
            .header-bg {
                flex-direction: column;
                text-align: center;
                gap: 10px;
                padding: 1rem 0.5rem;
            }
            .user-selection-title {
                font-size: 1.2em;
            }
        }
        @media (max-width: 480px) {
            .selection-box {
                max-width: 98vw;
                padding: 1rem 0.2rem;
            }
            .logo img {
                height: 30px;
            }
            .logo span {
                font-size: 1.1em;
            }
        }
    </style>
</head>
<body>
    <div class="header-bg">
        <div class="logo">
            <img src="images/logo.png" alt="Logo" onerror="this.style.display='none'">
            <span>Hotel Booking</span>
        </div>
        <div class="user-selection-title">User Selection</div>
    </div>
    <div class="selection-container">
        <div class="selection-box">
            <span>Customer</span>
            <a href="Register.php">Registration</a>
            <a href="login.php">Login</a>
        </div>
        <div class="selection-box agent">
            <span>Agent</span>
            <a href="agent_register.php">Registration</a>
            <a href="agent_login.php">Login</a>
        </div>
        <div class="selection-box agent">
            <span>Admin</span>
            <a href="admin_register.php">Registration</a>
            <a href="admin_login.php">Login</a>
        </div>
    </div>
    <div style="width:100%;text-align:center;margin-top:30px;">
        <a href="index.php" style="display:inline-block;padding:12px 30px;background:rgba(0,0,0,0.6);color:#fff;border-radius:8px;text-decoration:none;font-weight:600;transition:background 0.3s;">Kembali ke Halaman Utama</a>
    </div>
</body>
</html> 