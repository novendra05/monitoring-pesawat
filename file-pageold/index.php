<?php  
    include_once 'koneksi.php';
    $nama_halaman = 'Dashboard';

	include_once '_header.php';
	include_once '_menu-top.php';


?>

        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body overflow-hidden">
                                        <p class="text-truncate font-size-14 mb-2">Jumlah Pesawat</p>
                                        <h4 class="mb-0">12</h4>
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
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body overflow-hidden">
                                        <p class="text-truncate font-size-14 mb-2">Jam Terbang</p>
                                        <h4 class="mb-0">89</h4>
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
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body overflow-hidden">
                                        <p class="text-truncate font-size-14 mb-2">Mekanik</p>
                                        <h4 class="mb-0">25 Orang</h4>
                                    </div>
                                    <div class="text-primary">
                                        <i class="ri-briefcase-4-line font-size-24"></i>
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

        <div class="row">

            <?php for ($i = 1; $i < 5; $i++) : ?>
            
            <div class="col-lg-6">
                <div class="card text-dark <?= randomStatus($i); ?>">
                    <div class="row no-gutters align-items-center">
                        <div class="col-md-4">
                            <img class="card-img img-fluid" src="assets/images/small/img-<?= $i; ?>.jpg" alt="Card image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h4 class=" text-center">PESAWAT AX12-7<?= $i; ?>6</h4>
                                <p class="card-text text-center">Waktu Maintenance : 0 Hari 12 Jam 30 Menit</p>
                                <p class="card-text text-center text-uppercase pt-3"><strong class="text-muted">Maintenance Selanjutnya : </strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php endfor; ?>
            
        </div>

                       

                    
<?php  	
	include_once '_menu-bottom.php';
	include_once '_footer.php';
?>