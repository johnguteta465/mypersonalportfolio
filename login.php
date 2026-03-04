<?php
session_start();
include 'db.php';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username && $password) {
        $stmt = $mysqli->prepare("SELECT id, password FROM admin WHERE username = ? LIMIT 1");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $stored = $row['password'];
            if (password_verify($password, $stored) || $password === $stored) {
                $_SESSION['admin_logged'] = true;
                $_SESSION['admin_user'] = $username;
                header('Location: admin.php');
                exit;
            } else {
                $err = 'Invalid credentials.';
            }
        } else {
            if ($username === 'admin' && $password === 'admin123') {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $ins = $mysqli->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
                $ins->bind_param('ss', $username, $hash);
                if ($ins->execute()) {
                    $_SESSION['admin_logged'] = true;
                    $_SESSION['admin_user'] = $username;
                    header('Location: admin.php');
                    exit;
                } else {
                    $err = 'Failed to create admin.';
                }
            } else {
                $err = 'Invalid credentials.';
            }
        }
        $stmt->close();
    } else {
        $err = 'Please enter username and password.';
    }
}

$bodyClass = 'login-page';
include 'header.php';
?>

<style>
    .login-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }

    .login-page .site-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }

    .login-page #main-content {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        flex: 1;
    }

    .login-wrapper {
        width: 100%;
        max-width: 1000px;
        margin: 0 auto;
        animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-split-card {
        display: flex;
        background: white;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        min-height: 600px;
    }

    .brand-panel {
        flex: 1;
        background: linear-gradient(145deg, #1e3a8a, #9333ea);
        padding: 3rem 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .brand-panel::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .brand-icon {
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        border: 4px solid rgba(255, 255, 255, 0.3);
        position: relative;
        z-index: 1;
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    .brand-icon i {
        font-size: 3.5rem;
        color: white;
    }

    .brand-panel h2 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
    }

    .brand-panel p {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 280px;
        margin: 0 auto 2rem;
        position: relative;
        z-index: 1;
    }

    .feature-list {
        list-style: none;
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 280px;
    }

    .feature-list li {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 1rem 0;
        padding: 0.8rem 1rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 40px;
        backdrop-filter: blur(5px);
        font-size: 0.95rem;
    }

    .feature-list li i {
        color: #fbbf24;
        font-size: 1.2rem;
    }

    .form-panel {
        flex: 1;
        padding: 3rem;
        background: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .form-header h3 {
        font-size: 2rem;
        color: #1e3a8a;
        margin-bottom: 0.5rem;
        font-weight: 700;
    }

    .form-header p {
        color: #6b7280;
        font-size: 0.95rem;
    }

    .login-form {
        max-width: 340px;
        margin: 0 auto;
        width: 100%;
    }

    .form-group {
        margin-bottom: 1.8rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #374151;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 1.1rem;
        transition: all 0.3s;
    }

    .input-wrapper input {
        width: 100%;
        padding: 1rem 1rem 1rem 2.8rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s;
        background: #f9fafb;
    }

    .input-wrapper input:focus {
        outline: none;
        border-color: #1e3a8a;
        background: white;
        box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.1);
    }

    .input-wrapper input:focus+i {
        color: #1e3a8a;
    }

    .options-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 1.5rem 0 2rem;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.9rem;
        cursor: pointer;
    }

    .remember-me input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #1e3a8a;
    }

    .forgot-link {
        color: #6b7280;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s;
    }

    .forgot-link:hover {
        color: #1e3a8a;
    }

    .login-btn {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(90deg, #1e3a8a, #9333ea);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        position: relative;
        overflow: hidden;
    }

    .login-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(30, 58, 138, 0.5);
    }

    .login-btn:hover::before {
        left: 100%;
    }

    .error-message {
        background: #fee2e2;
        border-left: 4px solid #dc2626;
        border-radius: 8px;
        padding: 1rem 1.2rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        20% {
            transform: translateX(-5px);
        }

        40% {
            transform: translateX(5px);
        }

        60% {
            transform: translateX(-3px);
        }

        80% {
            transform: translateX(3px);
        }
    }

    .error-message i {
        color: #dc2626;
        font-size: 1.2rem;
    }

    .error-message span {
        color: #991b1b;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .demo-card {
        margin-top: 2.5rem;
        background: #f3f4f6;
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s;
    }

    .demo-card:hover {
        background: #e5e7eb;
    }

    .demo-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        color: #1e3a8a;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .demo-credentials {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .cred-item {
        flex: 1;
        min-width: 120px;
    }

    .cred-label {
        display: block;
        color: #6b7280;
        font-size: 0.8rem;
        margin-bottom: 0.3rem;
    }

    .cred-value {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: white;
        padding: 0.6rem 1rem;
        border-radius: 8px;
        font-family: monospace;
        font-size: 1rem;
        border: 1px solid #d1d5db;
    }

    .cred-value i {
        color: #1e3a8a;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .login-split-card {
            flex-direction: column;
            min-height: auto;
        }

        .brand-panel {
            padding: 2.5rem 1.5rem;
        }

        .form-panel {
            padding: 2.5rem 1.5rem;
        }

        .brand-icon {
            width: 90px;
            height: 90px;
        }

        .brand-icon i {
            font-size: 2.5rem;
        }

        .brand-panel h2 {
            font-size: 2rem;
        }
    }
</style>

<div class="login-wrapper">
    <div class="login-split-card">

        <div class="form-panel">
            <div class="form-header">
                <h3>Welcome Back</h3>
                <p>Please sign in to continue</p>
            </div>

            <?php if ($err): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo htmlspecialchars($err); ?></span>
                </div>
            <?php endif; ?>

            <form method="post" action="login.php" class="login-form" id="loginForm">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                </div>
                <div class="options-row">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div>
                <button type="submit" class="login-btn" id="loginBtn">
                    <i class="fas fa-arrow-right"></i>
                    <span>Sign In</span>
                </button>
            </form>



            <script>
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }

                document.querySelector('.demo-card')?.addEventListener('dblclick', function() {
                    document.getElementById('username').value = 'admin';
                    document.getElementById('password').value = 'admin123';
                    this.style.background = '#e0e7ff';
                    setTimeout(() => this.style.background = '#f3f4f6', 200);
                });
            </script>

            <?php include 'footer.php'; ?>