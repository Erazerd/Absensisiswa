<?php
include "config/conn.php";

?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Jadwal Mengajar</strong></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<?php
    // Menggunakan mysqli_query sebagai pengganti mysql_query
    $sql = mysqli_query($conn, "SELECT * FROM guru WHERE nip='$uidi'");
    $rs = mysqli_fetch_array($sql);
?>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Hari</th>
                                <th class="text-center">Jam</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Mata Pelajaran</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        $sql = mysqli_query($conn, "
                            SELECT jadwal.idj, hari.nama_hari AS hari, kelas.nama_kelas, guru.idg AS id_guru, 
                                   mata_pelajaran.nama_mata_pelajaran AS nama_mp, jadwal.jam_selesai, jadwal.jam_mulai 
                            FROM jadwal
                            JOIN hari ON jadwal.idh = hari.idh
                            JOIN kelas ON jadwal.idk = kelas.idk
                            JOIN guru ON jadwal.idg = guru.idg
                            JOIN mata_pelajaran ON jadwal.idm = mata_pelajaran.idm
                            WHERE guru.idg = '{$rs['idg']}'
                            ORDER BY jadwal.idh ASC
                        ");

                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr class="odd gradeX">
                                <td><?php echo $no; ?></td>
                                <td><?php echo $row['hari']; ?></td>
                                <td><?php echo $row['jam_mulai'] . " - " . $row['jam_selesai']; ?></td>
                                <td><?php echo $row['nama_kelas']; ?></td>
                                <td><?php echo $row['nama_mp']; ?></td>
                                <td class="text-center">
                                    <a href="./././media.php?module=absen&idj=<?php echo $row['idj']; ?>">
                                        <button type="button" class="btn btn-info">Mulai Absen</button>
                                    </a>
                                    <a href="./././media.php?module=rekap_g&idj=<?php echo $row['idj']; ?>">
                                        <button type="button" class="btn btn-warning">Rekap Absen</button>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            $no++;
                        }
                        ?>
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
