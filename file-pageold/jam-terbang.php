<?php  
    include_once 'koneksi.php';
    $nama_halaman = 'Jam Terbang';

	include_once '_header.php';
	include_once '_menu-top.php';


?>

    

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                

                
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-5">Form Tambah Jam Terbang</h4>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Jenis Pesawat</label>
                            <div class="col-md-6">
                                <select class="form-control select2">
                                    <option selected disabled hidden>-- Pilih Pesawat --</option>
                                    <option value="AK">Semua Pesawat</option>
                                    <option value="AK">Pesawat 001</option>
                                    <option value="AK">Pesawat 002</option>
                                    <option value="AK">Pesawat 003</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-3 col-form-label">No. Registrasi</label>
                            <div class="col-md-6">
                                <select class="form-control select2">
                                    <option selected disabled hidden>-- Pilih No. Registrasi --</option>
                                    <option value="AK">PA 28-161</option>
                                    <option value="AK">PA 28-162</option>
                                    <option value="AK">PA 28-163</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Tanggal Terbang</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" data-provide="datepicker" data-date-format="dd M, yyyy">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Lifetime Sebelumnya</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light text-center" value="1200 Jam" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Lama Terbang</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input class="text-center" data-toggle="touchspin" value="1" type="text" data-step="1" data-decimals="0" data-bts-postfix="menit">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Lifetime Hasil</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light text-center" value="1200 Jam" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-3 col-form-label">Keterangan</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="" id="" cols="30" rows="5"></textarea>
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-3 col-form-label"></label>
                            <div class="col-md-6">
                                <button class="btn btn-warning">Reset</button>
                                <button class="btn btn-success">Tambah Jam Terbang</button>
                            </div>
                        </div>

                        
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-5">Data Laporan Maintenance</h4>

                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th class="text-center text-uppercase font-weight-bold" width="5%">No.</th>
                                <th class="text-center text-uppercase font-weight-bold">Jenis Pesawat</th>
                                <th class="text-center text-uppercase font-weight-bold">No. Registrasi</th>
                                <th class="text-center text-uppercase font-weight-bold">Lifetime</th>
                                <th class="text-center text-uppercase font-weight-bold">Keterangan</th>
                                <th class="text-center text-uppercase font-weight-bold">Aksi</th>
                            </tr>
                            </thead>


                            <tbody>
                            <?php $no = 1; for ($i = 0; $i < 20; $i++) : ?>
                                <tr>
                                    <td class="align-middle text-center"><?= $no++; ?></td>
                                    <td class="align-middle text-left">Piper Warrior III <br>PA-28-161</td>
                                    <td class="align-middle text-center">PK-AEA</td>
                                    <td class="align-middle text-center">1,200 Jam 30 Menit</td>
                                    <td class="align-middle">Laik Terbang</td>
                                    <td class="align-middle text-center">
                                        <a href="javascript:void(0);" class="btn btn-success">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                            </tbody>
                        </table>

                        
                        
                    </div>
                </div>
            </div>
        </div>

                       

                    
<?php  	
	include_once '_menu-bottom.php';
	include_once '_footer.php';
?>