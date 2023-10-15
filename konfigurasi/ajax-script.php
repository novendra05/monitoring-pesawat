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

          $queryLog = mysqli_query($connect, "SELECT * FROM data_pengguna WHERE email_pengguna = '$email_pengguna' " ) or die (mysqli_error($connect));
          $dataLog  = mysqli_fetch_assoc($queryLog);

          //   Jika data ditemukan
          if (!empty($dataLog)) {
              //   Jika password benar
              if (password_verify($password_pengguna, $dataLog['password_pengguna']))
              {                
                //   Jika akun aktif
                if ($dataLog['status_akun'] == 'aktif') {
                    unset($dataLog['password_pengguna']);
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
            $status_pesawat      = mysqli_real_escape_string($connect, $_POST['status_pesawat']);
            $keterangan          = mysqli_real_escape_string($connect, $_POST['keterangan']);
            $uuid                = Uuid::uuid4();

            $gambar_pesawat      =  $_FILES['gambar_pesawat'];

            if ($gambar_pesawat["error"] == 0) 
            {
                $ext_file    = ['png','jpg', 'jpeg'];
                $ext_nfile   = explode('.', $gambar_pesawat["name"]);
                $ext_nfile   = strtolower(end($ext_nfile));
                $tmp_name    = $gambar_pesawat['tmp_name'];
                $new_name    = uniqid() . '.' . $ext_nfile;
                $nama_file   = $new_name;
                $besar_file  = 0;
                $link        = '../assets/images/pesawat/';

                // Check apakah data type file cocok
                // Jika berhasil, upload file
                if (in_array($ext_nfile, $ext_file)) {
                    // Check jika foto pesawat berhasil diupload

                    // Jika berhasil simpan data pesawat baru
                    if (move_uploaded_file($tmp_name, $link . $new_name)) 
                    {
                        mysqli_query($connect, "SELECT nomor_registrasi FROM data_pesawat WHERE nomor_registrasi = '$nomor_registrasi' " ) or die (mysqli_error($connect));
                        if (mysqli_affected_rows($connect) == 0) 
                        {
                            mysqli_query($connect, "INSERT INTO data_pesawat (pesawat_id, kode_pesawat, nomor_registrasi, nama_pesawat, max_lifetime, total_time_inair, time_since_overhaul, gambar_pesawat, status_pesawat, keterangan) VALUES ('$uuid', '$kode_pesawat', '$nomor_registrasi', '$nama_pesawat', '$max_lifetime', '$total_time_inair', '$time_since_overhaul', '$nama_file', '$status_pesawat', '$keterangan') " ) or die (mysqli_error($connect));
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
                    // Jika gagal beri notifikasi gagal upload file foto pesawat
                    else{
                        echo json_encode(responseAjax('error', 200, 'GAGAL', 'Tidak bisa mengupload gambar pesawat', NULL));
                        exit;
                    }
                }
                // Jika gagal beri notifikasi type gambar tidak sama
                else{
                    echo json_encode(responseAjax('error', 200, 'GAGAL', 'Jenis foto gambar tidak sesuai ketentuan format', NULL));
                    exit;
                }
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
                $results['jam50'][]  = formatAngka(((50 - (($value['total_time_inair'] / 60) % 50)) / 50) * 100);
                $results['jam100'][]  = formatAngka(((100 - (($value['total_time_inair'] / 60) % 100)) / 100) * 100);
                $results['jam300'][]  = formatAngka(((300 - (($value['total_time_inair'] / 60) % 300)) / 300) * 100);
                $results['jam400'][]  = formatAngka(((400 - (($value['total_time_inair'] / 60) % 400)) / 400) * 100);
                $results['jam500'][]  = formatAngka(((500 - (($value['total_time_inair'] / 60) % 500)) / 500) * 100);
            }
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
        elseif ($_POST['form'] == 'ajax-check-pesawat' && !empty($_POST['nomor_registrasi'])) 
        { 
            $pesawat_id  = $_POST['nomor_registrasi'];
            $queryCheck  = mysqli_query($connect, "SELECT * FROM data_pesawat WHERE pesawat_id = '$pesawat_id' " ) or die (mysqli_error($connect));
            $dataPesawat = mysqli_fetch_assoc($queryCheck);

            if (!empty($dataPesawat)) {
                
                $dataPesawat['max_lifetime']   = $dataPesawat['max_lifetime'] . ' jam';
                $dataPesawat['aircraft_time']  = konversiMenit($dataPesawat['aircraft_time']);
                $dataPesawat['engine_time']    = konversiMenit($dataPesawat['engine_time']);
                $dataPesawat['propeller_time'] = konversiMenit($dataPesawat['propeller_time']);
                
                echo json_encode(responseAjax('success', 200,  'BERHASIL', 'Data ditemukan', $dataPesawat));
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
                                        (pesawat_id, jamter_id, tanggal_terbang, waktu_diudara, pengguna_id, tujuan_penerbangan, catatan, jumlah_aircraft, jumlah_engine, jumlah_propeller, jumlah_engine_numberlanding, total_waktu_aircraft, total_waktu_engine, total_waktu_propeller, total_engine_numberlanding, jumlah_pendaratan, waktu_ditambahkan) 
                                        VALUES ('$pesawat_id', '$jamter_id', '$tanggal_terbang', '$waktu_diudara', '$pilot', '$tujuan_penerbangan', '$keterangan', '$jumlah_aircraft', '$jumlah_engine', '$jumlah_propeller', '$jumlah_landing', '$total_aircraft', '$total_engine', '$total_propeller', '$total_landing', '$jumlah_pendaratan', '$waktu_ditambahkan') " ) or die (mysqli_error($connect));
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
            $status_pesawat   = mysqli_real_escape_string($connect, $_POST['status_pesawat']);
            $keterangan       = mysqli_real_escape_string($connect, $_POST['keterangan']);
            $gambar_pesawat   =  $_FILES['gambar_pesawat'];

            if (!empty($gambar_pesawat['name'])) 
            {
                $ext_file    = ['png','jpg', 'jpeg'];
                $ext_nfile   = explode('.', $gambar_pesawat["name"]);
                $ext_nfile   = strtolower(end($ext_nfile));
                $tmp_name    = $gambar_pesawat['tmp_name'];
                $new_name    = uniqid() . '.' . $ext_nfile;
                $nama_file   = $new_name;
                $besar_file  = 0;
                $link        = '../assets/images/pesawat/';
                
                if (in_array($ext_nfile, $ext_file)) {
                    // Check jika foto pesawat berhasil diupload
                
                    // Jika berhasil simpan data pesawat baru
                    if (move_uploaded_file($tmp_name, $link . $new_name)) 
                    {
                        mysqli_query($connect, "SELECT nomor_registrasi FROM data_pesawat WHERE nomor_registrasi = '$nomor_registrasi' AND pesawat_id != '$pesawat_id' " ) or die (mysqli_error($connect));
                        if (mysqli_affected_rows($connect) == 0) 
                        {
                            mysqli_query($connect, "UPDATE data_pesawat SET kode_pesawat = '$kode_pesawat', nomor_registrasi = '$nomor_registrasi', nama_pesawat = '$nama_pesawat', max_lifetime = '$max_lifetime', gambar_pesawat = '$nama_file', status_pesawat = '$status_pesawat', keterangan = '$keterangan' WHERE pesawat_id = '$pesawat_id' ") or die(mysqli_error($connect));
                            if (mysqli_affected_rows($connect) > 0) {
                                echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil mengupdate data pesawat', NULL));
                                exit;
                            }
                            else{
                                echo json_encode(responseAjax('error', 200, 'GAGAL', 'Data Pesawat gagal diupdate', NULL));
                                exit;    
                            }
                        }
                        else{
                            echo json_encode(responseAjax('error', 200, 'GAGAL', 'Nomor Registrasi Pesawat telah terdaftar silahkan gunakan nomor registrasi lain', NULL));
                            exit;
                        }
                    }
                    // Jika gagal beri notifikasi gagal upload file foto pesawat
                    else{
                        echo json_encode(responseAjax('error', 200, 'GAGAL', 'Tidak bisa mengupload gambar pesawat', NULL));
                        exit;
                    }
                }
                // Jika gagal beri notifikasi type gambar tidak sama
                else{
                    echo json_encode(responseAjax('error', 200, 'GAGAL', 'Jenis foto gambar tidak sesuai ketentuan format', NULL));
                    exit;
                }
            }
            else{
                mysqli_query($connect, "SELECT nomor_registrasi FROM data_pesawat WHERE nomor_registrasi = '$nomor_registrasi' AND pesawat_id != '$pesawat_id' " ) or die (mysqli_error($connect));
                if (mysqli_affected_rows($connect) == 0) 
                {
                    mysqli_query($connect, "UPDATE data_pesawat SET kode_pesawat = '$kode_pesawat', nomor_registrasi = '$nomor_registrasi', nama_pesawat = '$nama_pesawat', max_lifetime = '$max_lifetime', status_pesawat = '$status_pesawat', keterangan = '$keterangan' WHERE pesawat_id = '$pesawat_id' ") or die(mysqli_error($connect));
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
        elseif ($_POST['form'] == 'tambah-maintenance-inspection' && !empty($_POST['pesawat_id'])) 
        {
            $pesawat_id                 = mysqli_escape_string($connect, $_POST['pesawat_id']);
            $jenis_inspeksi             = mysqli_escape_string($connect, $_POST['jenis_inspeksi']);
            $jenis_maintenance          = mysqli_escape_string($connect, $_POST['jenis_maintenance']);
            $tanggal_maintenanceispeksi = mysqli_escape_string($connect, $_POST['tanggal_maintenanceispeksi']);
            $tanggal_maintenanceispeksi = date('Y-m-d', strtotime($tanggal_maintenanceispeksi));            
            
            $catatan_inspeksi           = mysqli_escape_string($connect, $_POST['catatan_inspeksi']);
            $status_inspeksi            = mysqli_escape_string($connect, $_POST['status_inspeksi']);
            $teknisi_id                 = $_SESSION['sistemlog']['pengguna_id'];
            $waktu_ditambahkan          = time();
            $logmaintenance             = NULL;

            
            $queryCheck       = mysqli_query($connect, "SELECT * FROM data_pesawat WHERE pesawat_id = '$pesawat_id' " ) or die (mysqli_error($connect));
            $dataPesawat      = mysqli_fetch_assoc($queryCheck);
            if (mysqli_affected_rows($connect) > 0) 
            {
                $sisa_aircraft          = $dataPesawat['aircraft_time'];
                $sisa_engine            = $dataPesawat['engine_time'];
                $sisa_propeller         = $dataPesawat['propeller_time'];
                $sisa_jumlah_pendaratan = $dataPesawat['engine_numberlanding'];
                $jumlah_waktu_diudara   = $dataPesawat['total_time_inair'];
                $logmaintenance         = json_decode($dataPesawat['riwayat_maintenance'], true);

                if ($jenis_inspeksi == '50jam') {
                    $logmaintenance['mt50'] = $dataPesawat['total_time_inair'];
                }
                elseif ($jenis_inspeksi == '100jam') {
                    $logmaintenance['mt100'] = $dataPesawat['total_time_inair'];
                }
                elseif ($jenis_inspeksi == '300jam') {
                    $logmaintenance['mt300'] = $dataPesawat['total_time_inair'];
                }
                elseif ($jenis_inspeksi == '400jam') {
                    $logmaintenance['mt400'] = $dataPesawat['total_time_inair'];
                }
                elseif ($jenis_inspeksi == '500jam') {
                    $logmaintenance['mt500'] = $dataPesawat['total_time_inair'];
                }
                elseif ($jenis_inspeksi == '1000jam') {
                    $logmaintenance['mt1000'] = $dataPesawat['total_time_inair'];
                }
                elseif ($jenis_inspeksi == '2000jam') {
                    $logmaintenance['mt2000'] = $dataPesawat['total_time_inair'];
                }

                $encoderiwayatmaintenance = json_encode($logmaintenance);
                if ($status_inspeksi == 'diproses') {
                    $status_pesawat = 'maintenance';
                }
                else{
                    $status_pesawat = 'aktif';
                }

                mysqli_query($connect, "INSERT INTO data_maintenanceinspection 
                                        (pesawat_id, teknisi_id,  jenis_inspeksi, jenis_maintenance, total_time_inair, aircraft_jam, engine_jam, propeller_jam, landing_jumlah, tanggal_inspeksi, catatan_inspeksi, status_inspeksi, waktu_ditambahkan) 
                                        VALUES ('$pesawat_id', '$teknisi_id', '$jenis_inspeksi', '$jenis_maintenance', '$jumlah_waktu_diudara', '$sisa_aircraft', '$sisa_engine', '$sisa_propeller', '$sisa_jumlah_pendaratan', '$tanggal_maintenanceispeksi', '$catatan_inspeksi', '$status_inspeksi', '$waktu_ditambahkan') " ) or die (mysqli_error($connect));
                if (mysqli_affected_rows($connect) > 0) 
                {
                    mysqli_query($connect, "UPDATE data_pesawat SET riwayat_maintenance = '$encoderiwayatmaintenance', status_pesawat = 'maintenance' WHERE pesawat_id = '$pesawat_id' " ) or die (mysqli_error($connect));
                    echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil menambahkan Data Maintenance Inspections', NULL));
                    exit;
                }
                else{
                    echo json_encode(responseAjax('error', 200, 'GAGAL', 'Data Maintenance Inspections gagal ditambahkan', NULL));
                    exit;    
                }

            }
             else{
                echo json_encode(responseAjax('error', 200,  'ERROR', 'Data yang anda inputkan tidak ditemukan', NULL));
                exit;
             }
        }
        elseif ($_POST['form'] == 'update-maintenance-inspection' && !empty($_POST['minspect_id'])) 
        {
            $minspect_id                 = mysqli_escape_string($connect, $_POST['minspect_id']);
            $jenis_maintenance          = mysqli_escape_string($connect, $_POST['jenis_maintenance']);
            $tanggal_maintenanceispeksi = mysqli_escape_string($connect, $_POST['tanggal_maintenanceispeksi']);
            $tanggal_maintenanceispeksi = date('Y-m-d', strtotime($tanggal_maintenanceispeksi));            
            
            $catatan_inspeksi           = mysqli_escape_string($connect, $_POST['catatan_inspeksi']);
            $status_inspeksi            = mysqli_escape_string($connect, $_POST['status_inspeksi']);
            $statuspesawat              = NULL;

            
            $queryCheck       = mysqli_query($connect, "SELECT * FROM data_maintenanceinspection WHERE minspect_id = '$minspect_id' " ) or die (mysqli_error($connect));
            $dataPesawat      = mysqli_fetch_assoc($queryCheck);
            if (mysqli_affected_rows($connect) > 0) 
            {
                $pesawat_id               = $dataPesawat['pesawat_id'];

                mysqli_query($connect, "UPDATE data_maintenanceinspection
                                            SET jenis_maintenance = '$jenis_maintenance', tanggal_inspeksi = '$tanggal_maintenanceispeksi', catatan_inspeksi = '$catatan_inspeksi', status_inspeksi = '$status_inspeksi' WHERE minspect_id = '$minspect_id' " ) or die (mysqli_error($connect));
                if (mysqli_affected_rows($connect) > 0) 
                {
                    if ($status_inspeksi == 'diproses') {
                        $status_pesawat = 'maintenance';
                    }
                    else{
                        $status_pesawat = 'aktif';
                    }
                    mysqli_query($connect, "UPDATE data_pesawat SET status_pesawat = '$status_pesawat' WHERE pesawat_id = '$pesawat_id' " ) or die (mysqli_error($connect));
                    echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil mengupdate Data Maintenance Inspections', NULL));
                    exit;
                }
                else{
                    echo json_encode(responseAjax('error', 200, 'GAGAL', 'Data Maintenance Inspections gagal diupdate', NULL));
                    exit;    
                }

            }
             else{
                echo json_encode(responseAjax('error', 200,  'ERROR', 'Data yang anda inputkan tidak ditemukan', NULL));
                exit;
             }
        }
        elseif ($_POST['form'] == 'update-profile') 
        {
            $email_pengguna = mysqli_escape_string($connect, $_POST['email_pengguna']);
            $password       = mysqli_escape_string($connect, $_POST['password']);
            $nama_lengkap   = mysqli_escape_string($connect, $_POST['nama_lengkap']);
            $jenis_kelamin  = mysqli_escape_string($connect, $_POST['jenis_kelamin']);
            $tempat_lahir   = mysqli_escape_string($connect, $_POST['tempat_lahir']);
            $tanggal_lahir  = mysqli_escape_string($connect, $_POST['tanggal_lahir']);
            $no_hp          = mysqli_escape_string($connect, $_POST['no_hp']);
            $user_id        = $_SESSION['sistemlog']['pengguna_id'];

            
            if (!empty($password)) 
            {
                $password =  password_hash($password, PASSWORD_DEFAULT);
                mysqli_query($connect, "UPDATE data_pengguna
                                            SET email_pengguna = '$email_pengguna', 
                                            nama_lengkap = '$nama_lengkap', no_hp = '$no_hp', jenis_kelamin = '$jenis_kelamin', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', password_pengguna = '$password
                                            WHERE pengguna_id = '$user_id' " ) or die (mysqli_error($connect));
            }
            else{
                mysqli_query($connect, "UPDATE data_pengguna
                                            SET email_pengguna = '$email_pengguna', 
                                            nama_lengkap = '$nama_lengkap', no_hp = '$no_hp', jenis_kelamin = '$jenis_kelamin', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir' 
                                            WHERE pengguna_id = '$user_id' " ) or die (mysqli_error($connect));
            }
                
            if (mysqli_affected_rows($connect) > 0) 
            {
                $queryLog = mysqli_query($connect, "SELECT * FROM data_pengguna WHERE pengguna_id = '$user_id' " ) or die (mysqli_error($connect));
                $dataLog  = mysqli_fetch_assoc($queryLog);
                unset($dataLog['password_pengguna']);
                $_SESSION['sistemlog'] = $dataLog;

                echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil melakukan Update Profile', NULL));
                exit;
            }
            else{
                echo json_encode(responseAjax('error', 200, 'GAGAL', 'Gagal Melakukan update profile', NULL));
                exit;    
            }

          

            
            
        }
        elseif ($_POST['form'] == 'ajax-hapus-pesawat' && $_POST['dataid'] != NULL) 
        {
            $pesawatId = $_POST['dataid'];
            $queryData = mysqli_query($connect, "DELETE FROM data_pesawat WHERE pesawat_id = '$pesawatId' " ) or die (mysqli_error($connect));

            if (mysqli_affected_rows($connect) > 0) {
                echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil menghapus data pesawat', NULL));
                exit;
            }
            else{
                echo json_encode(responseAjax('error', 200, 'GAGAL', 'Gagal menghapus data pesawat', NULL));
                exit;    
            }
        }
        elseif ($_POST['form'] == 'ajax-hapus-users' && $_POST['pengguna'] != NULL) 
        {
            $penggunaId = $_POST['pengguna'];
            $queryData = mysqli_query($connect, "DELETE FROM data_pengguna WHERE pengguna_id = '$penggunaId' " ) or die (mysqli_error($connect));

            if (mysqli_affected_rows($connect) > 0) {
                echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil menghapus data user', NULL));
                exit;
            }
            else{
                echo json_encode(responseAjax('error', 200, 'GAGAL', 'Gagal menghapus data user', NULL));
                exit;    
            }
        }
        elseif ($_POST['form'] == 'tambah-penggunabaru') 
        {
            $email_pengguna   = mysqli_escape_string($connect, $_POST['email_pengguna']);
            $password         = mysqli_escape_string($connect, $_POST['password']);
            $password         = password_hash($password, PASSWORD_DEFAULT);
            $nama_lengkap     = mysqli_escape_string($connect, $_POST['nama_lengkap']);
            $jenis_kelamin    = mysqli_escape_string($connect, $_POST['jenis_kelamin']);
            $tempat_lahir     = mysqli_escape_string($connect, $_POST['tempat_lahir']);
            $tanggal_lahir    = mysqli_escape_string($connect, $_POST['tanggal_lahir']);
            $no_hp            = mysqli_escape_string($connect, $_POST['no_hp']);
            $status_akun      = mysqli_escape_string($connect, $_POST['status_akun']);
            $level_akun       = mysqli_escape_string($connect, $_POST['level_akun']);
            $jabatan_pengguna = mysqli_escape_string($connect, $_POST['jabatan_pengguna']);
            $user_id          = Uuid::uuid4();

            
                mysqli_query($connect, "INSERT INTO data_pengguna (pengguna_id, email_pengguna, nama_lengkap, no_hp, jenis_kelamin, tempat_lahir, tanggal_lahir, password_pengguna, status_akun, level_akun, jabatan)
                                            VALUES ('$user_id', '$email_pengguna', '$nama_lengkap', '$no_hp', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$password', '$status_akun', '$level_akun', '$jabatan_pengguna') " ) or die (mysqli_error($connect));                           
            if (mysqli_affected_rows($connect) > 0) 
            {
                echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil menambahkan data user baru', NULL));
                exit;
            }
            else{
                echo json_encode(responseAjax('error', 200, 'GAGAL', 'Gagal menambahkan data user baru', NULL));
                exit;    
            }

          

            
            
        }
        elseif ($_POST['form'] == 'update-pengguna' && !empty($_POST['userid'])) 
        {
            $email_pengguna   = mysqli_escape_string($connect, $_POST['email_pengguna']);
            $password         = mysqli_escape_string($connect, $_POST['password']);
            $nama_lengkap     = mysqli_escape_string($connect, $_POST['nama_lengkap']);
            $jenis_kelamin    = mysqli_escape_string($connect, $_POST['jenis_kelamin']);
            $tempat_lahir     = mysqli_escape_string($connect, $_POST['tempat_lahir']);
            $tanggal_lahir    = mysqli_escape_string($connect, $_POST['tanggal_lahir']);
            $no_hp            = mysqli_escape_string($connect, $_POST['no_hp']);
            $status_akun      = mysqli_escape_string($connect, $_POST['status_akun']);
            $level_akun       = mysqli_escape_string($connect, $_POST['level_akun']);
            $jabatan_pengguna = mysqli_escape_string($connect, $_POST['jabatan_pengguna']);
            $user_id          = mysqli_escape_string($connect, $_POST['userid']);
            
            mysqli_query($connect, "SELECT email_pengguna FROM data_pengguna WHERE email_pengguna = '$email_pengguna' AND pengguna_id != '$user_id' " ) or die (mysqli_error($connect));
            if (mysqli_affected_rows($connect) == 0) 
            {
                if (!empty($password)) 
                {
                    $password =  password_hash($password, PASSWORD_DEFAULT);
                    mysqli_query($connect, "UPDATE data_pengguna
                                                SET email_pengguna = '$email_pengguna', 
                                                nama_lengkap = '$nama_lengkap', no_hp = '$no_hp', jenis_kelamin = '$jenis_kelamin', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', password_pengguna = '$password', status_akun = '$status_akun', level_akun = '$level_akun', jabatan = '$jabatan_pengguna' 
                                                WHERE pengguna_id = '$user_id' " ) or die (mysqli_error($connect));
                }
                else{
                    mysqli_query($connect, "UPDATE data_pengguna
                                                SET email_pengguna = '$email_pengguna', 
                                                nama_lengkap = '$nama_lengkap', no_hp = '$no_hp', jenis_kelamin = '$jenis_kelamin', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', status_akun = '$status_akun', level_akun = '$level_akun', jabatan = '$jabatan_pengguna' 
                                                WHERE pengguna_id = '$user_id' " ) or die (mysqli_error($connect));
                }
                    
                if (mysqli_affected_rows($connect) > 0) 
                {
                    echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil melakukan Update users', NULL));
                    exit;
                }
                else{
                    echo json_encode(responseAjax('error', 200, 'GAGAL', 'Gagal Melakukan update users', NULL));
                    exit;    
                }
            }
            else{
                echo json_encode(responseAjax('error', 200, 'GAGAL', 'Email yang anda inputkan telah digunakan oleh user lain', NULL));
                exit;    
            }

          

            
            
        }
        elseif ($_POST['form'] == 'tambah-laporan-pesawat' && !empty($_POST['pesawat_id'])) 
        {
            $pesawat_id        = mysqli_escape_string($connect, $_POST['pesawat_id']);            
            $detail_laporan    = mysqli_escape_string($connect, $_POST['detail_laporan']);
            $pelapor_id        = $_SESSION['sistemlog']['pengguna_id'];
            $waktu_ditambahkan = time();
            $nama_file         = '-';
            $foto_laporan      = $_FILES['foto_laporan'];

            if ($foto_laporan["error"] == 0 && !empty($foto_laporan)) 
            {
                $ext_file    = ['png','jpg', 'jpeg'];
                $ext_nfile   = explode('.', $foto_laporan["name"]);
                $ext_nfile   = strtolower(end($ext_nfile));
                $tmp_name    = $foto_laporan['tmp_name'];
                $new_name    = uniqid() . '.' . $ext_nfile;
                $nama_file   = $new_name;
                $besar_file  = 0;
                $link        = '../assets/images/foto-laporan/';

                // Check apakah data type file cocok
                // Jika berhasil, upload file
                if (in_array($ext_nfile, $ext_file)) {
                    // Check jika foto pesawat berhasil diupload
                    move_uploaded_file($tmp_name, $link . $new_name);
                }
                else{
                    echo json_encode(responseAjax('error', 200, 'GAGAL', 'Format file yang anda upload tidak sesuai', NULL));
                    exit;    
                }
            }

            
            $queryCheck       = mysqli_query($connect, "SELECT * FROM data_pesawat WHERE pesawat_id = '$pesawat_id' " ) or die (mysqli_error($connect));
            $dataPesawat      = mysqli_fetch_assoc($queryCheck);
            if (mysqli_affected_rows($connect) > 0) 
            {

                mysqli_query($connect, "INSERT INTO data_laporanpesawat 
                                        (pesawat_id, pelapor_id,  keterangan_laporan, gambar_laporan, status_laporan, waktu_ditambahkan) 
                                        VALUES ('$pesawat_id', '$pelapor_id','$detail_laporan', '$nama_file', 'menunggu', '$waktu_ditambahkan') " ) or die (mysqli_error($connect));

                if (mysqli_affected_rows($connect) > 0) 
                {
                    echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil menambahkan Data Laporan Pesawat', NULL));
                    exit;
                }
                else{
                    echo json_encode(responseAjax('error', 200, 'GAGAL', 'Data Laporan Pesawat gagal ditambahkan', NULL));
                    exit;    
                }

            }
            else{
                echo json_encode(responseAjax('error', 200,  'ERROR', 'Data yang anda inputkan tidak ditemukan', NULL));
                exit;
            }
        }
        elseif ($_POST['form'] == 'ajax-batalkanlaporan' && $_POST['laporan'] != NULL) 
        {
            $laporanId = $_POST['laporan'];
            $queryData = mysqli_query($connect, "DELETE FROM data_laporanpesawat WHERE lapor_id = '$laporanId' " ) or die (mysqli_error($connect));

            if (mysqli_affected_rows($connect) > 0) {
                echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil membatalkan laporan pesawat', NULL));
                exit;
            }
            else{
                echo json_encode(responseAjax('error', 200, 'GAGAL', 'Gagal membatalkan laporan pesawat', NULL));
                exit;    
            }
        }
        elseif ($_POST['form'] == 'ajax-konfirmasilaporan' && $_POST['laporan'] != NULL) 
        {
            $laporanId = $_POST['laporan'];
            $pesawat   = $_POST['pesawat'];
            $teknisi   = $_SESSION['sistemlog']['pengguna_id'];

            mysqli_query($connect, "SELECT * FROM data_laporanpesawat WHERE lapor_id = '$laporanId' " ) or die (mysqli_error($connect));
            if (mysqli_affected_rows($connect) > 0) 
            {
                $queryData = mysqli_query($connect, "UPDATE data_laporanpesawat SET status_laporan = 'telah-dikonfirmasi', teknisi_id = '$teknisi' WHERE lapor_id = '$laporanId' " ) or die (mysqli_error($connect));

                if (mysqli_affected_rows($connect) > 0) {
                    echo json_encode(responseAjax('success', 200, 'BERHASIL', 'Berhasil mengkonfirmasi data laporan pesawat', NULL));
                    exit;
                }
                else{
                    echo json_encode(responseAjax('error', 200, 'GAGAL', 'Gagal mengkonfirmasi data laporan pesawat', NULL));
                    exit;    
                }
            }
            else{
                echo json_encode(responseAjax('error', 200, 'GAGAL', 'Data yang anda konfirmasi tidak ditemukan!', NULL));
                exit;    
            }
        }


    }
    else{
        echo 'Access denied';
    }