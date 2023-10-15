$("#login-form").submit(function (event) {
    event.preventDefault();   
    showLoading();
    $.ajax({
        url: "../konfigurasi/ajax-script.php",
        data: $("#login-form").serialize(),
        type: "post",
        async: false,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                window.location="../app/";
            }
            else{
                toastNotif(response.status, response.message, response.title);
                $('input[type="password"],textarea').val('');
            }
        },
        complete: function(){
            hideLoading();
        },
        error: function ()
        {
            Swal.fire({
                title: 'Gagal', 
                text: 'Edit data akun gagal',
                icon: 'error'
            });
        }
    });
});

$("#tambah-pesawat").submit(function (event) {
    event.preventDefault();   
    showLoading();
    $.ajax({
        url: "../konfigurasi/ajax-script.php",
        processData: false,
        contentType: false,
        data: new FormData(this),
        type: "post",
        async: false,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#tambah-pesawat')[0].reset();
                $("#status_pesawat").val('').select2();
                toastNotif(response.status, response.message, response.title, "../app/data-pesawat");
            }
            else{
                toastNotif(response.status, response.message, response.title);
            }
        },
        complete: function(){
            hideLoading();
        },
        error: function ()
        {
        }
    });
});

$("#tambah-maintenance").submit(function (event) {
    event.preventDefault();   
    showLoading();
    $.ajax({
        url: "../konfigurasi/ajax-script.php",
        data: $("#tambah-maintenance").serialize(),
        type: "post",
        async: false,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#tambah-maintenance')[0].reset();
                $("#jamter_id").val('').select2();
                toastNotif(response.status, response.message, response.title, "../app/maintenance-log");
            }
            else{
                toastNotif(response.status, response.message, response.title);
            }
        },
        complete: function(){
            hideLoading();
        },
        error: function ()
        {
        }
    });
});

$("#tambah-jam-terbang").submit(function (event) {
    event.preventDefault();   
    showLoading();
    $.ajax({
        url: "../konfigurasi/ajax-script.php",
        data: $("#tambah-jam-terbang").serialize(),
        type: "post",
        async: false,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#tambah-jam-terbang')[0].reset();
                $("#nomor_registrasi").val('').select2();
                toastNotif(response.status, response.message, response.title, "../app/jam-terbang");
            }
            else{
                toastNotif(response.status, response.message, response.title);
            }
        },
        complete: function(){
            hideLoading();
        },
        error: function ()
        {
        }
    });
});


$("#edit-pesawat").submit(function (event) {
    event.preventDefault();   
    showLoading();
    $.ajax({
        url: "../konfigurasi/ajax-script.php",
        processData: false,
        contentType: false,
        data: new FormData(this),
        type: "post",
        async: false,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#edit-pesawat')[0].reset();
                $("#status_pesawat").val('').select2();
                toastNotif(response.status, response.message, response.title, "../app/data-pesawat");
            }
            else{
                toastNotif(response.status, response.message, response.title);
            }
        },
        complete: function(){
            hideLoading();
        },
        error: function ()
        {
        }
    });
});

$("#tambah-maintenance-inspection").submit(function (event) {
    event.preventDefault();   
    showLoading();

    var pesawatId = document.getElementById('pesawat_id').value;
    $.ajax({
        url: "../konfigurasi/ajax-script.php",
        data: $("#tambah-maintenance-inspection").serialize(),
        type: "post",
        async: false,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#tambah-maintenance-inspection')[0].reset();
                $("#jenis_inspeksi").val('').select2();
                $("#jenis_maintenance").val('').select2();
                $("#status_inspeksi").val('').select2();
                toastNotif(response.status, response.message, response.title, "../app/pesawat?id=" + pesawatId + "#maintenance");
            }
            else{
                toastNotif(response.status, response.message, response.title);
            }
        },
        complete: function(){
            hideLoading();
        },
        error: function ()
        {
        }
    });
});

$("#update-maintenance-inspection").submit(function (event) {
    event.preventDefault();   
    showLoading();

    var pesawatId = document.getElementById('pesawat_id').value;
    $.ajax({
        url: "../konfigurasi/ajax-script.php",
        data: $("#update-maintenance-inspection").serialize(),
        type: "post",
        async: false,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#update-maintenance-inspection')[0].reset();
                $("#jenis_inspeksi").val('').select2();
                $("#jenis_maintenance").val('').select2();
                $("#status_inspeksi").val('').select2();
                toastNotif(response.status, response.message, response.title, "../app/pesawat?id=" + pesawatId + "#maintenance");
            }
            else{
                toastNotif(response.status, response.message, response.title);
            }
        },
        complete: function(){
            hideLoading();
        },
        error: function ()
        {
        }
    });
});

$("#update-profile").submit(function (event) {
    event.preventDefault();   
    showLoading();

    $.ajax({
        url: "../konfigurasi/ajax-script.php",        
        data: $("#update-profile").serialize(),
        type: "post",
        async: false,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#update-profile')[0].reset();
                $("#jenis_kelamin").val('').select2();
                toastNotif(response.status, response.message, response.title, "../app/akun-saya");
            }
            else{
                toastNotif(response.status, response.message, response.title);
            }
        },
        complete: function(){
            hideLoading();
        },
        error: function ()
        {
        }
    });
});

$("#tambah-penggunabaru").submit(function (event) {
    event.preventDefault();   
    showLoading();
    
    $.ajax({
        url: "../konfigurasi/ajax-script.php",        
        data: $("#tambah-penggunabaru").serialize(),
        type: "post",
        async: false,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#tambah-penggunabaru')[0].reset();
                $("#jenis_kelamin").val('').select2();
                $("#status_akun").val('').select2();
                $("#level_akun").val('').select2();
                toastNotif(response.status, response.message, response.title, "../app/manajemen-users");
            }
            else{
                toastNotif(response.status, response.message, response.title);
            }
        },
        complete: function(){
            hideLoading();
        },
        error: function ()
        {
        }
    });
});

$("#update-pengguna").submit(function (event) {
    event.preventDefault();   
    showLoading();
    
    $.ajax({
        url: "../konfigurasi/ajax-script.php",        
        data: $("#update-pengguna").serialize(),
        type: "post",
        async: false,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#update-pengguna')[0].reset();
                $("#jenis_kelamin").val('').select2();
                $("#status_akun").val('').select2();
                $("#level_akun").val('').select2();
                toastNotif(response.status, response.message, response.title, "../app/manajemen-users");
            }
            else{
                toastNotif(response.status, response.message, response.title);
            }
        },
        complete: function(){
            hideLoading();
        },
        error: function ()
        {
        }
    });
});

$("#tambah-laporan-pesawat").submit(function (event) {
    event.preventDefault();   
    showLoading();
    var pesawatId = document.getElementById('pesawat_id').value;

    
    $.ajax({
        url: "../konfigurasi/ajax-script.php",        
        data: new FormData(this),
        type: "post",
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            if (response.status === 'success') {
                $('#tambah-laporan-pesawat')[0].reset();
                toastNotif(response.status, response.message, response.title, "../app/pesawat?id=" + pesawatId + "#laporan");
            }
            else{
                toastNotif(response.status, response.message, response.title);
            }
        },
        complete: function(){
            hideLoading();
        },
        error: function ()
        {
        }
    });
});