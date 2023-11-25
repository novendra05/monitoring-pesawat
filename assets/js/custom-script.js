

// Fungsi tampilkan loading
    function hideLoading(){
      $("#loading-ajax").fadeOut();
  }

  // Fungsi hilangkan loading
  function showLoading(){
      $("#loading-ajax").fadeIn();
  }

  $(document).ready(function() {
      // Kode JavaScript Anda di sini akan dijalankan setelah dokumen HTML dimuat.
      // Ini adalah tempat yang baik untuk mengikat event, memanipulasi elemen, atau melakukan tindakan lain yang berkaitan dengan DOM.
      
      $("#loading-ajax").fadeOut(800);
      $('#customTable').DataTable({
        //"order": [[0, "desc"]], // Menentukan kolom pertama (index 0) diurutkan secara descending
        "pageLength": 50,
        "columnDefs": [
          {
            "targets": [1, 2, 3, 4, 5], // Daftar kolom yang tidak diizinkan untuk diurutkan
            "orderable": false
          }
        ]
      });

      $('.customTable').DataTable({
        //"order": [[0, "desc"]], // Menentukan kolom pertama (index 0) diurutkan secara descending
        "pageLength": 50,
        "columnDefs": [
          {
            "targets": [1, 2, 3, 4], // Daftar kolom yang tidak diizinkan untuk diurutkan
            "orderable": false
          }
        ]
      });

      $('#customTableLap').DataTable({
        //"order": [[0, "desc"]], // Menentukan kolom pertama (index 0) diurutkan secara descending
        "pageLength": 50,
        "columnDefs": [
          {
            "targets": [1, 2, 3, 4], // Daftar kolom yang tidak diizinkan untuk diurutkan
            "orderable": false
          }
        ]
      });

      $('#riwayatMT').DataTable({
        //"order": [[0, "desc"]], // Menentukan kolom pertama (index 0) diurutkan secara descending
        "pageLength": 50,
        "columnDefs": [
          {
            "targets": [1, 2, 3, 4], // Daftar kolom yang tidak diizinkan untuk diurutkan
            "orderable": false
          }
        ]
      });

      $('#riwayatPT').DataTable({
        //"order": [[0, "desc"]], // Menentukan kolom pertama (index 0) diurutkan secara descending
        "pageLength": 50,
        "columnDefs": [
          {
            "targets": [1, 2, 3, 4], // Daftar kolom yang tidak diizinkan untuk diurutkan
            "orderable": false
          }
        ]
      });
  });
  

  function toastNotif(status, pesan, judul, urlPindahHalaman) {
      if (status !== '' && pesan !== '' && judul !== '') {
        toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": true,
          "progressBar": true,
          "positionClass": "toast-top-full-width",
          "preventDuplicates": false,
          "showDuration": "3000",
          "hideDuration": "4000",
          "timeOut": "4000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut",
          "onHidden": function() {
            if (urlPindahHalaman && urlPindahHalaman.trim() !== '') {
              // Pindah halaman setelah pesan toastr ditutup
              window.location.href = urlPindahHalaman;
            }
          }
        };
    
        toastr[status](pesan, judul);
      }
  }

  // Fungsi untuk memuat data dari server dan mengisi chart
  function loadDataSinglePlane() {
    const baseUrlElement = document.getElementById('base-url');
    const baseUrl = baseUrlElement.getAttribute('data-base-url');
  
    const baseID = document.getElementById('data-id');
    const idPesawat = baseID.getAttribute('data-pesawat');
  
    const endpoint = 'konfigurasi/ajax-script.php';
    const fullUrl = baseUrl + endpoint;
  
    $.ajax({
      url: fullUrl,
      method: 'post',
      data: {
        pesawat: idPesawat,
        form: 'ajax',
      },
      dataType: 'json',
      success: function (response) {
        var targetData = response.jamPenggunaan;
        var labels = response.labels;
  
        // Ambil elemen canvas untuk grafik
        var chartElement = document.getElementById('chartpesawat');
  
        // Membuat objek data untuk chart
        var chartData = {
          labels: labels,
          datasets: [
            {
              label: 'Waktu Penggunaan',
              data: targetData,
              fill: true,
              lineTension: 0.1,
              backgroundColor: 'rgb(75, 192, 192)',
            },
          ],
        };
  
        var chartOptions = {
          plugins: {
            tooltip: {
              callbacks: {
                label: function (context) {
                  var label = context.dataset.label || '';
                  if (label) {
                    label += ': ';
                  }
                  if (context.parsed.y !== null) {
                    label += context.parsed.y + ' menit';
                  }
                  return label;
                },                  
              },
            },
            title: {
              display : true,
              text : 'GRAFIK JAM PENERBANGAN PESAWAT',
              position : 'bottom',
              font : {
                weight: 'bold',
                size: 12,                  
              },
              padding: {
                top: 20,
              }
            }
          },
        };
  
        // Inisialisasi chart baru
        var chart = new Chart(chartElement, {
          type: 'bar',
          data: chartData,
          options: chartOptions,
        });
      },
      error: function (xhr, status, error) {
        console.error('Error fetching data:', error);
      },
    });
  }
 
  function loadDataMultiPlane() {
    
  
    const endpoint = 'konfigurasi/ajax-script.php';
    
    $.ajax({
      url: '../konfigurasi/ajax-script.php',
      method: 'post',
      data: {
        form: 'ajax-multi-plane',
      },
      dataType: 'json',
      success: function (response) {
        var labels = response.labels;
  
        // Ambil elemen canvas untuk grafik
        var chartElement = document.getElementById('chartmtpesawat');
  
        // Membuat objek data untuk chart
        var chartData = {
          labels: labels,
          datasets: [
            {
              label: '50 Jam',
              data: response.jam50,
              fill: true,
              backgroundColor: '#7b2d43',
              lineTension: 0.1,
              datalabels: {
                align: 'top',
                anchor: 'end',
                offset: 1,
                color: 'black'
              }
            },
            {
              label: '100 Jam',
              data: response.jam100,
              fill: true,
              backgroundColor: '#d257b0',
              lineTension: 0.1,
              datalabels: {
                align: 'top',
                anchor: 'end',
                offset: 1,
                color: 'black'
              }
            },
            {
              label: '300 Jam',
              data: response.jam300,
              fill: true,
              backgroundColor: '#20c063',
              lineTension: 0.1,
              datalabels: {
                align: 'top',
                anchor: 'end',
                offset: 1,
                color: 'black'
              }
            },
            // {
            //   label: '400 Jam',
            //   data: response.jam400,
            //   fill: true,
            //   backgroundColor: '#49c959',
            //   lineTension: 0.1,
            //   datalabels: {
            //     align: 'top',
            //     anchor: 'end',
            //     offset: 1,
            //     color: 'black'
            //   }
            // },
            // {
            //   label: '500 Jam',
            //   data: response.jam500,
            //   fill: true,
            //   backgroundColor: '#ff102a',
            //   lineTension: 0.1,
            //   datalabels: {
            //     align: 'top',
            //     anchor: 'end',
            //     offset: 1,
            //     color: 'black'
            //   }
            // },
          ],
        };
  
        var chartOptions = {
          maintainAspectRatio: false,
          parsing: {
            // yAxisKey: 'available'
          },
          scales:{
            y: {
              // beginAtZero: true,
            }
          },          
          plugins: {
            tooltip: {
              callbacks: {
                label: function (context) {
                  var label = context.dataset.label || '';
                  var tipejam = label || label;
                  if (label) {
                    label = 'Sisa Waktu ' + label + ' : ';
                  }
                  if (context.parsed.y !== null) {
                    var persen = parseInt(context.parsed.y);
                    label += persen + '% [' + hitungNilaiAsli(persen, tipejam) + ' jam]';
                  }
                  return label;
                },                  
              },
            },
            title: {
              display : true,
              text : 'SISA WAKTU MAINTENANCE PESAWAT',
              position : 'bottom',
              font : {
                weight: 'bold',
                size: 12,                  
              },
              padding: {
                top: 20,
              }
            },
            datalabels:{
              formatter: (value, ctx) => {
                // console.log(ctx.chart.data);
                const persenData = ctx.chart.data.datasets[ctx.datasetIndex].data[ctx.dataIndex];
                // console.log(ctx.chart.data.datasets[ctx.datasetIndex].data[ctx.dataIndex]);
                // console.log(persenData);
                return persenData + '%';
              },
              font: {
                size: 10
            }
            },          
            legend: {
              position: 'bottom',
            }
          },
          layout: {
            padding: {
              top: 50
            }
          }
        };
  
        // Inisialisasi chart baru
        var chart = new Chart(chartElement, {
          type: 'bar',
          data: chartData,
          options: chartOptions,
          plugins: [ChartDataLabels]
        });
      },
      error: function (xhr, status, error) {
        console.error('Error fetching data:', error);
      },
    });
  }

  // Form Pilih Jam Terbang Halaman Maintenance Pesawat
  $("#jamter_id").on("change", function() 
  {
      var selectedValue = $(this).val();

      // Buat permintaan AJAX ke server
      $.ajax({
          url: "../konfigurasi/ajax-script.php",
          method: "post",
          data: { jamter: selectedValue, form: 'ajax-form-tambah-maintenance' },
          dataType: "json",
          success: function(response) {
              // Isi input dengan data yang diterima dari server
              if (response.status === 'success') {
                $("#nomor_registrasi").val(response.data.nomor_registrasi);
                $("#pesawat_id").val(response.data.pesawat_id);
                $("#kode_pesawat").val(response.data.kode_pesawat);
                $("#nama_pesawat").val(response.data.nama_pesawat);
                $("#tanggal_terbang").val(response.data.tanggalwaktu_terbang);
                $("#nama_pilot").val(response.data.nama_lengkap);
                $("#tujuan_penerbangan").val(response.data.tujuan_penerbangan);
                $("#max_lifetime").val(response.data.max_lifetime);

                $("#sisa-aircraft").val(response.data.aircraft_time);
                $("#sisa-engine").val(response.data.engine_time);
                $("#sisa-jumlah-pendaratan").val(response.data.engine_numberlanding);
                $("#sisa-propeller").val(response.data.propeller_time);
                $("#waktu_diudara").val('');
                $("#jumlah_pendaratan").val('');
                $("#keterangan").val('');
              }
              else{
                toastNotif(response.status, response.message, response.title);
              }
          },
          error: function(xhr, status, error) {
              console.error("Error fetching data:", error);
          }
      });
  });

  $("#jumlah_pendaratan").on("change", function() {
    
        var jumlah_pendaratan = $(this).val();
        var pesawat_id        = $("#pesawat_id").val();
        var waktu_diudara     = $("#waktu_diudara").val();

      // Periksa jika nomor registrasi sudah dipilih
      if (pesawat_id) {
          // Lakukan perhitungan atau permintaan AJAX ke server dengan waktu diudara sebagai data POST
          $.ajax({
              url: "../konfigurasi/ajax-script.php",
              method: "post",
              data: { waktu_diudara: waktu_diudara, form: 'ajax-hitung-waktu-penerbangan', pesawat: pesawat_id, pendaratan: jumlah_pendaratan},
              dataType: "json",
              success: function(response) 
              {
                if (response.status === 'success') {

                  $("#total-time-aircraft").val(response.data.aircraft_timetotal );
                  $("#total-time-engine").val(response.data.engine_timetotal );
                  $("#total-time-propeller").val(response.data.propeller_timetotal );
                  $("#total-jumlah-pendaratan").val(response.data.pendaratan_total );
                }
                else{
                  toastNotif(response.status, response.message, response.title);
                }                  
              },
              error: function(xhr, status, error) {
                  console.error("Error fetching data:", error);
              }
          });
      } else {
          // Jika nomor registrasi belum dipilih, tampilkan alert
          toastNotif('error', 'Harap input nomor registrasi pesawat terlebih dahulu', 'GAGAL');
      }
  });

  function detailMaintenanceLog(mainLogID) 
  {
    $.ajax({
      url: "../konfigurasi/ajax-script.php",
      method: "post",
      data: { main_id: mainLogID, form: 'ajax-detail-maintenancelog' },
      dataType: "json",
      success: function(response) 
      {
        if (response.status === 'success') {
            // $("#total-time-aircraft").val(response.data.aircraft_timetotal );
            document.getElementById('dt_noreg_pesawat').innerHTML               = response.data.nomor_registrasi;
            document.getElementById('dt_tanggal_terbang').innerHTML             = response.data.tanggal_terbang;
            document.getElementById('dt_kode_pesawat').innerHTML                = response.data.kode_pesawat;
            document.getElementById('dt_nama_lengkap').innerHTML                = response.data.nama_lengkap;
            document.getElementById('dt_tujuan_penerbangan').innerHTML          = response.data.tujuan_penerbangan;
            document.getElementById('dt_waktu_diudara').innerHTML               = response.data.waktu_diudara;
            document.getElementById('dt_jumlah_pendaratan').innerHTML               = response.data.jumlah_pendaratan;
            document.getElementById('dt_keterangan').innerHTML                  = response.data.keterangan;
            document.getElementById('dt_jumlah_aircraft').innerHTML             = response.data.jumlah_aircraft;
            document.getElementById('dt_jumlah_engine').innerHTML               = response.data.jumlah_engine;
            document.getElementById('dt_jumlah_engine_numberlanding').innerHTML = response.data.jumlah_engine_numberlanding;
            document.getElementById('dt_jumlah_propeller').innerHTML            = response.data.jumlah_propeller;
            document.getElementById('dt_total_aircraft').innerHTML              = response.data.total_waktu_aircraft;
            document.getElementById('dt_total_engine').innerHTML                = response.data.total_waktu_engine;
            document.getElementById('dt_total_engine_numberlanding').innerHTML  = response.data.total_engine_numberlanding;
            document.getElementById('dt_total_propeller').innerHTML             = response.data.total_waktu_propeller;
            $('#modal-detail-maintenancelog').modal('show');
          }
          else{
            toastNotif(response.status, response.message, response.title);
          }                  
        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });
  }

  function updateJamter(status, idJamter)
  {
    var pertanyaan;
    var icons = 'question';

    if (status == 'digunakan') {
      pertanyaan = 'Apakah anda ingin mengkonfirmasi penggunaan pesawat ?';
    }
    else if (status == 'selesai') {
      pertanyaan = 'Apakah anda ingin menyelesaikan penggunaan pesawat ?';      
    } 
    else if (status == 'batalkan') {
      pertanyaan = 'Apakah anda ingin membatalkan penggunaan pesawat ?';      
    } 

    Swal.fire({
          title: 'Konfirmasi',
          text: pertanyaan,
          icon: 'question',
          showCancelButton: true,                    
          cancelButtonColor: '#FF3D60',
          confirmButtonText: 'Ya, Konfirmasi',
          cancelButtonText: 'Batalkan'
    }).then((result) => {
      if (result.isConfirmed) 
      {
        $.ajax({
            url: "../konfigurasi/ajax-script.php",
            method: "post",
            data: { status: status, form: 'ajax-updatestats-jamter', jamter: idJamter },
            dataType: "json",
            success: function(response) 
            {
              if (response.status === 'success') {
                toastNotif(response.status, response.message, response.title, "../app/jam-terbang");
              }
              else{
                toastNotif(response.status, response.message, response.title);
              }                  
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
      }
      else{
        toastNotif('error', 'Aksi dibatalkan', 'GAGAL');
      }
    })


  }

  // Form Pilih Jam Terbang Halaman Maintenance Pesawat
  $("#nomor_registrasijamter").on("change", function() 
  {
      var selectedValue = $(this).val();

      // Buat permintaan AJAX ke server
      $.ajax({
          url: "../konfigurasi/ajax-script.php",
          method: "post",
          data: { nomor_registrasi: selectedValue, form: 'ajax-check-pesawat' },
          dataType: "json",
          success: function(response) {
              // Isi input dengan data yang diterima dari server
              if (response.status === 'success') {
                $("#kode_pesawat").val(response.data.kode_pesawat);
                $("#nama_pesawat").val(response.data.nama_pesawat);
                $("#max_lifetime").val(response.data.max_lifetime);

                $("#sisa-aircraft").val(response.data.aircraft_time);
                $("#sisa-engine").val(response.data.engine_time);
                $("#sisa-propeller").val(response.data.propeller_time);
              }
              else{
                toastNotif(response.status, response.message, response.title);
              }
          },
          error: function(xhr, status, error) {
              console.error("Error fetching data:", error);
          }
      });
  });
  
  function hitungNilaiAsli(persen, tipeNilai) 
  {
    // Daftar tipe nilai dan faktor pengali
    const faktorPengali = {
      '50 Jam': 50,
      '100 Jam': 100,
      '300 Jam': 300,
      '400 Jam': 400,
      '500 Jam': 500
    };
  
    // Periksa apakah tipe nilai valid
    if (faktorPengali[tipeNilai] !== undefined) {
      // Hitung nilai asli berdasarkan persentase dan faktor pengali
      const faktor = faktorPengali[tipeNilai];
      const nilaiAsli = (persen / 100) * faktor;
      
      return parseFloat(nilaiAsli.toFixed(1));
    } else {
      // Tipe nilai tidak valid
      return null;
    }
  }


  function setTabActiveFromURL() 
  {
    // Mendapatkan URL saat ini
    var currentURL = window.location.href;

    // Mencari tanda pagar (#) dalam URL
    var hashIndex = currentURL.indexOf('#');

    if (hashIndex !== -1) {
      // Jika tanda pagar (#) ditemukan dalam URL
      var tabId = currentURL.substring(hashIndex + 1); // Mengambil nilai setelah tanda pagar

      // Menghilangkan class 'active' dari semua elemen dengan class 'tab-pane'
      var tabPanes = document.querySelectorAll('.tab-pane');
      tabPanes.forEach(function (tabPane) {
        tabPane.classList.remove('active');
      });

      var navLink = document.querySelectorAll('.nav-link');
      navLink.forEach(function (navLink) {
        navLink.classList.remove('active');
      });

      // Menambahkan class 'active' ke elemen dengan id yang sesuai dengan nilai dari URL
      var activeTab = document.getElementById(tabId);
      if (activeTab) {
        activeTab.classList.add('active');
      }

      var activeNav = document.getElementById('navlink-' + tabId);
      if (activeNav) {
        activeNav.classList.add('active');
      }
    }
  }

  $('.konfirmasi-hapus-pesawat').click(function(){
      const dataid = $(this).attr("data-link");

          Swal.fire({
              title: 'Konfirmasi',
              text: "Apakah anda yakin ingin menghapus data pesawat ini?",
              icon: 'question',
              showCancelButton: true,                    
              cancelButtonColor: '#FF3D60',
              confirmButtonText: 'Ya, Hapus',
              cancelButtonText: 'Batalkan'
          }).then((result) => {
                    if (result.isConfirmed) {
                      $.ajax({
                        url: "../konfigurasi/ajax-script.php",
                        method: "post",
                        data: { dataid: dataid, form: 'ajax-hapus-pesawat' },
                        dataType: "json",
                        success: function(response) 
                        {
                          if (response.status === 'success') {
                              toastNotif(response.status, response.message, response.title,  "../app/data-pesawat");
                            }
                            else{
                              toastNotif(response.status, response.message, response.title);
                            }                  
                          },
                          error: function(xhr, status, error) {
                              console.error("Error fetching data:", error);
                          }
                      });
            }
          })
  });

  $('.konfirmasi-hapus-users').click(function(){
    const dataid = $(this).attr("data-link");

        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah anda yakin ingin menghapus data pengguna ini? Jika pengguna telah memiliki riwayat penggunaan pesawat maka data tidak bisa dihapus",
            icon: 'question',
            showCancelButton: true,                    
            cancelButtonColor: '#FF3D60',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batalkan'
        }).then((result) => {
                  if (result.isConfirmed) {
                    $.ajax({
                      url: "../konfigurasi/ajax-script.php",
                      method: "post",
                      data: { pengguna: dataid, form: 'ajax-hapus-users' },
                      dataType: "json",
                      success: function(response) 
                      {
                        if (response.status === 'success') {
                            toastNotif(response.status, response.message, response.title,  "../app/manajemen-users");
                          }
                          else{
                            toastNotif(response.status, response.message, response.title);
                          }                  
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching data:", error);
                        }
                    });
          }
        })
  });

  $('#logout-btn').click(function(){
    const link = $('#logout-btn').data('link');
        Swal.fire({
              title: 'Logout',
              icon: 'question',
              text: "Apakah anda ingin melakukan logout sistem?",
              showCancelButton: true,
              cancelButtonColor: '#FF3D60',
              confirmButtonText: 'Ya, logout sistem'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location = link;
          }
        })
  });

  function batalkanLaporan(laporanID, pesawatId)
  {
    Swal.fire({
        title: 'Konfirmasi',
        text: "Apakah anda yakin ingin membatalkan laporan ini? Setelah dibatalkan laporan akan menghilang",
        icon: 'question',
        showCancelButton: true,                    
        cancelButtonColor: '#FF3D60',
        confirmButtonText: 'Ya, Batalkan Laporan',
        cancelButtonText: 'Batalkan'
      }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url: "../konfigurasi/ajax-script.php",
                    method: "post",
                    data: { laporan: laporanID, form: 'ajax-batalkanlaporan' },
                    dataType: "json",
                      success: function(response) 
                      {
                        if (response.status === 'success') {
                          toastNotif(response.status, response.message, response.title, "../app/pesawat?id=" + pesawatId );    
                        }
                        else{
                          toastNotif(response.status, response.message, response.title);
                        }                  
                      },
                      error: function(xhr, status, error) {
                          console.error("Error fetching data:", error);
                      }
                  });
        }
    }); 
  }

  function konfirmasiLaporan(laporanID, pesawatId)
  {
    Swal.fire({
        title: 'Konfirmasi',
        text: "Apakah anda yakin ingin mengkonfirmasi laporan ini?",
        icon: 'question',
        showCancelButton: true,                    
        cancelButtonColor: '#FF3D60',
        confirmButtonText: 'Ya, Konfirmasi Laporan',
        cancelButtonText: 'Batalkan'
      }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url: "../konfigurasi/ajax-script.php",
                    method: "post",
                    data: { laporan: laporanID, pesawat: pesawatId, form: 'ajax-konfirmasilaporan' },
                    dataType: "json",
                      success: function(response) 
                      {
                        if (response.status === 'success') {
                          toastNotif(response.status, response.message, response.title, "../app/pesawat?id=" + pesawatId );    
                        }
                        else{
                          toastNotif(response.status, response.message, response.title);
                        }                  
                      },
                      error: function(xhr, status, error) {
                          console.error("Error fetching data:", error);
                      }
                  });
        }
    }); 
  }

  function checkMaintenanceValue() {
    // Ambil nilai dari elemen dengan id "jenis_maintenance"
    var jenisLaporanSelect = document.getElementById('jenis_laporan');
    var jenisMaintenanceSelect = document.getElementById('jenis_maintenance');
    
    // Tentukan nilai yang ingin dicek (misalnya: 'maintenance')
    var nilaiMaintenance = 'maintenance';
    
    // Periksa apakah nilai sama dengan 'maintenance'
    if (jenisLaporanSelect.value !== nilaiMaintenance) {
        // Jika tidak sama, atur disabled menjadi true
        jenisMaintenanceSelect.disabled = true;
    } else {
        // Jika sama, hilangkan disabled
        jenisMaintenanceSelect.disabled = false;
    }
  }

 

