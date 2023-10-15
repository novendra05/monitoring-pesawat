<?php  
    $nama_halaman = 'Jadwak Jam Terbang';

	include_once '_header.php';
	include_once '_menu-top.php';

    $queryDataPesawat = mysqli_query($connect, "SELECT * FROM data_pesawat WHERE status_pesawat = 'aktif' " ) or die (mysqli_error($connect));
    $dataPesawat      = mysqli_fetch_all($queryDataPesawat, MYSQLI_ASSOC);

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
                                        <span class="d-none d-sm-block">Data Jam Terbang</span>    
                                    </a>
                                </li>
                                <?php 
                                    if ($_SESSION['sistemlog']['level_akun'] == 'pilot' || $_SESSION['sistemlog']['level_akun'] == 'admin') :
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tambah-jamter" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Tambah Data Jam Terbang</span>    
                                    </a>
                                </li>
                                <?php
                                    endif;
                                ?>
                            </ul>

                            <div class="tab-content p-3 text-muted">
                                <!-- ============================================================ -->
                                <!--  Data Jam Terbang -->
                                <div class="tab-pane active" id="data-jamter" role="tabpanel">
                                    <h4 class="card-title mb-5 mt-3">Tabel Data Jam Terbang</h4>

                                    <table id="customTable" class=" table table-bordered table-striped  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th class="align-middle text-center " width="5%">No.</th>
                                            <th class="align-middle text-center ">No. Pesawat <br> Kode Pesawat</th>
                                            <th class="align-middle text-center ">Nama Pilot</th>
                                            <th class="align-middle text-center ">Tujuan Penerbangan</th>
                                            <th class="align-middle text-center ">Tgl Penggunaan</th>
                                            <th class="align-middle text-center ">Status</th>
                                            <th class="align-middle text-center ">Aksi</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        <?php 
                                            $no = 1; 
                                            foreach ($dataJam as $djamt) :
                                        ?>
                                            <tr >
                                                <td class="hover-cell align-middle text-center"><?= $no++; ?></td>
                                                <td class="hover-cell align-middle text-left"><code class="text-dark"><?= $djamt['nomor_registrasi']; ?></code> <br> <?= $djamt['kode_pesawat']; ?></td>
                                                <td class="hover-cell align-middle text-left"><?= $djamt['nama_lengkap']; ?></td>
                                                <td class="hover-cell align-middle text-left"><?= $djamt['tujuan_penerbangan']; ?></td>
                                                <td class="hover-cell align-middle text-center"><?= date('d/m/Y', $djamt['tanggalwaktu_terbang']); ?></td>
                                                <td class="hover-cell align-middle text-center"><?= statusJamter($djamt['status_jamterbang']); ?></td>
                                                <td class="hover-cell align-middle text-center">

                                                    <?php 
                                                        if ($_SESSION['sistemlog']['pengguna_id'] == $djamt['pengguna_id']) {
                                                            if ($djamt['status_jamterbang'] == 'menunggu' ) {
                                                            ?>
                                                                    <button onclick="updateJamter('digunakan', '<?= $djamt['jamter_id']; ?>')" class="m-1 btn btn-sm btn-outline-primary">Gunakan</button> <br>
                                                                    <button onclick="updateJamter('batalkan', '<?= $djamt['jamter_id']; ?>')" class="m-1 btn btn-sm btn-outline-danger">Batalkan</button>
                                                            <?php
                                                                }
                                                                else if ($djamt['status_jamterbang'] == 'menunggu') {
                                                            ?>
                                                                    <button onclick="updateJamter('selesai', '<?= $djamt['jamter_id']; ?>')" class="m-1 btn btn-sm btn-outline-success">Selesai</button> <br>
                                                                    <button onclick="updateJamter('batalkan', '<?= $djamt['jamter_id']; ?>')" class="m-1 btn btn-sm btn-outline-danger">Batalkan</button>
                                                            <?php
                                                                }
                                                                elseif($djamt['status_jamterbang'] == 'digunakan'){
                                                            ?>
                                                                    <button onclick="updateJamter('selesai', '<?= $djamt['jamter_id']; ?>')" class="m-1 btn btn-sm btn-outline-success">Selesai</button>
                                                            <?php
                                                                }
                                                                else{
                                                                    echo '-';
                                                                }
                                                        } 
                                                        else{
                                                            echo '-';
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- ============================================================ -->
                                <!-- Form Tambah Jam Terbang -->
                                <div class="tab-pane" id="tambah-jamter" role="tabpanel">
                                    <h4 class="card-title mb-5 mt-3">Tambah Data Jam Terbang</h4>

                                    <form method="post" id="tambah-jam-terbang">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-4 offset-md-1 col-form-label">Nomor Registrasi</label>
                                            <div class="col-md-6">
                                                <select class="form-control select2" name="nomor_registrasi" id="nomor_registrasijamter" required>
                                                    <option selected disabled hidden value="">-- Pilih Pesawat --</option>
                                                    <?php foreach ($dataPesawat as $value): ?>
                                                    <option value="<?= $value['pesawat_id']; ?>"><?= $value['nomor_registrasi']; ?></option>
                                                    <?php endforeach ?>
                                                    <input type="hidden" name="form" value="tambah-jam-terbang">
                                                </select>
                                                <small class="text-danger">*Data Pesawat tidak akan muncul jika dalam status MAINTENANCE </small>
                                            </div>
                                        </div>

                                
                                        <div class="form-group row">
                                            <label for="kode_pesawat" class="col-md-4 offset-md-1  col-form-label">Kode Pesawat</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light" id="kode_pesawat" value="-" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-4 offset-md-1  col-form-label">Nama Pesawat</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light" id="nama_pesawat" value="-" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-4 offset-md-1  col-form-label">Max Lifetime</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light text-center" id="max_lifetime" value="-" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-4 offset-md-1  col-form-label">Tanggal Terbang</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" data-provide="datepicker" data-date-format="dd M, yyyy" name="tanggal_terbang" id="tanggal_terbang" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="nama_pilot" class="col-md-4 offset-md-1  col-form-label">Nama Pilot</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light" name="nama_pilot" id="nama_pilot" value="<?= $_SESSION['sistemlog']['nama_lengkap']; ?>" readonly required>
                                                    <input type="hidden" name="pilot_id" id="pilot_id" value="<?= $_SESSION['sistemlog']['pengguna_id']; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-4 offset-md-1  col-form-label">Tujuan Penerbangan</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control " name="tujuan_penerbangan" id="tujuan_penerbangan" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-12  text-center"><h5>JUMLAH JAM TERBANG TERAKHIR</h5></label>
                                        </div>
                                        
                                        
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-4 offset-md-1  col-form-label">Aircraft</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light text-center" value="-" id="sisa-aircraft" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-4 offset-md-1  col-form-label">Engine</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light text-center" value="-" id="sisa-engine" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-4 offset-md-1  col-form-label">Propeller</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light text-center" value="-" id="sisa-propeller" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-4 offset-md-1  col-form-label"></label>
                                            <div class="col-md-6">
                                                <button class="btn btn-warning">Reset</button>
                                                <button type="submit" class="btn btn-success">Tambah Jam Terbang</button>
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