<?php
$bodyClass = 'about-page';
include 'header.php';
?>

<style>
    .about-wrapper {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: calc(100vh - 70px);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
    }

    .about-card {
        max-width: 1100px;
        width: 100%;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 40px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        padding: 3rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .about-header {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
    }

    .profile-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(145deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        color: white;
        box-shadow: 0 20px 30px -10px rgba(102, 126, 234, 0.5);
    }

    .title-section h1 {
        font-size: 3rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.5rem;
    }

    .title-section .tagline {
        font-size: 1.2rem;
        color: #4a5568;
        border-left: 4px solid #764ba2;
        padding-left: 1rem;
    }

    .intro-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #2d3748;
        margin-bottom: 2.5rem;
        background: rgba(102, 126, 234, 0.05);
        padding: 1.5rem;
        border-radius: 24px;
        border: 1px solid rgba(102, 126, 234, 0.2);
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 70%;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 2px;
    }

    .skills-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 2.5rem;
    }

    .skill-category {
        background: white;
        border-radius: 28px;
        padding: 1.8rem;
        box-shadow: 0 10px 30px -15px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .skill-category:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 40px -20px rgba(102, 126, 234, 0.4);
    }

    .skill-category h3 {
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        color: #2d3748;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .skill-category h3 i {
        color: #667eea;
        font-size: 2rem;
    }

    .skill-badge-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
    }

    .skill-badge {
        background: linear-gradient(145deg, #f0f4ff, #e6ecfe);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        font-size: 0.95rem;
        font-weight: 500;
        color: #2d3748;
        border: 1px solid rgba(102, 126, 234, 0.3);
        transition: all 0.2s ease;
        cursor: default;
    }

    .skill-badge:hover {
        background: #667eea;
        color: white;
        border-color: #667eea;
        transform: scale(1.05);
    }

    .training-section {
        margin-bottom: 2.5rem;
    }

    .training-list {
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        gap: 1.2rem;
    }

    .training-list li {
        background: rgba(118, 75, 162, 0.08);
        padding: 0.8rem 1.8rem;
        border-radius: 40px;
        font-size: 1.1rem;
        font-weight: 500;
        color: #4a5568;
        border: 1px dashed #764ba2;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .training-list li i {
        color: #764ba2;
        font-size: 1.2rem;
    }

    .cert-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.8rem;
    }

    .cert-card {
        background: white;
        border-radius: 30px;
        padding: 1.8rem;
        box-shadow: 0 15px 35px -20px rgba(0, 0, 0, 0.2);
        border-left: 6px solid #667eea;
        transition: 0.2s;
    }

    .cert-card:hover {
        border-left-width: 10px;
        box-shadow: 0 20px 40px -20px #667eea;
    }

    .cert-card h4 {
        font-size: 1.3rem;
        margin-bottom: 1rem;
        color: #2d3748;
    }

    .cert-card p {
        color: #4a5568;
        line-height: 1.5;
        font-size: 0.95rem;
    }

    .cert-badge {
        display: inline-block;
        margin-top: 1rem;
        background: #48bb78;
        color: white;
        padding: 0.3rem 1rem;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .contact-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin: 2.5rem 0 2rem;
        justify-content: center;
    }

    .contact-item {
        background: white;
        padding: 0.8rem 1.8rem;
        border-radius: 60px;
        border: 1px solid rgba(102, 126, 234, 0.3);
        color: #2d3748;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.02);
    }

    .contact-item:hover {
        background: linear-gradient(145deg, #667eea, #764ba2);
        color: white;
        border-color: transparent;
        transform: translateY(-3px);
        box-shadow: 0 12px 24px -8px rgba(102, 126, 234, 0.5);
    }

    .contact-item i {
        font-size: 1.3rem;
    }

    .closing {
        font-size: 1.2rem;
        font-weight: 500;
        text-align: center;
        margin-top: 3rem;
        padding: 2rem;
        background: linear-gradient(145deg, #fafbff, #f0f3ff);
        border-radius: 50px;
        color: #2d3748;
        border: 2px dashed #667eea;
    }

    .closing i {
        color: #667eea;
        margin: 0 0.3rem;
    }

    @media (max-width: 768px) {
        .about-wrapper {
            padding: 1rem;
        }

        .about-card {
            padding: 1.8rem;
        }

        .about-header {
            flex-direction: column;
            text-align: center;
        }

        .title-section h1 {
            font-size: 2.5rem;
        }

        .profile-icon {
            width: 100px;
            height: 100px;
            font-size: 2.8rem;
        }
    }
</style>

<div class="about-wrapper">
    <div class="about-card">
        <div class="about-header">
            <div class="profile-icon"><i class="fas fa-code"></i></div>
            <div class="title-section">
                <h1>About Me</h1>
                <div class="tagline">Full‑Stack Developer & Trainer</div>
            </div>
        </div>
        <div class="intro-text">
            <i class="fas fa-quote-left" style="color: #667eea; opacity: 0.6; margin-right: 0.5rem;"></i>
            I'm a passionate developer with hands‑on expertise in both front‑end and back‑end technologies.
            I love building robust applications and sharing knowledge through training. My approach combines
            clean code, modern design, and a continuous learning mindset.
        </div>

        <h2 class="section-title"></i>Core Expertise</h2>
        <div class="skills-grid">
            <div class="skill-category">
                <h3> Front‑End</h3>
                <div class="skill-badge-container">
                    <span class="skill-badge">HTML5</span>
                    <span class="skill-badge">CSS3</span>
                    <span class="skill-badge">JavaScript</span>
                    <span class="skill-badge">React.js</span>
                    <span class="skill-badge">Angular</span>
                </div>
            </div>
            <div class="skill-category">
                <h3></i> Back‑End & Database</h3>
                <div class="skill-badge-container">
                    <span class="skill-badge">PHP</span>
                    <span class="skill-badge">Node.js</span>
                    <span class="skill-badge">MySQL</span>
                    <span class="skill-badge">MongoDB</span>
                </div>
            </div>
        </div>

        <h2 class="section-title">Training & Mentorship</h2>
        <div class="training-section">
            <ul class="training-list">
                <li><i class="fab fa-vuejs"></i> Vue.js</li>
                <li><i class="fab fa-python"></i> Django (Python)</li>
                <li><i class="fab fa-python"></i> Python</li>
            </ul>
            <p style="margin-top: 1.2rem; color: #4a5568;">
                I've trained aspiring developers in these technologies, simplifying complex topics and guiding them through real‑world projects.
            </p>
        </div>

        <h2 class="section-title">Certifications</h2>
        <div class="cert-cards">
            <div class="cert-card">
                <h4>Web Development for Beginners</h4>
                <p>HTML5, CSS3, JavaScript fundamentals – building a solid foundation for modern web development.</p>
                <span class="cert-badge">Verified</span>
            </div>
            <div class="cert-card">
                <h4>Full Stack Java Development <span style="font-size:0.8rem; color:#718096;">(with JS stack)</span></h4>
                <p>HTML5, CSS3, JavaScript, React.js, Node.js, Angular, MongoDB, SQL. Comprehensive full‑stack training.</p>
                <span class="cert-badge">Certified</span>
            </div>
        </div>

        <h2 class="section-title">Connect with me</h2>
        <div class="contact-grid">
            <a href="https://t.me/jo65e" target="_blank" class="contact-item"><i class="fab fa-telegram"></i> @jo65e</a>
            <a href="mailto:johnguteta465@gmail.com" class="contact-item"><i class="fas fa-envelope"></i> johnguteta465@gmail.com</a>
            <a href="tel:+251965784143" class="contact-item"><i class="fas fa-phone-alt"></i> +251965784143</a>
            <a href="https://www.linkedin.com/in/yonas-guteta-1b427a38b" target="_blank" class="contact-item"><i class="fab fa-linkedin"></i> yonas-guteta</a>
        </div>

        <div class="closing">
            <i class="fas fa-rocket"></i> Let's build something amazing together! <i class="fas fa-rocket"></i>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>