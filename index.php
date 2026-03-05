<?php

/**
 * Yonas Guteta's Portfolio - Home Page
 * Action: Chat removed from footer, now a standalone page component.
 */

$bodyClass = 'home-page';
include 'header.php'; // Ensure your header.php doesn't contain the chat code
include 'db.php';

// 1. DATA LOGIC
$featuredProjects = [];
try {
    $stmt = $mysqli->prepare("SELECT id, title, description, technologies, project_link, created_at FROM projects ORDER BY created_at DESC LIMIT 2");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $featuredProjects[] = $row;
    }
} catch (Exception $e) {
    error_log($e->getMessage());
}
?>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --btn-gradient: linear-gradient(90deg, #6d28d9, #9333ea);
        --radius: 12px;
    }

    /* Layout Styling */
    .home-hero {
        padding: 5rem 1rem;
        background: var(--primary-gradient);
        color: white;
        text-align: center;
    }

    .featured-projects {
        max-width: 1200px;
        margin: 4rem auto;
        padding: 0 2rem;
    }

    .projects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2rem;
    }

    .project-card {
        background: white;
        border-radius: var(--radius);
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: 1px solid #edf2f7;
    }

    /* Side-by-Side Action Area */
    .action-row {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        margin-top: 4rem;
    }

    .main-btn {
        background: var(--btn-gradient);
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        transition: transform 0.2s;
    }

    /* Small AI Trigger Button (next to explore button) */
    .mini-ai-trigger {
        display: flex;
        align-items: center;
        gap: 8px;
        background: white;
        border: 2px solid #764ba2;
        padding: 0.8rem 1.2rem;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .mini-ai-trigger:hover {
        background: #f3f0ff;
        transform: scale(1.05);
    }

    .mini-ai-trigger span {
        color: #764ba2;
        font-weight: 700;
        font-size: 0.9rem;
    }

    /* --- Chat Box UI (Original Size) --- */
    #mainChat {
        position: fixed;
        bottom: 25px;
        right: 25px;
        width: 380px;
        height: 550px;
        background: white;
        border-radius: var(--radius);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        z-index: 2000;
        overflow: hidden;
        /* Start hidden/minimized */
        transform: translateY(calc(100% + 30px));
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    /* Class to show the chat */
    #mainChat.active {
        transform: translateY(0);
    }

    #mainChat.minimized {
        transform: translateY(calc(100% - 60px));
    }

    .chat-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.2rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-messages {
        flex: 1;
        padding: 1.2rem;
        overflow-y: auto;
        background: #f9fafb;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .msg {
        padding: 0.8rem 1rem;
        border-radius: 15px;
        font-size: 0.95rem;
        max-width: 85%;
    }

    .msg-ai {
        background: #e9ecef;
        color: #333;
        align-self: flex-start;
    }

    .msg-user {
        background: var(--primary-gradient);
        color: white;
        align-self: flex-end;
    }

    .chat-input-area {
        display: flex;
        padding: 1rem;
        border-top: 1px solid #eee;
        background: white;
    }

    .chat-input-area input {
        flex: 1;
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 0.5rem 1rem;
        outline: none;
    }

    .chat-input-area button {
        background: none;
        border: none;
        color: #764ba2;
        font-weight: bold;
        margin-left: 10px;
        cursor: pointer;
    }

    @media (max-width: 600px) {
        .action-row {
            flex-direction: column;
        }

        #mainChat {
            width: 92%;
            right: 4%;
            left: 4%;
        }
    }
</style>

<main>
    <section class="home-hero">
        <h1>Hi, I'm Yonas</h1>
        <p>Full-Stack Developer Specializing in Modern Web Solutions.</p>
    </section>

    <section class="featured-projects">
        <div class="projects-grid">
            <?php foreach ($featuredProjects as $project): ?>
                <article class="project-card">
                    <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                    <p><?php echo htmlspecialchars($project['description']); ?></p>
                    <a href="<?php echo htmlspecialchars($project['project_link']); ?>" target="_blank" style="color: #764ba2; font-weight: 600; font-size: 0.85rem;">View Source →</a>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="action-row">
            <a href="projects.php" class="main-btn">Explore All Work</a>

            <div class="mini-ai-trigger" onclick="openChat()">
                <span style="font-size: 1.1rem;">💬</span>
                <span>Ask AI Assistant</span>
            </div>
        </div>
    </section>
</main>

<div id="mainChat">
    <div class="chat-header" onclick="toggleChat()">
        <span>💬 AI Assistant</span>
        <span id="stateBtn">−</span>
    </div>
    <div class="chat-messages" id="chatDisplay">
        <div class="msg msg-ai">Hi! I'm Yonas's AI assistant. How can I help you today?</div>
    </div>
    <div class="chat-input-area">
        <input type="text" id="chatInput" placeholder="Type a message...">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<script>
    const chat = document.getElementById('mainChat');
    const display = document.getElementById('chatDisplay');
    const input = document.getElementById('chatInput');
    const stateBtn = document.getElementById('stateBtn');

    // Open chat when the "Ask AI" button is clicked
    function openChat() {
        chat.classList.add('active');
        chat.classList.remove('minimized');
        stateBtn.innerText = '−';
        input.focus();
    }

    // Toggle between minimized and expanded
    function toggleChat() {
        chat.classList.toggle('minimized');
        stateBtn.innerText = chat.classList.contains('minimized') ? '+' : '−';
    }

    async function sendMessage() {
        const text = input.value.trim();
        if (!text) return;

        appendMessage(text, 'user');
        input.value = '';

        const loader = appendMessage("Thinking...", 'ai');

        try {
            const response = await fetch("ai-chat.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    message: text
                })
            });
            const data = await response.json();
            loader.innerText = data.reply || "I'm having trouble thinking right now.";
        } catch (err) {
            loader.innerText = "Connection error.";
        }
    }

    function appendMessage(txt, sender) {
        const div = document.createElement('div');
        div.className = `msg msg-${sender}`;
        div.innerText = txt;
        display.appendChild(div);
        display.scrollTop = display.scrollHeight;
        return div;
    }

    input.addEventListener("keypress", (e) => {
        if (e.key === "Enter") sendMessage();
    });
</script>

<?php
// 2. FOOTER: Make sure your footer.php is clean of chat code!
include 'footer.php';
?>
