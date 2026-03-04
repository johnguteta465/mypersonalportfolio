<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$bodyClass = 'home-page';
include 'header.php';
include 'db.php';
?>

<style>
    .home-hero {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 5.5rem 1rem 3rem;
        gap: 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .home-hero h1 {
        font-size: clamp(2rem, 4vw, 3.6rem);
        line-height: 1.2;
        font-weight: 800;
        margin: 0;
    }

    .home-hero p {
        font-size: 1.1rem;
        max-width: 800px;
        margin: 0 auto;
        opacity: 0.9;
    }

    .featured-projects {
        max-width: 1200px;
        margin: 3rem auto;
        padding: 0 2rem;
    }

    .featured-projects h2 {
        text-align: center;
        font-size: 2.5rem;
        margin-bottom: 2rem;
        color: #1e3a8a;
    }

    .projects-grid {
        display: flex;
        gap: 2rem;
        overflow-x: auto;
        padding-bottom: 1rem;
        /* space for scrollbar */
        scroll-snap-type: x mandatory;
    }

    .project-card {
        flex: 0 0 300px;
        /* fixed width, adjust as needed */
        scroll-snap-align: start;
    }

    .project-card:hover {
        transform: translateY(-5px);
    }

    .project-card h3 {
        color: #1e3a8a;
        margin-bottom: 0.5rem;
    }

    .project-date {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .project-tech {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin: 1rem 0;
    }

    .tech-badge {
        background: #f3f4f6;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        color: #4b5563;
    }

    .view-btn {
        display: inline-block;
        background: linear-gradient(90deg, #10b981, #06b6d4);
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        margin-top: 1rem;
    }

    .view-all {
        text-align: center;
        margin-top: 2rem;
    }

    .btn-primary {
        display: inline-block;
        background: linear-gradient(90deg, #6d28d9, #9333ea);
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
    }
</style>

<div class="home-hero">
    <h1>Welcome to My Portfolio</h1>
    <p>I build secure and dynamic full-stack web applications using PHP, MySQL, JavaScript, and modern web technologies.</p>
</div>

<div class="featured-projects">
    <h2>Featured Projects</h2>
    <div class="projects-grid">
        <?php
        $stmt = $mysqli->prepare("SELECT id, title, description, technologies, project_link, created_at FROM projects ORDER BY created_at DESC LIMIT 2");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()):
            $techs = array_filter(array_map('trim', explode(',', $row['technologies'] ?? '')));
        ?>
            <div class="project-card">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p class="project-date"><?php echo date('F j, Y', strtotime($row['created_at'])); ?></p>
                <p><?php echo htmlspecialchars($row['description']); ?></p>

                <?php if (!empty($techs)): ?>
                    <div class="project-tech">
                        <?php foreach ($techs as $tech): ?>
                            <span class="tech-badge"><?php echo htmlspecialchars($tech); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- View button logic (same as projects.php) -->
                <?php
                // Special case for Library Management System (case‑insensitive)
                if (stripos($row['title'], 'library management system') !== false):
                ?>
                    <a class="view-btn" href="https://github.com/johnguteta465/-Online-Library-Management-System-OLMS-" target="_blank">View</a>
                <?php elseif (!empty($row['project_link']) && filter_var($row['project_link'], FILTER_VALIDATE_URL)): ?>
                    <a class="view-btn" href="<?php echo htmlspecialchars($row['project_link']); ?>" target="_blank">View</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="view-all">
        <a href="projects.php" class="btn-primary">View All Projects</a>
    </div>
</div>

<?php include 'footer.php'; ?>