<?php
// filepath: /C:/xampp/htdocs/jastipjember/admin/hapusproduk.php

// Mulai sesi
session_start();

// Periksa apakah pengguna sudah login sebagai admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Sertakan file konfigurasi untuk koneksi database
include '../config/config.php';

// Periksa apakah ID produk telah dikirim melalui URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Siapkan pernyataan SQL untuk menghapus produk
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $product_id);

    // Eksekusi pernyataan SQL
    if ($stmt->execute()) {
        // Jika berhasil, arahkan kembali ke halaman manajemen produk dengan pesan sukses
        $_SESSION['message'] = "Produk berhasil dihapus.";
        header("Location: hasiladdproduk.php");
        exit;
    } else {
        // Jika gagal, arahkan kembali ke halaman manajemen produk dengan pesan kesalahan
        $_SESSION['error'] = "Gagal menghapus produk.";
        header("Location: hasiladdproduk.php");
        exit;
    }
} else {
    // Jika ID produk tidak ada, arahkan kembali ke halaman manajemen produk
    $_SESSION['error'] = "ID produk tidak ditemukan.";
    header(header: "Location: hasiladdproduk.php");
    exit;
}
?>