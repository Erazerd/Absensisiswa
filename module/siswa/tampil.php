<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Data Siswa Per-Kelas</strong></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Pilih Kelas</div>
            <div class="panel-body">
                <div class="row">
                    <form method="get" role="form" action="././media.php?module=siswa">
                        <div class="col-lg-6">
                            <input type="hidden" name="module" value="siswa">
                            <div class="form-group">
                                <label>Kelas</label>
                                <select class="form-control" name="kls">
                                    <?php
                                    if ($_SESSION['level'] == "guru") {
                                        // Query untuk guru
                                        $sql = mysqli_query($conn, "SELECT * FROM kelas WHERE idk='$_SESSION[idk]'");
                                    } else {
                                        // Query untuk admin atau lainnya
                                        $sql = mysqli_query($conn, "SELECT * FROM kelas");
                                        echo "<option>semua</option>"; // Opsi "semua" untuk admin
                                    }

                                    // Loop untuk menampilkan opsi kelas
                                    while ($rs = mysqli_fetch_array($sql)) {
                                        $sqla = mysqli_query($conn, "SELECT * FROM sekolah WHERE id='$rs[id_sekolah]'");
                                        $rsa = mysqli_fetch_array($sqla);

                                        // Tampilkan nama kelas
                                        echo "<option value='{$rs['idk']}'>{$rs['nama_kelas']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
