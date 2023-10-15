<?php  
    $nama_halaman = 'Edit Data User';

	include_once '_header.php';
	include_once '_menu-top.php';

    if (empty($_GET['user'])) {
        echo '<script>window.location="manajemen-users";</script>';
    }

    $userID   = $_GET['user'];
    $query    = mysqli_query($connect, "SELECT * FROM data_pengguna WHERE pengguna_id = '$userID' " ) or die (mysqli_error($connect));
    $userData = mysqli_fetch_assoc($query);

    if (empty($userData)) {
        echo '<script>window.location="manajemen-users";</script>';
    }


?>

    

        <div class="row">
            
            <div class="col-lg-8 offset-lg-2">
                <a href="manajemen-users" class="btn btn-sm btn-secondary mt-3 mb-4">
                    <i class="fas fa-undo mr-2"></i>Kembali
                </a>

                
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-5">Form Edit Data User</h4>
                        <form method="post" id="update-pengguna">
                                        
                                        <div class="form-group row">
                                            <label for="email_pengguna" class="col-md-2 col-form-label">Email</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" id="email_pengguna" name="email_pengguna" value="<?= $userData['email_pengguna']; ?>" required>
                                                <input type="hidden" name="form" value="update-pengguna">
                                                <input type="hidden" name="userid" value="<?= $userData['pengguna_id']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-md-2 col-form-label">Password</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="password"  id="password" name="password" >
                                                <small class="text-danger">*Kosongkan password jika tidak diganti</small>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="nama_lengkap" class="col-md-2 col-form-label">Nama Lengkap</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text"  id="nama_lengkap" name="nama_lengkap" value="<?= $userData['nama_lengkap']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="jenis_kelamin" class="col-md-2 col-form-label">Jenis Kelamin</label>
                                            <div class="col-md-10">
                                                <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                                                    <option value="" selected disabled hidden>-- pilih jenis kelamin --</option>
                                                    <option <?= comboxSelect('laki-laki', $userData['jenis_kelamin']); ?> value="laki-laki">Laki-laki</option>
                                                    <option <?= comboxSelect('perempuan', $userData['jenis_kelamin']); ?> value="perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="tempat_lahir" class="col-md-2 col-form-label">Tempat Lahir</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text"  id="tempat_lahir" name="tempat_lahir" value="<?= $userData['tempat_lahir']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="tanggal_lahir" class="col-md-2 col-form-label">Tangal Lahir</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="date" name="tanggal_lahir" id="tanggal_lahir" value="<?= $userData['tanggal_lahir']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="status_akun" class="col-md-2 col-form-label">Status Akun</label>
                                            <div class="col-md-10">
                                                <select class="form-control" name="status_akun" id="status_akun" required>
                                                    <option value="" selected disabled hidden>-- pilih status akun --</option>
                                                    <option <?= comboxSelect('aktif', $userData['status_akun']); ?> value="aktif">Aktif</option>
                                                    <option <?= comboxSelect('tidak-aktif', $userData['status_akun']); ?> value="tidak-aktif">Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="no_hp" class="col-md-2 col-form-label">No. Handphone</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" id="no_hp" name="no_hp" value="<?= $userData['no_hp']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="level_akun" class="col-md-2 col-form-label">Level Akun</label>
                                            <div class="col-md-10">
                                                <select class="form-control "  id="level_akun" name="level_akun" required>
                                                    <option value="" selected disabled hidden>-- pilih level akun --</option>
                                                    <option <?= comboxSelect('admin', $userData['level_akun']); ?> value="admin">Administrator</option>
                                                    <option <?= comboxSelect('pilot', $userData['level_akun']); ?> value="pilot">Pilot</option>
                                                    <option <?= comboxSelect('enginer', $userData['level_akun']); ?> value="enginer">Enginer / Teknisi</option>
                                                    <option <?= comboxSelect('supervisor', $userData['level_akun']); ?> value="supervisor">Supervisor</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="jabatan_pengguna" class="col-md-2 col-form-label">Jabatan</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text"  id="jabatan_pengguna" name="jabatan_pengguna" value="<?= $userData['jabatan']; ?>" required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="jabatan_pengguna" class="col-md-2 col-form-label"></label>
                                            <div class="col-md-10">
                                                <button class="btn btn-warning">Reset</button>
                                                <button class="btn btn-success">Update User</button>
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