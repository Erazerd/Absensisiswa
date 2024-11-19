<?php
// Pastikan Anda sudah menyertakan koneksi database di awal file ini
include "config/conn.php";

if ($_SESSION['level'] == "admin_guru") {
    $query = "SELECT kelas.*, sekolah.kode AS kode_sekolah, sekolah.nama_sekolah FROM kelas 
              INNER JOIN sekolah ON kelas.id_sekolah = sekolah.id 
              WHERE sekolah.id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);
} else {
    $query = "SELECT kelas.*, sekolah.kode AS kode_sekolah, sekolah.nama_sekolah FROM kelas 
              INNER JOIN sekolah ON kelas.id_sekolah = sekolah.id";
    $stmt = mysqli_prepare($conn, $query);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Data Kelas</strong></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Data Kelas
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center">Kode Sekolah</th>
                                <th class="text-center">Nama Sekolah</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($rs = mysqli_fetch_array($result)) : ?>
                                <tr class="odd gradeX">
                                    <td class="text-center"><?php echo $rs['kode_sekolah']; ?></td>
                                    <td class="text-center"><?php echo $rs['nama_sekolah']; ?></td>
                                    <td class="text-center"><?php echo $rs['nama_kelas']; ?></td>
                                    <td class="text-center">
                                        <a href="./././media.php?module=input_kelas&act=edit_kelas&idk=<?php echo $rs['idk']; ?>">
                                            <button type="button" class="btn btn-info">Edit</button>
                                        </a>
                                        <a href="././module/simpan.php?act=hapus_kelas&idk=<?php echo $rs['idk']; ?>">
                                            <button type="button" class="btn btn-danger">Hapus</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<?php
// Tutup statement dan koneksi
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
