<?php  
    $nama_halaman = 'Maintenance Log';

	include_once '_header.php';
	include_once '_menu-top.php';

    $queryDataPesawat = mysqli_query($connect, "SELECT * FROM data_pesawat WHERE status_pesawat = 'aktif' " ) or die (mysqli_error($connect));
    $dataPesawat      = mysqli_fetch_all($queryDataPesawat, MYSQLI_ASSOC);

    $queryJamTerbang  = mysqli_query($connect, "SELECT data_jam_terbang.jamter_id, data_pesawat.nomor_registrasi, tanggalwaktu_terbang, data_pengguna.pengguna_id, data_pengguna.nama_lengkap, data_jam_terbang.tujuan_penerbangan 
                                                    FROM data_jam_terbang 
                                                    INNER JOIN data_pengguna ON data_jam_terbang.pengguna_id = data_pengguna.pengguna_id 
                                                    INNER JOIN data_pesawat ON data_jam_terbang.pesawat_id = data_pesawat.pesawat_id 
                                                    LEFT JOIN data_maintenancelog ON data_jam_terbang.jamter_id = data_maintenancelog.jamter_id
                                                    WHERE status_jamterbang = 'selesai' AND data_maintenancelog.jamter_id IS NULL
                                                    ORDER BY tanggalwaktu_terbang DESC" ) or die (mysqli_error($connect));
    $dataJamTer       = mysqli_fetch_all($queryJamTerbang, MYSQLI_ASSOC);

    // $queryDataMaintenLog = ;

    $queryDataMaintenLog = mysqli_query($connect, "SELECT data_maintenancelog.*, data_pengguna.nama_lengkap, data_pesawat.nama_pesawat, data_pesawat.nomor_registrasi, data_pesawat.kode_pesawat
                                                    FROM data_maintenancelog
                                                    INNER JOIN data_pengguna
                                                    ON data_pengguna.pengguna_id = data_maintenancelog.pengguna_id
                                                    INNER JOIN data_pesawat
                                                    ON data_pesawat.pesawat_id = data_maintenancelog.pesawat_id
                                                    ORDER BY tanggal_terbang DESC" ) or die (mysqli_error($connect));
    $dataMainten         = mysqli_fetch_all($queryDataMaintenLog, MYSQLI_ASSOC);
?>

    

        <div class="row">
            <div class="col-lg-12 ">
                

                
                <div class="card">
                    <div class="card-body">


                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#data-mainlog" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Data Maintenance Log</span>    
                                    </a>
                                </li>
                                <?php 
                                    if ($_SESSION['sistemlog']['level_akun'] == 'pilot' || $_SESSION['sistemlog']['level_akun'] == 'admin') :
                                ?>    
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tambah-mainlog" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Tambah Data Maintenance Log</span>    
                                    </a>
                                </li>
                                <?php
                                    endif;
                                ?>    
                            </ul>

                            <div class="tab-content p-3 text-muted">
                                <!-- ============================================================ -->
                                <!--  Data Maintenance Log -->
                                <div class="tab-pane active" id="data-mainlog" role="tabpanel">
                                    <h4 class="card-title mb-5 mt-3">Tabel Data Maintenance Log</h4>

                                    <table id="" class="custom-table table table-bordered table-striped  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center text-uppercase font-weight-bold" >Tgl</th>
                                            <th class="text-center text-uppercase font-weight-bold">No. Registrasi</th>
                                            <th class="text-center text-uppercase font-weight-bold">Kode Pesawat</th>
                                            <th class="text-center text-uppercase font-weight-bold">Nama Pilot</th>
                                            <th class="text-center text-uppercase font-weight-bold">Tujuan Penerbangan</th>
                                            <th class="text-center text-uppercase font-weight-bold">Waktu Diudara</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        <?php 
                                            $no = 1; 
                                            foreach ($dataMainten as $vlog) :
                                        ?>
                                            <tr onclick="detailMaintenanceLog('<?= $vlog['maintenance_id']; ?>')">
                                                <td class="hover-cell align-middle text-center"><?= date('d/m/Y', strtotime($vlog['tanggal_terbang'])); ?></td>
                                                <td class="hover-cell align-middle text-left"><?= $vlog['nomor_registrasi']; ?></td>
                                                <td class="hover-cell align-middle text-center"><?= $vlog['kode_pesawat']; ?></td>
                                                <td class="hover-cell align-middle text-left"><?= $vlog['nama_lengkap']; ?></td>
                                                <td class="hover-cell align-middle"><?= $vlog['tujuan_penerbangan']; ?></td>
                                                <td class="hover-cell align-middle text-center"><?= konversiMenit($vlog['waktu_diudara']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <strong>*Klik data untuk melihat detail penerbangan</strong>
                                </div>
                                
                                <!-- ============================================================ -->
                                <!-- Form Tambah Maintenance Log -->
                                <div class="tab-pane " id="tambah-mainlog" role="tabpanel">
                                    <h4 class="card-title mb-5 mt-3">Tambah Data Maintenance Log</h4>

                                    <form method="post" id="tambah-maintenance">
                                        <div class="form-group row">
                                            <label for="jamter_id" class="col-md-4 offset-md-1 col-form-label">Jam Terbang</label>
                                            <div class="col-md-6">
                                                <select class="form-control select2" name="jamter_id" id="jamter_id" required>
                                                    <option selected disabled hidden value="">-- Pilih Jam Terbang --</option>
                                                    <?php foreach ($dataJamTer as $value): ?>
                                                    <option value="<?= $value['jamter_id']; ?>"><?= date('d/m/Y', $value['tanggalwaktu_terbang']) . ' - ' . $value['nomor_registrasi'] . ' - ' . $value['nama_lengkap'] . ' - ' . $value['tujuan_penerbangan']; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <small class="text-danger">NOTE : TANGGAL-NOMOR REGISTRASI PESAWAT-NAMA PILOT-TUJUAN</small>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="nomor_registrasi" class="col-md-4 offset-md-1  col-form-label">Nomor Registrasi Pesawat</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light" id="nomor_registrasi" value="-" readonly>
                                                    <input type="hidden" name="pesawat_id" id="pesawat_id">
                                                    <input type="hidden" name="form" value="tambah-maintenance">
                                                </div>
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
                                            <label for="tanggal_terbang" class="col-md-4 offset-md-1  col-form-label">Tanggal Terbang</label>
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
                                            <label for="example-text-input" class="col-md-4 offset-md-1  col-form-label">Waktu Diudara</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input class="text-center" name="waktu_diudara" id="waktu_diudara" required data-toggle="touchspin" value="" type="text" data-step="1" data-decimals="0"  data-bts-postfix="menit">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="jumlah_pendaratan" class="col-md-4 offset-md-1  col-form-label">Jumlah Pendaratan</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input class="text-center" name="jumlah_pendaratan" id="jumlah_pendaratan" required data-toggle="touchspin" value="" type="text" data-step="1" data-decimals="0" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="nama_pilot" class="col-md-4 offset-md-1  col-form-label">Nama Pilot Pesawat</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light" id="nama_pilot" value="-" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-4 offset-md-1  col-form-label">Tujuan Penerbangan</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control " name="tujuan_penerbangan" id="tujuan_penerbangan" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-4 offset-md-1  col-form-label">Catatan</label>
                                            <div class="col-md-6">
                                                <textarea class="form-control" name="keterangan" id="keterangan" required cols="30" rows="5"></textarea>
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
                                            <label for="sisa-jumlah-pendaratan" class="col-md-4 offset-md-1  col-form-label">Jumlah Pendaratan</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light text-center" value="-" id="sisa-jumlah-pendaratan" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-12  text-center"><h5>JUMLAH JAM SETELAH TERBANG</h5></label>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-4 offset-md-1  col-form-label">Aircraft</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light text-center" value="-" id="total-time-aircraft" readonly>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-4 offset-md-1  col-form-label">Engine</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light text-center" value="-" id="total-time-engine" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-4 offset-md-1  col-form-label">Propeller</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light text-center" value="-" id="total-time-propeller" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="total-jumlah-pendaratan" class="col-md-4 offset-md-1  col-form-label">Jumlah Pendaratan</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light text-center" value="-" id="total-jumlah-pendaratan" readonly>
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

        <div class="modal fade modal-detail-maintenancelog" id="modal-detail-maintenancelog" tabindex="-1" role="dialog" aria-labelledby="modal-detail-maintenancelog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-detail-maintenancelog-title">Detail Maintenance Log</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                        <div class="table-responsive table-sm col-md-8 offset-md-2">
                            <table class="table mb-0">

                                
                                <tbody>
                                    <tr class="bg-secondary">    
                                        <th scope="row" colspan="3" class="text-center text-white">DETAIL PESAWAT</th>
                                    </tr>
                                    <tr>
                                        <th scope="row" width="30%"><b>Tanggal Penerbangan</b></th>
                                        <td width="5%">:</td>
                                        <td id="dt_tanggal_terbang">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" ><b>Nomor Registrasi</b></th>
                                        <td>:</td>
                                        <td id="dt_noreg_pesawat">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Kode Pesawat</th>
                                        <td>:</td>
                                        <td id="dt_kode_pesawat">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nama Pilot</th>
                                        <td>:</td>
                                        <td id="dt_nama_lengkap">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tujuan Penerbangan</th>
                                        <td>:</td>
                                        <td id="dt_tujuan_penerbangan">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Waktu Diudara</th>
                                        <td>:</td>
                                        <td id="dt_waktu_diudara">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Jumlah Pendaratan</th>
                                        <td>:</td>
                                        <td id="dt_jumlah_pendaratan">-</td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle" scope="row">Catatan</th>
                                        <td class="align-middle">:</td>
                                        <td class="align-middle" id="dt_keterangan">-</td>
                                    </tr>
                                    <tr class="bg-secondary">
                                        <th scope="row" colspan="3" class="text-center text-white">JUMLAH SEBELUM PENERBANGAN</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Aircraft</th>
                                        <td>:</td>
                                        <td id="dt_jumlah_aircraft">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Engine</th>
                                        <td>:</td>
                                        <td id="dt_jumlah_engine">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Jumlah Pendaratan</th>
                                        <td>:</td>
                                        <td id="dt_jumlah_engine_numberlanding">-</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Propeller</th>
                                        <td>:</td>
                                        <td id="dt_jumlah_propeller">-</td>
                                    </tr>
                                    <tr class="bg-secondary">
                                        <th scope="row" colspan="3" class="text-center text-white">JUMLAH SETELAH PENERBANGAN</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">Aircraft</th>
                                        <td>:</td>
                                        <td id="dt_total_aircraft">AXCPX006</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Engine</th>
                                        <td>:</td>
                                        <td id="dt_total_engine">AXCPX006</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Jumlah Pendaratan</th>
                                        <td>:</td>
                                        <td id="dt_total_engine_numberlanding">AXCPX006</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Propeller</th>
                                        <td>:</td>
                                        <td id="dt_total_propeller">AXCPX006</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        

                       

                    
<?php  	
	include_once '_menu-bottom.php';
	include_once '_footer.php';
?>