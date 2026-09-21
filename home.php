<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$fullName = $_SESSION['full_name'] ?? 'Explorer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nature of the Philippines</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-home">
    <header class="site-header">
        <a class="brand" href="home.php">
            <span class="brand-mark">NP</span>
            <span class="brand-name">Nature of the Philippines</span>
        </a>
        <nav class="topnav">
            <a class="nav-logout" href="logout.php">Log Out</a>
        </nav>
    </header>

    <div class="content">
        <h1>Nature of the Philippines</h1>
        <p class="tagline">7,641 islands of untouched beauty</p>
        <p class="login-subtitle">Welcome, <?php echo htmlspecialchars($fullName); ?></p>

        <section class="feature-grid landing-features">
            <div class="feature-card">
                <h3>Landmarks</h3>
                <p>Chocolate Hills, El Nido, Banaue Rice Terraces, Mayon Volcano and more.</p>
            </div>
            <div class="feature-card">
                <h3>Wildlife</h3>
                <p>Philippine Eagle, Tarsier, Dugong, Pawikan and other unique species.</p>
            </div>
            <div class="feature-card">
                <h3>Islands</h3>
                <p>7,641 islands with pristine beaches, crystal waters, and lush forests.</p>
            </div>
        </section>

        <div class="details">
            <div class="detail-group">
                <h3>Landmarks</h3>
                <p><strong>Chocolate Hills</strong> &mdash; 1,268 symmetrical mounds spread across Bohol.</p>
                <p><strong>El Nido</strong> &mdash; Towering limestone cliffs and turquoise lagoons in Palawan.</p>
                <p><strong>Banaue Rice Terraces</strong> &mdash; 2,000-year-old terraces hand-carved into the Ifugao mountains.</p>
                <p><strong>Mayon Volcano</strong> &mdash; The world's most perfectly shaped volcanic cone in Albay.</p>
            </div>

            <div class="detail-group">
                <h3>Wildlife</h3>
                <p><strong>Philippine Eagle</strong> &mdash; One of the largest and rarest eagles on Earth, a national symbol.</p>
                <p><strong>Tarsier</strong> &mdash; A tiny nocturnal primate with enormous eyes, native to Bohol.</p>
                <p><strong>Dugong</strong> &mdash; A gentle sea creature grazing in Palawan's seagrass meadows.</p>
                <p><strong>Pawikan</strong> &mdash; Endangered sea turtles nesting on Philippine shores every year.</p>
            </div>
        </div>
    </div>

    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <span class="brand-mark footer-mark">NP</span>
                <p class="footer-blurb">Exploring the natural wonders of the Philippines &mdash; 7,641 islands of untouched beauty.</p>
            </div>
        </div>
        <div class="footer-bottom">&copy; 2026 Nature of the Philippines &mdash; Web Project</div>
    </footer>
</body>
</html>