document.getElementById('total_menit').addEventListener('input', function () {
  var totalMenitInput = this;

  // Periksa apakah inputan memiliki nilai
  if (totalMenitInput.value !== '') {
      // Batasi nilai maksimal menjadi 59
      var inputValue = parseInt(totalMenitInput.value, 10);
      if (inputValue > 59) {
          totalMenitInput.value = 59;
      }
  } else {
      // Set nilai menjadi 0 jika input kosong dan cursor tidak berada di dalam input
      totalMenitInput.value = 0;
  }
});

// Event listener untuk menangkap perubahan fokus (blur) pada input
document.getElementById('total_menit').addEventListener('blur', function () {
  var totalMenitInput = this;

  // Set nilai menjadi 0 jika input kosong saat cursor tidak berada di dalam input
  if (totalMenitInput.value === '') {
      totalMenitInput.value = 0;
  }
});

document.getElementById('overhaul_menit').addEventListener('input', function () {
  var overhaulMenitInput = this;

  // Periksa apakah inputan memiliki nilai
  if (overhaulMenitInput.value !== '') {
      // Batasi nilai maksimal menjadi 59
      var inputValue = parseInt(overhaulMenitInput.value, 10);
      if (inputValue > 59) {
          overhaulMenitInput.value = 59;
      }
  } else {
      // Set nilai menjadi 0 jika input kosong dan cursor tidak berada di dalam input
      overhaulMenitInput.value = 0;
  }
});

// Event listener untuk menangkap perubahan fokus (blur) pada input
document.getElementById('overhaul_menit').addEventListener('blur', function () {
  var overhaulMenitInput = this;

  // Set nilai menjadi 0 jika input kosong saat cursor tidak berada di dalam input
  if (overhaulMenitInput.value === '') {
      overhaulMenitInput.value = 0;
  }
});



