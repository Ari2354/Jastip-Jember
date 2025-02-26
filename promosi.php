<?php
// filepath: /C:/xampp/htdocs/jastipjember/promosi.php
session_start();
include 'config/config.php';

// Query untuk mengambil data promosi
$sql = "SELECT image, title, description, discount FROM promotions ORDER BY id DESC";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .promotion-card {
            max-width: 300px;
            margin: 0 auto;
        }
        .promotion-card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="panel">
            <h2>Promotions</h2>
            <p>Check out our latest promotions and offers!</p>
            <div class="row">
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4 mb-4">';
                        echo '<div class="card promotion-card">';
                        echo !empty($row["image"]) ? '<img src="aset/' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["title"]) . '">' : '<img src="default-image.jpg" alt="Default Image">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($row["title"]) . '</h5>';
                        echo '<p class="card-text">' . htmlspecialchars($row["description"]) . '</p>';
                        echo '<p class="card-text text-danger font-weight-bold">Discount: ' . htmlspecialchars($row["discount"]) . '%</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-muted">No promotions available at the moment.</p>';
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