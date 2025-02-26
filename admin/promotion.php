<?php
// filepath: /C:/xampp/htdocs/jastipjember/admin/promotion.php
session_start();

// Periksa apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Sertakan file konfigurasi untuk koneksi database
include '../config/config.php';

// Query untuk mendapatkan semua promosi
$sql = "SELECT * FROM promotions";
$result = $con->query($sql);

// Hapus promosi jika ada permintaan penghapusan
if (isset($_GET['hapus'])) {
    $id_promotion = $_GET['hapus'];
    $sql_delete = "DELETE FROM promotions WHERE id = ?";
    $stmt_delete = $con->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id_promotion);
    $stmt_delete->execute();
    header("Location: promotion.php");
    exit;
}

// Tambah atau edit promosi jika formulir dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);
    $discount = htmlspecialchars($_POST['discount']);
    $image = htmlspecialchars($_POST['image']);
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    if ($id) {
        // Edit promosi
        $sql_update = "UPDATE promotions SET title = ?, description = ?, start_date = ?, end_date = ?, discount = ?, image = ?, updated_at = NOW() WHERE id = ?";
        $stmt_update = $con->prepare($sql_update);
        $stmt_update->bind_param("ssssisi", $title, $description, $start_date, $end_date, $discount, $image, $id);
        $stmt_update->execute();
    } else {
        // Tambah promosi baru
        $sql_insert = "INSERT INTO promotions (title, description, start_date, end_date, discount, image, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt_insert = $con->prepare($sql_insert);
        $stmt_insert->bind_param("ssssss", $title, $description, $start_date, $end_date, $discount, $image);
        $stmt_insert->execute();
    }
    header("Location: promotion.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Promosi</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../aset/produk.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Kelola Promosi</h2>
        
        <!-- Table for promotions -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Judul Promosi</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Diskon</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['discount']); ?>%</td>
                        <td><img src="../aset/image/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="img-thumbnail" width="100"></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editPromotion(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['title']); ?>', '<?php echo htmlspecialchars($row['description']); ?>', '<?php echo htmlspecialchars($row['start_date']); ?>', '<?php echo htmlspecialchars($row['end_date']); ?>', '<?php echo htmlspecialchars($row['discount']); ?>', '<?php echo htmlspecialchars($row['image']); ?>')">Edit</button>
                            <a href="promotion.php?hapus=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus promosi ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Add/Edit Promotion Form -->
        <div class="text-center mt-3">
            <h3 id="form-title">Tambah Promosi Baru</h3>
            <form action="promotion.php" method="POST" class="form-inline">
                <input type="hidden" id="promotion-id" name="id">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Promosi</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                </div>
                <div class="mb-3">
                    <label for="discount" class="form-label">Diskon (%)</label>
                    <input type="number" class="form-control" id="discount" name="discount" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar</label>
                    <input type="text" class="form-control" id="image" name="image" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="resetForm()">Batal</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editPromotion(id, title, description, start_date, end_date, discount, image) {
            document.getElementById('form-title').innerText = 'Edit Promosi';
            document.getElementById('promotion-id').value = id;
            document.getElementById('title').value = title;
            document.getElementById('description').value = description;
            document.getElementById('start_date').value = start_date;
            document.getElementById('end_date').value = end_date;
            document.getElementById('discount').value = discount;
            document.getElementById('image').value = image;
        }

        function resetForm() {
            document.getElementById('form-title').innerText = 'Tambah Promosi Baru';
            document.getElementById('promotion-id').value = '';
            document.getElementById('title').value = '';
            document.getElementById('description').value = '';
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';
            document.getElementById('discount').value = '';
            document.getElementById('image').value = '';
        }
    </script>
</body>
</html>

<?php
$con->close();
?>