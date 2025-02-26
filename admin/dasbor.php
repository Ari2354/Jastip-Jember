<?php
session_start();
include '../config/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-md">
            <div class="p-4 flex items-center">
                <img src="../aset/Jastip_Jember.png" alt="Logo" class="w-10 h-10">
                <span class="ml-2 text-xl font-bold">Admin Jastip Jember</span>
            </div>
            <nav class="mt-6">
                <ul>
                    <li class="px-4 py-2 text-purple-600 bg-purple-100 rounded-lg flex items-center">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        <a href="dasbor.php">Dashboard</a>
                    </li>
                    
                    <li class="px-4 py-2 mt-2 flex items-center">
                        <i class="fas fa-boxes mr-3"></i>
                        <a href="hasiladdproduk.php">Produk</a> 
                    </li>
                    <li class="px-4 py-2 mt-2 flex items-center">
                        <i class="fas fa-boxes mr-3"></i>
                        <a href="promotion.php">promo</a> 
                    </li>
                    <li class="px-4 py-2 mt-2 flex items-center">
                        <i class="fas fa-users mr-3"></i>
                        <a href="mngpengguna.php">Manajemen Pengguna</a>
                    </li>
                    <li class="px-4 py-2 mt-2 flex items-center">
                        <i class="fas fa-car mr-3"></i>
                        <a href="driver.php">Driver</a>
                    </li>
                    <li class="px-4 py-2 mt-2 flex items-center">
                        <i class="fas fa-car-side mr-3"></i>
                        <a href="statusdriver.php">Status driver</a>
                    </li>
                    <li class="px-4 py-2 mt-2 flex items-center">
                        <i class="fas fa-list mr-3"></i>
                        <a href="driverlist.php">List driver</a>
                    </li>
                    <li class="px-4 py-2 mt-2 flex items-center">
                        <i class="fas fa-shopping-cart mr-3"></i>
                        <a href="keranjang.php">Pesanan</a>
                    </li>
                    <li class="px-4 py-2 mt-2 flex items-center">
                        <i class="fas fa-comments mr-3"></i>
                        <a href="fedback.php">Kritik dan Saran</a>
                    </li>
                    <li class="px-4 py-2 mt-2 flex items-center">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <a href="logout.php">Logout</a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="relative w-1/3">
                    <input type="text" class="w-full p-2 pl-10 border rounded-lg" placeholder="Search">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-bell text-gray-400 text-xl mr-6"></i>
                    <i class="fas fa-envelope text-gray-400 text-xl mr-6"></i>
                    <i class="fas fa-cog text-gray-400 text-xl mr-6"></i>
                    <div class="flex items-center">
                        <img src="https://storage.googleapis.com/a1aa/image/ij_v11uyTbz5ia_0xWhhymNeAg583QA23WZ15vPG29s.jpg" alt="User  Avatar" class="w-10 h-10 rounded-full">
                        <span class="ml-2">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Stats Cards -->
                <div class="col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-orange-100 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-orange-600"><?php echo $total_users; ?></div>
                        <div class="text-gray-600">Jumlah Pengguna</div>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-yellow-600"><?php echo $total_orders; ?></div>
                        <div class="text-gray-600">Pesanan Masuk</div>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg text -center">
                        <div class="text-2xl font-bold text-green-600">Rp <?php echo number_format($total_revenue, 0, ',', '.'); ?></div>
                        <div class="text-gray-600">Total Pendapatan</div>
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Widgets -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <!-- Daily Sales -->
                <div class="bg-white p-4 rounded-lg shadow-md col-span-2">
                    <div class="flex justify-between items-center mb-4">
                        <div class="text-lg font-bold">Daily Sales</div>
                        <button class="bg-gray-200 text-gray-600 px-4 py-2 rounded-lg">Export</button>
                    </div>
                    <div class="text-green-500 text-2xl font-bold mb-4">Rp <?php echo number_format($total_revenue, 0, ',', '.'); ?></div>
                    <div class="text-gray-400 mb-4">March 25 - April 02</div>
                    <div class="h-40 bg-gray-100 rounded-lg">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
                <!-- Users Online -->
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <div class="text-lg font-bold">17</div>
                        <div class="text-gray-400">Users online</div>
                        <div class="bg-green-200 text-green-600 px-2 py-1 rounded-lg">+5%</div>
                    </div>
                    <div class="h-40 bg-gray-100 rounded-lg">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>