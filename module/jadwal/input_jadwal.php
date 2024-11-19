<?php
include "config/conn.php"; // Pastikan ini terhubung dengan database yang benar

if ($_GET['act'] == "input") {
?>
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><strong>Input Data Jadwal</strong></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Input Data Jadwal</div>
                <div class="panel-body">
                    <form method="post" role="form" action="././module/simpan.php?act=input_jadwal">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Hari</label>
                                <select class="form-control" name="hari" required>
                                    <option value="">--Pilih Hari--</option>
                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM hari");
                                    if ($sql) {
                                        while ($rs = mysqli_fetch_array($sql)) {
                                            echo "<option value='{$rs['idh']}'>{$rs['nama_hari']}</option>";
                                        }
                                    } else {
                                        echo "<option value=''>Data tidak ditemukan</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jam Mulai</label>
                                <input type="time" class="form-control" required placeholder="Jam Mulai" name="jam_mulai">
                            </div>
                            <div class="form-group">
                                <label>Jam Selesai</label>
                                <input type="time" class="form-control" placeholder="Jam Selesai" name="jam_selesai">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Mata Pelajaran</label>
                                <select class="form-control" name="pelajaran" required>
                                    <option value="">--Pilih Mata Pelajaran--</option>
                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM mata_pelajaran");
                                    if ($sql) {
                                        while ($rs = mysqli_fetch_array($sql)) {
                                            echo "<option value='{$rs['idm']}'>{$rs['nama_mata_pelajaran']}</option>";
                                        }
                                    } else {
                                        echo "<option value=''>Data tidak ditemukan</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kelas</label>
                                <select class="form-control" name="kelas" required>
                                    <option value="">--Pilih Kelas--</option>
                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM kelas");
                                    if ($sql) {
                                        while ($rs = mysqli_fetch_array($sql)) {
                                            echo "<option value='{$rs['idk']}'>{$rs['nama_kelas']}</option>";
                                        }
                                    } else {
                                        echo "<option value=''>Data tidak ditemukan</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Guru</label>
                                <select class="form-control" name="guru" required>
                                    <option value="">--Pilih Guru--</option>
                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM guru");
                                    if ($sql) {
                                        while ($rs = mysqli_fetch_array($sql)) {
                                            echo "<option value='{$rs['idg']}'>{$rs['nama']}</option>";
                                        }
                                    } else {
                                        echo "<option value=''>Data tidak ditemukan</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
