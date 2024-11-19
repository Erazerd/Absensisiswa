<?php
// FILE KONEKSI
include "config/conn.php";

$pass = md5($_POST['password']);
$passw = $_POST['password'];
$user = $_POST['username'];

// Gunakan 'nama_user' alih-alih 'nama' sesuai dengan struktur tabel 'user'
$sql = mysqli_query($conn, "SELECT * FROM user WHERE nama_user='$user' AND pass='$pass'");
$count = mysqli_num_rows($sql);
$rs = mysqli_fetch_array($sql);

if ($count > 0) {
    session_start();
    $_SESSION['idu'] = $rs['idu'];
    $_SESSION['nama'] = $rs['nama_user']; // Sesuai kolom 'nama_user'
    $_SESSION['level'] = $rs['level'];
    $_SESSION['idk'] = "";
    $_SESSION['ortu'] = "";
    $_SESSION['id'] = $rs['id_sekolah']; // Sesuaikan dengan id sekolah

    header('Location: media.php?module=home');
} else {
    $mr = md5($_POST['password']);
    $sqla = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$user' AND pass='$mr'");
    $counta = mysqli_num_rows($sqla);
    $rsa = mysqli_fetch_array($sqla);

    if ($counta > 0) {
        session_start();
        $_SESSION['idu'] = $rsa['nis'];
        $_SESSION['nama'] = $rsa['nama'];
        $_SESSION['level'] = "user";
        $_SESSION['ortu'] = $passw;
        $_SESSION['idk'] = $rsa['idk'];
        $_SESSION['id'] = "2";

        header('Location: media.php?module=home');
    } else {
        $gr = md5($_POST['password']);
        $sqlz = mysqli_query($conn, "SELECT * FROM guru WHERE nip='$user' AND pass='$gr'");
        $countz = mysqli_num_rows($sqlz);
        $rsz = mysqli_fetch_array($sqlz);

        if ($countz > 0) {
            session_start();
            $_SESSION['idu'] = $rsz['nip'];
            $_SESSION['nama'] = $rsz['nama'];
            $_SESSION['idk'] = $rsz['idk'];
            $_SESSION['level'] = "guru";
            $_SESSION['ortu'] = "";
            $_SESSION['id'] = "2";

            header('Location: media.php?module=home');
        } else {
            echo "<script>alert('Mohon periksa kembali Username & Password Anda'); location.href='login.php';</script>";
        }
    }
}
?>
