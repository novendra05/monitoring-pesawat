<?php  
    include_once 'koneksi.php';
    $nama_halaman = 'Cetak Laporan';

	include_once '_header.php';
	include_once '_menu-top.php';


?>

    

        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                

                
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-5">Form Cetak Laporan</h4>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Jenis Pesawat</label>
                            <div class="col-md-10">
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
                            <label for="example-text-input" class="col-md-2 col-form-label">Tanggal Awal</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" data-provide="datepicker" data-date-format="dd M, yyyy">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Tanggal Akhir</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" data-provide="datepicker" data-date-format="dd M, yyyy">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button class="btn btn-warning">Reset</button>
                                <button class="btn btn-success">Cetak Laporan</button>
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