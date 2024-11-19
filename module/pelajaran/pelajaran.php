<?php
include "config/conn.php"; // Pastikan koneksi ke database sudah benar

// Query untuk mengambil data mata pelajaran
$sql = mysqli_query($conn, "SELECT * FROM mata_pelajaran");
?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Data Mata Pelajaran</strong></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Data Mata Pelajaran
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Mata Pelajaran</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($rs = mysqli_fetch_array($sql)) {
                                echo "<tr>";
                                echo "<td class='text-center'>{$no}</td>";
                                echo "<td class='text-center'>{$rs['nama_mata_pelajaran']}</td>";
                                echo "<td class='text-center'>
                                        <a href='././media.php?module=input_pelajaran&act=edit_pelajaran&idm={$rs['idm']}'>
                                            <button type='button' class='btn btn-info'>Edit</button>
                                        </a>
                                        <a href='././module/simpan.php?act=hapus_pelajaran&idm={$rs['idm']}'>
                                            <button type='button' class='btn btn-danger'>Hapus</button>
                                        </a>
                                      </td>";
                                echo "</tr>";
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
