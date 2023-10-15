<?php

    include_once('../konfigurasi/koneksi.php');
    unset($_SESSION['sistemlog']);
	echo '<script>window.location="../auth";</script>';