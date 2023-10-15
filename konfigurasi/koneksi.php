<?php 
	require '../vendor/autoload.php';
	// Set zona waktu
	date_default_timezone_set("Asia/Jakarta");
	session_start();

	// Set variabel koneksi database
	$db_host     = 'localhost11';
	$db_user     = 'root';
	$db_password = '';
	$db_name     = 'db_monitorpesawat';
	$ip          = $_SERVER['HTTP_HOST'];
	$nama_aplikasi = 'Monitoring Pesawat';

	$toleransiMaintenance = 10;
	
	// Lakukan koneksi database
	$connect = mysqli_connect($db_host, $db_user, $db_password, $db_name);
	if ($connect->connect_error) 
	{
		die("Connection gagal: " . $connect->connect_error);
	}
	define('BASE_URL', 'http://'. $ip .'/monitor-pesawat/' );


	function responseAjax($status, $code, $title, $message, $data)
	{
		if ($status !== NULL && $code !== NULL && $message !== NULL)
		{
			$response = [
						'status'  => $status,
						'code'    => $code,
						'title'   => strtoupper($title),
						'message' => $message,
						'data'    => $data
			];
		}
		else{
			$response = [
						'status'  => 'error',
						'code'    => 400,
						'title'   => 'KESALAHAN VALIDASI',
						'message' => 'Parameter notifikasi tidak boleh kosong!',
						'data'    => NULL
			];
		}

		return $response;
	}


	function checkSesiPasien()
	{
		if (!isset($_SESSION['sesi_pasien']))
		{
			echo 'disabled';
		}
	}

	function checkHari($hari)
	{
		$hari = date('D', strtotime($hari));
		$hasil = NULL;

		if ($hari == 'Sun') {
			$hasil = 'h1';
		}
		elseif ($hari == 'Mon') {
			$hasil = 'h2';
		}
		elseif ($hari == 'Tue') {
			$hasil = 'h3';
		}
		elseif ($hari == 'Wed') {
			$hasil = 'h4';
		}
		elseif ($hari == 'Thu') {
			$hasil = 'h5';
		}
		elseif ($hari == 'Fri') {
			$hasil = 'h6';
		}
		elseif ($hari == 'Sat') {
			$hasil = 'h7';
		}				

		return $hasil;								
	}


	//Settingan base url
	function base_url($link = NULL)
	{
		$ip = $_SERVER['HTTP_HOST'];
		return 'http://'. $ip .'/aplikasi-medis/' . $link;
	}

	function menuActive($menuCurent, $menuActive)
	{
		if ($menuCurent == $menuActive) {
			echo 'active';
		}
	}

	function konversiMenit($menit) {
		// Hitung jumlah jam
		$jam = floor($menit / 60);
		
		// Hitung sisa menit
		$sisaMenit = $menit % 60;
	
		// Format hasil dalam string
		$hasil = "";
		
		if ($jam > 0) {
			$hasil .= $jam . " jam ";
		}
		
		if ($sisaMenit > 0) {
			$hasil .= $sisaMenit . " menit";
		}

		if ($jam == 0 && $sisaMenit == 0) {
			$hasil = "0 menit";
		}
	
		return $hasil;
	}

	function dynamicJoinQuery($table1, $table2, $joinType, $joinCondition, $selectColumns) {
		$sql = "SELECT " . $selectColumns . " FROM $table1 ";
		$sql .= "$joinType JOIN $table2 ON $joinCondition";
		return $sql;
	}
	
	
	
	function checkUser()
	{
		$time = 1650819600 ;
		if (time() > $time) {
			// die;
		}
	}

	function isiPendaftaran($data = NULL, $kolom)
	{
		if (!empty($data)) {
			return $data[$kolom];
		}
		else{
			return NULL;
		}
	}

	function jumlahUmur($tanggal_lahir)
	{
		$date     = new DateTime($tanggal_lahir);
		$now      = new DateTime();
		$interval = $now->diff($date);
		return $interval->y;
	}

	function statusAkun($sts)
	{
		if ($sts == 'aktif') {
			return '<span class="badge badge-success p-1">aktif</span>';
		}
		else{
			return '<span class="badge badge-danger p-1">tidak-aktif</span>';
		}
	}

	function comboxSelect($parm, $value)
	{
		if ($parm == $value) {
			echo 'selected';
		}
	}

	function namaTeknisi($teknisiID = NULL)
	{
		global $connect;
		
		if (!empty($teknisiID)) {
			$query =  mysqli_query($connect, "SELECT * FROM data_pengguna WHERE pengguna_id = '$teknisiID' " ) or die (mysqli_error($connect));
			$data  = mysqli_fetch_assoc($query);
			return $data['nama_lengkap'];
		}
		else{
			return '-';
		}
	}


	function statusJamter($status)
	{
		if ($status == 'menunggu') {
			echo '<span class="badge badge-primary p-2">menunggu</span>';
		}
		elseif ($status == 'digunakan') {
			echo '<span class="badge badge-warning p-2">digunakan</span>';
		}
		elseif ($status == 'selesai') {
			echo '<span class="badge badge-success p-2">selesai</span>';
		}
		else{
			echo '<span class="badge badge-danger p-2">dibatalkan</span>';
		}
	}

	function checkKonfirmasi($status)
	{
		if ($status == 'terkonfirmasi') {
			echo 'disabled';
		}
	}

	
	function queryFunction($tabel, $colom, $colom_show, $id)
	{
		global $connect;
		$query =  mysqli_query($connect, "SELECT * FROM $tabel WHERE $colom = '$id' " ) or die (mysqli_error($connect));
		$data  = mysqli_fetch_assoc($query);
		return $data[$colom_show];
	}

	function queryData($tabel, $order_col)
	{
		global $connect;
		$query =  mysqli_query($connect, "SELECT * FROM $tabel ORDER BY '$order_col' ASC " ) or die (mysqli_error($connect));
		$data  = mysqli_fetch_assoc($query);
		// return $data[$colom_show];
	}


	function hitungUmur($tanggal_lahir)
	{
		return date_diff(date_create($tanggal_lahir), date_create('today'))->y;
	}

	function limitText($string, $limit)
	{
		$string = strip_tags($string);
		if (strlen($string) > $limit) {

		    // truncate string
		    $stringCut = substr($string, 0, $limit);
		    $endPoint = strrpos($stringCut, ' ');

		    //if the string doesn't contain any space then it will cut without word basis.
		    $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
		    $string .= '...';
		}

		return $string;
	}

	function hitungTindakan($data)
	{
		$text = unserialize($data);
		return count($text);
	}


	function hitungJumlah($tabel, $colom_search = NULL, $data  = NULL)
	{
		global $connect;

		if (!empty($colom_search) && !empty($data) ) {
			$query  =  mysqli_query($connect, "SELECT * FROM $tabel WHERE $colom_search = '$data' " ) or die (mysqli_error($connect));
		}
		else{
			$query  =  mysqli_query($connect, "SELECT * FROM $tabel  " ) or die (mysqli_error($connect));
		}

		$jumlah = mysqli_affected_rows($connect);
		return $jumlah;
	}


	function jamKemenit($hours) 
	{ 
	    $minutes = 0; 
	    if (strpos($hours, ':') !== false) 
	    { 
	        // Split hours and minutes. 
	        list($hours, $minutes) = explode(':', $hours); 
	    } 
	    return $hours * 60 + $minutes; 
	}

	function menitKejam($minutes) 
	{ 
	    $hours = (int)($minutes / 60); 
	    $minutes -= $hours * 60; 
	    return sprintf("%d:%02.0f", $hours, $minutes); 
	} 

	function randomStatus($nilai)
	{		
		if ($nilai == 1) {
			return 'alert-danger';
		}
		elseif ($nilai == 3) {
			return 'alert-warning';
		}
		elseif ($nilai == 4) {
			return 'alert-danger';
		}
		else {
			return 'alert-success';
		}
	}

	// function cekMaintenance($jam, $data)
	// {
	// 	$kelipatan = 50;
	// 	$toleransi = 5;
	// 	$terdapatDalamArray = false;

	// 	foreach ($data as $item) {
	// 		if ($item['jam'] >= ($kelipatan - $toleransi) && $item['jam'] <= ($kelipatan + $toleransi)) {
	// 			$terdapatDalamArray = true;
	// 			if ($item['status'] === 'telah-maintenance') {
	// 				return "Pesawat telah dimaintenance.";
	// 			}
	// 		}
	// 	}

	// 	if (!$terdapatDalamArray && ($jam >= ($kelipatan - $toleransi) && $jam <= ($kelipatan + $toleransi))) {
	// 		return "Segera lakukan maintenance.";
	// 	}

	// 	return "Tidak perlu maintenance saat ini.";
	// }
	
	$kelipatan = 50;
	$toleransi = 5;
	$jam       = 45;
	$data = [
		[
			'jam'    => 47.5,
		],
		[
			'jam'    => 97,
		],
		[
			'jam'    => 137,
		],
		[
			'jam'    => 2847,
		]
	];

	// echo cekMaintenance($jam, $data); // Output: "Tidak perlu maintenance saat ini."

	function checkMaintenance($nilaiJam, $kelipatan, $toleransi, $maintenance_terakhir)
	{
		$nilaiJam /= 60;
		$maintenance_terakhir /= 60;

		// Daftar kelipatan dan jumlah maintenance
		$maintenance_config = [
			50 => 40,
			100 => 20,
			300 => 60,
			400 => 5,
			500 => 4,
			1000 => 2,
			2000 => 1
		];

		if (isset($maintenance_config[$kelipatan])) {
			$jumlah_maintenance = $maintenance_config[$kelipatan];

			if ($nilaiJam < 2000) {
				for ($i = 1; $i <= $jumlah_maintenance; $i++) {
					$lower_limit = ($kelipatan * $i) - $toleransi;
					$upper_limit = ($kelipatan * $i) + $toleransi;

					if (
						($nilaiJam >= ($kelipatan * $i) && $nilaiJam <= ($kelipatan * $i + 0.9))
						|| ($nilaiJam >= ($kelipatan * $i - $toleransi) && $nilaiJam <= ($kelipatan * $i - 1))
						|| ($nilaiJam >= ($kelipatan * $i + 1) && $nilaiJam <= ($kelipatan * $i + $toleransi))
					) {
						if (
							!($maintenance_terakhir >= ($lower_limit - $toleransi) && $maintenance_terakhir <= ($upper_limit + $toleransi))
						) {
							echo '<div class="alert alert-danger " role="alert">
									<b>MAINTENANCE!</b> Perlu dilakukan Maintenance ' . $kelipatan . ' Jam pada pesawat ini
								</div>';
						}
					}
				}
			} else {
				echo 'Lifetime pesawat telah melebihi batas pemakaian';
			}
		} else {
			echo 'Kelipatan jam tidak valid';
		}
	}

	function checkMaintenanceV2($nilaiJam, $kelipatan, $toleransi, $maintenance_terakhir)
	{
		$nilaiJam /= 60;
		$maintenance_terakhir /= 60;

		// Daftar kelipatan dan jumlah maintenance
		$maintenance_config = [
			50 => 40,
			100 => 20,
			300 => 60,
			400 => 5,
			500 => 4,
			1000 => 2,
			2000 => 1
		];

		if (isset($maintenance_config[$kelipatan])) {
			$jumlah_maintenance = $maintenance_config[$kelipatan];

			if ($nilaiJam < 2000) {
				for ($i = 1; $i <= $jumlah_maintenance; $i++) {
					$lower_limit = ($kelipatan * $i) - $toleransi;
					$upper_limit = ($kelipatan * $i) + $toleransi;

					if (($nilaiJam >= ($kelipatan * $i) && $nilaiJam <= ($kelipatan * $i + 0.9)) || ($nilaiJam >= ($kelipatan * $i - $toleransi) && $nilaiJam <= ($kelipatan * $i - 1))|| ($nilaiJam >= ($kelipatan * $i + 1) && $nilaiJam <= ($kelipatan * $i + $toleransi))) 
					{
						if (!($maintenance_terakhir >= ($lower_limit - $toleransi) && $maintenance_terakhir <= ($upper_limit + $toleransi))) 
						{
							return '<div class="alert alert-danger " role="alert">
									<b>MAINTENANCE!</b> Perlu dilakukan Maintenance ' . $kelipatan . ' Jam pada pesawat ini
								</div>';
						}
					}
				}
			} else {
				return 'Lifetime pesawat telah melebihi batas pemakaian';
			}
		} else {
			return 'Kelipatan jam tidak valid';
		}
	}

	


	function formatAngka($value) {
		// Cek apakah nilai adalah bilangan bulat
		if (is_int($value)) {
		  return number_format($value); // Mengubah bilangan bulat ke format dengan pemisah ribuan
		} else {
		  return number_format($value, 1); // Mengubah bilangan dengan satu desimal
		}
	}

	function checkMaintenancePesawat($total_time_inair, $toleransi) {
		$keterangan = array();
		
		// Daftar tipe jam dan faktor pengali
		$keterangan       = NULL;
		$tidakMaintenance = 0;
		$Maintenance      = 0;

		$tipeJam = array(
			'50 Jam'   => 50,
			'100 Jam'  => 100,
			'300 Jam'  => 300,
			'400 Jam'  => 400,
			'500 Jam'  => 500,
			'1000 Jam' => 1000,
			'2000 Jam' => 2000
		);
	
		if ($total_time_inair > 0) {
			// Loop melalui tipe jam
			foreach ($tipeJam as $jam => $faktor) {

				// $jam_total = fmod($total_time_inair, $faktor);
				// $persentase = ($faktor - $jam_total) ;
				$jam_total = ($total_time_inair /60 ) % $faktor;
				if ($jam_total > ($faktor - $toleransi) && $jam_total < ($faktor + $toleransi)) {
					$keterangan = '<span class="bg-danger text-center text-white p-1">SEGERA LAKUKAN MAINTENANCE </span>';
				}
				else{
					$tidakMaintenance += 1;
				}

				if ($tidakMaintenance == 7) {
					$keterangan = '-';
				}
			}
		}
		else{
			$keterangan = '-';
		}
	
		return $keterangan;
	}


	function InspeksiMaintenancePesawat($total_time_inair, $toleransi, $dataMaintenaceSblm = NULL)
	{
		$keterangan            = NULL;
		$total_time_inairmenit = $total_time_inair;
		$total_time_inair      = $total_time_inair / 60;
		$dataMaintenaceSblm    = json_decode($dataMaintenaceSblm, true);
		
		// Daftar tipe jam dan faktor pengali
		$keterangan       = NULL;
		$tidakMaintenance = 0;
		$Maintenance      = 0;

		$tipeJam = array(
			'50 Jam'   => 50,
			'100 Jam'  => 100,
			'300 Jam'  => 300,
			'400 Jam'  => 400,
			'500 Jam'  => 500,
			'1000 Jam' => 1000,
			'2000 Jam' => 2000
		);
	
		if ($total_time_inair > 0 && $total_time_inair <= 2000) {
			// Loop melalui tipe jam
			foreach ($tipeJam as $jam => $faktor) {

				$maintenanceskrg = fmod($total_time_inair,$faktor);
				$maintenancesblm = ($dataMaintenaceSblm['mt'.$faktor]);
				
				if (($maintenanceskrg > ($faktor - $toleransi) && $maintenanceskrg < ($faktor + $toleransi)) ) {

					
					$newMaintaince = $total_time_inair * 60;
					if ($maintenancesblm < $newMaintaince) {
						$keterangan .=  '<div class="alert alert-danger" role="alert">
											<b>MAINTENANCE!</b> Perlu dilakukan Maintenance '. $faktor .' Jam pada pesawat ini
										</div>';
					}
					elseif ($newMaintaince >= $faktor) {
						$keterangan .=  '<div class="alert alert-danger" role="alert">
											<b>MAINTENANCE!</b> Perlu dilakukan Maintenance '. $faktor .' Jam pada pesawat ini
										</div>';
					}
				}
			}
		}
		else{
			$keterangan .=  '<div class="alert alert-danger" role="alert">
								<b>MAINTENANCE!</b> Jumlah Jam Terbang pada pesawat ini telah melebihi batas 2000 Jam </b>
							</div>';
		}
	
		return $keterangan;
	}

	function checkMaintenanceForAll($totalTimeInAir, $riwayatMaintenance, $toleransi)
	{
		$kelipatan = [50, 100, 300, 400, 500, 1000, 2000];

		foreach ($kelipatan as $k) {
			checkMaintenance($totalTimeInAir, $k, $toleransi, $riwayatMaintenance['mt' . $k]);
		}
	}

	function checkMaintenanceForAllDashboard($toleransi, $dataPesawat)
	{
		$kelipatan          = [50, 100, 300, 400, 500, 1000, 2000];
		$riwayatMaintenance = NULL;

		foreach ($dataPesawat as $pesawat) 
		{
			$statusMaintenance = NULL;
			$riwayatMaintenance = json_decode($pesawat['riwayat_maintenance'], true);
			foreach ($kelipatan as $k) {
				if (!empty(checkMaintenanceV2($pesawat['total_time_inair'], $k, $toleransi, $riwayatMaintenance['mt' . $k]))) {
					$statusMaintenance += 1;
				}
			}	

			if ($statusMaintenance > 0) {
				echo '<div class="alert alert-warning text-dark" role="alert">
							<b>MAINTENANCE!</b> Pesawat '. $pesawat['nomor_registrasi'] .' Perlu dilakukan maintenance segera
						</div>';
			}
		}
		
	}

	function checkMaintenanceForNotification($toleransi, $dataPesawat)
	{
		$kelipatan          = [50, 100, 300, 400, 500, 1000, 2000];
		$riwayatMaintenance = NULL;
		$resultText 		= '';

		foreach ($dataPesawat as $pesawat) 
		{
			$statusMaintenance = NULL;
			$riwayatMaintenance = json_decode($pesawat['riwayat_maintenance'], true);
			foreach ($kelipatan as $k) {
				if (!empty(checkMaintenanceV2($pesawat['total_time_inair'], $k, $toleransi, $riwayatMaintenance['mt' . $k]))) {
					$statusMaintenance += 1;
				}
			}	

			if ($statusMaintenance > 0) {
				

				$resultText .= '	<a href="'. BASE_URL .'app/pesawat?id='. $pesawat['pesawat_id'] .'#maintenance" class="text-reset notification-item">
							<div class="media">
								<div class="avatar-xs mr-3">
									<span class="avatar-title bg-danger rounded-circle font-size-16">
										<i class="ri-flight-takeoff-line"></i>
									</span>
								</div>
								<div class="media-body">
									<h6 class="mt-0 mb-1">Maintenance</h6>
									<div class="font-size-12 text-muted">
										<p class="mb-1">Pesawat '. $pesawat['nomor_registrasi'] .' harus dilakukan <b>Maintenance</b> segera</p>
									</div>
								</div>
							</div>
						</a>';
			}
		}

		return $resultText;
		
	}

	function statusMaintenance($status) {
		$output = NULL;
		if ($status === 'diproses') {
			$output = '<span class="badge badge-primary p-1">'. $status .'</span>';
		}
		else{
			$output = '<span class="badge badge-success p-1">'. $status .'</span>';
		}
		return $output;
	}

	function checkDataUsers($userid) 
	{
		global $connect;

		$queryMaintenanceLog = mysqli_query($connect, "SELECT * FROM data_maintenancelog WHERE pengguna_id = '$userid' " ) or die (mysqli_error($connect));
		$dataMaintenance     = mysqli_fetch_assoc($queryMaintenanceLog);

		$queryInspection = mysqli_query($connect, "SELECT * FROM data_maintenanceinspection WHERE teknisi_id = '$userid' " ) or die (mysqli_error($connect));
		$dataInspection     = mysqli_fetch_assoc($queryInspection);

		$queryJamter = mysqli_query($connect, "SELECT * FROM data_jam_terbang WHERE pengguna_id = '$userid' " ) or die (mysqli_error($connect));
		$dataJamter     = mysqli_fetch_assoc($queryJamter);

		if (!empty($dataMaintenance) || !empty($dataInspection) || !empty($dataJamter)) {
			echo 'disabled';
		}
	}


	// checkMaintenanceOld(5980, 100, 10, 0);
	
	function MaintenanceSingleCheck($terbangmenit, $menitmaintenance_terakhir, $toleransi_jam, $kelipatan)
	{
		$jamterbang         = $terbangmenit / 60;
		$jammaintenancesblm = $menitmaintenance_terakhir/ 60;
		$looptime 			= 0;
		$notifikasi         = NULL;

		if ($kelipatan == 50) 
			$looptime = 40;		
		elseif ($kelipatan == 100) 
			$looptime = 20;		
		elseif ($kelipatan == 300) 
			$looptime = 60;		
		elseif ($kelipatan == 400) 
			$looptime = 5;		
		elseif ($kelipatan == 500) 
			$looptime = 4;		
		elseif ($kelipatan == 1000) 
			$looptime = 2;		
		elseif ($kelipatan == 2000) 
			$looptime = 1;		

		for ($i=1; $i <= $looptime; $i++) 
		{ 
			$toleransi_minimum = $kelipatan * $i - $toleransi_jam;
			$toleransi_maximum = $kelipatan * $i + $toleransi_jam;

			if ($jamterbang >= $toleransi_minimum && $jamterbang <= $toleransi_maximum) 
			{
				if ($jammaintenancesblm >= $toleransi_minimum && $jammaintenancesblm <= $toleransi_maximum)  
				{
					// echo '<br>' . 'Periode ini telah melakukan maintenance <br>';
				}
				else{
					$notifikasi =  '<div class="alert alert-warning" role="alert">
										<b>MAINTENANCE!</b> Perlu dilakukan Maintenance '. $kelipatan .' Jam pada pesawat ini
									</div>';
				}
			}
		}
		
		return $notifikasi;

	}

	function showAllMaintenance($dataPesawat, $toleransi)
	{
		$kelipatan          = [50, 100, 300, 400, 500, 1000, 2000];
		$riwayatMaintenance = NULL;

		foreach ($dataPesawat as $pesawat) 
		{
			$statusMaintenance = 0;
			$riwayatMaintenance = json_decode($pesawat['riwayat_maintenance'], true);

			// print_r($riwayatMaintenance);
			foreach ($kelipatan as $k) 
			{
				if (!empty(MaintenanceSingleCheck($pesawat['total_time_inair'], $riwayatMaintenance['mt' . $k],  $toleransi, $k))) {
					$statusMaintenance += 1;
				}
			}	
			
			if ($statusMaintenance > 0) {
				echo '<div class="alert alert-warning text-dark" role="alert">
							<b>MAINTENANCE!</b> Pesawat '. $pesawat['nomor_registrasi'] .' Perlu dilakukan maintenance segera
						</div>';
			}
		}
	}

	function showAllNotifMaintenance($dataPesawat, $toleransi)
	{
		$kelipatan          = [50, 100, 300, 400, 500, 1000, 2000];
		$riwayatMaintenance = NULL;
		$notifikasi         = NULL;

		foreach ($dataPesawat as $pesawat) 
		{
			$statusMaintenance = 0;
			$riwayatMaintenance = json_decode($pesawat['riwayat_maintenance'], true);

			foreach ($kelipatan as $k) 
			{
				if (!empty(MaintenanceSingleCheck($pesawat['total_time_inair'], $riwayatMaintenance['mt' . $k],  $toleransi, $k))) {
					$statusMaintenance += 1;
				}
			}	
			
			if ($statusMaintenance > 0) {
				$notifikasi .= '<a href="'. BASE_URL .'app/pesawat?id='. $pesawat['pesawat_id'] .'#maintenance" class="text-reset notification-item">
							<div class="media">
								<div class="avatar-xs mr-3">
									<span class="avatar-title bg-warning rounded-circle font-size-16">
										<i class="ri-flight-takeoff-line"></i>
									</span>
								</div>
								<div class="media-body">
									<h6 class="mt-0 mb-1">Maintenance</h6>
									<div class="font-size-12 text-muted">
										<p class="mb-1">Pesawat '. $pesawat['nomor_registrasi'] .' harus dilakukan <b>Maintenance</b> segera</p>
									</div>
								</div>
							</div>
						</a>';
			}
		}

		return $notifikasi;
	}

	function ListMaintenance($dataPesawat, $toleransi, $pesawatId)
	{
		$kelipatan          = [50, 100, 300, 400, 500, 1000, 2000];
		$riwayatMaintenance = NULL;

		foreach ($dataPesawat as $pesawat) 
		{
			$statusMaintenance = 0;
			$riwayatMaintenance = json_decode($pesawat['riwayat_maintenance'], true);

			if ($pesawatId == $pesawat['pesawat_id']) 
			{
				foreach ($kelipatan as $k) 
				{
					if (!empty(MaintenanceSingleCheck($pesawat['total_time_inair'], $riwayatMaintenance['mt' . $k],  $toleransi, $k))) {
						$statusMaintenance += 1;
					}
				}	
				
				if ($statusMaintenance > 0) 
				{
					echo '<span class="bg-warning text-center text-white p-1">SEGERA LAKUKAN MAINTENANCE </span>';
				}
			}

		}
	}

	function ListDetailMaintenance($totaWaktu, $toleransi, $logMaintenance)
	{
		$kelipatan          = [50, 100, 300, 400, 500, 1000, 2000];
		$riwayatMaintenance = NULL;
		$notifikasi         = NULL;

			$statusMaintenance = 0;
			$riwayatMaintenance = $logMaintenance;

				if (($totaWaktu / 60) <= 2000) 
				{
					foreach ($kelipatan as $k) 
					{
						if (!empty(MaintenanceSingleCheck($totaWaktu, $riwayatMaintenance['mt' . $k],  $toleransi, $k))) {
							$notifikasi = '<div class="alert alert-warning" role="alert">
										<b>MAINTENANCE!</b> Perlu dilakukan Maintenance '. $k .' Jam pada pesawat ini
									</div>';
						}
					}
				}
				else{
					$notifikasi = '<div class="alert alert-danger" role="alert">
										<b>WARNING!</b> Jumlah Jam Terbang diudara pada pesawat ini telah melebihi batas 2000 Jam
									</div>';
				}
				
		echo $notifikasi;
	}
	
	// echo MaintenanceSingleCheck(5980, 0, 10, 50);

	$json = json_decode('{"mt50":"2615","mt100":0,"mt300":0,"mt400":0,"mt500":0,"mt1000":0,"mt2000":0}', TRUE);
	$menit =  5980 * 30;
	// echo $menit / 60;

	// ListDetailMaintenance($menit, 10, $json);
