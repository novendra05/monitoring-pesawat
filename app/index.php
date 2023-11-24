<?php  
    $nama_halaman = 'Dashboard';

	include_once '_header.php';
	include_once '_menu-top.php';

    $queryData = mysqli_query($connect, "SELECT * FROM data_pesawat ORDER BY nomor_registrasi ASC" ) or die (mysqli_error($connect));
    $dataPesawat = mysqli_fetch_all($queryData, MYSQLI_ASSOC);

    $query1  = mysqli_query($connect, "SELECT COUNT(*) AS jumlah_data FROM data_pengguna" ) or die (mysqli_error($connect));
    $jumlah1 = mysqli_fetch_assoc($query1);

    $query2  = mysqli_query($connect, "SELECT COUNT(*) AS jumlah_data FROM data_pesawat" ) or die (mysqli_error($connect));
    $jumlah2 = mysqli_fetch_assoc($query2);

    $queryLaporan  = mysqli_query($connect, "SELECT data_laporanpesawat.*, data_pengguna.nama_lengkap, data_pesawat.nomor_registrasi
                                                    FROM data_laporanpesawat
                                                    INNER JOIN data_pengguna
                                                    ON data_pengguna.pengguna_id = data_laporanpesawat.pelapor_id
                                                    INNER JOIN data_pesawat
                                                    ON data_pesawat.pesawat_id = data_laporanpesawat.pesawat_id
                                                    WHERE data_laporanpesawat.status_laporan = 'menunggu'
                                                    ORDER BY waktu_ditambahkan DESC " ) or die (mysqli_error($connect));
    $resultLaporan = mysqli_fetch_all($queryLaporan, MYSQLI_ASSOC);

?>

        
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body overflow-hidden">
                                        <p class="text-truncate font-size-14 mb-2">Jumlah Pesawat</p>
                                        <h4 class="mb-0"><?= $jumlah1['jumlah_data']; ?> Pesawat</h4>
                                    </div>
                                    <div class="text-primary">
                                        <i class="ri-stack-line font-size-24"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body border-top py-3">
                                <div class="text-truncate">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body overflow-hidden">
                                        <p class="text-truncate font-size-14 mb-2">Jumlah Users</p>
                                        <h4 class="mb-0"><?= $jumlah2['jumlah_data']; ?> Orang</h4>
                                    </div>
                                    <div class="text-primary">
                                        <i class="ri-store-2-line font-size-24"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border-top py-3">
                                <div class="text-truncate">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- end row -->

        <style>
       
            #chartmtpesawat {
                width: 100%;
                height: 500px;
                padding: 20px;
                background: white;
            }
            @media only screen and (max-width: 700px) {
                #chartmtpesawat{
                    width: 100%;
                    height: 500px;
                }
            }
        </style>        

        <?=
            showAllMaintenance($dataPesawat, $toleransiMaintenance);

            foreach ($resultLaporan as $laporlog) :
                echo '<div class="alert alert-primary text-dark" role="alert">
							<b style="font-weight:bold;">LAPORAN!</b> Pesawat '. $laporlog['nomor_registrasi'] .' : ' . $laporlog['keterangan_laporan'] . ' 
						</div>';
            endforeach; 
            
            // echo checkMaintenance(5980, 50, 10, 0);
        ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="chartmtpesawat" height="100px">Your browser does not support the canvas element.</canvas>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row">

            
            
            <?php foreach($dataPesawat as $value) : ?>
            
            
            <div class="col-lg-6">
                <div class="card text-dark  ">
                    <div class="row no-gutters align-items-center ">
                        <div class="col-md-4">
                            <a href="<?= BASE_URL . 'app/pesawat?id=' . $value["pesawat_id"] ; ?>">
                                <img class="card-img img-fluid" src="<?= BASE_URL; ?>assets/images/pesawat/<?= $value['gambar_pesawat']; ?>" alt="Card image">
                            </a>
                        </div>
                        <div class="col-md-8 ">
                            <div class="card-body ">
                                <a href="<?= BASE_URL . 'app/pesawat?id=' . $value["pesawat_id"] ; ?>">
                                    <h4 class=" text-left "><?= $value['nomor_registrasi']; ?></h4>
                                </a>
                                <p class="card-text text-left ">
                                    <div class="row p-2">
                                        <div class="col-6 col-sm-3 col-lg-5">STATUS PESAWAT <span class="float-right">:</span></div>
                                        <div class="col-6 col-sm-3 col-lg-7"><code class="text-uppercase"><?= $value['status_pesawat']; ?></code></div>
                                    </div>

                                    <div class="row p-2">
                                        <div class="col-6 col-sm-3 col-lg-5">WAKTU DI UDARA <span class="float-right">:</span></div>
                                        <div class="col-6 col-sm-3 col-lg-7"><span class="text-uppercase"><?= konversiMenit($value['total_time_inair']); ?></span></div>
                                    </div>

                                    <a href="<?= BASE_URL . 'app/pesawat?id=' . $value['pesawat_id'] . '#maintenance'; ?>">
                                    <div class="row p-2 align-items-center bg-light">
                                        <div class="col-6 col-sm-3 col-lg-5 align-middle">MAINTENANCE <span class="float-right">:</span></div>
                                        <div class="col-6 col-sm-3 col-lg-7 align-middle">
                                                <?=  ListMaintenance($dataPesawat, $toleransiMaintenance, $value['pesawat_id']); 
                                                ?>
                                            </div>
                                        </div>
                                    </a>
                               
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>
            
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
                loadDataMultiPlane();
            });

        </script>