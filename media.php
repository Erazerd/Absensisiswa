<?php
session_start();
if (!empty($_SESSION['nama'])) {
    $uidi = $_SESSION['idu'];
    $usre = $_SESSION['nama'];
    $level = $_SESSION['level'];
    $klss = $_SESSION['idk'];
    $ortu = $_SESSION['ortu'];
    $idd = $_SESSION['id'];

    include "config/conn.php";
    include "config/fungsi.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEM ABSENSI SISWA</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
    <script type="text/javascript">
      var detik = <?php echo date('s'); ?>;
      var menit = <?php echo date('i'); ?>;
      var jam = <?php echo date('H'); ?>;
      
      function clock() {
          if (detik != 0 && detik % 60 == 0) {
              menit++;
              detik = 0;
          }
          second = detik;
          if (menit != 0 && menit % 60 == 0) {
              jam++;
              menit = 0;
          }
          minute = menit;
          if (jam != 0 && jam % 24 == 0) {
              jam = 0;
          }
          hour = jam;
          if (detik < 10) {
              second = '0' + detik;
          }
          if (menit < 10) {
              minute = '0' + menit;
          }
          if (jam < 10) {
              hour = '0' + jam;
          }
          waktu = hour + ':' + minute + ':' + second;

          // Pengecekan apakah elemen dengan id "clock" ada
          var clockElement = document.getElementById("clock");
          if (clockElement) {
              clockElement.innerHTML = waktu;
          }

          detik++;
      }

      setInterval(clock, 1000);
    </script>
    <style media="screen">
      .labelol {
        padding: 0;
        margin: 0;
      }
    </style>
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="media.php?module=home">SISTEM ABSENSI SISWA</a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php
                        if ($level == "admin") {
                            echo "[[$usre]]";
                        } elseif ($level == "guru") {
                            echo "Guru: $usre";
                        } else {
                            echo "Siswa: $usre";
                        }
                        ?>
                    </a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php

                        // Check level of the user
                        if ($level == "admin" || $level == "guru") {
                            // Query to get the school name for admin or guru
                            $sqla = mysqli_query($conn, "SELECT nama_sekolah FROM sekolah WHERE id='$idd'");
                            if ($sqla && mysqli_num_rows($sqla) > 0) {
                                $rsa = mysqli_fetch_array($sqla);
                                echo $rsa['nama_sekolah'];
                            } else {
                                echo "Nama sekolah tidak ditemukan";
                            }
                        } else {
                            // Query to get class and school name for students
                            $sql = mysqli_query($conn, "SELECT * FROM kelas WHERE idk='$klss'");
                            if ($sql && mysqli_num_rows($sql) > 0) {
                                $rs = mysqli_fetch_array($sql);
                                $sqla = mysqli_query($conn, "SELECT nama_sekolah FROM sekolah WHERE id='{$rs['id_sekolah']}'");
                                if ($sqla && mysqli_num_rows($sqla) > 0) {
                                    $rsa = mysqli_fetch_array($sqla);
                                    echo "Kelas: " . $rs['nama_kelas'] . " | " . $rsa['nama_sekolah'];
                                } else {
                                    echo "Nama sekolah tidak ditemukan";
                                }
                            } else {
                                echo "Nama kelas tidak ditemukan";
                            }
                        }
                        ?>
                    </a>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php
                        $tgl_lengkap = tgl_ina(date("Y-m-d"));
                        if ($level == "guru") {
                            $hhari = hari_ina(date("l"));
                            echo "<b>$hhari, $tgl_lengkap</b> | <label class='labelol' id='clock'></label>";
                        } else {
                            echo $tgl_lengkap;
                        }
                        ?>
                    </a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="" href="logout.php">
                        <?php echo "Logout"; ?>
                    </a>
                </li>
            </ul>

            <!-- Sidebar Start -->
            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <?php if($level=='admin'){ ?>
                            <li>
                                <a href="#"><i class="fa fa-dashboard fa-fw"></i> Data Siswa<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="media.php?module=input_siswa&act=input">Input Data</a></li>
                                    <li><a href="media.php?module=tampil">View Data</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="#"><i class="fa fa-dashboard fa-fw"></i> Data Guru<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="media.php?module=input_guru&act=input">Input Data</a></li>
                                    <li><a href="media.php?module=guru">View Data</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="#"><i class="fa fa-dashboard fa-fw"></i> Data Kelas<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="media.php?module=input_kelas&act=input">Input Data</a></li>
                                    <li><a href="media.php?module=kelas">View Data</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="#"><i class="fa fa-dashboard fa-fw"></i> Data Mata Pelajaran<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="media.php?module=input_pelajaran&act=input">Input Data</a></li>
                                    <li><a href="media.php?module=mata_pelajaran">View Data</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="#"><i class="fa fa-dashboard fa-fw"></i> Data Jadwal<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="media.php?module=input_jadwal&act=input">Input Data</a></li>
                                    <li><a href="media.php?module=senin">View Data</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="media.php?module=sekolah"><i class="fa fa-dashboard fa-fw"></i> Data Sekolah</a>
                            </li>
                        <?php } ?>

                        <?php if($level=='user'){ ?>
                            <li><a href="media.php?module=siswa_senin"><i class="fa fa-bar-chart-o fa-fw"></i> Jadwal Belajar</a></li>
                        <?php } ?>
                        <?php if($level=='guru'){ ?>
                            <li><a href="media.php?module=jadwal_mengajar"><i class="fa fa-bar-chart-o fa-fw"></i> Jadwal Mengajar</a></li>
                            <li><a href="media.php?module=guru_det"><i class="fa fa-dashboard fa-fw"></i> Data Guru</a></li>
                        <?php } ?>
                        <?php if($level=='user'){ ?>
                            <li><a href="media.php?module=siswa_det"><i class="fa fa-dashboard fa-fw"></i> Data Siswa</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <!-- Sidebar End -->
        </nav>

        <div id="page-wrapper">
            <?php include "content.php"; ?>
        </div>
    </div>

    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/sb-admin.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTables-example').dataTable();
        });
    </script>

</body>
</html>

<?php 
} else {
    echo "<center><h2>Anda Harus Login Terlebih Dahulu</h2>
    <a href=index.php><b>Klik ini untuk Login</b></a></center>";
}
?>
