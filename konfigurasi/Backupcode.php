<?php
  include_once('koneksi.php');
  
  use Ramsey\Uuid\Uuid;

  header('Content-Type: application/json; charset=utf-8');
    // Check request dari ajax
    if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') == 'xmlhttprequest') {

        // Login Form
        if($_POST['form'] == 'login' && !empty($_POST['email']) && !empty($_POST['userpassword']))
        {
          $email_pengguna    = mysqli_real_escape_string($connect, $_POST['email']);
          $password_pengguna = mysqli_real_escape_string($connect, $_POST['userpassword']);

          $queryLog = mysqli_query($connect, "SELECT pengguna_id, email_pengguna, nama_lengkap, password_pengguna, level_akun, foto_profile, status_akun FROM data_pengguna WHERE email_pengguna = '$email_pengguna' " ) or die (mysqli_error($connect));
          $dataLog  = mysqli_fetch_assoc($queryLog);

          //   Jika data ditemukan
          if (!empty($dataLog)) {
              //   Jika password benar
              if (password_verify($password_pengguna, $dataLog['password_pengguna']))
              {                
                //   Jika akun aktif
                if ($dataLog['status_akun'] == 'aktif') {
                    $_SESSION['sistemlog'] = $dataLog;
                    echo json_encode(responseAjax('success', 200,  'LOGIN BERHASIL', 'Redirect kehalaman home', NULL));
                    exit;
                }
                //   Jika akun tidak aktif
                else{
                    echo json_encode(responseAjax('error', 200,  'LOGIN GAGAL', 'Status Akun anda tidak aktif, Silahkan hubungi pihak administrator', NULL));
                    exit;
                }
            }
            // Jika password salah
            else{
                echo json_encode(responseAjax('error', 200, 'LOGIN GAGAL', 'Email atau Password yang anda masukkan salah', NULL));
                exit;
            }
          }
          //   Jika tidak data ditemukan
          else{
                echo json_encode(responseAjax('error', 200, 'LOGIN GAGAL', 'Email atau Password yang anda masukkan salah', NULL));
                exit;
          }
        }
        elseif ($_POST['form'] == 'tambah-pesawat') 
        {
            $kode_pesawat        = mysqli_real_escape_string($connect, $_POST['kode_pesawat']);
            $nomor_registrasi    = mysqli_real_escape_string($connect, $_POST['nomor_registrasi']);
            $nama_pesawat        = mysqli_real_escape_string($connect, $_POST['nama_pesawat']);
            $max_lifetime        = mysqli_real_escape_string($connect, $_POST['max_lifetime']);
            $total_time_inair    = mysqli_real_escape_string($connect, $_POST['total_time_inair']);
            $time_since_overhaul = mysqli_real_escape_string($connect, $_POST['time_since_overhaul']);
            $gambar_pesawat      = '-';
            $status_pesawat      = mysqli_real_escape_string($connect, $_POST['status_pesawat']);
            $keterangan          = mysqli_real_escape_string($connect, $_POST['keterangan']);
            $uuid                = Uuid::uuid4();

            mysqli_query($connect, "SELECT nomor_registrasi FROM data_pesawat WHERE nomor_registrasi = '$nomor_registrasi' " ) or die (mysqli_error($connect));
            if (mysqli_affected_rows($connect) == 0) 
            {
                mysqli_query($connect, "INSERT INTO data_pesawat (pesawat_id, kode_pesawat, nomor_registrasi, nama_pesawat, max_lifetime, total_time_inair, time_since_overhaul, gambar_pesawat, status_pesawat, keterangan) VALUES ('$uuid', '$kode_pesawat', '$nomor_registrasi', '$nama_pesawat', '$max_lifetime', '$total_time_inair', '$time_since_overhaul', '$gambar_pesawat', '$status_pesawat', '$keterangan') " ) or die (mysqli_error($connect));
                if (mysqli_affected_rows($connect) > 0) {
                    echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil menambahkan data pesawat baru', NULL));
                    exit;
                }
                else{
                    echo json_encode(responseAjax('error', 200, 'GAGAL', 'Data Pesawat baru gagal ditambahkan', NULL));
                    exit;    
                }
            }
            else{
                echo json_encode(responseAjax('error', 200, 'GAGAL', 'Nomor Registrasi Pesawat telah terdaftar silahkan gunakan nomor registrasi lain', NULL));
                exit;
            }


        }
        elseif ($_POST['form'] == 'ajax' && $_POST['pesawat'] != NULL) 
        {
            $pesawatId = $_POST['pesawat'];
            $results   = [];

            $queryData = mysqli_query($connect, "SELECT waktu_diudara, tanggal_terbang FROM data_maintenancelog WHERE pesawat_id = '$pesawatId' " ) or die (mysqli_error($connect));
            $dataChart = mysqli_fetch_all($queryData, MYSQLI_ASSOC);

            foreach ($dataChart as $value) {
                $results['labels'][]        = date('d/m', strtotime($value['tanggal_terbang']));
                $results['jamPenggunaan'][] = $value['waktu_diudara'];
            }
            
            echo json_encode($results);
            exit;
        }
        elseif ($_POST['form'] == 'ajax-multi-plane') 
        {            
            $results   = [];

            $queryData = mysqli_query($connect, "SELECT * FROM data_pesawat ORDER BY nomor_registrasi ASC" ) or die (mysqli_error($connect));
            $dataChart = mysqli_fetch_all($queryData, MYSQLI_ASSOC);

            foreach ($dataChart as $value) {
                $results['labels'][] = $value['nomor_registrasi'];
                $results['jam50'][]  = formatAngka(((50 - ($value['total_time_inair'] % 50)) / 50) * 100);
                $results['jam100'][]  = formatAngka(((100 - ($value['total_time_inair'] % 100)) / 100) * 100);
                $results['jam300'][]  = formatAngka(((300 - ($value['total_time_inair'] % 300)) / 300) * 100);
                $results['jam400'][]  = formatAngka(((400 - ($value['total_time_inair'] % 400)) / 400) * 100);
                $results['jam500'][]  = formatAngka(((500 - ($value['total_time_inair'] % 500)) / 500) * 100);
            }

            // $results['labels'] = ['Pesawat I','Pesawat II'];
            // $results['jam50']  = [['persen' => 10, 'jam' => 5], ['persen' => 25, 'jam' => 12.5]];
            // $results['jam100'] = [['persen' => 12, 'jam' => 12], ['persen' => 75, 'jam' => 75]];
            
            
            // $results['jam300'] = [41, 137, 298, 165, 178];
            // $results['jam400'] = [389, 67, 163, 89, 3];
            // $results['jam500'] = [90, 54, 238, 211, 103];
            echo json_encode($results);
        }
        elseif ($_POST['form'] == 'ajax-form-tambah-maintenance' && !empty($_POST['jamter'])) 
        { 
            $jamter_id   = $_POST['jamter'];
            $queryCheck  = mysqli_query($connect, "SELECT jamter_id, tanggalwaktu_terbang, tujuan_penerbangan, data_pesawat.*, data_pengguna.nama_lengkap 
                                                    FROM data_jam_terbang 
                                                    INNER JOIN data_pengguna 
                                                    ON data_jam_terbang.pengguna_id = data_pengguna.pengguna_id 
                                                    INNER JOIN data_pesawat 
                                                    ON data_jam_terbang.pesawat_id = data_pesawat.pesawat_id 
                                                    WHERE jamter_id = '$jamter_id' " ) or die (mysqli_error($connect));
            $dataJamterbang = mysqli_fetch_assoc($queryCheck);

            if (!empty($dataJamterbang)) {
                
                $dataJamterbang['max_lifetime']         = $dataJamterbang['max_lifetime'] . ' jam';
                $dataJamterbang['tanggalwaktu_terbang'] = date('d M, Y', $dataJamterbang['tanggalwaktu_terbang']);
                $dataJamterbang['aircraft_time']        = konversiMenit($dataJamterbang['aircraft_time']);
                $dataJamterbang['engine_time']          = konversiMenit($dataJamterbang['engine_time']);
                $dataJamterbang['propeller_time']       = konversiMenit($dataJamterbang['propeller_time']);
                
                echo json_encode(responseAjax('success', 200,  'BERHASIL', 'Data ditemukan', $dataJamterbang));
            }
             else{
                echo json_encode(responseAjax('error', 200,  'ERROR', 'Data yang anda inputkan tidak ditemukan', NULL));
                exit;
             }
        }
        elseif ($_POST['form'] == 'ajax-hitung-waktu-penerbangan' && !empty($_POST['waktu_diudara']) && !empty($_POST['pesawat'])) 
        {
            $waktu_diudara     = $_POST['waktu_diudara'];
            $jumlah_pendaratan = $_POST['pendaratan'];
            $pesawat_id        = $_POST['pesawat'];
            $queryCheck        = mysqli_query($connect, "SELECT * FROM data_pesawat WHERE pesawat_id = '$pesawat_id' " ) or die (mysqli_error($connect));
            $dataPesawat       = mysqli_fetch_assoc($queryCheck);
            $total_aircraft    = 0;
            $total_engine      = 0;
            $total_propeller   = 0;
            $total_pendaratan  = 0;
            $hasilPerhitungan  = [];

            if(empty($waktu_diudara))
            {
                echo json_encode(responseAjax('error', 200,  'ERROR', 'Mohon isi inputan Waktu Diudara', NULL));
                exit;
            }
            elseif(empty($waktu_diudara))
            {
                echo json_encode(responseAjax('error', 200,  'ERROR', 'Mohon isi inputan Jumlah Pendaratan', NULL));
                exit;
            }
            else{
               
                if (!empty($dataPesawat)) {
                    $total_aircraft  = $dataPesawat['aircraft_time'] + $waktu_diudara;
                    $total_engine    = $dataPesawat['engine_time'] + $waktu_diudara;
                    $total_propeller = $dataPesawat['propeller_time'] + $waktu_diudara;
                    $total_pendaratan = $dataPesawat['engine_numberlanding'] + $jumlah_pendaratan;

                    $hasilPerhitungan['aircraft_timetotal']  = konversiMenit($total_aircraft);
                    $hasilPerhitungan['engine_timetotal']    = konversiMenit($total_engine);
                    $hasilPerhitungan['propeller_timetotal'] = konversiMenit($total_propeller);
                    $hasilPerhitungan['pendaratan_total']    = $total_pendaratan;
                    echo json_encode(responseAjax('success', 200,  'BERHASIL', 'Data ditemukan', $hasilPerhitungan));
                }
                else{
                    echo json_encode(responseAjax('error', 200,  'ERROR', 'Data yang anda inputkan tidak ditemukan', NULL));
                    exit;
                }
            }
        }
        elseif ($_POST['form'] == 'tambah-maintenance' && !empty($_POST['jamter_id'])) 
        {
            $jamter_id          = mysqli_escape_string($connect, $_POST['jamter_id']);
            $waktu_diudara      = mysqli_escape_string($connect, $_POST['waktu_diudara']);
            $jumlah_pendaratan  = mysqli_escape_string($connect, $_POST['jumlah_pendaratan']);
            $pesawat_id         = mysqli_escape_string($connect, $_POST['pesawat_id']);
            $tanggal_terbang    = mysqli_escape_string($connect, $_POST['tanggal_terbang']);
            $tanggal_terbang    = date('Y-m-d', strtotime($tanggal_terbang));            
            $tujuan_penerbangan = mysqli_escape_string($connect, $_POST['tujuan_penerbangan']);
            $keterangan         = mysqli_escape_string($connect, $_POST['keterangan']);
            $maintenance_id     = Uuid::uuid4();
            $waktu_ditambahkan  = time();

            
            $queryCheck  = mysqli_query($connect, "SELECT jamter_id, tanggalwaktu_terbang, tujuan_penerbangan, data_pesawat.*, data_pengguna.pengguna_id 
                                                    FROM data_jam_terbang 
                                                    INNER JOIN data_pengguna 
                                                    ON data_jam_terbang.pengguna_id = data_pengguna.pengguna_id 
                                                    INNER JOIN data_pesawat 
                                                    ON data_jam_terbang.pesawat_id = data_pesawat.pesawat_id 
                                                    WHERE jamter_id = '$jamter_id' " ) or die (mysqli_error($connect));
            $dataPesawat      = mysqli_fetch_assoc($queryCheck);
            $total_aircraft   = 0;
            $total_engine     = 0;
            $total_propeller  = 0;
            $hasilPerhitungan = [];

            if (!empty($dataPesawat)) {

                $jumlah_aircraft  = $dataPesawat['aircraft_time'];
                $jumlah_engine    = $dataPesawat['engine_time'];
                $jumlah_propeller = $dataPesawat['propeller_time'];
                $jumlah_landing   = $dataPesawat['engine_numberlanding'];
                $pilot            = $dataPesawat['pengguna_id'];

                $total_waktupenerbangan = $dataPesawat['total_time_inair'] + $waktu_diudara;
                $total_aircraft         = $dataPesawat['aircraft_time'] + $waktu_diudara;
                $total_engine           = $dataPesawat['engine_time'] + $waktu_diudara;
                $total_propeller        = $dataPesawat['propeller_time'] + $waktu_diudara;
                $total_landing          = $jumlah_landing + $jumlah_pendaratan;


                mysqli_query($connect, "INSERT INTO data_maintenancelog 
                                        (pesawat_id, tanggal_terbang, waktu_diudara, pengguna_id, tujuan_penerbangan, catatan, jumlah_aircraft, jumlah_engine, jumlah_propeller, jumlah_engine_numberlanding, total_waktu_aircraft, total_waktu_engine, total_waktu_propeller, total_engine_numberlanding, jumlah_pendaratan, waktu_ditambahkan) 
                                        VALUES ('$pesawat_id', '$tanggal_terbang', '$waktu_diudara', '$pilot', '$tujuan_penerbangan', '$keterangan', '$jumlah_aircraft', '$jumlah_engine', '$jumlah_propeller', '$jumlah_landing', '$total_aircraft', '$total_engine', '$total_propeller', '$total_landing', '$jumlah_pendaratan', '$waktu_ditambahkan') " ) or die (mysqli_error($connect));
                if (mysqli_affected_rows($connect) > 0) {

                    mysqli_query($connect, "UPDATE data_pesawat SET total_time_inair = '$total_waktupenerbangan', aircraft_time = '$total_aircraft', engine_time = '$total_engine', engine_numberlanding = '$total_landing', propeller_time = '$total_propeller' WHERE pesawat_id = '$pesawat_id'  " ) or die (mysqli_error($connect));

                    echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil menambahkan data Maintenance Log', NULL));
                    exit;
                }
                else{
                    echo json_encode(responseAjax('error', 200, 'GAGAL', 'Data Maintenance Log gagal ditambahkan', NULL));
                    exit;    
                }
            }
             else{
                echo json_encode(responseAjax('error', 200,  'ERROR', 'Data yang anda inputkan tidak ditemukan', NULL));
                exit;
             }
        }
        elseif ($_POST['form'] == 'tambah-jam-terbang' && !empty($_POST['nomor_registrasi'])) 
        {
            $pesawat_id         = mysqli_escape_string($connect, $_POST['nomor_registrasi']);
            $tanggal_terbang    = mysqli_escape_string($connect, $_POST['tanggal_terbang']);
            // $tanggal_terbang    = date('Y-m-d', strtotime($tanggal_terbang));
            $tanggal_terbang    = strtotime($tanggal_terbang);
            $pilot_id           = mysqli_escape_string($connect, $_POST['pilot_id']);
            $tujuan_penerbangan = mysqli_escape_string($connect, $_POST['tujuan_penerbangan']);
            $waktu_ditambahkan  = time();

            
            $queryCheck       = mysqli_query($connect, "SELECT * FROM data_pesawat WHERE pesawat_id = '$pesawat_id' AND status_pesawat = 'aktif' " ) or die (mysqli_error($connect));
            $dataPesawat      = mysqli_fetch_assoc($queryCheck);

            if (!empty($dataPesawat)) 
            {


                mysqli_query($connect, "INSERT INTO data_jam_terbang (pesawat_id, pengguna_id,  tanggalwaktu_terbang, tujuan_penerbangan, status_jamterbang, waktu_ditambahkan) VALUES ('$pesawat_id', '$pilot_id', '$tanggal_terbang', '$tujuan_penerbangan', 'menunggu', '$waktu_ditambahkan') " ) or die (mysqli_error($connect));
                if (mysqli_affected_rows($connect) > 0) {
                    echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil menambahkan data Jam Terbang', NULL));
                    exit;
                }
                else{
                    echo json_encode(responseAjax('error', 200, 'GAGAL', 'Data Jam Terbang gagal ditambahkan', NULL));
                    exit;    
                }
            }
             else{
                echo json_encode(responseAjax('error', 200,  'ERROR', 'Data yang anda inputkan tidak ditemukan', NULL));
                exit;
             }
        }
        elseif ($_POST['form'] == 'ajax-detail-maintenancelog' && !empty($_POST['main_id'])) 
        { 
            $mainlog_id  = $_POST['main_id'];
            // $queryCheck  = mysqli_query($connect, "SELECT * FROM data_jam_terbang WHERE jamter_id = '$jamter_id' " ) or die (mysqli_error($connect));

            $queryCheck = mysqli_query($connect, "SELECT data_maintenancelog.*, data_pesawat.*, data_pengguna.nama_lengkap FROM data_maintenancelog INNER JOIN data_pesawat ON data_maintenancelog.pesawat_id = data_pesawat.pesawat_id INNER JOIN data_pengguna ON data_maintenancelog.pengguna_id =  data_pengguna.pengguna_id  WHERE maintenance_id = '$mainlog_id' " ) or die (mysqli_error($connect));

            $dataMainLog = mysqli_fetch_assoc($queryCheck);

            if (!empty($dataMainLog)) {                

                $dataMainLog['waktu_diudara']  = konversiMenit($dataMainLog['waktu_diudara']);
                $dataMainLog['jumlah_aircraft']  = konversiMenit($dataMainLog['jumlah_aircraft']);
                $dataMainLog['jumlah_engine']    = konversiMenit($dataMainLog['jumlah_engine']);
                $dataMainLog['jumlah_propeller'] = konversiMenit($dataMainLog['jumlah_propeller']);
                
                $dataMainLog['total_waktu_aircraft']  = konversiMenit($dataMainLog['total_waktu_aircraft']);
                $dataMainLog['total_waktu_engine']    = konversiMenit($dataMainLog['total_waktu_engine']);
                $dataMainLog['total_waktu_propeller'] = konversiMenit($dataMainLog['total_waktu_propeller']);
                echo json_encode(responseAjax('success', 200,  'BERHASIL', 'Data ditemukan', $dataMainLog));
            }
             else{
                echo json_encode(responseAjax('error', 200,  'ERROR', 'Data yang anda inputkan tidak ditemukan', NULL));
                exit;
             }
        }
        elseif ($_POST['form'] == 'edit-pesawat') 
        {
            $pesawat_id       = mysqli_real_escape_string($connect, $_POST['pesawat_id']);
            $kode_pesawat     = mysqli_real_escape_string($connect, $_POST['kode_pesawat']);
            $nomor_registrasi = mysqli_real_escape_string($connect, $_POST['nomor_registrasi']);
            $nama_pesawat     = mysqli_real_escape_string($connect, $_POST['nama_pesawat']);
            $max_lifetime     = mysqli_real_escape_string($connect, $_POST['max_lifetime']);
            $gambar_pesawat   = '-';
            $status_pesawat   = mysqli_real_escape_string($connect, $_POST['status_pesawat']);
            $keterangan       = mysqli_real_escape_string($connect, $_POST['keterangan']);

            mysqli_query($connect, "SELECT nomor_registrasi FROM data_pesawat WHERE nomor_registrasi = '$nomor_registrasi' AND pesawat_id != '$pesawat_id' " ) or die (mysqli_error($connect));
            if (mysqli_affected_rows($connect) == 0) 
            {
                mysqli_query($connect, "UPDATE data_pesawat SET kode_pesawat = '$kode_pesawat', nomor_registrasi = '$nomor_registrasi', nama_pesawat = '$nama_pesawat', max_lifetime = '$max_lifetime', gambar_pesawat = '$gambar_pesawat', status_pesawat = '$status_pesawat', keterangan = '$keterangan' WHERE pesawat_id = '$pesawat_id' ") or die(mysqli_error($connect));
                if (mysqli_affected_rows($connect) > 0) {
                    echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil mengupdate data pesawat', NULL));
                    exit;
                }
                else{
                    echo json_encode(responseAjax('error', 200, 'GAGAL', 'Data Pesawat gagal diupdate ditambahkan', NULL));
                    exit;    
                }
            }
            else{
                echo json_encode(responseAjax('error', 200, 'GAGAL', 'Nomor Registrasi Pesawat telah terdaftar silahkan gunakan nomor registrasi lain', NULL));
                exit;
            }


        }
        elseif ($_POST['form'] == 'ajax-updatestats-jamter' && !empty($_POST['status']) && !empty($_POST['jamter'])) 
        {
            $status = mysqli_real_escape_string($connect, $_POST['status']);
            $jamter = mysqli_real_escape_string($connect, $_POST['jamter']);
            
            mysqli_query($connect, "SELECT jamter_id FROM data_jam_terbang WHERE jamter_id = '$jamter' " ) or die (mysqli_error($connect));
            if (mysqli_affected_rows($connect) > 0) 
            {
                mysqli_query($connect, "UPDATE data_jam_terbang SET status_jamterbang = '$status' WHERE jamter_id = '$jamter' ") or die(mysqli_error($connect));
                if (mysqli_affected_rows($connect) > 0) {
                    echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil mengupdate data Jam Terbang', NULL));
                    exit;
                }
                else{
                    echo json_encode(responseAjax('error', 200, 'GAGAL', 'Data Jam Terbang gagal diupdate', NULL));
                    exit;    
                }
            }
            else{
                echo json_encode(responseAjax('error', 200, 'GAGAL', 'Data jam terbang yang anda pilih tidak ditemukan', NULL));
                exit;
            }


        }
    }
    else{
        echo 'Access denied';
    }