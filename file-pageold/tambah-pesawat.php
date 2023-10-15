<?php  
    include_once 'koneksi.php';
    $nama_halaman = 'Tambah Pesawat';

	include_once '_header.php';
	include_once '_menu-top.php';


?>

    

        <div class="row">
            
            <div class="col-lg-8 offset-lg-2">
                <a href="data-pesawat.php" class="btn btn-secondary mt-3 mb-4">
                    <i class="fas fa-undo mr-2"></i>Kembali
                </a>

                
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-5">Form Tambah Data Pesawat</h4>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Jenis Pesawat</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="Jenis pesawat" id="example-text-input">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">No. Registrasi</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="Nomor registrasi" id="example-text-input">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Lifetime</label>
                            <div class="col-md-10">
                                <input class="form-control" type="number"  id="example-text-input">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Keterangan</label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="" id="" cols="30" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button class="btn btn-warning">Reset</button>
                                <button class="btn btn-success">Simpan Data</button>
                            </div>
                        </div>

                        
                        
                    </div>
                </div>
            </div>

            
        </div>

                       

                    
<?php  	
	include_once '_menu-bottom.php';
	include_once '_footer.php';
?>