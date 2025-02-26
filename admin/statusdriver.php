<?php
session_start();
include '../config/config.php';
// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Inisialisasi variabel pesan
$message = "";

// Ambil data driver


// Tutup koneksi database
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status Driver</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Update Status Driver</h2>
        
        <!-- Pesan Success/Error -->
        <?php if (!empty($message)) { ?>
            <?php echo $message; ?>
        <?php } ?>

        <!-- Tabel Data Driver -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                    <?php 
                    $q = "SELECT * FROM drivers";
                    $drivers = mysqli_query($con, $q);
                    while ($driver = mysqli_fetch_array($drivers)) { ?>
                        <tr>
                            <td><?php echo $driver['id']; ?></td>
                            <td><?php echo $driver['name']; ?></td>
                            <td><?php echo $driver['status']; ?></td>
                            <td>
                                <a href="update_status.php?id=<?php echo $driver['id']; ?>" class="btn btn-primary btn-sm">Update</a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data driver.</td>
                    </tr>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
