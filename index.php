<?php
session_start();
include 'config/config.php';

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
if (!$is_logged_in) {
    // Redirect to login page if trying to access 'pesan' without being logged in
    if (isset($_GET['action']) && $_GET['action'] == 'pesan') {
        header("Location: login.php");
        exit;
    }
}

// Fetch data from the database
$sql_users = "SELECT COUNT(*) AS total_users FROM users";
$result_users = $con->query($sql_users);
$total_users = $result_users->fetch_assoc()['total_users'];

$sql_orders = "SELECT COUNT(*) AS total_orders FROM orders WHERE status = 'baru'";
$result_orders = $con->query($sql_orders);
$total_orders = $result_orders->fetch_assoc()['total_orders'];

$sql_revenue = "SELECT SUM(total_price) AS total_revenue FROM orders WHERE status = 'selesai'";
$result_revenue = $con->query($sql_revenue);
$total_revenue = $result_revenue->fetch_assoc()['total_revenue'];

// Fetch driver data
$sql_drivers = "SELECT * FROM drivers";
$result_drivers = $con->query($sql_drivers);
$drivers = $result_drivers->fetch_all(MYSQLI_ASSOC); // Fetch all drivers at once
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jastip Jember</title>
    <link rel="icon" href="aset/Jastip_Jember.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="aset/Jastip_Jember.png" alt="Jastip Jember Logo" width="80" height="80" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php"><i class="fas fa-home"></i> Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menu.php"><i class="fas fa-utensils"></i> Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="keranjang.php"><i class="fas fa-shopping-cart"></i> Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kontak.php"><i class="fas fa-phone"></i> Kontak</a>
                    </li>
                    <?php if ($is_logged_in): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4">Selamat Datang di Jastip Jember</h1>
            <?php if ($is_logged_in): ?>
                <p class="lead">Selamat datang kembali, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            <?php else: ?>
                <p class="lead">Selamat datang di Jastip Jember, solusi terbaik untuk kebutuhan belanja Anda tanpa repot!</p>
            <?php endif; ?>
            <div class="input-group mt-4">
                <input type="text" class="form-control" placeholder="Cari makanan...">
                <button class="btn btn-dark" type="button"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="bg-gray-100 py-10">
        <div class="container text-center mb-8">
            <h1 class="text-4xl font-bold">Menu Promosi Spesial</h1>
            <p class="text-lg text-gray-600 mt-2">Menu populer</p>

            <div class="promotions-container">
                <?php
                // Query untuk mengambil data promosi
                $sql = "SELECT image, title, description, discount FROM promotions ORDER BY id DESC"; 
                $result = $con->query($sql);
                
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="card">';
                        echo !empty($row["image"]) ? '<img src="aset/' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["title"]) . '" class="w-32 h-32 mb-4 rounded-full" width="150" height="150">' : '<img src="default-image.jpg" alt="Default Image" class="w-32 h-32 mb-4 rounded-full" width="150" height="150">';
                        echo '<h2 class="text-xl font-bold mb-2 card-title">' . htmlspecialchars($row["title"]) . '</h2>';
                        echo !empty($row["description"]) ? '<p class="description text-gray-700 mb-2">' . htmlspecialchars($row["description"]) . '</p>' : '';
                        echo !empty($row["discount"]) ? '<p class="discount text-red-500 font-semibold">' . htmlspecialchars($row["discount"]) . '</p>' : '';
                        echo '<p class="timestamp text-gray-500">Muncul pada: ' . date('Y-m-d H:i:s') . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-gray-600">Tidak ada promosi saat ini.</p>';
                }
                ?>
            </div>
        </div>
        <div class="text-center">
            <a href="promosi.php" class="btn btn-primary font-bold py-2 px-6 rounded-full hover:bg-primary-dark transition duration-300">
                <i class="fas fa-eye"></i> VIEW PROMOTIONS PANEL
            </a>
        </div>
    </div>

    <div class="container mt-5">
        <h2 class="mb-4">Kategori Makanan</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <a href="sarapan.php"></a>
                        <img src="https://storage.googleapis.com/a1aa/image/tXNHf7cJ3dvSLzfd1BSGx-29qfQYN3-oZV4FUlU5gmE.jpg" class="card-img-top" alt="Sarapan">
                        <div class="card-body text-center">
                            <h5 class="card-title">Sarapan</h5>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <a href="cepatsaji.php">
                        <img src="https://storage.googleapis.com/a1aa/image/MAGlDGDcSkZBSBhFZRJLZn-PVV0GWGylc0y48z-kric.jpg" class="card-img-top" alt="Fast Food">
                        <div class="card-body text-center">
                            <h5 class="card-title">Fast Food</h5>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3"></div>
                <div class="card">
                    <a href="kue.php">
                        <img src="https://storage.googleapis.com/a1aa/image/OYWYRBsxsTLQR4xrFf0q2PViCBKKsjNtmRaUprVqU8M.jpg" class="card-img-top" alt="Kue">
                        <div class="card-body text-center">
                            <h5 class="card-title">Kue</h5>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <a href="minuman.php"></a>
                        <img src="https://storage.googleapis.com/a1aa/image/I8ND4Qthz7MFojcTN-AYNjqlNAfPmpD77WzRtLdK_bo.jpg" class="card-img-top" alt="Minuman">
                        <div class="card-body text-center">
                            <h5 class="card-title">Minuman</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h2 class="mb-4">Terdekat dengan kamu</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <img src="https://storage.googleapis.com/a1aa/image/Rr4xXXEivpVuyk7Ft3EE8Hjb9oO2gJLaw3dpT_7t2zA.jpg" class="card-img-top" alt="Sate Ayam Prapatan">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-star text-warning"></i>
                                <span class="ms-2">4.5 (120)</span>
                            </div>
                            <span>0.1 km</span>
                        </div>
                        <h5 class="card-title mt-2">Sate Ayam Prapatan</h5>
                        <p class="card-text">Rp 10.000</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <img src="https://storage.googleapis.com/a1aa/image/zmtvv3Df8iQfAqdGFgLAspe5nRgqtAe8_QCyG6vDbis.jpg" class="card-img-top" alt="Nasi Goreng Mak Inah">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-star text-warning"></i>
                                <span class="ms-2">5.0 (160)</span>
                            </div>
                            <span>500 m</span>
                        </div>
                        <h5 class="card-title mt-2">Nasi Goreng Mak Inah</h5>
                        <p class="card-text">Rp 5.000</p>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-5 mb-4">Jangan lupa minumnya biar nggak seret</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <img src="https://storage.googleapis.com/a1aa/image/38MqXzfbahQFzBoZX3U21gcTfzTsoWC5n7KkrUB9Frs.jpg" class="card-img-top" alt="Susu Coklat Es">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-star text-warning"></i>
                                <span class="ms-2">4.8 (110)</span>
                            </div>
                            <span>700 m</span>
                        </div>
                        <h5 class="card-title mt-2">Susu Coklat Es</h5>
                        <p class="card-text">Rp 5.000</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <img src="https://storage.googleapis.com/a1aa/image/C9edQOLrhgcXzUyb0riuMZEMVj1m0heZymX8Y4Xvqp8.jpg" class="card-img-top" alt="Es Buah Mbak Laras">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-star text-warning"></i>
                                <span class="ms-2">4.0 (90)</span>
                            </div>
                            <span>500 m</span>
                        </div>
                        <h5 class="card-title mt-2">Es Buah Mbak Laras</h5>
                        <p class="card-text">Rp 5.000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fixed Bottom Navigation -->
    <nav class="navbar fixed-bottom navbar-light fixed-bottom-nav">
        <div class="container-fluid">
            <a class="nav-link active" href="#">
                <i class="fas fa-home text-xl"></i>
                <span class="text-xs">Beranda</span>
            </a>
            <a class="nav-link" href="#">
                <i class="fas fa-plus-circle text-xl"></i>
                <span class="text-xs">Buat Postingan</span>
            </a>
            <a class="nav-link" href="#">
                <i class="fas fa-bell text-xl"></i>
                <span class="text-xs">Notifikasi</span>
            </a>
            <a class="nav-link" href="#">
                <i class="fas fa-cog text-xl"></i>
                <span class="text-xs">Pengaturan</span>
            </a>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <footer>
        <div class="container text-center text-secondary mt-5">
            &copy; 2021 Jastip Jember
        </div>
    </footer>
    <script>
        window.onload = function() {
            const header = document.querySelector('header');
            header.classList.add('show');
        };
    </script>
</body>
</html>
