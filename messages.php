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

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $del = $mysqli->prepare("DELETE FROM messages WHERE id = ?");
    $del->bind_param('i', $id);
    $del->execute();
    $del->close();
    echo '<p class="notice">Message deleted.</p>';
}

$stmt = $mysqli->prepare("SELECT id, name, email, message, created_at FROM messages ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    .messages-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 2rem;
    }

    .messages-container h2 {
        color: #1e3a8a;
        margin-bottom: 1.5rem;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .admin-table th,
    .admin-table td {
        padding: 12px;
        border: 1px solid #e5e7eb;
    }

    .admin-table th {
        background: #f3f4f6;
        color: #374151;
        font-weight: 600;
    }

    .admin-table tr:hover {
        background: #f9fafb;
    }

    .delete-link {
        color: #dc2626;
        text-decoration: none;
        font-weight: 500;
    }

    .delete-link:hover {
        text-decoration: underline;
    }

    .notice {
        background: #c6f6d5;
        color: #22543d;
        padding: 1rem;
        border-radius: 8px;
        margin: 1rem 2rem;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 1rem;
        color: #1e3a8a;
        text-decoration: none;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>

<div class="messages-container">
    <h2>Messages</h2>
    <a href="admin.php" class="back-link">← Back to dashboard</a>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Sent</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars(substr($row['message'], 0, 50)) . (strlen($row['message']) > 50 ? '...' : ''); ?></td>
                    <td><?php echo date('M j, Y', strtotime($row['created_at'])); ?></td>
                    <td><a href="messages.php?delete=<?php echo $row['id']; ?>" class="delete-link" onclick="return confirm('Delete this message?')">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>