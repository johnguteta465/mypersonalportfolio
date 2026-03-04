<?php
session_start();
if (
    !isset($_SESSION['admin_logged'], $_SESSION['admin_user']) ||
    $_SESSION['admin_logged'] !== true ||
    $_SESSION['admin_user'] !== 'admin'
) {
    header('Location: login.php');
    exit;
}
include 'db.php';
include 'header.php';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $tech = trim($_POST['technologies'] ?? '');
    $link = trim($_POST['project_link'] ?? '');

    if ($title && $desc) {
        $stmt = $mysqli->prepare("INSERT INTO projects (title, description, technologies, project_link) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $title, $desc, $tech, $link);
        if ($stmt->execute()) {
            header('Location: admin.php');
            exit;
        } else {
            $err = 'Failed to add project.';
        }
        $stmt->close();
    } else {
        $err = 'Title and description required.';
    }
}
?>

<style>
    .admin-form {
        max-width: 600px;
        margin: 2rem auto;
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .admin-form h2 {
        color: #1e3a8a;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #374151;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #1e3a8a;
    }

    .submit-btn {
        background: linear-gradient(90deg, #1e3a8a, #9333ea);
        color: white;
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
    }

    .notice {
        background: #fee2e2;
        color: #991b1b;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
</style>

<div class="admin-form">
    <h2>Add New Project</h2>
    <?php if ($err): ?>
        <p class="notice"><?php echo htmlspecialchars($err); ?></p>
    <?php endif; ?>
    <form method="post" action="add_project.php">
        <div class="form-group">
            <label for="title">Project Title *</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description *</label>
            <textarea id="description" name="description" rows="6" required></textarea>
        </div>
        <div class="form-group">
            <label for="technologies">Technologies (comma separated)</label>
            <input type="text" id="technologies" name="technologies" placeholder="e.g., PHP, MySQL, JavaScript">
        </div>
        <div class="form-group">
            <label for="project_link">Project Link</label>
            <input type="url" id="project_link" name="project_link" placeholder="https://...">
        </div>
        <button type="submit" class="submit-btn">Add Project</button>
    </form>
</div>

<?php include 'footer.php'; ?>