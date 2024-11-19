<?php
// Pastikan untuk menyertakan koneksi database mysqli
include 'config/conn.php';

$sql = mysqli_query($conn, "SELECT * FROM guru WHERE idg='$_GET[idg]'");
$rs = mysqli_fetch_array($sql);
?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Data Guru : <?php echo $rs['nama']; ?></strong></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Data Guru</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <fieldset disabled>
                            <div class="form-group">
                                <label>NIP</label><br>
                                <label><?php echo $rs['nip']; ?></label>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input class="form-control" placeholder="Nama" name="nama" value="<?php echo $rs['nama']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <?php if ($rs['jk'] == "L") { ?>
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
                                <?php } else { ?>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jk" value="L">Laki - Laki
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jk" value="P" checked>Perempuan
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" placeholder="Alamat" name="alamat" rows="3" disabled><?php echo $rs['alamat']; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
