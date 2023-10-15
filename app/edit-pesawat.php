<?php  
    $nama_halaman = 'Edit Pesawat';

	include_once '_header.php';
	include_once '_menu-top.php';

    if (empty($_GET['id'])) {
        echo '<script>window.location="data-pesawat";</script>';
    }

    $idpesawat    = $_GET['id'];
    $querypesawat = mysqli_query($connect, "SELECT * FROM data_pesawat WHERE pesawat_id = '$idpesawat' " ) or die (mysqli_error($connect));
    $pesawat  = mysqli_fetch_assoc($querypesawat);
?>

    

        <div class="row">
            
            <div class="col-lg-8 offset-lg-2">
                <a href="data-pesawat" class="btn btn-sm btn-secondary mt-3 mb-4">
                    <i class="fas fa-undo mr-2"></i>Kembali
                </a>

                
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-5">Form Edit Data Pesawat</h4>

                        <form method="post" id="edit-pesawat" enctype="multipart/form-data">

                        <div class="form-group row">
                            <label for="kode_pesawat" class="col-md-2 col-form-label">Kode Pesawat</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" placeholder="kode pesawat" id="kode_pesawat" name="kode_pesawat" value="<?= $pesawat['kode_pesawat']; ?>" required>
                                <input type="hidden" name="form" value="edit-pesawat">
                                <input type="hidden" name="pesawat_id" value="<?= $pesawat['pesawat_id']; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nomor_registrasi" class="col-md-2 col-form-label">No. Registrasi</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" placeholder="nomor registrasi" id="nomor_registrasiedit" name="nomor_registrasi" value="<?= $pesawat['nomor_registrasi']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nama_pesawat" class="col-md-2 col-form-label">Nama Pesawat</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" placeholder="nama pesawat" id="nama_pesawat" name="nama_pesawat" value="<?= $pesawat['nama_pesawat']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="max_lifetime" class="col-md-2 col-form-label">Lifetime</label>
                            <div class="col-md-5">
                                <input class="form-control" type="number" id="max_lifetime" name="max_lifetime" placeholder="lifetime" value="<?= $pesawat['max_lifetime']; ?>" required>
                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <label for="gambar_pesawat" class="col-md-2 col-form-label">Foto Pesawat</label>
                            <div class="col-md-5">
                                <input class="form-control" type="file" id="gambar_pesawat" name="gambar_pesawat" accept="image/*" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="time_since_overhaul" class="col-md-2 col-form-label">Status Pesawat</label>
                            <div class="col-md-6">
                                <select class="form-control" name="status_pesawat" id="status_pesawat" required>
                                    <option value="" selected hidden disabled>-- pilih status pesawat --</option>
                                    <option <?= comboxSelect($pesawat['status_pesawat'], 'aktif'); ?> value="aktif">Aktif</option>
                                    <option <?= comboxSelect($pesawat['status_pesawat'], 'tidak-aktif'); ?> value="tidak-aktif">Tidak Aktif</option>
                                    <option <?= comboxSelect($pesawat['status_pesawat'], 'maintenance'); ?> value="maintenance">Maintenance</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Keterangan</label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="5"><?= $pesawat['keterangan']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button class="btn btn-warning">Reset</button>
                                <button class="btn btn-success">Edit Data Pesawat</button>
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