<?php
  include_once('../konfigurasi/koneksi.php');


    if (empty($_GET['pesawat']) && empty($_GET['laporan'])) {
        header('Location:cetak-laporan');
    }

    $pesawatID         = mysqli_escape_string($connect, $_GET['pesawat']);
    $jenisMaintenance  = mysqli_escape_string($connect, $_GET['jenis_maintenance']);
    $jenisLaporan      = mysqli_escape_string($connect, $_GET['jenis_laporan']);
    $resultDataInpeksi = NULL;
    $resultLaporan     = NULL;
    $jenisMaintenance  = mysqli_escape_string($connect, $_GET['jenis_maintenance']);
    // $textQueryMaintenance = NULL;
    $textQueryMaintenance =  ($_GET['jenis_maintenance'] ?? null) != 'semua' ? 'AND jenis_maintenance = "' . $jenisMaintenance . '"' : null;
    
    $querypesawat = mysqli_query($connect, "SELECT * FROM data_pesawat WHERE pesawat_id = '$pesawatID' " ) or die (mysqli_error($connect));
    $pesawat      = mysqli_fetch_assoc($querypesawat);
    // Check apakah data pesawat nya ada 
    if(empty($pesawat)){
        echo '<script>alert("Error! Tidak ditemukan data yang dicari");window.location="cetak-laporan";</script>';
        exit();
    }

    
    if ($jenisLaporan == 'maintenance') {    
    
        if($_GET['awal'] == NULL && $_GET['akhir'] == NULL)
        {
            $textQuery = "SELECT data_maintenanceinspection.*, data_pengguna.nama_lengkap
                                                            FROM data_maintenanceinspection
                                                            INNER JOIN data_pengguna
                                                            ON data_pengguna.pengguna_id = data_maintenanceinspection.teknisi_id
                                                            WHERE pesawat_id = '$pesawatID' $textQueryMaintenance
                                                            ORDER BY tanggal_inspeksi DESC ";
        

        }
        else{
            $tanggal_awal  = mysqli_escape_string($connect, $_GET['awal']);
            $tanggal_awal  = date('Y-m-d', strtotime($tanggal_awal));
            $tanggal_akhir = mysqli_escape_string($connect, $_GET['akhir']);
            $tanggal_akhir = date('Y-m-d', strtotime($tanggal_akhir));

            $textQuery = "SELECT data_maintenanceinspection.*, data_pengguna.nama_lengkap
                                                            FROM data_maintenanceinspection
                                                            INNER JOIN data_pengguna
                                                            ON data_pengguna.pengguna_id = data_maintenanceinspection.teknisi_id
                                                            WHERE pesawat_id = '$pesawatID' AND tanggal_inspeksi BETWEEN '$tanggal_awal' AND '$tanggal_akhir'  $textQueryMaintenance
                                                            ORDER BY tanggal_inspeksi DESC";
        }        
    }
    elseif ($jenisLaporan == 'laporanpesawat') { 
        if($_GET['awal'] == NULL && $_GET['akhir'] == NULL)
        {
            $queryLaporan  = mysqli_query($connect, "SELECT data_laporanpesawat.*, data_pengguna.nama_lengkap
                                                    FROM data_laporanpesawat
                                                    INNER JOIN data_pengguna
                                                    ON data_pengguna.pengguna_id = data_laporanpesawat.pelapor_id
                                                    WHERE pesawat_id = '$pesawatID'
                                                    ORDER BY waktu_ditambahkan DESC " ) or die (mysqli_error($connect));      
        }
        else{
            $tanggal_awal  = strtotime(mysqli_escape_string($connect, $_GET['awal']));
            $tanggal_akhir = strtotime(mysqli_escape_string($connect, $_GET['akhir']));

            $queryLaporan  = mysqli_query($connect, "SELECT data_laporanpesawat.*, data_pengguna.nama_lengkap
                                                    FROM data_laporanpesawat
                                                    INNER JOIN data_pengguna
                                                    ON data_pengguna.pengguna_id = data_laporanpesawat.pelapor_id
                                                    WHERE pesawat_id = '$pesawatID' AND waktu_ditambahkan >= $tanggal_awal AND waktu_ditambahkan <= $tanggal_akhir
                                                    ORDER BY waktu_ditambahkan DESC " ) or die (mysqli_error($connect));      
        }  
    }
    elseif ($jenisLaporan == 'penerbangan') { 
        if($_GET['awal'] == NULL && $_GET['akhir'] == NULL)
        {
            $queryDataMaintenLog = mysqli_query($connect, "SELECT data_maintenancelog.*, data_pengguna.nama_lengkap, data_pesawat.nama_pesawat, data_pesawat.nomor_registrasi, data_pesawat.kode_pesawat
                                                    FROM data_maintenancelog
                                                    INNER JOIN data_pengguna
                                                    ON data_pengguna.pengguna_id = data_maintenancelog.pengguna_id
                                                    INNER JOIN data_pesawat
                                                    ON data_pesawat.pesawat_id = data_maintenancelog.pesawat_id
                                                    WHERE data_maintenancelog.pesawat_id = '$pesawatID'
                                                    ORDER BY tanggal_terbang DESC" ) or die (mysqli_error($connect));
        }
        else{
            $tanggal_awal  = date('Y-m-d', strtotime(mysqli_escape_string($connect, $_GET['awal'])));
            $tanggal_akhir = date('Y-m-d', strtotime(mysqli_escape_string($connect, $_GET['akhir'])));

            $queryDataMaintenLog = mysqli_query($connect, "SELECT data_maintenancelog.*, data_pengguna.nama_lengkap, data_pesawat.nama_pesawat, data_pesawat.nomor_registrasi, data_pesawat.kode_pesawat
                                                    FROM data_maintenancelog
                                                    INNER JOIN data_pengguna
                                                    ON data_pengguna.pengguna_id = data_maintenancelog.pengguna_id
                                                    INNER JOIN data_pesawat
                                                    ON data_pesawat.pesawat_id = data_maintenancelog.pesawat_id
                                                    WHERE data_maintenancelog.pesawat_id = '$pesawatID' AND tanggal_terbang BETWEEN '$tanggal_awal' AND '$tanggal_akhir' 
                                                    ORDER BY tanggal_terbang DESC" ) or die (mysqli_error($connect));
            
        }  
    }

    

    $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
    $mpdf->SetTitle('Laporan Maintenance Pesawat');
    ob_start();
?>    



<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
    <style>
        @page { margin: 20px; }
        body { margin: 20px; }

        #datalaporan, #datalaporanpesawat, #datalaporanpenerbangan  {
            border-collapse: collapse;
            width: 100%;            
        }

        #datalaporan, #datalaporan th, #datalaporan td, #datalaporanpesawat, #datalaporanpesawat th, #datalaporanpesawat td, #datalaporanpenerbangan, #datalaporanpenerbangan th, #datalaporanpenerbangan td {
            border: 1px solid black;
        }

        #datalaporan td, #datalaporanpesawat td, #datalaporanpenerbangan td {
            height: 25px;
            padding: 5px;
        }

        #datalaporan th, #datalaporanpesawat th, #datalaporanpenerbangan th {
            height: 35px;
        }

       
    </style>
    
    <h1  style="font-weight: bold;font-size:20px; text-align:center;padding-bottom:10px;" >LAPORAN <?= strtoupper(jenisLaporan($jenisLaporan)); ?> PESAWAT</h1> 
    
    <table style="font-size: 12px; padding-bottom: 15px;">
        <tr>
            <td style="font-weight:bold;">PESAWAT</td>
            <td>: <?= $pesawat['kode_pesawat']; ?> - <?= $pesawat['nama_pesawat']; ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">NOMOR REGISTRASI</td>
            <td>: <?= $pesawat['nomor_registrasi']; ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">STATUS PESAWAT</td>
            <td>: <?= $pesawat['status_pesawat']; ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">JENIS LAPORAN</td>
            <td>: <?= jenisLaporan($jenisLaporan); ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">WAKTU CETAK</td>
            <td>: <?= date('H:i, d/m/Y'); ?></td>
        </tr>
    </table>

    <?php
        if ($jenisLaporan == 'laporanpesawat') {
    ?>
            <table id="datalaporanpesawat" border="1" style="font-size:12px;">
                <thead >
                    <tr>
                        <!-- <th>No.</th> -->
                        <th>Tgl Laporan</th>
                        <th>Nama Pelapor</th>
                        <th>Detail Laporan</th>
                        <th>Status</th>
                        <th>Teknisi</th>
                    </tr>
                </thead>

                <tbody >
                <?php 
                    $nop = 1;                 
                    $resultLaporan = mysqli_fetch_all($queryLaporan, MYSQLI_ASSOC);
                    foreach ($resultLaporan as $laperbg) : ?>  
                    <tr >
                    
                    <td style="text-align: center;"><?= date('d/m/Y', $laperbg['waktu_ditambahkan']); ?></td>
                    <td class="align-middle text-left"><?= $laperbg['nama_lengkap']; ?></td>
                    <td class="align-middle"><?= $laperbg['keterangan_laporan']; ?></td>
                    <td style="text-align: center;"><?= $laperbg['status_laporan']; ?></td>
                    <td><?= namaTeknisi($laperbg['teknisi_id']); ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($resultLaporan)) : ?>
                    <tr >
                        <td colspan="8" style="text-align: center;"><i>Tidak ada riwayat laporan ditemukan dalam rentang data pesawat ini.</i></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

    <?php
        }
        elseif ($jenisLaporan == 'maintenance') {
    ?>
        <table id="datalaporan" border="1" style="font-size:12px;">
            <thead >
                <tr>
                    <th>No.</th>
                    <th>Tgl Maintenance</th>
                    <th >Waktu Diudara</th>
                    <th >Jumlah Landing</th>
                    <th >Jenis Inspeksi</th>
                    <th>Jenis Maintenance</th>
                    <th>Teknisi</th>
                    <th>Status</th>
                </tr>
            </thead>


            <tbody >
            <?php 
                $no = 1; 
                $queryInspection   = mysqli_query($connect, $textQuery ) or die (mysqli_error($connect));
                $resultDataInpeksi = mysqli_fetch_all($queryInspection, MYSQLI_ASSOC);
                foreach ($resultDataInpeksi as $ispeksi) : ?>  
                <tr >
                    <td style="text-align: center;"><?= $no++; ?></td>
                    <td style="text-align: center;"><?= date('d/m/Y', strtotime($ispeksi['tanggal_inspeksi'])); ?></td>
                    <td style="text-align: center;"><?= konversiMenit($ispeksi['total_time_inair']); ?></td>
                    <td style="text-align: center;"><?= $ispeksi['landing_jumlah']; ?>X</td>
                    <td style="text-align: center;"><?= $ispeksi['jenis_inspeksi']; ?></td>
                    <td style="text-align: center;"><?= $ispeksi['jenis_maintenance']; ?></td>
                    <td style="text-align: left;"><?= $ispeksi['nama_lengkap']; ?></td>
                    <td style="text-align: center;"><?= statusMaintenance($ispeksi['status_inspeksi']); ?></td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($resultDataInpeksi)) : ?>
                <tr >
                    <td colspan="8" style="text-align: center;"><i>Tidak ada riwayat maintenance dalam rentang data pesawat ini.</i></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    <?php
        }
        elseif ($jenisLaporan == 'penerbangan'){
    ?>
        <table id="datalaporanpenerbangan" border="1" style="font-size:12px;">
            <thead >
                <tr>
                    <th>No.</th>
                    <th>Tgl Terbang</th>
                    <th >Waktu Diudara</th>
                    <th >Jumlah Landing</th>
                    <th >Nama Pilot</th>
                    <th>Tujuan Penerbangan</th>
                    <th>Catatan</th>
                </tr>
            </thead>


            <tbody >
            <?php 
                $noter = 1;                 
                $dataMainten         = mysqli_fetch_all($queryDataMaintenLog, MYSQLI_ASSOC);
                foreach ($dataMainten as $logter) : ?>  
                <tr >
                    <td style="text-align: center;"><?= $noter++; ?></td>
                    <td style="text-align: center;"><?= date('d/m/Y', strtotime($logter['tanggal_terbang'])); ?></td>
                    <td style="text-align: center;"><?= konversiMenit($logter['waktu_diudara']); ?></td>
                    <td style="text-align: center;"><?= $logter['jumlah_pendaratan']; ?>X</td>
                    <td style="text-align: center;"><?= $logter['nama_lengkap']; ?></td>
                    <td style="text-align: center;"><?= $logter['tujuan_penerbangan']; ?></td>
                    <td style="text-align: left;"><?= $logter['catatan']; ?></td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($dataMainten)) : ?>
                <tr >
                    <td colspan="8" style="text-align: center;"><i>Tidak ada riwayat penerbangan dalam rentang data pesawat ini.</i></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    <?php
        }
    ?>
    
  </body>
</html>


<?php
    $html =  ob_get_contents();
    ob_get_clean();
    // $html =  file_get_contents('_template-laporan.php');
    

    $mpdf->WriteHTML($html);
    $mpdf->Output('Laporan Maintenance Pesawat - ' . $pesawat['nomor_registrasi'] . '.pdf', 'I');
    
    exit(0);
?>