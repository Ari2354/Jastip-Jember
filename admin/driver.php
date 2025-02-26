<?php
session_start();
include '../config/config.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Proses form tambah driver
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Format email tidak valid.";
    } else {
        // Query untuk menambah driver baru
        $sql = "INSERT INTO drivers (name, phone, email) VALUES ('$name', '$phone', '$email')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Driver berhasil ditambahkan.";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Driver</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color:rgb(255, 255, 255); /* Warna latar belakang hitam */
            color: #ced4da; /* Warna teks abu-abu muda */
        }
        .card {
            background-color:rgb(254, 255, 253); /* Warna hitam ke abu-abu */
            color: #ced4da; /* Warna teks abu-abu muda */
            border: none; /* Menghapus border */
        }
        .card-header {
            background-color:rgb(138, 223, 111); /* Warna abu-abu gelap */
            color: #f8f9fa; /* Warna teks putih */
        }
        .form-control {
            background-color: rgb(255, 255, 255); /* Background input */
            color: #f8f9fa; /* Teks input */
            border: 1px solid #6c757d; /* Border abu-abu */
        }
        .form-control:focus {
            background-color: rgb(138, 223, 111); /* Background saat focus */
            color: #f8f9fa; /* Teks saat focus */
            border-color: #adb5bd; /* Border focus abu-abu lebih terang */
            box-shadow: none; /* Menghapus shadow */
        }
        .btn-success {
            background-color: #6c757d; /* Warna abu-abu gelap */
            border: none; /* Menghapus border */
        }
        .btn-success:hover {
            background-color: #adb5bd; /* Warna abu-abu lebih terang */
            color: #212529; /* Teks hitam */
        }
        .alert {
            background-color: #495057; /* Background abu-abu gelap */
            color: #f8f9fa; /* Teks putih */
            border: 1px solid #6c757d; /* Border abu-abu */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-person-plus-fill"></i> Tambah Driver</h4>
            </div>
            <div class="card-body">
                <!-- Pesan Success/Error -->
                <?php if (isset($message)) { ?>
                    <div class="alert">
                        <i class="bi bi-info-circle-fill"></i> <?php echo $message; ?>
                    </div>
                <?php } ?>

                <form action="driver.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label"><i class="bi bi-person"></i> Nama Driver</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama driver" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label"><i class="bi bi-telephone"></i> Nomor Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan nomor telepon" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"><i class="bi bi-envelope"></i> Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Tambah Driver</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
