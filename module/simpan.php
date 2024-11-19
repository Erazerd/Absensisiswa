<?php
include "../config/conn.php"; // Pastikan koneksi database tersambung


if ($_GET['act'] == "input_user") {
    $pw = md5($_POST['pass']);
    mysqli_query($conn, "INSERT INTO user(nama_user, pass, level, id_sekolah) VALUES ('$_POST[nama]', '$pw', 'admin_guru', '$_POST[sekolah]')");
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=user')</script>";
}

if ($_GET['act'] == "edit_user") {
    if (!empty($_POST['pass'])) {
        $pw = md5($_POST['pass']);
        mysqli_query($conn, "UPDATE user SET nama_user='$_POST[nama]', pass='$pw', id_sekolah='$_POST[sekolah]' WHERE idu='$_POST[idu]'");
    } else {
        mysqli_query($conn, "UPDATE user SET nama_user='$_POST[nama]', id_sekolah='$_POST[sekolah]' WHERE idu='$_POST[idu]'");
    }
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=user')</script>";
}

if ($_GET['act'] == "hapus_user") {
    mysqli_query($conn, "DELETE FROM user WHERE idu='$_GET[idu]'");
    echo "<script>window.alert('Data Terhapus'); window.location=('../media.php?module=user')</script>";
}

if ($_GET['act'] == "input_siswa") {
    $mr = md5($_POST["k_password"]);
    mysqli_query($conn, "INSERT INTO siswa(nis, nama_siswa, jk, alamat, idk, telepon, nama_bapak, pekerjaan_bapak, nama_ibu, pekerjaan_ibu, pass) VALUES ('$_POST[nis]', '$_POST[nama]', '$_POST[jk]', '$_POST[alamat]', '$_POST[kelas]', '$_POST[tlp]', '$_POST[bapak]', '$_POST[k_bapak]', '$_POST[ibu]', '$_POST[k_ibu]', '$mr')");
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=siswa&kls=semua')</script>";
}

if ($_GET['act'] == "edit_siswa") {
    $mr = md5($_POST["k_password"]);
    mysqli_query($conn, "UPDATE siswa SET nis='$_POST[nis]', nama_siswa='$_POST[nama]', jk='$_POST[jk]', alamat='$_POST[alamat]', idk='$_POST[kelas]', telepon='$_POST[tlp]', nama_bapak='$_POST[bapak]', pekerjaan_bapak='$_POST[k_bapak]', nama_ibu='$_POST[ibu]', pekerjaan_ibu='$_POST[k_ibu]', pass='$mr' WHERE ids='$_POST[id]'");
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=siswa&kls=semua')</script>";
}

if ($_GET['act'] == "siswa_det") {
    if (!empty($_POST['pass'])) {
        $pw = md5($_POST['pass']);
        mysqli_query($conn, "UPDATE siswa SET pass='$pw' WHERE ids='$_POST[id]'");
        echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=siswa_det')</script>";
    } else {
        echo "<script>window.alert('Isi Password'); window.location=('../media.php?module=siswa_det')</script>";
    }
}

if ($_GET['act'] == "hapus") {
    mysqli_query($conn, "DELETE FROM siswa WHERE ids='$_GET[ids]'");
    echo "<script>window.alert('Data Terhapus'); window.location=('../media.php?module=siswa&kls=semua')</script>";
}

if ($_GET['act'] == "input_absen") {
    $sql = mysqli_query($conn, "SELECT * FROM siswa WHERE idk='$_GET[kelas]'");
    while ($rs = mysqli_fetch_array($sql)) {
        $ra = $rs['ids'];
        $tgl = $_GET['tanggal'];
        $sqla = mysqli_query($conn, "SELECT * FROM absen WHERE ids='$rs[ids]' AND tgl='$tgl' AND idj='$_GET[idj]'");
        $conk = mysqli_num_rows($sqla);

        if ($conk == 0) {
            mysqli_query($conn, "INSERT INTO absen(ids, idj, tgl, ket) VALUES ('$rs[ids]', '$_GET[idj]', '$tgl', '$_POST[$ra]')");
        } else {
            mysqli_query($conn, "UPDATE absen SET ket='$_POST[$ra]' WHERE ids='$rs[ids]' AND tgl='$tgl' AND idj='$_GET[idj]'");
        }
    }
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=jadwal_mengajar')</script>";
}

