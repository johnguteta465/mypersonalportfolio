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

// Handle delete
if (isset($_GET['delete_project'])) {
    $id = (int)$_GET['delete_project'];
    $del = $mysqli->prepare("DELETE FROM projects WHERE id = ?");
    $del->bind_param('i', $id);
    $del->execute();
    $del->close();
    echo '<p class="notice">Project deleted.</p>';
}

// Handle add project (submitted from the form on this page)
$add_err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_project'])) {
    $title = trim($_POST['title'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $tech = trim($_POST['technologies'] ?? '');
    $link = trim($_POST['project_link'] ?? '');

    if ($title && $desc) {
        $stmt = $mysqli->prepare("INSERT INTO projects (title, description, technologies, project_link) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $title, $desc, $tech, $link);
        if ($stmt->execute()) {
            echo '<p class="notice success">Project added successfully.</p>';
        } else {
            $add_err = 'Failed to add project.';
        }
        $stmt->close();
    } else {
        $add_err = 'Title and description are required.';
    }
}

// Statistics
$stats = [];
$res = $mysqli->query("SELECT COUNT(*) AS cnt FROM projects");
if ($row = $res->fetch_assoc()) $stats['projects'] = $row['cnt'];
$res = $mysqli->query("SELECT COUNT(*) AS cnt FROM messages");
if ($row = $res->fetch_assoc()) $stats['messages'] = $row['cnt'];

// Get all projects for the table
$all_projects = $mysqli->query("SELECT id, title, description, technologies, project_link, created_at FROM projects ORDER BY created_at DESC");
?>

<style>
    .admin-container {
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 20px;
        padding: 20px;
    }

    .sidebar {
        background: #1e3a8a;
        color: white;
        padding: 20px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        font-weight: 600;
    }

    .sidebar a:hover {
        text-decoration: underline;
    }

    .main-content {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .dashboard-cards {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .card {
        flex: 1 1 200px;
        background: #fefefe;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-4px);
    }

    .card h3 {
        margin: 0 0 10px;
        color: #1e3a8a;
    }

    .card .number {
        font-size: 2rem;
        font-weight: bold;
    }

    .card .button {
        display: inline-block;
        background: #1e3a8a;
        color: white;
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
    }

    .card .button:hover {
        background: #9333ea;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .admin-table th,
    .admin-table td {
        padding: 8px 12px;
        border: 1px solid #ddd;
    }

    .admin-table th {
        background: #f3f4f6;
        text-align: left;
    }

    .add-form {
        background: #f9fafb;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        border: 1px solid #e5e7eb;
    }

    .add-form h3 {
        margin-top: 0;
        color: #1e3a8a;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: #374151;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #d1d5db;
        border-radius: 4px;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #1e3a8a;
    }

    .btn-primary {
        background: linear-gradient(90deg, #1e3a8a, #9333ea);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-primary:hover {
        opacity: 0.9;
    }

    .notice {
        padding: 10px;
        border-radius: 4px;
        margin: 10px 0;
    }

    .notice.success {
        background: #d1fae5;
        border: 1px solid #10b981;
        color: #065f46;
    }

    .notice.error {
        background: #fee2e2;
        border: 1px solid #ef4444;
        color: #991b1b;
    }

    @media (max-width: 768px) {
        .admin-container {
            grid-template-columns: 1fr;
        }

        .sidebar {
            flex-direction: row;
            flex-wrap: wrap;
        }

        .sidebar a {
            flex: 1 1 45%;
        }
    }
</style>

<center>
    <h2>Admin Dashboard</h2>
</center>

<div class="admin-container">
    <nav class="sidebar">
        <a href="admin.php">Dashboard</a>
        <a href="messages.php">Messages</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="main-content">
        <div class="dashboard-cards">
            <div class="card">
                <h3>Projects</h3>
                <div class="number"><?php echo $stats['projects'] ?? 0; ?></div>
                <p><a href="#projects">View all</a></p>
            </div>
            <div class="card">
                <h3>Messages</h3>
                <div class="number"><?php echo $stats['messages'] ?? 0; ?></div>
                <p><a href="messages.php">View messages</a></p>
            </div>
        </div>

        <!-- Add New Project Form -->
        <div class="add-form">
            <h3>➕ Add New Project</h3>
            <?php if ($add_err): ?>
                <div class="notice error"><?php echo htmlspecialchars($add_err); ?></div>
            <?php endif; ?>
            <form method="post" action="admin.php">
                <input type="hidden" name="add_project" value="1">
                <div class="form-group">
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="technologies">Technologies (comma separated)</label>
                    <input type="text" id="technologies" name="technologies" placeholder="e.g. PHP, MySQL, JavaScript">
                </div>
                <div class="form-group">
                    <label for="project_link">Project Link</label>
                    <input type="url" id="project_link" name="project_link" placeholder="https://...">
                </div>
                <button type="submit" class="btn-primary">Add Project</button>
            </form>
        </div>

        <!-- All Projects List -->
        <h3 id="projects">📁 All Projects</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Technologies</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $all_projects->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars(substr($row['description'], 0, 50)) . (strlen($row['description']) > 50 ? '…' : ''); ?></td>
                        <td><?php echo htmlspecialchars($row['technologies']); ?></td>
                        <td><?php echo date('M j, Y', strtotime($row['created_at'])); ?></td>
                        <td>
                            <a href="edit_project.php?id=<?php echo $row['id']; ?>">✏️ Edit</a> |
                            <a href="admin.php?delete_project=<?php echo $row['id']; ?>" onclick="return confirm('Delete this project?')">🗑️ Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>