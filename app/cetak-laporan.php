<?php  
    $nama_halaman = 'Cetak Laporan';

	include_once '_header.php';
	include_once '_menu-top.php';


    $queryDataPesawat = mysqli_query($connect, "SELECT * FROM data_pesawat ORDER BY nomor_registrasi ASC " ) or die (mysqli_error($connect));
    $dataPesawat      = mysqli_fetch_all($queryDataPesawat, MYSQLI_ASSOC);


?>

    

        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                

                
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-5">Form Cetak Laporan</h4>

                        <form action="generate-laporan" method="get" target="_blank">
                            <div class="form-group row">
                                <label for="pesawat" class="col-md-2 col-form-label">Jenis Pesawat</label>
                                <div class="col-md-10">
                                    <select class="form-control select2" name="pesawat" required>
                                        <option selected disabled hidden value="">-- Pilih Pesawat --</option>
                                        <?php foreach ($dataPesawat as $value): ?>
                                        <option value="<?= $value['pesawat_id']; ?>"><?= $value['nomor_registrasi']; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <input type="hidden" name="laporan" value="tanggal">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="awal" class="col-md-2 col-form-label">Tanggal Awal</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="awal" data-provide="datepicker" data-date-format="dd M, yyyy" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="akhir" class="col-md-2 col-form-label">Tanggal Akhir</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="akhir" data-provide="datepicker" data-date-format="dd M, yyyy" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label"></label>
                                <div class="col-md-10">
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                    <button type="submit" class="btn btn-success">Cetak Laporan</button>
                                </div>
                            </div>
                        </form>

                        
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-5">Data Laporan Maintenance</h4>

                        <table id="customTableLap" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                            <?php 
                                $no = 1;
                                foreach ($dataPesawat as $value): ?>
                                <tr>
                                    <td class="align-middle text-center"><?= $no++; ?></td>
                                    <td class="align-middle text-left"><?= $value['kode_pesawat']; ?></td>
                                    <td class="align-middle text-center"><?= $value['nomor_registrasi']; ?></td>
                                    <td class="align-middle text-center"><?= konversiMenit($value['total_time_inair']); ?></td>
                                    <td class="align-middle"><?= $value['keterangan']; ?></td>
                                    <td class="align-middle text-center">
                                        <a href="generate-laporan?pesawat=<?= $value['pesawat_id']; ?>&laporan=semua" target="_blank" class="btn btn-success">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
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