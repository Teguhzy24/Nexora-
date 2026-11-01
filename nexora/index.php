
<?php
require_once __DIR__ . '/config/database.php';

$pageTitle = 'NEXORA — Gadget & Teknologi';
$searchQuery = trim($_GET['q'] ?? '');
$products = [];
$dbError = false;

try {
    if ($searchQuery !== '') {
        $sql = "SELECT id, name, slug, description, price, stock, image
                FROM products
                WHERE name LIKE ? OR description LIKE ?
                ORDER BY created_at DESC
                LIMIT 12";

        $stmt = $conn->prepare($sql);
        $keyword = '%' . $searchQuery . '%';
        $stmt->bind_param('ss', $keyword, $keyword);
    } else {
        $sql = "SELECT id, name, slug, description, price, stock, image
                FROM products
                ORDER BY created_at DESC
                LIMIT 8";

        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();
} catch (Throwable $e) {
    // Detail error disimpan di log server, bukan ditampilkan ke pengunjung.
    error_log($e->getMessage());
    $dbError = true;
}

require_once __DIR__ . '/includes/header.php';
?>

<section class="hero-section">
    <div class="container hero-grid">
        <div class="hero-content">
            <span class="eyebrow">
                <span class="eyebrow-dot"></span>
                TECHNOLOGY FOR EVERYDAY
            </span>

            <h1>
                Upgrade cara kamu
                <span>berteknologi.</span>
            </h1>

            <p class="hero-description">
                Temukan gadget pilihan dengan kualitas terbaik
                untuk menemani aktivitas dan produktivitasmu.
            </p>

            <div class="hero-actions">
                <a href="#produk" class="btn btn-primary">
                    Jelajahi Produk <span aria-hidden="true">→</span>
                </a>
                <a href="#keunggulan" class="btn btn-secondary">
                    Kenali NEXORA
                </a>
            </div>

            <div class="hero-note">
                <span class="note-check">✓</span>
                Pilihan teknologi untuk kebutuhan sehari-hari
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-image-frame">
                <img
                    src="https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=1000&q=85"
                    alt="Beragam perangkat elektronik dan gadget"
                    class="hero-image"
                >
            </div>

            <div class="floating-card">
                <span class="floating-icon">✦</span>
                <div>
                    <strong>Technology, simplified.</strong>
                    <p>Temukan perangkat favoritmu.</p>
                </div>
            </div>

            <div class="hero-decoration"></div>
        </div>
    </div>
</section>

<section class="benefits-section" id="keunggulan">
    <div class="container benefits-grid">
        <article class="benefit-item">
            <div class="benefit-icon">✓</div>
            <div>
                <h3>Produk Pilihan</h3>
                <p>Kurasi gadget untuk kebutuhanmu.</p>
            </div>
        </article>

        <article class="benefit-item">
            <div class="benefit-icon">◇</div>
            <div>
                <h3>Belanja Praktis</h3>
                <p>Jelajahi produk dengan mudah.</p>
            </div>
        </article>

        <article class="benefit-item">
            <div class="benefit-icon">₨</div>
            <div>
                <h3>Harga Transparan</h3>
                <p>Harga ditampilkan dalam Rupiah.</p>
            </div>
        </article>
    </div>
</section>

<section class="products-section" id="produk">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="section-eyebrow">PILIHAN UNTUKMU</span>
                <h2>
                    <?= $searchQuery !== ''
                        ? 'Hasil pencarian'
                        : 'Produk pilihan' ?>
                </h2>
                <p>
                    <?= $searchQuery !== ''
                        ? 'Hasil untuk: ' . htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8')
                        : 'Temukan perangkat yang mendukung aktivitasmu.' ?>
                </p>
            </div>

            <?php if ($searchQuery !== ''): ?>
                <a href="index.php" class="text-link">Hapus pencarian ×</a>
            <?php endif; ?>
        </div>

        <?php if ($dbError): ?>
            <div class="notice notice-error">
                Produk belum dapat dimuat. Silakan periksa koneksi database
                dan struktur tabel products.
            </div>

        <?php elseif (count($products) > 0): ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <?php
                    $productName = $product['name'] ?? 'Produk NEXORA';
                    $productSlug = $product['slug'] ?? '';
                    $productImage = trim((string) ($product['image'] ?? ''));
                    $productDescription = trim(
                        (string) ($product['description'] ?? '')
                    );
                    $price = (float) ($product['price'] ?? 0);
                    $stock = (int) ($product['stock'] ?? 0);
                    ?>

                    <article class="product-card">
                        <a
                            class="product-image-wrap"
                            href="product.php?slug=<?= rawurlencode($productSlug) ?>"
                            aria-label="Lihat <?= htmlspecialchars($productName, ENT_QUOTES, 'UTF-8') ?>"
                        >
                            <?php if ($productImage !== ''): ?>
                                <img
                                    src="<?= htmlspecialchars($productImage, ENT_QUOTES, 'UTF-8') ?>"
                                    alt="<?= htmlspecialchars($productName, ENT_QUOTES, 'UTF-8') ?>"
                                    class="product-image"
                                    loading="lazy"
                                >
                            <?php else: ?>
                                <div class="product-placeholder">
                                    <span>⌘</span>
                                    <small>NEXORA TECH</small>
                                </div>
                            <?php endif; ?>

                            <span class="product-badge">
                                <?= $stock > 0 ? 'Tersedia' : 'Habis' ?>
                            </span>
                        </a>

                        <div class="product-info">
                            <h3>
                                <a href="product.php?slug=<?= rawurlencode($productSlug) ?>">
                                    <?= htmlspecialchars($productName, ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </h3>

                            <p class="product-description">
                                <?= htmlspecialchars(
                                    $productDescription !== ''
                                        ? $productDescription
                                        : 'Perangkat teknologi pilihan dari NEXORA.',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </p>

                            <div class="product-card-bottom">
                                <span class="product-price">
                                    Rp<?= number_format($price, 0, ',', '.') ?>
                                </span>

                                <a
                                    href="product.php?slug=<?= rawurlencode($productSlug) ?>"
                                    class="product-arrow"
                                    aria-label="Lihat detail produk"
                                >↗</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">⌕</div>
                <h3>
                    <?= $searchQuery !== ''
                        ? 'Produk tidak ditemukan'
                        : 'Produk sedang dipersiapkan' ?>
                </h3>
                <p>
                    <?= $searchQuery !== ''
                        ? 'Coba gunakan kata kunci pencarian yang berbeda.'
                        : 'Produk akan tampil di sini setelah ditambahkan ke database.' ?>
                </p>

                <?php if ($searchQuery !== ''): ?>
                    <a href="index.php" class="btn btn-primary">
                        Lihat Semua Produk
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="cta-section" id="kontak">
    <div class="container">
        <div class="cta-content">
            <span class="section-eyebrow">YOUR NEXT TECH STARTS HERE</span>
            <h2>Teknologi yang tepat, untuk langkah berikutnya.</h2>
            <p>
                Jelajahi pilihan gadget yang sesuai dengan kebutuhanmu.
            </p>
            <a href="#produk" class="btn btn-light">
                Temukan Gadgetmu <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

