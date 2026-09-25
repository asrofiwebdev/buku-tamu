<!-- panggil file header -->
<?php include "header.php"; ?>

<?php
// Uji jika tombol simpan diklik
if (isset($_POST['bsimpan'])) {
    $tgl = date('Y-m-d');

    // htmlspecialchars agar input lebih aman dari injection
    $nama = htmlspecialchars($_POST['nama'], ENT_QUOTES);
    $alamat = htmlspecialchars($_POST['alamat'], ENT_QUOTES);
    $tujuan = htmlspecialchars($_POST['tujuan'], ENT_QUOTES);
    $nope = htmlspecialchars($_POST['nope'], ENT_QUOTES);
    
    // persiapan query simpan data
    $simpan = mysqli_query($koneksi, "INSERT INTO ttamu VALUES (NULL, '$tgl', '$nama', '$alamat', '$tujuan', '$nope')");

    // Uji jika simpan data sukses
    if ($simpan) {
        echo "<script>alert('Simpan Data Sukses, Terima Kasih!');
              document.location='?'</script>";
    }else{
        echo "<script>alert('Simpan Data Gagal');
              document.location='?'</script>";
    }

}
?>
        <!-- Head -->
        <div class="head text-center">
            <img src="assets/img/logo.png" width="100" alt="">
            <h2 class="text-white">Sistem Informasi Buku Tamu <br> Asfahany's Tech </h2>
        </div>
        <!-- End Head -->

        <!-- Awal Row -->
        <div class="row mt-2">
            <!-- col-lg-7 -->
            <div class="col-lg-7 mb-3">
                <div class="card shadow bg-gradient-light">
                    <!-- awal card-body -->
                    <div class="card-body">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Identitas Pengunjung</h1>
                            </div>
                            <form class="user" method="POST" action="">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="nama" placeholder="Nama Pengunjung" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="alamat" placeholder="Alamat Pengunjung" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="tujuan" placeholder="Tujuan Pengunjung" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="nope" placeholder="No. HP Pengunjung" required>
                                </div>

                                <button type="submit" name="bsimpan" class="btn btn-primary btn-user btn-block">Simpan Data</button>
                                                               
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="#">&copy; Asfahany's Tech | 2025 - <?=date('Y') ?></a>
                            </div>
                    </div>
                    <!-- end card-body -->
                </div>
            </div>
            <!-- end col-lg-7 -->

            <!-- col-lg-5 -->
            <div class="col-lg-5 mb-3">
                <!-- card -->
                <div class="card shadow">
                    <!-- awal card-body -->
                    <div class="card-body">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Statistik Pengunjung</h1>
                        </div>
                        <?php
                        // deklarasi tanggal
                        $tgl_sekarang = date('Y-m-d');

                        // menampilkan tanggal kemarin
                        $kemarin = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));

                        // mendapatkan 6 hari sebelum tgl sekarang
                        $seminggu = date('Y-m-d h:i:s', strtotime('-1 week +1 day', strtotime($tgl_sekarang)));

                        $sekarang = date('Y-m-d h:i:s');
                        $bulan_ini = date('m');
                        
                        // persiapan query tampilkan jumlah data pengunjung
                        $tgl_sekarang = mysqli_fetch_array(mysqli_query($koneksi,"SELECT count(*) FROM ttamu where tanggal like '%$tgl_sekarang%'"));
                        $kemarin = mysqli_fetch_array(mysqli_query($koneksi,"SELECT count(*) FROM ttamu where tanggal like '%$kemarin%'"));
                        $seminggu = mysqli_fetch_array(mysqli_query($koneksi,"SELECT count(*) FROM ttamu where tanggal BETWEEN '$seminggu' and '$sekarang'"));
                        $sebulan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT count(*) FROM ttamu where month(tanggal) = '$bulan_ini'"));
                        $keseluruhan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT count(*) FROM ttamu"));
                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <td><i class="fas fa-calendar-day mr-2"></i>Hari ini</td>
                                <td>: <?= $tgl_sekarang[0] ?></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-calendar-minus mr-2"></i>Kemarin</td>
                                <td>: <?= $kemarin[0] ?></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-calendar-week mr-2"></i>Minggu ini</td>
                                <td>: <?= $seminggu[0] ?></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-calendar-alt mr-2"></i>Bulan ini</td>
                                <td>: <?= $sebulan[0] ?></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-chart-line mr-2"></i>Keseluruhan</td>
                                <td>: <?= $keseluruhan[0] ?></td>
                            </tr>
                        </table>
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col-lg-5 -->


        </div>
        <!-- End Row -->
        <!-- DataTables Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Pengunjung Hari ini [<?=date('d-m-Y')?>]</h6>
            </div>
            <div class="card-body">
                <a href="rekapitulasi.php" class="btn btn-success mb-3"><i class="fa fa-table"></i> Rekapitulasi Pengunjung</a>
                <a href="logout.php" class="btn btn-danger mb-3"><i class="fa fa-sign-out-alt"></i> Log Out</a>

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
                                        $tampil = mysqli_query($koneksi, "SELECT * FROM ttamu order by id desc");
                                        $no = 1;
                                        while($data = mysqli_fetch_array($tampil)) {
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
                </div>
            </div>
        </div>

<!-- panggil file footer -->
<?php include "footer.php"; ?>