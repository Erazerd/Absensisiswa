<?php
include "config/conn.php"; // Pastikan koneksi ke database sudah benar

// Pastikan ada parameter 'ids' yang dikirim melalui GET
if (isset($_GET['ids'])) {
    $ids = $_GET['ids'];
    
    // Ambil data siswa berdasarkan 'ids'
    $sql = mysqli_query($conn, "SELECT * FROM siswa WHERE ids='$ids'");
    $rs = mysqli_fetch_array($sql);
    if (!$rs) {
        echo "Data siswa tidak ditemukan.";
        exit;
    }
} else {
    echo "ID siswa tidak tersedia.";
    exit;
}
?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Edit Data Siswa</strong></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Edit Data Siswa</div>
            <div class="panel-body">
                <form method="post" role="form" action="././module/simpan.php?act=edit_siswa">
                    <input type="hidden" name="id" value="<?php echo $rs['ids']; ?>" />
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>NIS</label>
                            <input class="form-control" placeholder="NIS" name="nis" value="<?php echo $rs['nis']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input class="form-control" placeholder="Nama" name="nama" value="<?php echo $rs['nama_siswa']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="jk" value="L" <?php echo ($rs['jk'] == "L") ? "checked" : ""; ?>> Laki - Laki
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="jk" value="P" <?php echo ($rs['jk'] == "P") ? "checked" : ""; ?>> Perempuan
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" placeholder="Alamat" name="alamat" rows="3"><?php echo $rs['alamat']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <select class="form-control" name="kelas">
                                <?php
                                $sqlc = mysqli_query($conn, "SELECT * FROM kelas");
                                while ($rsc = mysqli_fetch_array($sqlc)) {
                                    $selected = ($rs['idk'] == $rsc['idk']) ? "selected" : "";
                                    echo "<option value='{$rsc['idk']}' $selected>{$rsc['nama_kelas']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon">+62</span>
                            <input type="text" class="form-control" placeholder="No Telepon" name="telepon" value="<?php echo $rs['telepon']; ?>">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nama Ayah</label>
                            <input class="form-control" placeholder="Nama Ayah" name="bapak" value="<?php echo $rs['nama_bapak']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Pekerjaan Ayah</label>
                            <input class="form-control" placeholder="Pekerjaan Ayah" name="k_bapak" value="<?php echo $rs['pekerjaan_bapak']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama Ibu</label>
                            <input class="form-control" placeholder="Nama Ibu" name="ibu" value="<?php echo $rs['nama_ibu']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Pekerjaan Ibu</label>
                            <input class="form-control" placeholder="Pekerjaan Ibu" name="k_ibu" value="<?php echo $rs['pekerjaan_ibu']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Ganti Password</label>
                            <input class="form-control" placeholder="Password baru" name="pass" type="password">
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
