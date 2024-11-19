<?php
include "config/conn.php"; // Pastikan koneksi database sudah benar

if ($_GET['act'] == "edit_sekolah") {
?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Data Sekolah</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Edit Data Sekolah
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                        // Menggunakan mysqli_query untuk query
                        $sql = mysqli_query($conn, "SELECT * FROM sekolah WHERE id='{$_GET['id']}'");
                        $rs = mysqli_fetch_array($sql);

                        if ($rs) {
                        ?>
                            <form method="post" role="form" action="././module/simpan.php?act=edit_sekolah">
                                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Kode Sekolah</label>
                                        <input class="form-control" placeholder="Kode" name="kode" value="<?php echo $rs['kode']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Sekolah</label>
                                        <input class="form-control" placeholder="Nama Sekolah" name="nama" value="<?php echo $rs['nama_sekolah']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea class="form-control" placeholder="Alamat" name="alamat" rows="3"><?php echo $rs['alamat']; ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </form>
                        <?php
                        } else {
                            echo "<p>Data tidak ditemukan.</p>";
                        }
                        ?>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
<?php
}
?>
