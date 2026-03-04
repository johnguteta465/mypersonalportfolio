<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Global styles -->
    <link rel="stylesheet" href="style.css">
    <!-- Page-specific CSS -->
    <?php if (isset($bodyClass) && $bodyClass === 'home-page'): ?>
        <link rel="stylesheet" href="index.css">
    <?php endif; ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f9fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .skip-link {
            position: absolute;
            top: -40px;
            left: 0;
            background: #1e3a8a;
            color: white;
            padding: 8px;
            z-index: 100;
            text-decoration: none;
        }

        .skip-link:focus {
            top: 0;
        }

        .site-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .logo a {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e3a8a;
        }

        .logo-text {
            font-size: 1.25rem;
            color: #1e3a8a;
        }

        .logo-img {
            height: 50px;
            width: 50px;
            display: block;
            border-radius: 50%;
            object-fit: cover;
        }

        .main-nav {
            display: flex;
            align-items: center;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #1e3a8a;
            cursor: pointer;
        }

        .nav-list {
            display: flex;
            list-style: none;
            gap: 1.5rem;
        }

        .nav-list li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            padding: 0.5rem 0;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-list li a i {
            color: #9333ea;
        }

        .nav-list li.active a {
            color: #1e3a8a;
            border-bottom: 2px solid #9333ea;
        }

        .nav-list li a:hover {
            color: #9333ea;
        }

        .auth-nav a {
            font-weight: 600;
            color: #1e3a8a;
        }

        .auth-nav a:hover {
            color: #9333ea;
        }

        .admin-nav a {
            background: #facc15;
            color: #111 !important;
            padding: 0.4rem 1rem !important;
            border-radius: 30px;
            transition: background 0.2s;
        }

        .admin-nav a:hover {
            background: #eab308;
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .nav-list {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 70px;
                left: 0;
                right: 0;
                background: white;
                padding: 1.5rem;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                gap: 1rem;
                border-top: 2px solid #9333ea;
            }

            .nav-list.active {
                display: flex;
            }

            .nav-list li a {
                padding: 0.75rem 0;
                justify-content: center;
            }
        }

        #main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body class="<?php echo isset($bodyClass) ? htmlspecialchars($bodyClass) : ''; ?>">
    <a href="#main-content" class="skip-link">Skip to main content</a>
    <header class="site-header">
        <div class="header-container">
            <div class="logo">
                <a href="index.php">
                    <img src="joess.jpg" alt="Logo" class="logo-img" />
                    <span class="logo-text">personal portfolio</span>
                </a>
            </div>
            <nav class="main-nav" aria-label="Main navigation">
                <button class="menu-toggle" aria-label="Toggle menu" aria-expanded="false">☰</button>
                <ul class="nav-list">
                    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
                        <a href="index.php"> Home</a>
                    </li>
                    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'projects.php') ? 'active' : ''; ?>">
                        <a href="projects.php"> Projects</a>
                    </li>
                    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'active' : ''; ?>">
                        <a href="about.php"> About</a>
                    </li>
                    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'contact.php') ? 'active' : ''; ?>">
                        <a href="contact.php"> Contact</a>
                    </li>
                    <?php
                    if (
                        isset($_SESSION['admin_logged'], $_SESSION['admin_user']) &&
                        $_SESSION['admin_logged'] === true &&
                        $_SESSION['admin_user'] === 'admin'
                    ): ?>
                        <li class="admin-nav">
                            <a href="admin.php"><i class="fas fa-cog"></i> Admin</a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true): ?>
                        <li class="auth-nav">
                            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="auth-nav">
                            <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main id="main-content">