<?php  
    $nama_halaman = 'Data Pesawat';

	include_once '_header.php';
	include_once '_menu-top.php';


?>

    

        <div class="row">
            
            <div class="col-lg-12">
                <?php if ($_SESSION['sistemlog']['level_akun'] == 'admin') : ?>
                <a href="tambah-pesawat" class="btn btn-primary mt-3 mb-4 align-middle">
                    <i class="fas fa-plus mr-2"></i>Tambah Pesawat
                </a>
                <?php endif; ?>

                

                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        
                        <?php
                            $query   = mysqli_query($connect, "SELECT * FROM data_pesawat ORDER BY nomor_registrasi ASC" ) or die (mysqli_error($connect));
                            $pesawat = mysqli_fetch_all($query, MYSQLI_ASSOC);
                            foreach ($pesawat as $data) :
                        ?>
                        <div class="card">
                            <h4 class="card-header mt-0 bg-secondary text-white"><?= $data['nomor_registrasi']; ?></h4>
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-3 text-center">
                                        <img class="card-img img-fluid" src="<?= BASE_URL; ?>assets/images/pesawat/<?= $data['gambar_pesawat']; ?>" style="max-width: 70%;"  alt="Gambar Rusak">
                                    </div>
                                    <div class="col-md-8 offset-1">
                                        <table class="table table-sm table-borderless text-dark" width="100%">
                                            <tr>
                                                <th class="align-middle" >Kode Pesawat</th>
                                                <td class="align-middle">:</td>
                                                <td class="align-middle"><?= $data['kode_pesawat']; ?></td>
                                            </tr>
                                            <tr>
                                                <th class="align-middle" >No. Registrasi</th>
                                                <td class="align-middle">:</td>
                                                <td class="align-middle"><?= $data['nomor_registrasi']; ?></td>
                                            </tr>
                                            <tr>
                                                <th class="align-middle" width="40%">Nama Pesawat</th>
                                                <td class="align-middle" width="5px">:</td>
                                                <td class="align-middle"><?= $data['nama_pesawat']; ?></td>
                                            </tr>
                                            <tr>
                                                <th class="align-middle" >Lifetime</th>
                                                <td class="align-middle">:</td>
                                                <td class="align-middle"><?= $data['max_lifetime']; ?> Jam</td>
                                            </tr>
                                            <tr>
                                                <th class="align-middle" >Total Time in Air</th>
                                                <td class="align-middle">:</td>
                                                <td class="align-middle"><?= konversiMenit($data['total_time_inair']); ?></td>
                                            </tr>                                            
                                            <tr>
                                                <td colspan="3"></td>
                                            </tr>
                                            <tr>
                                                <th colspan="2" class="align-middle" ></th>
                                                <td class="align-middle">

                                                    <a href="pesawat?id=<?= $data['pesawat_id']; ?>" class="btn btn-sm btn-primary">Detail</a>
                                                    <?php if ($_SESSION['sistemlog']['level_akun'] == 'admin') : ?>
                                                        <a href="edit-pesawat?id=<?= $data['pesawat_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-danger konfirmasi-hapus-pesawat" data-link="<?= $data['pesawat_id']; ?>">Hapus</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <?php if (empty($pesawat)) : ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">TIDAK ADA DATA</h5>
                                    <p class="card-text text-center">Data pesawat tidak tersedia, silahkan tambahkan data pesawat terlebih dahulu</p>
                                </div>
                            </div>
                        <?php endif; ?>

                        
                        
                    </div>
                </div>

            </div>

            
        </div>

                       

                    
<?php  	
	include_once '_menu-bottom.php';
	include_once '_footer.php';
?>