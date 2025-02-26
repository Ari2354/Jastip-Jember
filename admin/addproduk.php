<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include '../config/config.php';

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    // Tentukan folder tujuan untuk gambar
    $target_dir = "../aset/image/";
    $target_file = $target_dir . basename($image);

    // Cek apakah folder tujuan ada dan bisa ditulis
    if (!is_dir($target_dir)) {
        echo "Folder tujuan tidak ditemukan!";
    } else {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Query untuk menyimpan produk baru ke database
            $sql = "INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssis", $product_name, $description, $price, $image);
            $stmt->execute();

            // Cek jika produk berhasil ditambahkan
            if ($stmt->affected_rows > 0) {
                $message = "Produk berhasil ditambahkan!";
                $alert_type = "alert-success";
            } else {
                $message = "Gagal menambahkan produk!";
                $alert_type = "alert-danger";
            }

            $stmt->close();
        } else {
            echo "Gagal mengunggah gambar.";
        }
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="../aset/produk.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Tambah Produk</h2>

        <!-- Tampilkan pesan sukses atau error -->
        <?php if (isset($message)): ?>
            <div class="alert <?php echo $alert_type; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="addproduk.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="product_name" class="form-label">Nama Produk</label>
                <input type="text" name="product_name" id="product_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Harga</label>
                <input type="number" name="price" id="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Gambar Produk</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Tambah Produk</button>
        </form>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
