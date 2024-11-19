<?php
if ($_GET['act'] == "input") {
?>
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><strong>Input Data Siswa</strong></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Input Data Siswa</div>
                <div class="panel-body">
                    <div class="row">
                        <form method="post" role="form" action="././module/simpan.php?act=input_siswa">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>NIS</label>
                                    <input class="form-control" placeholder="Nis" name="nis">
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input class="form-control" placeholder="Nama" name="nama">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jk" value="L" checked>Laki - Laki
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jk" value="P">Perempuan
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" placeholder="Alamat" name="alamat" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select class="form-control" name="kelas">
                                        <?php
                                        $sql = mysqli_query($conn, "SELECT * FROM kelas");
                                        while ($rs = mysqli_fetch_array($sql)) {
                                            $sqla = mysqli_query($conn, "SELECT * FROM sekolah WHERE id='$rs[id_sekolah]'");
                                            $rsa = mysqli_fetch_array($sqla);

                                            if ($_SESSION['level'] == "admin_guru" && $rsa['id'] == $_SESSION['id']) {
                                                echo "<option value='{$rs['idk']}'>{$rs['nama_kelas']}</option>";
                                            } elseif ($_SESSION['level'] != "admin_guru") {
                                                echo "<option value='{$rs['idk']}'>{$rs['nama_kelas']}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon">+62</span>
                                    <input type="text" class="form-control" placeholder="No Telepon" name="tlp">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nama Ayah</label>
                                    <input class="form-control" placeholder="Nama" name="bapak">
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input class="form-control" placeholder="Pekerjaan" name="k_bapak">
                                </div>
                                <div class="form-group">
                                    <label>Nama Ibu</label>
                                    <input class="form-control" placeholder="Nama" name="ibu">
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input class="form-control" placeholder="Pekerjaan" name="k_ibu">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" placeholder="Password" name="k_password" type="password">
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
?>
