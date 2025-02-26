<?php
$servername = "localhost"; // sesuaikan dengan server Anda
$username = "root";        // sesuaikan dengan username database Anda
$password = "";            // sesuaikan dengan password database Anda
$dbname = "jastip_jember";     // sesuaikan dengan nama database Anda

// Membuat koneksi
$con = new mysqli(hostname: $servername, username: $username, password: $password, database: $dbname);

// Cek koneksi
if ($con->connect_error) {
    die("Koneksi gagal: " . $con->connect_error);
}
?>

<?php
// Password yang ingin dienkripsi
$password = '123456';

// Enkripsi password menggunakan password_hash
$hashed_password = password_hash(password: $password, algo: PASSWORD_DEFAULT);

// Tampilkan hasil hash

?>
