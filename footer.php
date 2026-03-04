</main>
<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-info">
                &copy; <?php echo date('Y'); ?> My Portfolio
            </div>
            <div class="footer-social">
                <div class="social-links">
                    <a href="https://www.linkedin.com/in/yonas-guteta-1b427a38b" target="_blank" rel="noopener" class="social-link linkedin">
                        <i class="fab fa-linkedin"></i>
                        <span>LinkedIn</span>
                    </a>
                    <a href="https://t.me/jo65e" target="_blank" rel="noopener" class="social-link telegram">
                        <i class="fab fa-telegram"></i>
                        <span>Telegram</span>
                    </a>
                    <a href="mailto:johnguteta465@gmail.com" class="social-link email">
                        <i class="fas fa-envelope"></i>
                        <span>Email</span>
                    </a>
                    <a href="tel:+251965784143" class="social-link phone">
                        <i class="fas fa-phone"></i>
                        <span>Phone</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .site-footer {
        background-color: #333;
        color: #fff;
        padding: 2rem 0;
        margin-top: 3rem;
    }

    .footer-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
    }

    .footer-info {
        text-align: center;
        font-size: 0.95rem;
    }

    .social-links {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1rem;
    }

    .social-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background-color: #444;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .social-link:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .social-link.linkedin:hover {
        background-color: #0077b5;
    }

    .social-link.telegram:hover {
        background-color: #0088cc;
    }

    .social-link.email:hover {
        background-color: #ea4335;
    }

    .social-link.phone:hover {
        background-color: #34b7f1;
    }

    .social-link i {
        font-size: 1.2rem;
    }

    @media (min-width: 768px) {
        .footer-content {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        .footer-info {
            text-align: left;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.querySelector('.menu-toggle');
        const navList = document.querySelector('.nav-list');
        if (toggle && navList) {
            toggle.addEventListener('click', function() {
                const expanded = this.getAttribute('aria-expanded') === 'true' ? false : true;
                this.setAttribute('aria-expanded', expanded);
                navList.classList.toggle('active');
            });
        }
    });
</script>
</body>

</html>