<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include '../config/orderbg.php';

// Query untuk mendapatkan semua pesanan
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

// Mengupdate status pesanan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $update_sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Status pesanan berhasil diperbarui!";
    } else {
        $_SESSION['message'] = "Gagal memperbarui status pesanan!";
    }

    header("Location: pesanan.php");
    exit;
}

$conn->close();
?>
