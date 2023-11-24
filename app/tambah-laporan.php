<?php  
    $nama_halaman = 'Tambah Laporan Pesawat';

	include_once '_header.php';
	include_once '_menu-top.php';

    if (empty($_GET['id'])) {
        echo '<script>window.location="data-pesawat";</script>';
    }

    $maininspectID   = $_GET['id'];
    $query       = mysqli_query($connect, "SELECT *
                                            FROM data_pesawat 
                                            WHERE pesawat_id = '$maininspectID' " ) or die (mysqli_error($connect));
    $pesawatData = mysqli_fetch_assoc($query);
    $pesawatID   = $pesawatData['pesawat_id'];




?>

    

        <div class="row">
            
            <div class="col-lg-8 offset-lg-2">
                <a href="<?= BASE_URL . 'app/pesawat?id=' . $pesawatID; ?>" class="btn btn-sm btn-secondary mt-3 mb-4">
                    <i class="fas fa-undo mr-2"></i>Kembali
                </a>

                
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-5">Form Tambah Laporan Pesawat</h4>

                        <form method="post" id="tambah-laporan-pesawat" enctype="multipart/form-data">

                        <div class="form-group row">
                            <label for="kode_pesawat" class="col-md-4 col-form-label">Kode Pesawat</label>
                            <div class="col-md-8">
                                <input class="form-control bg-light" type="text" id="kode_pesawat" name="kode_pesawat" value="<?= $pesawatData['kode_pesawat']; ?>" readonly>
                                <input type="hidden" name="form" value="tambah-laporan-pesawat">
                                <input type="hidden" name="minspect_id" id="minspect_id" value="<?= $maininspectID; ?>">
                                <input type="hidden" name="pesawat_id" id="pesawat_id" value="<?= $pesawatID; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nomor_registrasi" class="col-md-4 col-form-label">No. Registrasi</label>
                            <div class="col-md-8">
                                <input class="form-control bg-light" type="text" id="nomor_registrasi" name="nomor_registrasi" value="<?= $pesawatData['nomor_registrasi']; ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nama_pesawat" class="col-md-4 col-form-label">Nama Pesawat</label>
                            <div class="col-md-8">
                                <input class="form-control bg-light" type="text" id="nama_pesawat" name="nama_pesawat" value="<?= $pesawatData['nama_pesawat']; ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="max_lifetime" class="col-md-4 col-form-label">Lifetime</label>
                            <div class="col-md-8">
                                <input class="form-control bg-light" type="text" id="max_lifetime" value="<?= $pesawatData['max_lifetime'] . ' Jam'; ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="total_time_inair" class="col-md-4 col-form-label">Total Time in Air</label>
                            <div class="col-md-8">
                                <input class="form-control bg-light" type="text" id="total_time_inair" value="<?= konversiMenit($pesawatData['total_time_inair']) . ' / [' . $pesawatData['total_time_inair'] . ' menit]'; ?>" readonly>
                            </div>
                        </div>
                      

                        <div class="form-group row">
                            <label for="detail_laporan" class="col-md-4 col-form-label">Detail Laporan</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="detail_laporan" id="detail_laporan" cols="30" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="foto_laporan" class="col-md-4 col-form-label">Foto Laporan</label>
                            <div class="col-md-8">
                                <input class="form-control" name="foto_laporan" type="file" >
                                <small class="text-danger">*Upload foto jika ada</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label  class="col-md-4 col-form-label"></label>
                            <div class="col-md-8">
                                <button class="btn btn-warning">Reset</button>
                                <button class="btn btn-primary">Tambah Laporan Pesawat</button>
                            </div>
                        </div>

                        </form>

                        
                        
                    </div>
                </div>
            </div>

            
        </div>

                       

                    
<?php  	
	include_once '_menu-bottom.php';
	include_once '_footer.php';
?>