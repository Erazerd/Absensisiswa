<?php
// Establish database connection
$connection = mysqli_connect($host, $user, $password, $database); // Replace with your actual database credentials
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Input Data Absensi</strong></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php
                $idj = $_GET['idj'];
                $dataquery = mysqli_query($connection, "SELECT * FROM jadwal WHERE idj='$idj'");
                $arrayj = mysqli_fetch_array($dataquery);
                $datamp = mysqli_query($connection, "SELECT * FROM mata_pelajaran WHERE idm='$arrayj[idm]'");
                $arraymp = mysqli_fetch_array($datamp);

                echo "Data Siswa";
                $sqlj = mysqli_query($connection, "SELECT * FROM kelas WHERE idk='$arrayj[idk]'");
                $rsj = mysqli_fetch_array($sqlj);

                echo "Kelas $rsj[nama_kelas] | $arraymp[nama_mata_pelajaran]";
                ?>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <form method="post" role="form" action="././module/simpan.php?act=input_absen&idj=<?php echo $idj ?>&tanggal=<?php echo date("Y-m-d") ?>&kelas=<?php echo $arrayj['idk'] ?>">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th class="text-center">NIS</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $tg = date("Y-m-d");
                                $sqljk = mysqli_query($connection, "SELECT * FROM siswa WHERE idk='$arrayj[idk]'");
                                while ($rs = mysqli_fetch_array($sqljk)) {
                                    $sqla = mysqli_query($connection, "SELECT * FROM absen WHERE ids='$rs[ids]' AND tgl='$tg' AND idj='$idj'");
                                    $rsa = mysqli_fetch_array($sqla);
                                    $conk = mysqli_num_rows($sqla);
                                    $sqlw = mysqli_query($connection, "SELECT * FROM kelas WHERE idk='$rs[idk]'");
                                    $rsw = mysqli_fetch_array($sqlw);
                                    $sqlb = mysqli_query($connection, "SELECT * FROM sekolah WHERE id='$rsw[idk]'");
                                    $rsb = mysqli_fetch_array($sqlb);
                                ?>
                                    <tr class="odd gradeX">
                                        <td><label style="font-weight:normal;"><?php echo "$rs[nis]"; ?></label></td>
                                        <td><label style="font-weight:normal;"><?php echo "$rs[nama_siswa]"; ?></label></td>

                                        <td class="text-center">
                                            <div class="form-group">
                                                <?php
                                                if ($conk == 0) {
                                                ?>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="<?php echo $rs['ids'] ?>" value="A">A
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="<?php echo $rs['ids'] ?>" value="I">I
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="<?php echo $rs['ids'] ?>" value="S">S
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="<?php echo $rs['ids'] ?>" value="M">M
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="<?php echo $rs['ids'] ?>" value="N" checked>N
                                                    </label>
                                                <?php
                                                } else {
                                                    $statuses = ['A', 'I', 'S', 'M', 'N'];
                                                    foreach ($statuses as $status) {
                                                        $checked = ($rsa['ket'] == $status) ? 'checked' : '';
                                                        echo "<label class='radio-inline'>
                                                                <input type='radio' name='{$rs['ids']}' value='$status' $checked>$status
                                                              </label>";
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-success">Simpan Data Absen</button>
                    </form>
                </div>
                <!-- /.table-responsive -->
                <br>
                <div class="well">
                    <h4>Keterangan Absensi</h4>
                    <p>A = Tidak Masuk Tanpa Keterangan</p>
                    <p>I = Tidak Masuk Ada Surat Ijin Atau Pemberitahuan</p>
                    <p>S = Tidak Masuk Ada Surat Dokter Atau Pemberitahuan</p>
                    <p>M = Hadir</p>
                    <p>N = Belum di Absen</p>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->