<?php
// filepath: /C:/xampp/htdocs/jastipjember/sarapan.php
session_start();
include 'config/config.php';

// Query untuk mengambil data menu sarapan
$sql = "SELECT image, title, description, price FROM menu WHERE category = 'sarapan' ORDER BY id DESC";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Sarapan</title>
    <link rel="icon" href="aset/Jastip_Jember.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .panel {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .panel h2 {
            margin-top: 0;
        }
        .menu-card {
            max-width: 300px;
            margin: 0 auto;
        }
        .menu-card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="panel">
            <h2>Menu Sarapan</h2>
            <p>Rekomendasi menu sarapan untuk Anda!</p>
            <div class="row">
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4 mb-4">';
                        echo '<div class="card menu-card">';
                        echo !empty($row["image"]) ? '<img src="aset/' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["title"]) . '">' : '<img src="default-image.jpg" alt="Default Image">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($row["title"]) . '</h5>';
                        echo '<p class="card-text">' . htmlspecialchars($row["description"]) . '</p>';
                        echo '<p class="card-text text-success font-weight-bold">Price: Rp ' . htmlspecialchars($row["price"]) . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-muted">Tidak ada menu sarapan saat ini.</p>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$con->close();
?>