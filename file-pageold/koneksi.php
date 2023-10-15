<?php 
	
	date_default_timezone_set("Asia/Jakarta");
	session_start();

	$nama_aplikasi = 'Maintenance Pesawat';



	function base_url($link = NULL)
	{
		$ip = $_SERVER['HTTP_HOST'];
		return 'http://'. $ip .'/aplikasi-properti-v2/' . $link;
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