<?php  
    include_once 'koneksi.php';
    $nama_halaman = 'Profile Akun Saya';

	include_once '_header.php';
	include_once '_menu-top.php';


?>

    

        <div class="row">
            
            <div class="col-lg-8 offset-lg-2">

                
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-5">Form Profile</h4>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Username</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" id="example-text-input">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Password</label>
                            <div class="col-md-10">
                                <input class="form-control" type="password"  id="example-text-input">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Nama Lengkap</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="Nomor registrasi" id="example-text-input">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text"  id="example-text-input">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Status</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text"  id="example-text-input">
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
                                <button class="btn btn-success">Update Data</button>
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