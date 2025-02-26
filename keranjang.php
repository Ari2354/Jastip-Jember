<?php
// filepath: /C:/xampp/htdocs/jastipjember/keranjang.php
session_start();

// Sertakan file konfigurasi untuk koneksi database
include 'config/config.php';

// Periksa apakah keranjang belanja ada di sesi
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array();
}

// Jika ada permintaan untuk menghapus item dari keranjang
if (isset($_GET['hapus'])) {
    $id_produk = $_GET['hapus'];
    unset($_SESSION['keranjang'][$id_produk]);
    header("Location: keranjang.php");
    exit;
}

// Query untuk mendapatkan detail produk dalam keranjang
$produk_ids = array_keys($_SESSION['keranjang']);
if (count($produk_ids) > 0) {
    $ids = implode(',', $produk_ids);
    $sql = "SELECT * FROM products WHERE id IN ($ids)";
    $result = $con->query($sql);
} else {
    $result = array();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="aset/Jastip_Jember.png" alt="Jastip Jember Logo" width="80" height="80" class="d-inline-block align-text-top">
                Jastip Jember
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menu.php"><i class="fas fa-utensils"></i> Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="keranjang.php"><i class="fas fa-shopping-cart"></i> Keranjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kontak.php"><i class="fas fa-phone"></i> Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="daftar.php"><i class="fas fa-user-plus"></i> Daftar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="bg-light py-5">
        <div class="container text-center mb-5">
            <h1 class="display-4 font-weight-bold">Keranjang Belanja</h1>
            <p class="lead text-muted">Berikut adalah daftar produk yang ada di keranjang belanja Anda.</p>
        </div>
        <div class="container">
            <?php if (count($produk_ids) > 0) { ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_bayar = 0;
                        while ($row = $result->fetch_assoc()) {
                            $id_produk = $row['id'];
                            $jumlah = $_SESSION['keranjang'][$id_produk];
                            $total = $row['price'] * $jumlah;
                            $total_bayar += $total;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                            <td><?php echo $jumlah; ?></td>
                            <td>Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                            <td>
                                <a href="keranjang.php?hapus=<?php echo $id_produk; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')">Hapus</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="text-end">
                <h4>Total Bayar: Rp <?php echo number_format($total_bayar, 0, ',', '.'); ?></h4>
                <a href="checkout.php" class="btn btn-success">Checkout</a>
            </div>
            <?php } else { ?>
            <div class="alert alert-info text-center">
                Keranjang belanja Anda kosong.
            </div>
            <?php } ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white text-center py-4 mt-5">
        <div class="container">
            <p class="text-muted mb-0">&copy; 2021 Jastip Jember. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$con->close();
?>