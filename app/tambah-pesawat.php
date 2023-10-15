<?php  
    $nama_halaman = 'Tambah Pesawat';

	include_once '_header.php';
	include_once '_menu-top.php';


?>

    

        <div class="row">
            
            <div class="col-lg-8 offset-lg-2">
                <a href="data-pesawat" class="btn btn-sm btn-secondary mt-3 mb-4">
                    <i class="fas fa-undo mr-2"></i>Kembali
                </a>

                
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-5">Form Tambah Data Pesawat</h4>

                        <form method="post" id="tambah-pesawat" enctype="multipart/form-data">

                            <div class="form-group row">
                                <label for="kode_pesawat" class="col-md-2 col-form-label">Kode Pesawat</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" placeholder="kode pesawat" id="kode_pesawat" name="kode_pesawat" required>
                                    <input type="hidden" name="form" value="tambah-pesawat">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nomor_registrasi" class="col-md-2 col-form-label">No. Registrasi</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" placeholder="nomor registrasi" id="nomor_registrasi" name="nomor_registrasi" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nama_pesawat" class="col-md-2 col-form-label">Nama Pesawat</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" placeholder="nama pesawat" id="nama_pesawat" name="nama_pesawat" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="max_lifetime" class="col-md-2 col-form-label">Lifetime</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="number" id="max_lifetime" name="max_lifetime" placeholder="lifetime" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="total_time_inair" class="col-md-2 col-form-label">Total Time in Air</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="number" id="total_time_inair" name="total_time_inair" placeholder="total time in air" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="time_since_overhaul" class="col-md-2 col-form-label">Time Since Overhaul</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="number" id="time_since_overhaul" name="time_since_overhaul" placeholder="time since overhaul" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gambar_pesawat" class="col-md-2 col-form-label">Foto Pesawat</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="file" id="gambar_pesawat" name="gambar_pesawat" accept="image/*" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="time_since_overhaul" class="col-md-2 col-form-label">Status Pesawat</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="status_pesawat" id="status_pesawat" required>
                                        <option value="" selected hidden disabled>-- pilih status pesawat --</option>
                                        <option value="aktif">Aktif</option>
                                        <option value="tidak-aktif">Tidak Aktif</option>
                                        <option value="maintenance">Maintenance</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Keterangan</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label"></label>
                                <div class="col-md-10">
                                    <button class="btn btn-warning">Reset</button>
                                    <button class="btn btn-success">Simpan Data</button>
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