<?php
$host = 'sql213.infinityfree.com';
$user = 'if0_37737615';
$password = 'bbKhrSpW4V';
$database = 'if0_37737615_absensisiswa';

// Menggunakan mysqli_connect
$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
