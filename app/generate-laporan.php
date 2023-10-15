<?php
  include_once('../konfigurasi/koneksi.php');


    if (empty($_GET['pesawat']) && empty($_GET['laporan'])) {
        header('Location:cetak-laporan');
    }

    $pesawatID         = mysqli_escape_string($connect, $_GET['pesawat']);
    $resultDataInpeksi = NULL;
    
    if($_GET['laporan'] == 'semua'){
        $textQuery = "SELECT data_maintenanceinspection.*, data_pengguna.nama_lengkap
                                                        FROM data_maintenanceinspection
                                                        INNER JOIN data_pengguna
                                                        ON data_pengguna.pengguna_id = data_maintenanceinspection.teknisi_id
                                                        WHERE pesawat_id = '$pesawatID'
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
                                                        WHERE pesawat_id = '$pesawatID' AND tanggal_inspeksi BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                                        ORDER BY tanggal_inspeksi DESC";
    }

    $querypesawat = mysqli_query($connect, "SELECT * FROM data_pesawat WHERE pesawat_id = '$pesawatID' " ) or die (mysqli_error($connect));
    $pesawat      = mysqli_fetch_assoc($querypesawat);

    if(empty($pesawat)){
        echo '<script>alert("Error! Tidak ditemukan data yang dicari");window.location="cetak-laporan";</script>';
        exit();
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

        #datalaporan {
            border-collapse: collapse;
            width: 100%;
        }

        #datalaporan, #datalaporan th, #datalaporan td {
            border: 1px solid black;
        }

        #datalaporan td {
            height: 25px;
            padding: 5px;
        }

        #datalaporan th {
            height: 35px;
        }

       
    </style>
    
    <h1  style="font-weight: bold;font-size:20px; text-align:center;padding-bottom:10px;" >LAPORAN MAINTENANCE PESAWAT</h1> 
    
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
            <td style="font-weight:bold;">STATUS</td>
            <td>: <?= $pesawat['status_pesawat']; ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">WAKTU CETAK</td>
            <td>: <?= date('H:i, d/m/Y'); ?></td>
        </tr>
    </table>


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