if ($_GET['act'] == "input_sekolah") {
    mysqli_query($conn, "INSERT INTO sekolah(kode, nama_sekolah, alamat) VALUES ('$_POST[kode]', '$_POST[nama]', '$_POST[alamat]')");
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=sekolah')</script>";
}

if ($_GET['act'] == "edit_sekolah") {
    mysqli_query($conn, "UPDATE sekolah SET kode='$_POST[kode]', nama_sekolah='$_POST[nama]', alamat='$_POST[alamat]' WHERE id='$_POST[id]'");
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=sekolah')</script>";
}

if ($_GET['act'] == "hapus_sekolah") {
    mysqli_query($conn, "DELETE FROM sekolah WHERE id='$_GET[id]'");
    echo "<script>window.alert('Data Terhapus'); window.location=('../media.php?module=sekolah')</script>";
}

if ($_GET['act'] == "input_kelas") {
    mysqli_query($conn, "INSERT INTO kelas(id_sekolah, nama_kelas) VALUES ('$_POST[id]', '$_POST[nama]')");
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=kelas')</script>";
}

if ($_GET['act'] == "edit_kelas") {
    mysqli_query($conn, "UPDATE kelas SET id_sekolah='$_POST[id]', nama_kelas='$_POST[nama]' WHERE idk='$_POST[idk]'");
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=kelas')</script>";
}

if ($_GET['act'] == "hapus_kelas") {
    // Cek apakah ada entri di tabel jadwal yang terkait dengan kelas ini
    $result = mysqli_query($conn, "SELECT * FROM jadwal WHERE idk='$_GET[idk]'");
    if (mysqli_num_rows($result) > 0) {
        echo "<script>window.alert('Tidak bisa menghapus kelas karena ada jadwal yang terkait.');
              window.location=('../media.php?module=kelas')</script>";
    } else {
        // Hapus data kelas jika tidak ada data terkait
        mysqli_query($conn, "DELETE FROM kelas WHERE idk='$_GET[idk]'");
        echo "<script>window.alert('Data Kelas sudah terhapus'); window.location=('../media.php?module=kelas')</script>";
    }
}

if ($_GET['act'] == "input_pelajaran") {
    mysqli_query($conn, "INSERT INTO mata_pelajaran(nama_mata_pelajaran) VALUES ('$_POST[nama_mp]')");
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=mata_pelajaran')</script>";
}

if ($_GET['act'] == "edit_pelajaran") {
    mysqli_query($conn, "UPDATE mata_pelajaran SET nama_mata_pelajaran='$_POST[nama_mp]' WHERE idm='$_POST[idm]'");
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=mata_pelajaran')</script>";
}

if ($_GET['act'] == "edit_pelajaran") {
    mysqli_query($conn, "UPDATE mata_pelajaran SET nama_mata_pelajaran='$_POST[nama_mp]' WHERE idm='$_POST[idm]'");
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=mata_pelajaran')</script>";
}

// Fungsi untuk menghapus mata pelajaran
if ($_GET['act'] == "hapus_pelajaran") {
    // Cek apakah ada entri di tabel jadwal yang terkait dengan mata pelajaran ini
    $result = mysqli_query($conn, "SELECT * FROM jadwal WHERE idm='$_GET[idm]'");
    if (mysqli_num_rows($result) > 0) {
        // Jika ada data terkait, tampilkan pesan peringatan
        echo "<script>window.alert('Tidak bisa menghapus mata pelajaran karena ada jadwal yang terkait.');
              window.location=('../media.php?module=mata_pelajaran')</script>";
    } else {
        // Hapus data mata pelajaran jika tidak ada data terkait
        mysqli_query($conn, "DELETE FROM mata_pelajaran WHERE idm='$_GET[idm]'");
        echo "<script>window.alert('Data Mata Pelajaran sudah terhapus');
              window.location=('../media.php?module=mata_pelajaran')</script>";
    }
}

