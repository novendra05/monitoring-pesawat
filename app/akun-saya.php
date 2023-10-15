<?php  
    $nama_halaman = 'Profile Akun Saya';

	include_once '_header.php';
	include_once '_menu-top.php';


?>

    

        <div class="row">
            
            <div class="col-lg-8 offset-lg-2">

                
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-5">Form Profile</h4>

                        <form action="" id="update-profile">

                        <div class="form-group row">
                            <label for="email_pengguna" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="<?= $_SESSION['sistemlog']['email_pengguna']; ?>" id="email_pengguna" name="email_pengguna" required>
                                <input type="hidden" name="form" value="update-profile">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-2 col-form-label">Password</label>
                            <div class="col-md-10">
                                <input class="form-control" type="password"  id="password" name="password">
                                <small class="text-danger">*Kosongkan password jika tidak diganti</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nama_lengkap" class="col-md-2 col-form-label">Nama Lengkap</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="<?= $_SESSION['sistemlog']['nama_lengkap']; ?>" id="nama_lengkap" name="nama_lengkap" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jenis_kelamin" class="col-md-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-md-10">
                                <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                                    <option value="" selected disabled hidden>-- pilih jenis kelamin --</option>
                                    <option <?= comboxSelect('laki-laki', $_SESSION['sistemlog']['jenis_kelamin']); ?> value="laki-laki">Laki-laki</option>
                                    <option <?= comboxSelect('perempuan', $_SESSION['sistemlog']['jenis_kelamin']); ?> value="perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tempat_lahir" class="col-md-2 col-form-label">Tempat Lahir</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="<?= $_SESSION['sistemlog']['tempat_lahir']; ?>" id="tempat_lahir" name="tempat_lahir" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tanggal_lahir" class="col-md-2 col-form-label">Tangal Lahir</label>
                            <div class="col-md-10">
                                <input class="form-control" type="date" name="tanggal_lahir" id="tanggal_lahir" value="<?= $_SESSION['sistemlog']['tanggal_lahir']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status_akun" class="col-md-2 col-form-label">Status Akun</label>
                            <div class="col-md-10">
                                <input class="form-control bg-light" type="text" value="<?= $_SESSION['sistemlog']['status_akun']; ?>" id="status_akun"  disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_hp" class="col-md-2 col-form-label">No. Handphone</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="<?= $_SESSION['sistemlog']['no_hp']; ?>" id="no_hp" name="no_hp" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jabatan" class="col-md-2 col-form-label">Jabatan</label>
                            <div class="col-md-10">
                                <select class="form-control bg-light"  id="jabatan" disabled>
                                    <option value="" selected disabled hidden>-- pilih jenis kelamin --</option>
                                    <option <?= comboxSelect('admin', $_SESSION['sistemlog']['level_akun']); ?> value="admin">Administrator</option>
                                    <option <?= comboxSelect('pilot', $_SESSION['sistemlog']['level_akun']); ?> value="pilot">Pilot</option>
                                    <option <?= comboxSelect('enginer', $_SESSION['sistemlog']['level_akun']); ?> value="enginer">Enginer / Teknisi</option>
                                    <option <?= comboxSelect('supervisor', $_SESSION['sistemlog']['level_akun']); ?> value="supervisor">Supervisor</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="reset" class="btn btn-warning">Reset</button>
                                <button type="submit" class="btn btn-success">Update Profil</button>
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