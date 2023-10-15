<?php
    include_once('../konfigurasi/koneksi.php');

    if (isset($_SESSION['sistemlog'])) {
        header('Location: ../app/');
    }
?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Login | Nazox - Responsive Bootstrap 4 Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= BASE_URL; ?>assets/images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>assets/libs/toastr/build/toastr.min.css">

        <!-- Bootstrap Css -->
        <link href="<?= BASE_URL; ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?= BASE_URL; ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?= BASE_URL; ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

        <link href="<?= BASE_URL; ?>assets/css/custom-script.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="auth-body-bg">
        <div id="loading-ajax">Loading</div>        
        <div>
            <div class="container-fluid p-0">
                <div class="row no-gutters">
                    <div class="col-lg-4">
                        <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                            <div class="w-100">
                                <div class="row justify-content-center">
                                    <div class="col-lg-9">
                                        <div>
                                            <div class="text-center">
                                                <div>
                                                    <a href="index.html" class="logo"><img src="<?= BASE_URL; ?>assets/images/logo-dark.png" height="60" alt="logo"></a>
                                                </div>
    
                                                <p class="text-muted">Sign in to continue system.</p>
                                            </div>

                                            <div class="p-2 mt-5">
                                                <form class="form-horizontal" id="login-form" method="post">
                    
                                                    <div class="form-group auth-form-group-custom mb-4">
                                                        <i class="ri-user-2-line auti-custom-input-icon"></i>
                                                        <label for="email">Email</label>
                                                        <input type="hidden" name="form" value="login">
                                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                                                    </div>
                            
                                                    <div class="form-group auth-form-group-custom mb-4">
                                                        <i class="ri-lock-2-line auti-custom-input-icon"></i>
                                                        <label for="userpassword">Password</label>
                                                        <input type="password" class="form-control" id="userpassword" name="userpassword" placeholder="Enter password" required>
                                                    </div>
                            
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customControlInline">
                                                        <label class="custom-control-label" for="customControlInline">Remember me</label>
                                                    </div>

                                                    <div class="mt-4 text-center">
                                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                                                    </div>

                                                    <div class="mt-4 text-center">
                                                        <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock mr-1"></i> Forgot your password?</a>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="mt-5 text-center">
                                                <p>© 2023 Monitoring Pesawat </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="authentication-bg">
                            <div class="bg-overlay"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- JAVASCRIPT -->
        <script src="<?= BASE_URL; ?>assets/libs/jquery/jquery.min.js"></script>
        <script src="<?= BASE_URL; ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= BASE_URL; ?>assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?= BASE_URL; ?>assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?= BASE_URL; ?>assets/libs/node-waves/waves.min.js"></script>


        <!-- toastr plugin -->
        <script src="<?= BASE_URL; ?>assets/libs/toastr/build/toastr.min.js"></script>

        <!-- toastr init -->
        <script src="<?= BASE_URL; ?>assets/js/pages/toastr.init.js"></script>

        <script src="<?= BASE_URL; ?>assets/js/app.js"></script>
        <script src="<?= BASE_URL; ?>assets/js/custom-script.js"></script>
        <script src="<?= BASE_URL; ?>assets/js/custom-form.js"></script>
        <!-- <script>
            toastNotif('error', 'Email atau Password yang anda masukkan salah', 'GAGAL');
        </script> -->

    </body>
</html>
