<?php
include "config/conn.php"; // Pastikan terhubung ke database dengan benar
?>
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Data Siswa</strong></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php
                $klas = $_GET['kls'];
                if ($klas == "semua") {
                    echo "Data Semua Siswa";
                } else {
                    $claris = mysqli_query($conn, "SELECT * FROM kelas WHERE idk='$_GET[kls]'");
                    $click = mysqli_fetch_array($claris);
                    echo "Data Siswa Kelas " . $click['nama_kelas'];
                }
                ?>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center">NIS</th>
                                <th class="text-center" width="30%">Nama</th>
                                <th class="text-center">JK</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">No Telepon</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

<?php
$no = 1;
$klas = $_GET['kls'];
if ($klas == "semua") {
    $sql = mysqli_query($conn, "SELECT * FROM siswa");
} else {
    $sql = mysqli_query($conn, "SELECT * FROM siswa WHERE idk='$_GET[kls]'");
}

while ($rs = mysqli_fetch_array($sql)) {
    $sqlw = mysqli_query($conn, "SELECT * FROM kelas WHERE idk='$rs[idk]'");
    $rsw = mysqli_fetch_array($sqlw);
    $sqlb = mysqli_query($conn, "SELECT * FROM sekolah WHERE id='$rsw[id_sekolah]'");
    $rsb = mysqli_fetch_array($sqlb);

    if ($_SESSION['level'] == "admin_guru") {
        if ($rsb['id'] == $_SESSION['id_sekolah']) {
?>
            <tr class="odd gradeX">
                <td><?php echo $rs['nis']; ?></td>
                <td><?php echo $rs['nama_siswa']; ?></td>
                <td class="text-center"><?php echo ($rs['jk'] == "L") ? "Laki - Laki" : "Perempuan"; ?></td>
                <td><?php echo $rs['idk']; ?></td>
                <td><?php echo $rs['telepon']; ?></td>
                <td class="text-center">
                    <a href="./././media.php?module=input_siswa&act=edit&ids=<?php echo $rs['ids'] ?>">
                        <button type="button" class="btn btn-info">Edit</button>
                    </a>
                    <a href="././module/simpan.php?act=hapus&ids=<?php echo $rs['ids'] ?>">
                        <button type="button" class="btn btn-danger">Hapus</button>
                    </a>
                </td>
            </tr>
<?php
        }
    } else {
?>
            <tr class="odd gradeX">
                <td><?php echo $rs['nis']; ?></td>
                <td><?php echo $rs['nama_siswa']; ?></td>
                <td class="text-center"><?php echo ($rs['jk'] == "L") ? "Laki - Laki" : "Perempuan"; ?></td>
                <td><?php
                    $namakelas = mysqli_query($conn, "SELECT * FROM kelas WHERE idk='$rs[idk]'");
                    $nama_kelas = mysqli_fetch_array($namakelas);
                    echo $nama_kelas['nama_kelas'];
                    ?></td>
                <td><?php echo $rs['telepon']; ?></td>
                <td class="text-center">
                    <a href="./././media.php?module=detail_siswa&act=details&ids=<?php echo $rs['ids'] ?>">
                        <button type="button" class="btn btn-warning">Details</button>
                    </a>
                     <!-- Edit -->
                                   
                    <a href="././module/simpan.php?act=hapus&ids=<?php echo $rs['ids'] ?>">
                        <button type="button" class="btn btn-danger">Hapus</button>
                    </a>
                </td>
            </tr>
<?php
    }
}
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