if ($_GET['act'] == "input_jadwal") {
    mysqli_query($conn, "INSERT INTO jadwal(idh, idg, idk, idm, jam_mulai, jam_selesai) VALUES ('$_POST[hari]', '$_POST[guru]', '$_POST[kelas]', '$_POST[pelajaran]', '$_POST[jam_mulai]', '$_POST[jam_selesai]')");
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=senin')</script>";
}

if ($_GET['act'] == "edit_jadwal") {
    mysqli_query($conn, "UPDATE jadwal SET idh='$_POST[hari]', idg='$_POST[guru]', idk='$_POST[kelas]', idm='$_POST[pelajaran]', jam_mulai='$_POST[jam_mulai]', jam_selesai='$_POST[jam_selesai]' WHERE idj='$_POST[idj]'");
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=senin')</script>";
}

if ($_GET['act'] == "hapus_jadwal") {
    // Hapus entri terkait di tabel absen terlebih dahulu
    $idj = $_GET['idj'];
    mysqli_query($conn, "DELETE FROM absen WHERE idj='$idj'");

    // Lalu hapus data di tabel jadwal
    mysqli_query($conn, "DELETE FROM jadwal WHERE idj='$idj'");
    
    echo "<script>window.alert('Data Jadwal dan data terkait sudah terhapus'); window.location=('../media.php?module=senin')</script>";
}

if ($_GET['act'] == "input_guru") {
    $mrg = md5($_POST['k_password']);
    mysqli_query($conn, "INSERT INTO guru(nip, nama, jk, alamat, pass) VALUES ('$_POST[nip]', '$_POST[nama]', '$_POST[jk]', '$_POST[alamat]', '$mrg')");
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=guru&kls=semua')</script>";
}

if ($_GET['act'] == "edit_guru") {
    $mrg = md5($_POST['k_password']);
    mysqli_query($conn, "UPDATE guru SET nip='$_POST[nip]', nama='$_POST[nama]', jk='$_POST[jk]', alamat='$_POST[alamat]', pass='$mrg' WHERE idg='$_POST[idg]'");
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=guru&kls=semua')</script>";
}

if ($_GET['act'] == "hapus_guru") {
    // Cek apakah ada entri di tabel jadwal yang terkait dengan guru ini
    $result = mysqli_query($conn, "SELECT * FROM jadwal WHERE idg='$_GET[idg]'");
    if (mysqli_num_rows($result) > 0) {
        echo "<script>window.alert('Tidak bisa menghapus guru karena ada jadwal yang terkait.');
              window.location=('../media.php?module=guru&kls=semua')</script>";
    } else {
        // Hapus data guru jika tidak ada data terkait
        mysqli_query($conn, "DELETE FROM guru WHERE idg='$_GET[idg]'");
        echo "<script>window.alert('Data Guru sudah terhapus'); window.location=('../media.php?module=guru&kls=semua')</script>";
    }
}

if ($_GET['act'] == "guru_det") {
    if (!empty($_POST['pass'])) {
        $pw = md5($_POST['pass']);
        mysqli_query($conn, "UPDATE guru SET nama='$_POST[nama]', jk='$_POST[jk]', alamat='$_POST[alamat]', pass='$pw' WHERE idg='$_POST[idg]'");
    } else {
        mysqli_query($conn, "UPDATE guru SET nama='$_POST[nama]', jk='$_POST[jk]', alamat='$_POST[alamat]' WHERE idg='$_POST[idg]'");
    }
    echo "<script>window.alert('Data Tersimpan'); window.location=('../media.php?module=guru_det')</script>";
}

?>
