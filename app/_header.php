<?php
    include_once('../konfigurasi/koneksi.php');

    if (!isset($_SESSION['sistemlog'])) {
        echo '<script>window.location="../auth";</script>';
    }

    $queryNotif = mysqli_query($connect, "SELECT * FROM data_pesawat ORDER BY nomor_registrasi ASC" ) or die (mysqli_error($connect));
    $dataNotifPesawat = mysqli_fetch_all($queryNotif, MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title><?= $nama_halaman; ?> | Nama Aplikasi</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= BASE_URL; ?>assets/images/favicon.ico">
        <link href="<?= BASE_URL; ?>assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>assets/libs/toastr/build/toastr.min.css">

        <!-- jquery.vectormap css -->
        <link href="<?= BASE_URL; ?>assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

        <link href="<?= BASE_URL; ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= BASE_URL; ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="<?= BASE_URL; ?>assets/libs/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="<?= BASE_URL; ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />

        <!-- DataTables -->
        <link href="<?= BASE_URL; ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= BASE_URL; ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= BASE_URL; ?>assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Plugins css -->

        <!-- Responsive datatable examples -->
        <link href="<?= BASE_URL; ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Sweet Alert-->
        <link href="<?= BASE_URL; ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="<?= BASE_URL; ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?= BASE_URL; ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?= BASE_URL; ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Custom Css-->
        <link href="<?= BASE_URL; ?>assets/css/custom-script.css" rel="stylesheet" type="text/css" />

    </head>

    <body data-topbar="dark" data-layout="horizontal">

        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar">
                <div class="navbar-header ">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="<?= BASE_URL . 'app'; ?>" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="<?= BASE_URL; ?>assets/images/logo-sm-dark.png" alt="" height="62">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?= BASE_URL; ?>assets/images/logo-dark.png" alt="" height="20">
                                </span>
                            </a>

                            <a href="<?= BASE_URL . 'app'; ?>" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="<?= BASE_URL; ?>assets/images/logo-sm-light.png" alt="" height="62">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?= BASE_URL; ?>assets/images/logo-light.png" alt="" height="60">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item" data-toggle="collapse" data-target="#topnav-menu-content">
                            <i class="ri-menu-2-line align-middle"></i>
                        </button>

                      
                    </div>

                    <div class="d-flex">

                        



                       

                        <div class="dropdown d-none d-lg-inline-block ml-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                <i class="ri-fullscreen-line"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-notification-3-line"></i>
                                <?php
                                    if(!empty(checkMaintenanceForNotification($toleransiMaintenance, $dataNotifPesawat)))
                                    {
                                        echo '<span class="noti-dot"></span>';
                                    }
                                ?>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0"> Notifications </h6>
                                        </div>
                                        <div class="col-auto">
                                            <!-- <a href="#!" class="small"> View All</a> -->
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    <?= showAllNotifMaintenance($dataNotifPesawat, $toleransiMaintenance); ?>
                                </div>
                                
                            </div>
                        </div>

                        <div class="dropdown d-inline-block user-dropdown">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="<?= BASE_URL; ?>assets/images/users/avatar-2.jpg"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ml-1"><?= $_SESSION['sistemlog']['nama_lengkap']; ?></span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <a class="dropdown-item" href="<?= BASE_URL . 'app/akun-saya'; ?>"><i class="ri-user-line align-middle mr-1"></i> Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" data-link="<?= BASE_URL . 'auth/logout'; ?>" id="logout-btn"><i class="ri-shut-down-line align-middle mr-1 text-danger"></i> Logout</a>
                            </div>
                        </div>

                   
            
                    </div>
                </div>
            </header>
