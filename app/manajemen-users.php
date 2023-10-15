<?php  
    $nama_halaman = 'Manajemen Users';

	include_once '_header.php';
	include_once '_menu-top.php';

    $queryDataPesawat = mysqli_query($connect, "SELECT * FROM data_pesawat WHERE status_pesawat = 'aktif' " ) or die (mysqli_error($connect));
    $dataPesawat      = mysqli_fetch_all($queryDataPesawat, MYSQLI_ASSOC);

    $queryUsers = mysqli_query($connect, "SELECT * FROM data_pengguna ORDER BY nama_lengkap ASC " ) or die (mysqli_error($connect));
    $dataUser   = mysqli_fetch_all($queryUsers, MYSQLI_ASSOC);

    // $queryDataMaintenLog = ;

    $queryJamTerbang = mysqli_query($connect, "SELECT data_jam_terbang.*, data_pesawat.*, data_pengguna.nama_lengkap, data_pengguna.pengguna_id FROM data_jam_terbang INNER JOIN data_pesawat ON data_jam_terbang.pesawat_id = data_pesawat.pesawat_id INNER JOIN data_pengguna ON data_jam_terbang.pengguna_id =  data_pengguna.pengguna_id  ORDER BY tanggalwaktu_terbang DESC" ) or die (mysqli_error($connect));
    $dataJam         = mysqli_fetch_all($queryJamTerbang, MYSQLI_ASSOC);
?>

    

        <div class="row">
            <div class="col-lg-12 ">
                

                
                <div class="card">
                    <div class="card-body">


                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#data-jamter" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Data Users</span>    
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tambah-jamter" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Tambah Data Users</span>    
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content p-3 text-muted">
                                <!-- ============================================================ -->
                                <!--  Data Users -->
                                <div class="tab-pane active" id="data-jamter" role="tabpanel">
                                    <h4 class="card-title mb-5 mt-3">Tabel Data Users</h4>

                                    <table id="datatable" class="custom-table table table-bordered table-striped  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th class="align-middle text-center " width="5%">No.</th>
                                            <th class="align-middle text-center ">Nama Lengkap</th>
                                            <th class="align-middle text-center ">Email</th>
                                            <th class="align-middle text-center ">No. Handphone</th>
                                            <th class="align-middle text-center ">Level</th>
                                            <th class="align-middle text-center ">Status Akun</th>
                                            <th class="align-middle text-center ">Aksi</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        <?php 
                                            $no = 1; 
                                            foreach ($dataUser as $dtusers) :
                                        ?>
                                            <tr onclick="">
                                                <td class="hover-cell align-middle text-center"><?= $no++; ?></td>
                                                <td class="hover-cell align-middle text-left"><code class="text-dark"><?= $dtusers['nama_lengkap']; ?></td>
                                                <td class="hover-cell align-middle text-left"><?= $dtusers['email_pengguna']; ?></td>
                                                <td class="hover-cell align-middle text-left"><?= $dtusers['no_hp']; ?></td>
                                                <td class="hover-cell align-middle text-center"><?= $dtusers['level_akun']; ?></td>
                                                <td class="hover-cell align-middle text-center"><?= $dtusers['status_akun']; ?></td>
                                                <td class="hover-cell align-middle text-center">

                                                    <a href="<?= BASE_URL . 'app/update-user?user=' . $dtusers['pengguna_id']; ?>" class="m-1 btn btn-sm btn-primary">Edit</a>
                                                    <button data-link="<?= $dtusers['pengguna_id']; ?>" class="konfirmasi-hapus-users m-1 btn btn-sm btn-danger " <?= checkDataUsers($dtusers['pengguna_id']); ?>>Hapus</button>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <strong class="text-danger">*Data users tidak bisa dihapus apabila telah tersimpan kedalam riwayat penggunaan pesawat atau maintenance pesawat</strong>
                                </div>
                                
                                <!-- ============================================================ -->
                                <!-- Form Tambah Jam Terbang -->
                                <div class="tab-pane" id="tambah-jamter" role="tabpanel">
                                    <h4 class="card-title mb-5 mt-3">Tambah Users Baru</h4>

                                    <form method="post" id="tambah-penggunabaru">
                                        
                                        <div class="form-group row">
                                            <label for="email_pengguna" class="col-md-2 col-form-label">Email</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" id="email_pengguna" name="email_pengguna" required>
                                                <input type="hidden" name="form" value="tambah-penggunabaru">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-md-2 col-form-label">Password</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="password"  id="password" name="password" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="nama_lengkap" class="col-md-2 col-form-label">Nama Lengkap</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text"  id="nama_lengkap" name="nama_lengkap" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="jenis_kelamin" class="col-md-2 col-form-label">Jenis Kelamin</label>
                                            <div class="col-md-10">
                                                <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                                                    <option value="" selected disabled hidden>-- pilih jenis kelamin --</option>
                                                    <option value="laki-laki">Laki-laki</option>
                                                    <option value="perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="tempat_lahir" class="col-md-2 col-form-label">Tempat Lahir</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text"  id="tempat_lahir" name="tempat_lahir" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="tanggal_lahir" class="col-md-2 col-form-label">Tangal Lahir</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="date" name="tanggal_lahir" id="tanggal_lahir" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="status_akun" class="col-md-2 col-form-label">Status Akun</label>
                                            <div class="col-md-10">
                                                <select class="form-control" name="status_akun" id="status_akun" required>
                                                    <option value="" selected disabled hidden>-- pilih status akun --</option>
                                                    <option value="aktif">Aktif</option>
                                                    <option value="tidak-aktif">Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="no_hp" class="col-md-2 col-form-label">No. Handphone</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" id="no_hp" name="no_hp" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="level_akun" class="col-md-2 col-form-label">Level Akun</label>
                                            <div class="col-md-10">
                                                <select class="form-control "  id="level_akun" name="level_akun" required>
                                                    <option value="" selected disabled hidden>-- pilih level akun --</option>
                                                    <option value="admin">Administrator</option>
                                                    <option value="pilot">Pilot</option>
                                                    <option value="enginer">Enginer / Teknisi</option>
                                                    <option value="supervisor">Supervisor</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="jabatan_pengguna" class="col-md-2 col-form-label">Jabatan</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text"  id="jabatan_pengguna" name="jabatan_pengguna" required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="jabatan_pengguna" class="col-md-2 col-form-label"></label>
                                            <div class="col-md-10">
                                                <button class="btn btn-warning">Reset</button>
                                                <button class="btn btn-success">Tambah Users</button>
                                            </div>
                                        </div>

                                        
                                    </form>

                                    
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