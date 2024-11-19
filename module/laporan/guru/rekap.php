<?php
// FILE KONEKSI
include "config/conn.php";

$acuan = $_GET['idj'];
$sqlacuan = mysqli_query($conn, "SELECT * FROM jadwal WHERE idj='$acuan'");
$rss = mysqli_fetch_array($sqlacuan);

$sqlkss = mysqli_query($conn, "SELECT * FROM kelas WHERE idk='{$rss['idk']}'");
$kss = mysqli_fetch_array($sqlkss);

$sqlmp = mysqli_query($conn, "SELECT * FROM mata_pelajaran WHERE idm='{$rss['idm']}'");
$nama_mp = mysqli_fetch_array($sqlmp);

$sqlidh = mysqli_query($conn, "SELECT * FROM hari WHERE idh='{$rss['idh']}'");
$nama_hari = mysqli_fetch_array($sqlidh);

$pecah = explode(" ", $tgl_lengkap);
$satu = $pecah[0];
$dua = $pecah[1];
$tahun1 = $pecah[2];

if ($dua == "Juli" || $dua == "Agustus" || $dua == "September" || $dua == "Oktober" || $dua == "November" || $dua == "Desember") {
    $tahun2 = $tahun1 + 1;
} else {
    $tahun2 = $tahun1 - 1;
}
?>
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <strong>
                <?php
                if ($dua == "Juli" || $dua == "Agustus" || $dua == "September" || $dua == "Oktober" || $dua == "November" || $dua == "Desember") {
                    echo "Tahun Ajaran $tahun1 - $tahun2";
                } else {
                    echo "Tahun Ajaran $tahun2 - $tahun1";
                }
                ?>
            </strong>
            <form action="module/laporan/guru/cetak_rekap.php" method="post">
                <input type="hidden" name="idj" value="<?php echo $acuan; ?>">
                <input type="hidden" name="tgl_lengkap" value="<?php echo $tgl_lengkap; ?>">
                <input style="float:right; margin-top:-40px;" class="btn btn-success btn-lg" type="submit" name="cetak" value="Cetak">
            </form>
        </h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Data Absensi Kelas <?php echo "<b>{$kss['nama_kelas']} | {$nama_mp['nama_mata_pelajaran']}</b>"; ?>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <?php
                    $sqlabsen = mysqli_query($conn, "SELECT DISTINCT tgl FROM absen WHERE idj='$acuan'");
                    $jumlahtanggal = mysqli_num_rows($sqlabsen);
                    $jumlahkolom = $jumlahtanggal + 1;
                    ?>
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <td colspan="<?php echo $jumlahkolom; ?>" class="text-center info">
                                <?php echo "<b>{$nama_hari['nama_hari']}, {$rss['jam_mulai']} - {$rss['jam_selesai']}</b>"; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="success text-center" rowspan="2"><b>Siswa</b></td>
                            <td colspan="<?php echo $jumlahtanggal; ?>" class="text-center success"><b>Tanggal (TGL/BLN)</b></td>
                        </tr>
                        <tr>
                            <?php
                            while ($tglnya = mysqli_fetch_array($sqlabsen)) {
                                $pecah = explode("-", $tglnya['tgl']);
                                $satu = $pecah[0];
                                $dua = $pecah[1];
                                $tiga = $pecah[2];
                                ?>
                                <td class="text-center warning"><?php echo "<b>$tiga/$dua</b>"; ?></td>
                            <?php } ?>
                        </tr>
                        <?php
                        $sqlrss = mysqli_query($conn, "SELECT * FROM siswa WHERE idk='{$rss['idk']}'");
                        while ($siswanya = mysqli_fetch_array($sqlrss)) {
                            ?>
                            <tr>
                                <td class="text-center warning"><?php echo $siswanya['nama_siswa']; ?></td>
                                <?php
                                $sqlabsen2 = mysqli_query($conn, "SELECT ket FROM absen WHERE ids='{$siswanya['ids']}' AND idj='$acuan'");
                                while ($ketnya = mysqli_fetch_array($sqlabsen2)) {
                                    ?>
                                    <td class="text-center"><?php echo $ketnya['ket']; ?></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <div class="well">
                    <h4>Keterangan Absensi</h4>
                    <p>A = Tidak Masuk Tanpa Keterangan<br>
                    <p>I = Tidak Masuk Ada Surat Ijin Atau Pemberitahuan</p>
                    <p>S = Tidak Masuk Ada Surat Dokter Atau Pemberitahuan</p>
                    <p>M = Hadir

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
