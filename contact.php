<?php
$bodyClass = 'contact-page';
include 'header.php';
include 'db.php';

$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $email && $message) {
        $stmt = $mysqli->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $name, $email, $message);
        if ($stmt->execute()) {
            $success = 'Message sent. Thank you!';
        } else {
            $success = 'Failed to send message.';
        }
        $stmt->close();
    } else {
        $success = 'Please fill all fields.';
    }
}
?>

<style>
    .contact-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 70px);
        padding: 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .contact-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 30px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        padding: 2.5rem;
        max-width: 600px;
        width: 100%;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .contact-card h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .contact-form .form-group {
        margin-bottom: 1.5rem;
    }

    .contact-form label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #2d3748;
    }

    .contact-form input,
    .contact-form textarea {
        width: 100%;
        padding: 0.9rem 1.2rem;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        font-size: 1rem;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: white;
    }

    .contact-form input:focus,
    .contact-form textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .contact-form button {
        background: linear-gradient(90deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 40px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 100%;
    }

    .contact-form button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }

    .notice {
        background: #c6f6d5;
        color: #22543d;
        padding: 1rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        border-left: 6px solid #48bb78;
    }

    @media (max-width: 640px) {
        .contact-wrapper {
            padding: 1rem;
        }

        .contact-card {
            padding: 1.5rem;
        }
    }
</style>

<div class="contact-wrapper">
    <div class="contact-card">
        <h1>Get in Touch</h1>
        <?php if ($success): ?>
            <p class="notice"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <form method="post" action="contact.php" class="contact-form">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit">Send Message</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>