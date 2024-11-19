<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><strong>Data Guru</strong></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Data Guru</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center">NIP</th>
                                <th class="text-center" width="50%">Nama</th>
                                <th class="text-center">JK</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            // Pastikan variabel $conn telah dikonfigurasi dengan benar di file koneksi
                            $sql = mysqli_query($conn, "SELECT * FROM guru");
                            while ($rs = mysqli_fetch_array($sql)) { ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $rs['nip']; ?></td>
                                    <td><?php echo $rs['nama']; ?></td>
                                    <td class="text-center">
                                        <?php echo $rs['jk'] == "L" ? "Laki - Laki" : "Perempuan"; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="./././media.php?module=detail_guru&idg=<?php echo $rs['idg']; ?>">
                                            <button type="button" class="btn btn-warning">Detail</button>
                                        </a>
                                        <a href="./././media.php?module=input_guru&act=edit_guru&idg=<?php echo $rs['idg']; ?>">
                                            <button type="button" class="btn btn-info">Edit</button>
                                        </a>
                                        <a href="././module/simpan.php?act=hapus_guru&idg=<?php echo $rs['idg']; ?>">
                                            <button type="button" class="btn btn-danger">Hapus</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
