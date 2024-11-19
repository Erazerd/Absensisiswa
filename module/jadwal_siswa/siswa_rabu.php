<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Jadwal Belajar</strong></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>

<?php
// Establishing a connection to the database
$mysqli = new mysqli('localhost', 'root', 'root', 'test');

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Prepare and execute the query to get class data
$stmt = $mysqli->prepare("SELECT * FROM kelas WHERE idk = ?");
$stmt->bind_param("s", $klss);
$stmt->execute();
$result = $stmt->get_result();
$rs = $result->fetch_assoc();
?>

<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Jadwal Belajar Kelas <?php echo htmlspecialchars($rs['nama']); ?>
            </div>
            <ul class="nav nav-tabs">
                <li role="presentation"><a href="media.php?module=siswa_senin">Senin</a></li>
                <li role="presentation"><a href="media.php?module=siswa_selasa">Selasa</a></li>
                <li role="presentation"><a href="media.php?module=siswa_rabu">Rabu</a></li>
                <li role="presentation"><a href="media.php?module=siswa_kamis">Kamis</a></li>
                <li role="presentation" class="active"><a href="media.php?module=siswa_jumat">Jum'at</a></li>
            </ul>
            <br>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Hari</th>
                                <th class="text-center">Jam</th>
                                <th class="text-center">Guru Pengajar</th>
                                <th class="text-center">Mata Pelajaran</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            // Prepare and execute the query to get schedule data
                            $stmt = $mysqli->prepare("
                                SELECT jadwal.idj, hari.hari, guru.nama AS nama_guru, mata_pelajaran.nama_mp,
                                       jadwal.jam_selesai, jadwal.jam_mulai
                                FROM jadwal
                                JOIN hari ON jadwal.idh = hari.idh
                                JOIN guru ON jadwal.idg = guru.idg
                                JOIN mata_pelajaran ON jadwal.idm = mata_pelajaran.idm
                                WHERE jadwal.idh = ? AND jadwal.idk = ?
                                ORDER BY jadwal.jam_mulai
                            ");
                            $id_hari = 5; // Assuming 5 is the ID for 'Jumat'
                            $stmt->bind_param("is", $id_hari, $rs['idk']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($rs = $result->fetch_assoc()) {
                            ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo htmlspecialchars($rs['hari']); ?></td>
                                    <td><?php echo htmlspecialchars($rs['jam_mulai'] . " - " . $rs['jam_selesai']); ?></td>
                                    <td><?php echo htmlspecialchars($rs['nama_guru']); ?></td>
                                    <td><?php echo htmlspecialchars($rs['nama_mp']); ?></td>
                                    <td>
                                        <a href="media.php?module=rekap_s&idj=<?php echo $rs['idj']; ?>">
                                            <button type="button" class="btn btn-primary">Data Absen</button>
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
       