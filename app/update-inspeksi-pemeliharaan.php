<?php  
    $nama_halaman = 'Update Maintenance Inspection';

	include_once '_header.php';
	include_once '_menu-top.php';

    if (empty($_GET['id'])) {
        echo '<script>window.location="data-pesawat";</script>';
    }

    $maininspectID   = $_GET['id'];
    $query       = mysqli_query($connect, "SELECT data_maintenanceinspection.* , data_pesawat.nama_pesawat, data_pesawat.nomor_registrasi, data_pesawat.max_lifetime, data_pesawat.kode_pesawat
                                            FROM data_maintenanceinspection 
                                            INNER JOIN data_pesawat 
                                            ON data_maintenanceinspection.pesawat_id = data_maintenanceinspection.pesawat_id
                                            WHERE minspect_id = '$maininspectID' " ) or die (mysqli_error($connect));
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

                        <h4 class="card-title mb-5">Form Update Maintenance Inspection</h4>

                        <form method="post" id="update-maintenance-inspection" enctype="multipart/form-data">

                        <div class="form-group row">
                            <label for="kode_pesawat" class="col-md-4 col-form-label">Kode Pesawat</label>
                            <div class="col-md-8">
                                <input class="form-control bg-light" type="text" id="kode_pesawat" name="kode_pesawat" value="<?= $pesawatData['kode_pesawat']; ?>" readonly>
                                <input type="hidden" name="form" value="update-maintenance-inspection">
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
                            <label for="time_since_overhaul" class="col-md-4 col-form-label">Aircraft Time</label>
                            <div class="col-md-8">
                                <input class="form-control bg-light" type="text" id="sisa_aircraft" name="sisa_aircraft" value="<?= konversiMenit($pesawatData['aircraft_jam']); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="time_since_overhaul" class="col-md-4 col-form-label">Engine Time</label>
                            <div class="col-md-8">
                                <input class="form-control bg-light" type="text" id="sisa_engine" name="sisa_engine" value="<?= konversiMenit($pesawatData['engine_jam']); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="time_since_overhaul" class="col-md-4 col-form-label">Propeller Time</label>
                            <div class="col-md-8">
                                <input class="form-control bg-light" type="text" id="sisa_propeller" name="sisa_propeller" value="<?= konversiMenit($pesawatData['propeller_jam']); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="time_since_overhaul" class="col-md-4 col-form-label">Jumlah Pendaratan</label>
                            <div class="col-md-8">
                                <input class="form-control bg-light" type="text" id="sisa_jumlah_pendaratan" name="sisa_jumlah_pendaratan" value="<?= $pesawatData['landing_jumlah'] . 'X'; ?>" readonly>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="jenis_inspeksi" class="col-md-4 col-form-label">Jenis Inspeksi</label>
                            <div class="col-md-8">
                                <select class="form-control bg-light" name="jenis_inspeksi" id="jenis_inspeksi" required disabled>
                                    <option value="" selected hidden disabled>-- pilih jenis inspeksi --</option>
                                    <option <?= comboxSelect('50jam', $pesawatData['jenis_inspeksi']); ?> value="50jam">50 Jam</option>
                                    <option <?= comboxSelect('100jam', $pesawatData['jenis_inspeksi']); ?> value="100jam">100 Jam</option>
                                    <option <?= comboxSelect('300jam', $pesawatData['jenis_inspeksi']); ?> value="300jam">300 Jam</option>
                                    <option <?= comboxSelect('400jam', $pesawatData['jenis_inspeksi']); ?> value="400jam">400 Jam</option>
                                    <option <?= comboxSelect('500jam', $pesawatData['jenis_inspeksi']); ?> value="500jam">500 Jam</option>
                                    <option <?= comboxSelect('1000jam', $pesawatData['jenis_inspeksi']); ?> value="1000jam">1000 Jam</option>
                                    <option <?= comboxSelect('2000jam', $pesawatData['jenis_inspeksi']); ?> value="2000jam">2000 Jam</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jenis_maintenance" class="col-md-4 col-form-label">Jenis Maintenance</label>
                            <div class="col-md-8">
                                <select class="form-control" name="jenis_maintenance" id="jenis_maintenance" required>
                                    <option value="" selected hidden disabled>-- pilih jenis maintenance --</option>
                                    <option <?= comboxSelect('engine', $pesawatData['jenis_maintenance']); ?> value="engine">Engine</option>
                                    <option <?= comboxSelect('propeller', $pesawatData['jenis_maintenance']); ?> value="propeller">Propeller</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tanggal_maintenanceispeksi" class="col-md-4 col-form-label">Tanggal Maintenance Inspection</label>
                            <div class="col-md-8">
                            <div class="input-group">
                                    <input type="text" class="form-control" data-provide="datepicker" data-date-format="dd M, yyyy" value="<?= date('d M, Y', strtotime($pesawatData['tanggal_inspeksi'])); ?>" name="tanggal_maintenanceispeksi" id="tanggal_maintenanceispeksi" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>                        

                        <div class="form-group row">
                            <label for="catatan_inspeksi" class="col-md-4 col-form-label">Catatan Maintenance</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="catatan_inspeksi" id="catatan_inspeksi" cols="30" rows="5"><?= $pesawatData['catatan_inspeksi']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status_inspeksi" class="col-md-4 col-form-label">Status Maintenance Inspection</label>
                            <div class="col-md-8">
                                <select class="form-control" name="status_inspeksi" id="status_inspeksi" required>
                                    <option value="" selected hidden disabled>-- pilih status maintenance --</option>
                                    <option <?= comboxSelect('selesai', $pesawatData['status_inspeksi']); ?> value="selesai">Selesai</option>
                                    <option <?= comboxSelect('diproses', $pesawatData['status_inspeksi']); ?> value="diproses">Diproses</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label  class="col-md-4 col-form-label"></label>
                            <div class="col-md-8">
                                <button class="btn btn-warning">Reset</button>
                                <button class="btn btn-success">Update Data Maintenance</button>
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