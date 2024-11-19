<?php
session_start();
if (!empty($_SESSION['nama'])) {
    $uidi = $_SESSION['idu'];
    $usre = $_SESSION['nama'];
    $level = $_SESSION['level'];
    $klss = $_SESSION['idk'];
    $ortu = $_SESSION['ortu'];
    $idd = $_SESSION['id'];

    include "../../../config/conn.php"; // Pastikan file ini menggunakan mysqli
    include "../../../config/fungsi.php";
    require_once('../../../config/TCPDF-main/tcpdf.php');

    $filename = "Laporan_Absensi_Kelas.pdf";
    ob_start(); // Mulai output buffering
    $acuan = $_POST['idj'];
    $tgl_lengkap = $_POST['tgl_lengkap'];

    // Menggunakan prepared statements untuk mencegah SQL injection
    $stmt = mysqli_prepare($conn, "SELECT * FROM jadwal WHERE idj=?");
    mysqli_stmt_bind_param($stmt, "s", $acuan);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rss = mysqli_fetch_array($result);

    $stmt = mysqli_prepare($conn, "SELECT * FROM kelas WHERE idk=?");
    mysqli_stmt_bind_param($stmt, "s", $rss['idk']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $kss = mysqli_fetch_array($result);

    $stmt = mysqli_prepare($conn, "SELECT * FROM mata_pelajaran WHERE idm=?");
    mysqli_stmt_bind_param($stmt, "s", $rss['idm']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $nama_mp = mysqli_fetch_array($result);

    $stmt = mysqli_prepare($conn, "SELECT * FROM hari WHERE idh=?");
    mysqli_stmt_bind_param($stmt, "s", $rss['idh']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $nama_hari = mysqli_fetch_array($result);

    // Proses tahun ajaran
    $pecah = explode(" ", $tgl_lengkap);
    $satu = $pecah[0];
    $dua = $pecah[1];
    $tahun1 = $pecah[2];

    if (in_array($dua, ["Juli", "Agustus", "September", "Oktober", "November", "Desember"])) {
        $tahun2 = $tahun1 + 1;
        $tahun_ajaran = "Tahun Ajaran $tahun1 - $tahun2";
    } else {
        $tahun2 = $tahun1 - 1;
        $tahun_ajaran = "Tahun Ajaran $tahun2 - $tahun1";
    }

    // Ambil tanggal absensi
    $stmt = mysqli_prepare($conn, "SELECT DISTINCT tgl FROM absen WHERE idj=?");
    mysqli_stmt_bind_param($stmt, "s", $acuan);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $jumlahtanggal = mysqli_num_rows($result);
    $jumlahkolom = $jumlahtanggal + 1;

    // Buat konten PDF
    $content = "
   <style>
    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
    }
    table, th, td {
        border: 1px solid black;
    }
    th, td {
        text-align: center; /* Rata tengah secara horizontal */
        vertical-align: middle; /* Rata tengah secara vertikal */
        padding: 5px; /* Menambahkan ruang agar tidak terlalu rapat */
    }
    th {
        background-color: #f2f2f2;
    }
</style>
    <h3>Laporan Data Absensi Kelas {$kss['nama_kelas']} | {$nama_mp['nama_mata_pelajaran']}</h3>
                <p><b>$tahun_ajaran</b><br>{$nama_hari['nama_hari']}, {$rss['jam_mulai']} - {$rss['jam_selesai']}</p>
                <table cellpadding=0 cellspacing=0>
                <tr>
                    <td align='center' style='border: 1px solid #000; padding: 5px; font-size: 11.5px; background-color:#d0e9c6;' rowspan=2><b>Siswa</b></td>
                    <td align='center' style='border: 1px solid #000; padding: 5px; font-size: 11.5px; background-color:#d0e9c6;' colspan='$jumlahtanggal'><b>Tanggal/Bulan</b></td>
                </tr>
                <tr>";

    // Tambahkan tanggal ke tabel
    while ($tglnya = mysqli_fetch_array($result)) {
        $pecah = explode("-", $tglnya['tgl']);
        $content .= "<td align='middle' style='border: 1px solid #000; padding: 5px; font-size: 11.5px; background-color:#faf2cc;' colspan=2><b></b></td>
                     <td align='middle' style='border: 1px solid #000; padding: 5px; font-size: 11.5px; background-color:#faf2cc;' colspan=2><b>{$pecah[2]}/{$pecah[1]}</b></td>";
    }
    $content .= "</tr>";

    // Ambil data siswa
    $stmt = mysqli_prepare($conn, "SELECT * FROM siswa WHERE idk=?");
    mysqli_stmt_bind_param($stmt, "s", $rss['idk']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($siswanya = mysqli_fetch_array($result)) {
        $content .= "<tr>
                      <td align='center' style='border: 1px solid #000; padding: 5px; font-size: 11.5px; background-color:#faf2cc;'>{$siswanya['nama_siswa']}</td>";

        // Ambil keterangan absensi
        $stmt = mysqli_prepare($conn, "SELECT ket FROM absen WHERE ids=? AND idj=?");
        mysqli_stmt_bind_param($stmt, "ss", $siswanya['ids'], $acuan);
        mysqli_stmt_execute($stmt);
        $result2 = mysqli_stmt_get_result($stmt);

        while ($ketnya = mysqli_fetch_array($result2)) {
            $content .= "<td align='center' style='border: 1px solid #000; padding: 5px; font-size: 11.5px;'>{$ketnya['ket']}</td>";
        }
        $content .= "</tr>";
    }
    $content .= "
    </table>
    <br>
    <br>
    <b>Keterangan Absensi</b>
    <p>
        A = Tidak Masuk Tanpa Keterangan<br>
        I = Tidak Masuk Ada Surat Ijin Atau Pemberitahuan<br>
        S = Tidak Masuk Ada Surat Dokter Atau Pemberitahuan<br>
        M = Hadir
    </p>
";

    // Konversi HTML ke PDF
    try {
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
        $pdf->writeHTML($content, true, false, true, false, '');
        $pdf->Output($filename, 'I');
    } catch (Exception $e) {
        echo "Terjadi kesalahan dalam pembuatan PDF: " . $e->getMessage();
    }
} else {
    echo "<center><h2>Anda Harus Login Terlebih Dahulu</h2>
          <a href='index.php'><b>Klik ini untuk Login</b></a></center>";
}
