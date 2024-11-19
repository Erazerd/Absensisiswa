<?php 
// Include file koneksi
include "config/conn.php";

// Pastikan variabel $conn sudah terdefinisi di dalam file config/conn.php
$today = hari_ina(date("l"));

// Mengganti nama kolom menjadi `nama_hari` sesuai dengan struktur tabel
$query = mysqli_query($conn, "SELECT * FROM hari WHERE nama_hari='$today'");

if (!$query) {
    die("Query error: " . mysqli_error($conn));
}

$id_hari = mysqli_fetch_array($query);

// Pastikan hasil query tidak null
if ($id_hari) {
    $now = date("H:i:s");
    $idh = (int)$id_hari['idh']; // Cast ke integer untuk menghindari null

    // Update jadwal untuk mengaktifkan sesuai kondisi
    $aktifkan = mysqli_query($conn, "UPDATE jadwal SET aktif=1 WHERE idh=$idh AND jam_mulai <= '$now' AND jam_selesai >= '$now'");

    if (!$aktifkan) {
        die("Aktifkan error: " . mysqli_error($conn));
    }

    // Update jadwal untuk menonaktifkan jadwal yang tidak relevan
    $nonaktifkan = mysqli_query($conn, "UPDATE jadwal SET aktif=0 WHERE idh <> $idh");
    if (!$nonaktifkan) {
        die("Nonaktifkan error: " . mysqli_error($conn));
    }

    $nonaktifkan2 = mysqli_query($conn, "UPDATE jadwal SET aktif=0 WHERE idh=$idh AND (jam_mulai >= '$now' OR jam_selesai <= '$now')");
    if (!$nonaktifkan2) {
        die("Nonaktifkan2 error: " . mysqli_error($conn));
    }

    // Memastikan ID Jadwal dari parameter GET
    if (isset($_GET['idj'])) {
        $idj = mysqli_real_escape_string($conn, $_GET['idj']);

        // Mendapatkan informasi jadwal tertentu berdasarkan ID
        $tentukan = mysqli_query($conn, "SELECT * FROM jadwal WHERE idj='$idj'");
        if (!$tentukan) {
            die("Tentukan error: " . mysqli_error($conn));
        }

        $aktifgak = mysqli_fetch_array($tentukan);

        if ($aktifgak && $aktifgak['aktif'] == 1) {
            include "input_absen.php";
        } else {
            echo "<center><br><h3>Maaf, Anda tidak bisa mengabsen siswa di luar jam pelajaran.</h3>
                  <a href='media.php?module=jadwal_mengajar'><b>Kembali</b></a></center>";
        }
    } else {
        echo "<center><br><h3>ID Jadwal tidak ditemukan dalam parameter GET.</h3>
              <a href='media.php?module=jadwal_mengajar'><b>Kembali</b></a></center>";
    }
} else {
    // Jika $id_hari null, tampilkan pesan error
    echo "<center><br><h3>Data hari '$today' tidak ditemukan di dalam database. Harap periksa kembali data hari di tabel.</h3>
          <a href='media.php?module=jadwal_mengajar'><b>Kembali</b></a></center>";
}