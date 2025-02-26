<?php
// filepath: /C:/xampp/htdocs/jastipjember/menu.php
session_start();

// Sertakan file konfigurasi untuk koneksi database
include 'config/config.php';

// Query untuk mendapatkan semua produk
$sql = "SELECT * FROM products";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Produk</title>
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
                        <a class="nav-link active" href="menu.php"><i class="fas fa-utensils"></i> Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="keranjang.php"><i class="fas fa-shopping-cart"></i> Keranjang</a>
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
            <h1 class="display-4 font-weight-bold">Menu Produk</h1>
            <p class="lead text-muted">Berikut adalah daftar produk yang tersedia.</p>
        </div>
        <div class="container">
            <div class="row">
                <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="aset/image/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="card-text text-primary font-weight-bold">Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></p>
                            <?php if (isset($_SESSION['user_id'])) { ?>
                                <a href="pesan.php?id=<?php echo $row['id']; ?>" class="btn btn-primary mt-auto">Pesan</a>
                            <?php } else { ?>
                                <a href="login.php" class="btn btn-primary mt-auto">Pesan</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
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