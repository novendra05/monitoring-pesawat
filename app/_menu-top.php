                <div id="loading-ajax">Loading</div>        
                <div class="topnav">
                    <div class="container-fluid">
                        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
    
                            <div class="collapse navbar-collapse" id="topnav-menu-content">
                                <ul class="navbar-nav">

                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= BASE_URL . 'app'; ?>">
                                            <i class="ri-dashboard-line mr-2"></i> Dashboard
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="data-pesawat">
                                            <i class="ri-flight-land-fill mr-2"></i> Data Pesawat
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="jam-terbang">
                                            <i class="ri-timer-flash-line mr-2"></i> Jam Terbang
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="maintenance-log">
                                            <i class="ri-database-line mr-2"></i> Maintenance Log
                                        </a>
                                    </li>
                                    <?php if ($_SESSION['sistemlog']['level_akun'] == 'admin') : ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="manajemen-users">
                                            <i class="ri-user-settings-line mr-2"></i> Manajemen Users
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="cetak-laporan">
                                            <i class="ri-newspaper-line mr-2"></i> Cetak Laporan
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="akun-saya">
                                            <i class="ri-user-settings-line mr-2"></i> Akun Saya
                                        </a>
                                    </li>
        
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">


                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $nama_aplikasi; ?></a></li>
                                            <li class="breadcrumb-item active"><?= $nama_halaman; ?></li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->