<?php  
    $nama_halaman = 'Detail Pesawat';

	include_once '_header.php';
	include_once '_menu-top.php';

    if (empty($_GET['id'])) {
        echo '<script>window.location="data-pesawat";</script>';
    }

    $pesawatID   = $_GET['id'];
    $query       = mysqli_query($connect, "SELECT * FROM data_pesawat WHERE pesawat_id = '$pesawatID' " ) or die (mysqli_error($connect));
    $pesawatData = mysqli_fetch_assoc($query);

    $queryDataRiwayat = mysqli_query($connect, "SELECT data_maintenancelog.*, data_pengguna.nama_lengkap, data_pesawat.nama_pesawat, data_pesawat.nomor_registrasi, data_pesawat.kode_pesawat
                                                    FROM data_maintenancelog
                                                    INNER JOIN data_pengguna
                                                    ON data_pengguna.pengguna_id = data_maintenancelog.pengguna_id
                                                    INNER JOIN data_pesawat
                                                    ON data_pesawat.pesawat_id = data_maintenancelog.pesawat_id
                                                    WHERE data_maintenancelog.pesawat_id = '$pesawatID'
                                                    ORDER BY tanggal_terbang DESC" ) or die (mysqli_error($connect));
    $resultDataRiwayat         = mysqli_fetch_all($queryDataRiwayat, MYSQLI_ASSOC);

    $queryInspection  = mysqli_query($connect, "SELECT data_maintenanceinspection.*, data_pengguna.nama_lengkap
                                                    FROM data_maintenanceinspection
                                                    INNER JOIN data_pengguna
                                                    ON data_pengguna.pengguna_id = data_maintenanceinspection.teknisi_id
                                                    WHERE pesawat_id = '$pesawatID'
                                                    ORDER BY tanggal_inspeksi DESC " ) or die (mysqli_error($connect));
    $resultDataInpeksi = mysqli_fetch_all($queryInspection, MYSQLI_ASSOC);
    $riwayatMaintenance = json_decode($pesawatData['riwayat_maintenance'], true);

    $queryLaporan  = mysqli_query($connect, "SELECT data_laporanpesawat.*, data_pengguna.nama_lengkap
                                                    FROM data_laporanpesawat
                                                    INNER JOIN data_pengguna
                                                    ON data_pengguna.pengguna_id = data_laporanpesawat.pelapor_id
                                                    WHERE pesawat_id = '$pesawatID'
                                                    ORDER BY waktu_ditambahkan DESC " ) or die (mysqli_error($connect));
    $resultLaporan = mysqli_fetch_all($queryLaporan, MYSQLI_ASSOC);

?>

    

        <div class="row">
            
            <div class="col-lg-12">
                <a href="data-pesawat" class="btn btn-sm btn-secondary mt-3 mb-4">
                    <i class="fas fa-undo mr-2"></i>Kembali
                </a>

                <div id="base-url" data-base-url="<?= BASE_URL; ?>"></div>
                <div id="data-id" data-pesawat="<?= $pesawatData['pesawat_id']; ?>"></div>

                

                <div class="row">
                    <div class="col-lg-12 ">
                        
                        <div class="card">
                            <div class="card-body">

                            <?php if (!empty($pesawatData)) : ?>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" id="navlink-grafik-data" href="#grafik-data" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Grafik & Data</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" id="navlink-riwayat-penerbangan" href="#riwayat-penerbangan" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">Riwayat Penerbangan</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" id="navlink-maintenance" href="#maintenance" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">Riwayat Maintenance </span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" id="navlink-laporan" href="#laporan" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                            <span class="d-none d-sm-block">Laporan Pesawat</span>    
                                        </a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" id="navlink-engine" href="#engine" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                            <span class="d-none d-sm-block">Engine Log</span>    
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" id="navlink-propeler" href="#propeler" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                            <span class="d-none d-sm-block">Propeler Log</span>    
                                        </a>
                                    </li> -->
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content p-3 text-muted">

                                    <!-- GRAFIK DAN DATA PESAWAT -->
                                    <div class="tab-pane active" id="grafik-data" role="tabpanel">
                                        <h4 class="card-title mb-5 mt-3">Grafik Penggunaan Pesawat</h4>

                                        <?php
                                            ListDetailMaintenance($pesawatData['total_time_inair'], $toleransiMaintenance, $riwayatMaintenance);
                                        ?>

                                        <canvas id="chartpesawat" height="100px">Your browser does not support the canvas element.</canvas>

                                        <hr>

                                        <h4 class="card-title mb-5 mt-3">Detail Data Pesawat</h4>

                                        <div class="table-responsive mt-5 col-lg-10 offset-lg-1">
                                            <table class="table mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" colspan="3" class="bg-light">INFORMASI PESAWAT</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="30%">Kode Pesawat</th>
                                                        <td width="5px">:</td>
                                                        <td ><?= $pesawatData['kode_pesawat']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >Nomor Registrasi</th>
                                                        <td >:</td>
                                                        <td ><?= $pesawatData['nomor_registrasi']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >Nama Pesawat</th>
                                                        <td >:</td>
                                                        <td ><?= $pesawatData['nama_pesawat']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >Max Lifetime</th>
                                                        <td >:</td>
                                                        <td ><?= $pesawatData['max_lifetime']; ?> Jam</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >Total Time in Air</th>
                                                        <td >:</td>
                                                        <td ><?= konversiMenit($pesawatData['total_time_inair']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >Time Since Overhaul</th>
                                                        <td >:</td>
                                                        <td ><?= $pesawatData['time_since_overhaul']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >Waktu Aircraft</th>
                                                        <td >:</td>
                                                        <td ><?= konversiMenit($pesawatData['aircraft_time']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >Waktu Engine</th>
                                                        <td >:</td>
                                                        <td ><?= konversiMenit($pesawatData['engine_time']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >Waktu Propeller</th>
                                                        <td >:</td>
                                                        <td ><?= konversiMenit($pesawatData['propeller_time']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >Jumlah Landing</th>
                                                        <td >:</td>
                                                        <td ><?= $pesawatData['engine_numberlanding']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >Status Pesawat</th>
                                                        <td >:</td>
                                                        <td ><?= $pesawatData['status_pesawat']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >Keterangan</th>
                                                        <td >:</td>
                                                        <td ><?= $pesawatData['keterangan']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" colspan="3" class="bg-light">MAINTENANCE TERAKHIR</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >50 Jam</th>
                                                        <td >:</td>
                                                        <td ><?= konversiMenit($riwayatMaintenance['mt50']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >100 Jam</th>
                                                        <td >:</td>
                                                        <td ><?= konversiMenit( $riwayatMaintenance['mt100']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >300 Jam</th>
                                                        <td >:</td>
                                                        <td ><?= konversiMenit( $riwayatMaintenance['mt300']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >400 Jam</th>
                                                        <td >:</td>
                                                        <td ><?= konversiMenit( $riwayatMaintenance['mt400']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >500 Jam</th>
                                                        <td >:</td>
                                                        <td ><?= konversiMenit( $riwayatMaintenance['mt500']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >1000 Jam</th>
                                                        <td >:</td>
                                                        <td ><?=  konversiMenit($riwayatMaintenance['mt1000']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" >2000 Jam</th>
                                                        <td >:</td>
                                                        <td ><?=  konversiMenit($riwayatMaintenance['mt2000']); ?></td>
                                                    </tr>
                                                    

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- RIWAYAT PENERBANGAN -->
                                    <div class="tab-pane" id="riwayat-penerbangan" role="tabpanel">
                                        <h4 class="card-title mb-5 mt-3">Riwayat Penerbangan</h4>

                                        <table id="customTable" class="custom-table table table-bordered table-striped  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th class="align-middle text-center" >No.</th>
                                                <th class="align-middle text-center" >Tgl</th>
                                                <th class="align-middle text-center">Nama Pilot</th>
                                                <th class="align-middle text-center">Tujuan Penerbangan</th>
                                                <th class="align-middle text-center">Waktu Diudara</th>
                                                <th class="align-middle text-center" width="10%">Jumlah  Pendaratan</th>
                                            </tr>
                                            </thead>


                                            <tbody>
                                            <?php 
                                                $no = 1; 
                                                foreach ($resultDataRiwayat as $vlog) :
                                            ?>
                                                <tr onclick="detailMaintenanceLog('<?= $vlog['maintenance_id']; ?>')">
                                                    <td class="hover-cell align-middle text-center"><?= $no++; ?></td>
                                                    <td class="hover-cell align-middle text-center"><?= date('d/m/Y', strtotime($vlog['tanggal_terbang'])); ?></td>
                                                    <td class="hover-cell align-middle text-left"><?= $vlog['nama_lengkap']; ?></td>
                                                    <td class="hover-cell align-middle"><?= $vlog['tujuan_penerbangan']; ?></td>
                                                    <td class="hover-cell align-middle text-center"><?= konversiMenit($vlog['waktu_diudara']); ?></td>
                                                    <td class="hover-cell align-middle text-center"><?= $vlog['jumlah_pendaratan']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- TAMBAH MAINTENANCE -->
                                    <div class="tab-pane" id="maintenance" role="tabpanel">
                                        
                                        <?php
                                                ListDetailMaintenance($pesawatData['total_time_inair'], $toleransiMaintenance, $riwayatMaintenance);
                                            ?>
                                        <?php if ($_SESSION['sistemlog']['level_akun'] == 'admin' || $_SESSION['sistemlog']['level_akun'] == 'enginer') : ?>
                                            <a href="<?= BASE_URL . 'app/tambah-inpeksi-pemeliharaan?id=' . $pesawatID; ?>" class="btn  btn-primary mb-2">Tambah Maintenance</a>
                                        <?php endif; ?>
                                            
                                        <h4 class="card-title mb-2 mt-3">Riwayat Maintenance</h4>
                                        <table id="" class="customTable custom-table table table-bordered table-striped  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th class="align-middle text-center " >No.</th>
                                                <th class="align-middle text-center ">Tanggal Maintenance</th>
                                                <th class="align-middle text-center " >Jenis Inspeksi</th>
                                                <th class="align-middle text-center ">Jenis Maintenance</th>
                                                <th class="align-middle text-center ">Teknisi</th>
                                                <th class="align-middle text-center ">Status</th>
                                                <?php if ($_SESSION['sistemlog']['level_akun'] == 'admin' || $_SESSION['sistemlog']['level_akun'] == 'enginer') : ?>
                                                <th class="align-middle text-center ">Aksi</th>
                                                <?php endif; ?>
                                            </tr>
                                            </thead>


                                            <tbody>
                                            <?php $no = 1; foreach ($resultDataInpeksi as $ispeksi) : ?>  <tr onclick="detailInspection('<?= $ispeksi['minspect_id']; ?>')">
                                                    <td class="hover-cell align-middle text-center"><?= $no++; ?></td>
                                                    <td class="hover-cell align-middle text-center"><?= date('d/m/Y', strtotime($ispeksi['tanggal_inspeksi'])); ?></td>
                                                    <td class="hover-cell align-middle text-center"><?= $ispeksi['jenis_inspeksi']; ?></td>
                                                    <td class="hover-cell align-middle text-center"><?= $ispeksi['jenis_maintenance']; ?></td>
                                                    <td class="hover-cell align-middle"><?= $ispeksi['nama_lengkap']; ?></td>
                                                    <td class="hover-cell align-middle text-center"><?= statusMaintenance($ispeksi['status_inspeksi']); ?></td>
                                                    <?php if ($_SESSION['sistemlog']['level_akun'] == 'admin' || $_SESSION['sistemlog']['level_akun'] == 'enginer') : ?>
                                                    <td class="hover-cell align-middle text-center">
                                                            <a href="update-inspeksi-pemeliharaan?id=<?= $ispeksi['minspect_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                                            <!-- <a href="javascript:void(0);" class="btn btn-sm btn-danger">Hapus</a> -->
                                                    </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?></tbody>
                                        </table>


                                    </div>

                                    <!-- LAPORAN PESAWAT -->
                                    <div class="tab-pane" id="laporan" role="tabpanel">
                                        <h4 class="card-title mb-5 mt-3">Laporan Pesawat</h4>
                                        
                                        <a href="<?= BASE_URL . 'app/tambah-laporan?id=' . $pesawatID; ?>" class="btn  btn-primary mb-2">Tambah Laporan</a>
                                        <table  class="custom-table table table-bordered table-striped  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th class="align-middle text-center" width="10%">Tgl</th>
                                                <th class="align-middle text-center">Nama Pelapor</th>
                                                <th class="align-middle text-center">Detail Laporan</th>
                                                <th class="align-middle text-center">Status</th>
                                                <th class="align-middle text-center">Teknisi</th>
                                                <th class="align-middle text-center" width="10%">Aksi</th>
                                            </tr>
                                            </thead>


                                            <tbody>
                                            <?php 
                                                $no = 1; 
                                                foreach ($resultLaporan as $laporlog) :
                                            ?>
                                                <tr>
                                                    <td class="hover-cell align-middle text-center"><?= date('d/m/Y', $laporlog['waktu_ditambahkan']); ?></td>
                                                    <td class="hover-cell align-middle text-left"><?= $laporlog['nama_lengkap']; ?></td>
                                                    <td class="hover-cell align-middle"><?= $laporlog['keterangan_laporan']; ?></td>
                                                    <td class="hover-cell align-middle text-center"><?= $laporlog['status_laporan']; ?></td>
                                                    <td class="hover-cell align-middle text-center"><?= namaTeknisi($laporlog['teknisi_id']); ?></td>
                                                    <td class="hover-cell align-middle text-center">
                                                        <?php if (($laporlog['pelapor_id'] == $_SESSION['sistemlog']['pengguna_id']) && $laporlog['status_laporan'] == 'menunggu') :?>
                                                            <a href="javascript:void(0);" onclick="batalkanLaporan('<?= $laporlog['lapor_id']; ?>', '<?= $laporlog['pesawat_id']; ?>') " class="btn btn-sm btn-danger" title="Batalkan Laporan"><i class="fas fa-times"></i></a>
                                                        <?php endif; 
                                                        
                                                        if (($_SESSION['sistemlog']['level_akun'] == 'enginer') && $laporlog['status_laporan'] == 'menunggu') :?>
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" onclick="konfirmasiLaporan('<?= $laporlog['lapor_id']; ?>', '<?= $laporlog['pesawat_id']; ?>') "><i class="fas fa-check"></i></a>
                                                        <?php endif; ?> 
                                                    </td>
                                                </tr>
                                                
                                            <?php endforeach; 
                                                if (empty($resultLaporan)) {
                                                    echo '<tr><td colspan="6" class="text-center"><i>Tidak ada laporan mengenai pesawat saat ini</i></td></tr>';
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- ENGINE LOG -->
                                    <!-- <div class="tab-pane" id="engine" role="tabpanel">
                                        <h4 class="card-title mb-5 mt-3">Engine Log</h4>
                                    </div>


                                    <div class="tab-pane" id="propeler" role="tabpanel">
                                        <h4 class="card-title mb-5 mt-3">Propeler Log</h4>
                                    </div> -->
                                </div>
                            
                            <?php else: ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="mdi mdi-block-helper mr-2"></i>
                                    ERROR — Data yang anda cari tidak ditemukan!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                               

                                
                                
                            </div>
                        </div>

                        
                        
                    </div>
                </div>

            </div>

            
        </div>

        <div class="modal fade modal-detail-maintenancelog" id="modal-detail-maintenancelog" tabindex="-1" role="dialog" aria-labelledby="modal-detail-maintenancelog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-detail-maintenancelog-title">Detail Riwayat Penerbangan Pesawat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                        <div class="table-responsive table-sm col-md-8 offset-md-2">
                            <table class="table mb-0">

                                
                                <tbody>
                                    <tr class="bg-secondary">    
                                        <th scope="row" colspan="3" class="text-center text-white">DETAIL PESAWAT</th>
                                    </tr>
                                    <tr>
                                        <th scope="row" width="30%"><b>Tanggal Penerbangan</b></th>
                                        <td width="5%">:</td>
                                        <td id="dt_tanggal_terbang">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" ><b>Nomor Registrasi</b></th>
                                        <td>:</td>
                                        <td id="dt_noreg_pesawat">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Kode Pesawat</th>
                                        <td>:</td>
                                        <td id="dt_kode_pesawat">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nama Pilot</th>
                                        <td>:</td>
                                        <td id="dt_nama_lengkap">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tujuan Penerbangan</th>
                                        <td>:</td>
                                        <td id="dt_tujuan_penerbangan">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Waktu Diudara</th>
                                        <td>:</td>
                                        <td id="dt_waktu_diudara">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Jumlah Pendaratan</th>
                                        <td>:</td>
                                        <td id="dt_jumlah_pendaratan">-</td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle" scope="row">Catatan</th>
                                        <td class="align-middle">:</td>
                                        <td class="align-middle" id="dt_keterangan">-</td>
                                    </tr>
                                    <tr class="bg-secondary">
                                        <th scope="row" colspan="3" class="text-center text-white">JUMLAH SEBELUM PENERBANGAN</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Aircraft</th>
                                        <td>:</td>
                                        <td id="dt_jumlah_aircraft">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Engine</th>
                                        <td>:</td>
                                        <td id="dt_jumlah_engine">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Jumlah Pendaratan</th>
                                        <td>:</td>
                                        <td id="dt_jumlah_engine_numberlanding">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Propeller</th>
                                        <td>:</td>
                                        <td id="dt_jumlah_propeller">-</td>
                                    </tr>
                                    <tr class="bg-secondary">
                                        <th scope="row" colspan="3" class="text-center text-white">JUMLAH SETELAH PENERBANGAN</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Aircraft</th>
                                        <td>:</td>
                                        <td id="dt_total_aircraft">AXCPX006</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Engine</th>
                                        <td>:</td>
                                        <td id="dt_total_engine">AXCPX006</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Jumlah Pendaratan</th>
                                        <td>:</td>
                                        <td id="dt_total_engine_numberlanding">AXCPX006</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Propeller</th>
                                        <td>:</td>
                                        <td id="dt_total_propeller">AXCPX006</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        
  

                       

                    
<?php  	
	include_once '_menu-bottom.php';
	include_once '_footer.php';
?>

<script>
            // Mendapatkan elemen chart
            // var chartElement = document.getElementById("chartpesawat");



            // Memanggil fungsi untuk memuat dan mengisi data chart saat halaman dimuat
            $(document).ready(function() {
                loadDataSinglePlane();
                setTabActiveFromURL();

            });

            

        </script>