<?php
$bodyClass = 'projects-page';
include 'header.php';
include 'db.php';
?>

<style>
    .projects-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 3rem 0;
        text-align: center;
    }

    .projects-header h1 {
        font-size: 3rem;
        margin: 0;
    }

    .projects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        max-width: 1200px;
        margin: 3rem auto;
        padding: 0 2rem;
    }

    .project {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .project:hover {
        transform: translateY(-5px);
    }

    .project h3 {
        color: #1e3a8a;
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .project .muted {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .project p {
        color: #4b5563;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .skill-badge-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin: 1rem 0;
    }

    .skill-badge {
        background: #f3f4f6;
        padding: 0.4rem 1rem;
        border-radius: 30px;
        font-size: 0.9rem;
        color: #4b5563;
    }

    .actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .view-btn {
        display: inline-block;
        background: linear-gradient(90deg, #10b981, #06b6d4);
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
    }

    .btn-primary {
        display: inline-block;
        background: linear-gradient(90deg, #6d28d9, #9333ea);
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
    }
</style>

<div class="projects-header">
    <h1>All Projects</h1>
</div>

<div class="projects-grid">
    <?php
    $stmt = $mysqli->prepare("SELECT id, title, description, technologies, project_link, created_at FROM projects ORDER BY created_at DESC");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()):
        $techs = array_filter(array_map('trim', explode(',', $row['technologies'] ?? '')));
    ?>
        <article class="project">
            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
            <p class="muted"><?php echo date('M j, Y', strtotime($row['created_at'])); ?></p>
            <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>

            <?php if (!empty($techs)): ?>
                <div class="skill-badge-container">
                    <?php foreach ($techs as $t): ?>
                        <span class="skill-badge"><?php echo htmlspecialchars($t); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="actions">
                <?php if (stripos($row['title'], 'library management system') !== false): ?>
                    <a class="view-btn" href="http://joe-library-system.free.nf/" target="_blank">Visit</a>
                <?php elseif (!empty($row['project_link']) && filter_var($row['project_link'], FILTER_VALIDATE_URL)): ?>
                    <a class="view-btn" href="<?php echo htmlspecialchars($row['project_link']); ?>" target="_blank">Visit</a>
                <?php endif; ?>

                <?php if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true): ?>
                    <a class="btn-primary" href="edit_project.php?id=<?php echo (int)$row['id']; ?>">Edit</a>
                <?php endif; ?>
            </div>
        </article>
    <?php endwhile;
    $stmt->close(); ?>
</div>

<?php include 'footer.php'; ?>