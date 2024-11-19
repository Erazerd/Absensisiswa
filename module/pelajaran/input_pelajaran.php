<?php
include "config/conn.php"; // Pastikan koneksi ke database sudah benar

if ($_GET['act'] == "input") {
?>
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><strong>Input Data Mata Pelajaran</strong></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Input Data Mata Pelajaran
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form method="post" role="form" action="././module/simpan.php?act=input_pelajaran">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Mata Pelajaran</label>
                                    <input type="text" class="form-control" placeholder="Mata Pelajaran" name="nama_mp" required>
                                </div>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
}

if ($_GET['act'] == "edit_pelajaran") {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Data Mata Pelajaran</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Edit Data Mata Pelajaran
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                        // Gunakan mysqli_query untuk koneksi mysqli
                        $idm = isset($_GET['idm']) ? intval($_GET['idm']) : 0;
                        $sql = mysqli_query($conn, "SELECT * FROM mata_pelajaran WHERE idm='$idm'");

                        // Cek apakah data ditemukan
                        if ($sql && mysqli_num_rows($sql) > 0) {
                            $rs = mysqli_fetch_array($sql);
                        ?>
                            <form method="post" role="form" action="././module/simpan.php?act=edit_pelajaran">
                                <input type="hidden" name="idm" value="<?php echo htmlspecialchars($idm); ?>" />
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Mata Pelajaran</label>
                                        <input class="form-control" placeholder="Mata Pelajaran" name="nama_mp" value="<?php echo htmlspecialchars($rs['nama_mata_pelajaran']); ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </form>
                        <?php
                        } else {
                            // Tampilkan pesan error jika data tidak ditemukan
                            echo "<p>Data tidak ditemukan untuk ID: " . htmlspecialchars($idm) . "</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
} 
?>
