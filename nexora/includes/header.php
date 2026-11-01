
<?php
$pageTitle = $pageTitle ?? 'NEXORA — Gadget & Teknologi';
$searchQuery = trim($_GET['q'] ?? '');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="Temukan gadget dan teknologi pilihan di NEXORA.">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js" defer></script>
</head>
<body>

<header class="site-header">
    <div class="container header-inner">
        <a href="index.php" class="brand" aria-label="NEXORA Beranda">
            <span class="brand-mark">N</span>
            <span>NEXORA</span>
        </a>

        <button
            class="menu-toggle"
            id="menuToggle"
            type="button"
            aria-label="Buka menu navigasi"
            aria-expanded="false"
            aria-controls="mainNav"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="main-nav" id="mainNav">
            <a href="index.php" class="nav-link active">Beranda</a>
            <a href="index.php#produk" class="nav-link">Produk</a>
            <a href="index.php#keunggulan" class="nav-link">Tentang Kami</a>
        </nav>

        <div class="header-actions">
            <form action="index.php" method="GET" class="search-form">
                <span class="search-icon" aria-hidden="true">⌕</span>
                <input
                    type="search"
                    name="q"
                    placeholder="Cari gadget..."
                    value="<?= htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8') ?>"
                    aria-label="Cari produk"
                >
            </form>

            <a href="cart.php" class="cart-link" aria-label="Keranjang belanja">
                <span aria-hidden="true">🛒</span>
                <span class="cart-label">Keranjang</span>
            </a>
        </div>
    </div>
</header>

<main>
