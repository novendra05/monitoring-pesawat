<?php  
    include_once 'koneksi.php';
    $nama_halaman = 'Data Pesawat';

	include_once '_header.php';
	include_once '_menu-top.php';


?>

    

        <div class="row">
            
            <div class="col-lg-12">
                <a href="tambah-pesawat.php" class="btn btn-primary mt-3 mb-4 align-middle">
                <i class="fas fa-plus mr-2"></i>Tambah Pesawat
                </a>

                <?php for ($i = 0; $i < 5; $i++) : ?>
                    <div class="card text-dark">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-3">
                                <img class="card-img img-fluid" src="assets/images/small/img-2.jpg"  alt="Card image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <!-- <h4 class=" text-left">PESAWAT AX12-7<?= $i; ?>6</h4> -->
                                    <!-- <p class="card-text text-center">Waktu Maintenance : 0 Hari 12 Jam 30 Menit</p>
                                    <p class="card-text text-center text-uppercase pt-3"><strong class="text-muted">Maintenance Selanjutnya : </strong></p> -->

                                    <table class="table table-borderless text-dark" width="100%">
                                        <tr>
                                            <th class="align-middle" width="40%">Nama Pesawat</th>
                                            <td class="align-middle" width="5px">:</td>
                                            <td class="align-middle">PESAWAT AX12-7<?= $i; ?>6</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle" >No. Registrasi</th>
                                            <td class="align-middle">:</td>
                                            <td class="align-middle">PK-AEB<?= $i; ?>6</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle" >Lifetime</th>
                                            <td class="align-middle">:</td>
                                            <td class="align-middle">1200 Jam 30 Menit</td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle" >Keterangan</th>
                                            <td class="align-middle">:</td>
                                            <td class="align-middle">Latik Terbang</td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle text-center" colspan="3" >
                                                <a href="javascript:void(0);" class="btn btn-warning">Edit Data</a>
                                                <a href="javascript:void(0);" class="btn btn-danger">Hapus Data</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

            
        </div>

                       

                    
<?php  	
	include_once '_menu-bottom.php';
	include_once '_footer.php';
?>