<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'absensisiswa';

// Menggunakan mysqli_connect
$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
