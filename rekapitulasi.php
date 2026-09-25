<?php include "header.php"?>
<!-- Awal Row -->
<div class="row">
<!-- Awal col-md-12 -->
    <div class="col-md-12">
        <!-- Awal Card body -->
        <div class="card shadow mb-4 mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rekapitulasi Pengunjung</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="" class="text-center">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Dari Tanggal</label>
                                <input type="date" class="form-control" name="tanggal1" value="<?= isset($_POST['tanggal1'])? $_POST['tanggal1'] : date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sampai Tanggal</label>
                                <input type="date" class="form-control" name="tanggal2" value="<?= isset($_POST['tanggal2']) ? $_POST['tanggal2'] : date('Y-m-d') ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-2">
                            <button class="btn btn-primary form-control" name="btampilkan"><i class="fa fa-search"></i> Tampilkan</button>
                        </div>
                        <div class="col-md-2">
                            <a href="admin.php" class="btn btn-danger form-control"><i class="fa fa-backward"></i> Kembali</a>
                        </div>
                    </div>
                </form>

                <?php
                    if (isset($_POST['btampilkan'])) :
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Nama Pengunjung</th>
                                <th>Alamat</th>
                                <th>Tujuan</th>
                                <th>No. HP</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Nama Pengunjung</th>
                                <th>Alamat</th>
                                <th>Tujuan</th>
                                <th>No. HP</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $tgl1 = $_POST['tanggal1'];
                            $tgl2 = $_POST['tanggal2'];

                            $tampil = mysqli_query($koneksi, "SELECT * FROM ttamu where tanggal BETWEEN '$tgl1' and '$tgl2' order by id desc");
                            $no = 1;
                            while ($data = mysqli_fetch_array($tampil)) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['tanggal'] ?></td>
                                    <td><?= $data['nama'] ?></td>
                                    <td><?= $data['alamat'] ?></td>
                                    <td><?= $data['tujuan'] ?></td>
                                    <td><?= $data['nope'] ?></td>
                                </tr>
                             <?php } ?>
                                        
                        </tbody>
                    </table>

                    <!-- Tombol Export Excel & PDF -->

                    <div class="row justify-content-center mt-3">
                        <div class="col-md-3 mb-2">
                            <form method="POST" action="export/exportexcel.php">
                                    <input type="hidden" name="tanggala" value="<?= @$_POST['tanggal1'] ?>">
                                    <input type="hidden" name="tanggalb" value="<?= @$_POST['tanggal2'] ?>">
                                    <button class="btn btn-success form-control" name="bexport"><i class="fa fa-file-excel"></i> Export Data Excel</button>
                            </form>
                        </div>    
                        <div class="col-md-3 mb-2">
                            <form method="POST" action="export/exportpdf.php">
                                    <input type="hidden" name="tanggala" value="<?= @$_POST['tanggal1'] ?>">
                                    <input type="hidden" name="tanggalb" value="<?= @$_POST['tanggal2'] ?>">
                                    <button class="btn btn-danger form-control" name="bexport"><i class="fa fa-file-pdf"></i> Cetak PDF</button>
                            </form>
                        </div>    
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
        <!-- Akhir Card body -->
    </div>
    <!-- akhir col-md-12 -->
</div>
<!-- Akhir row -->


<?php include "footer.php"?>
