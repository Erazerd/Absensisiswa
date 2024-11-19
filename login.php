<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEM ABSENSI SISWA</title>
    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                include 'config/conn.php';

                // Menggunakan mysqli untuk koneksi
                $sql = mysqli_query($conn, "SELECT * FROM sekolah WHERE id='1'");

                if ($sql) {
                    $rs = mysqli_fetch_array($sql);
                    // Check if 'nama' exists in the result
                    if (isset($rs['nama'])) {
                        $namaSekolah = htmlspecialchars($rs['nama']);
                    } else {
                        $namaSekolah = "Sekolah"; // Default text if 'nama' is not available
                    }
                } else {
                    echo "<div class='alert alert-danger'>Query Error: " . mysqli_error($conn) . "</div>";
                    $namaSekolah = "Sekolah"; // Default text if query fails
                }
                ?>
                <marquee><h2>Selamat Datang di Absensi SDN 007 Samarinda, Silahkan Admin dan Guru Login dibawah ini.</h2></marquee>
                
                <div class="login-panel panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="ceklog.php">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" required autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" required>
                                </div>
                                <button class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>
</body>
</html>
