  <!-- Required datatable js -->
  <script src="<?= base_url('assets/'); ?>plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('assets/'); ?>plugins/datatables/dataTables.bootstrap4.min.js"></script>
  <!-- Responsive examples -->
  <script src="<?= base_url('assets/'); ?>plugins/datatables/dataTables.responsive.min.js"></script>
  <script src="<?= base_url('assets/'); ?>plugins/datatables/responsive.bootstrap4.min.js"></script>

  <!-- Sweet Alert Js  -->
  <script src="<?= base_url('assets/'); ?>plugins/sweet-alert/sweetalert2.all.min.js"></script>

  <!-- Select2 js -->
  <script src="<?= base_url('assets/'); ?>plugins/select2/js/select2.min.js" type="text/javascript"></script>

  <!-- fuse search js -->
  <script src="<?= base_url('assets/'); ?>plugins/fuse-js/fuse.js" type="text/javascript"></script>

  <!-- Modal-Effect -->
  <script src="<?= base_url('assets/'); ?>plugins/custombox/dist/custombox.min.js"></script>
  <script src="<?= base_url('assets/'); ?>plugins/custombox/dist/legacy.min.js"></script>


  <!-- script sendiri   // script Radio Fitur Simple dan Adnvace
  // init hide advance search -->
  <script>
    $(document).ready(function() {
      console.log(sessionStorage.getItem("no_order"));
      console.log("ready!");
      $.ajax({
        url: '<?= base_url("Manajemen_Penjualan/PenjualanBarang/clear_keranjang_belanja/"); ?>' + sessionStorage.getItem("no_order"),
      });
    });
    $('#cari_barang').hide();
    $('#simple').change(function() {
      $("#select_nama_barang").select2({
        ajax: {
          url: '<?= base_url("Manajemen_Penjualan/PenjualanBarang/get_data_barang_versi_select2"); ?>',
          type: "post",
          dataType: 'json',
          delay: 250,
          // data: function(params) {
          //   return {
          //     search_term: params.term
          //   };
          // },
          processResults: function(data) {
            var results = [];
            for (var i in data.data) {
              results.push({
                "id": data.data[i].kode_barang + ' -  ' + data.data[i].nama_barang + ' -  ' + data.data[i].satuan + ' -  ' + data.data[i].jumlah_persediaan,
                "text": data.data[i].kode_barang + ' -  ' + data.data[i].nama_barang
              });
            };
            return {
              results: results
            };
          },

          cache: true
        },
        placeholder: "Pencarian Barang, menggunakan Nama Barang atau Kode Barang .."
      }).show().on('select2:select', function(evt) {
        var data = $("#select_nama_barang option:selected").val();
        str = data.split("-");
        var kode_barang = str[0];
        var nama_barang = str[1];
        var satuan = str[2];
        var jumlah_persediaan = str[3];
        if (jumlah_persediaan == 0) {
          console.log(jumlah_persediaan);
          persediaan_habis(nama_barang, satuan, jumlah_persediaan);
        } else {
          quantityalert(kode_barang, satuan, jumlah_persediaan, jumlah_keranjang);
        }
      });
      $('#cari_barang').hide();
      $("#result_page").empty();
      display_none = '<div class="col-12 text-center"><p>Cari Data Barang di Kolom Pencarian</p></div>';
      $("#result_page").append(display_none);
    });
    $('#advance').change(function() {
      $("#select_nama_barang").select2('destroy').hide();
      $('#select_nama_barang').val(null).trigger('change');
      $('#cari_barang').show();
    });

    // script formatRupiah
    function formatRupiah(angka, prefix) {
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }


    function terbilang(angka) {
      var bilangan = angka;
      var kalimat = "";
      var angka = new Array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
      var kata = new Array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan');
      var tingkat = new Array('', 'Ribu', 'Juta', 'Milyar', 'Triliun');
      var panjang_bilangan = bilangan.length;

      /* pengujian panjang bilangan */
      if (panjang_bilangan > 15) {
        kalimat = "Diluar Batas";
      } else {
        /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
        for (i = 1; i <= panjang_bilangan; i++) {
          angka[i] = bilangan.substr(-(i), 1);
        }

        var i = 1;
        var j = 0;

        /* mulai proses iterasi terhadap array angka */
        while (i <= panjang_bilangan) {
          subkalimat = "";
          kata1 = "";
          kata2 = "";
          kata3 = "";

          /* untuk Ratusan */
          if (angka[i + 2] != "0") {
            if (angka[i + 2] == "1") {
              kata1 = "Seratus";
            } else {
              kata1 = kata[angka[i + 2]] + " Ratus";
            }
          }

          /* untuk Puluhan atau Belasan */
          if (angka[i + 1] != "0") {
            if (angka[i + 1] == "1") {
              if (angka[i] == "0") {
                kata2 = "Sepuluh";
              } else if (angka[i] == "1") {
                kata2 = "Sebelas";
              } else {
                kata2 = kata[angka[i]] + " Belas";
              }
            } else {
              kata2 = kata[angka[i + 1]] + " Puluh";
            }
          }

          /* untuk Satuan */
          if (angka[i] != "0") {
            if (angka[i + 1] != "1") {
              kata3 = kata[angka[i]];
            }
          }

          /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
          if ((angka[i] != "0") || (angka[i + 1] != "0") || (angka[i + 2] != "0")) {
            subkalimat = kata1 + " " + kata2 + " " + kata3 + " " + tingkat[j] + " ";
          }

          /* gabungkan variabe sub kalimat (untuk Satu blok 3 angka) ke variabel kalimat */
          kalimat = subkalimat + kalimat;
          i = i + 3;
          j = j + 1;
        }

        /* mengganti Satu Ribu jadi Seribu jika diperlukan */
        if ((angka[5] == "0") && (angka[6] == "0")) {
          kalimat = kalimat.replace("Satu Ribu", "Seribu");
        }
      }
      return kalimat + " Rupiah";
    }

    function quantityalert(kode_barang, satuan, sisa_persediaan, jumlah_keranjang) {
      console.log(sisa_persediaan)
      const {
        value: jumlah
      } = Swal.fire({
        title: 'Berapa ' + satuan + ' ?',
        input: 'text',
        html: 'Sisa persediaan sebanyak <b>' + sisa_persediaan + ' ' + satuan + '</b>',
        showCancelButton: true,
        inputValidator: (value) => {
          if (!value) {
            return 'Jumlah pembelian harus di isi!'
          } else {
            if (isNaN(value)) {
              return 'Hanya Input Angka!!'
            } else {
              value = parseInt(value);
              sisa_persediaan = parseInt(sisa_persediaan);
              console.log(value >= sisa_persediaan);
              if (value <= sisa_persediaan) {
                push_keranjang_belanja(value, kode_barang);
                push_persediaan_temporary_tambah(value, kode_barang);
                set_data_session_no_order_sebelumnya($('#no_order').text());
                $('#select_nama_barang').val(null).trigger('change');
                $('#cari_barang').val('');
                $("#result_page").empty();
                display_none = '<div class="col-12 text-center"><p>Cari Data Barang di Kolom Pencarian</p></div>';
                $("#result_page").append(display_none);
              } else {
                return 'Sisa barang tidak cukup dengan jumlah pembelian!!'
              }
            }
          }
        }
      });

    }
  </script>


  <!-- fetch data ke id pelanggan, jika pake fitur cari -->
  <script>
    function batal_pelanggan() {
      console.log('asdasd');
      $('#id_pelanggan').attr('disabled', false).val('');
      $('#nama_pelanggan').attr('disabled', false).val('');
      $('#alamat').attr('disabled', false).val('');
      $('#nomor_telepon').attr('disabled', false).val('');
      $('#div_cari-button').empty();
      $('#id_pelanggan_help').text('Kosong kan jika tidak ada ID Pelanggan');
      display = '<button id="cari-button" name="cari-button" onClick="cari_pelanggan();" class="btn btn-dark waves-effect waves-light" type="button"><i class="fa fa-search"></i></button>'
      $('#div_cari-button').append(display);
    };

    function tutup_tombol_cari() {
      $('#id_pelanggan').attr('disabled', true);
      $('#nama_pelanggan').attr('disabled', true);
      $('#alamat').attr('disabled', true);
      $('#nomor_telepon').attr('disabled', true);
      $('#div_cari-button').empty();
      $('#id_pelanggan_help').text('');
      display = '<button id="cari-edit" onClick="batal_pelanggan();" name="cari-edit" class="btn btn-success waves-effect waves-light" type="button"><i class="fa  fa-edit "></i></button>'
      $('#div_cari-button').append(display);
    }

    function cari_pelanggan() {
      var id_pelanggan = $('#id_pelanggan');
      var nama_pelanggan = $('#nama_pelanggan');
      var alamat = $('#alamat');
      var nomor_telepon = $('#nomor_telepon');
      if (id_pelanggan.val() !== "") {
        $.ajax({
          url: '<?= base_url("Manajemen_Penjualan/PenjualanBarang/get_data_pelanggan/"); ?>' + id_pelanggan.val(),
          type: "POST",
          dataType: "JSON",
          async: false,
          success: function(data) {
            if (data !== null) {
              nama_pelanggan.val(data.nama_pelanggan);
              alamat.val(data.alamat);
              nomor_telepon.val(data.nomor_telepon);
              tutup_tombol_cari();
            } else {
              alert_data_pelanggan("tidak_ada");
              nama_pelanggan.val(null);
              alamat.val(null);
              nomor_telepon.val(null);
            }
          }
        });
      } else {
        $('#pelanggan_modal').modal('show');
        // alert_data_pelanggan("kosong");
      }

    };

    function alert_data_pelanggan(status) {
      switch (status) {
        case "kosong":
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'ID Pelanggan kosong!!',
            // footer: '<a href>Kenapa Bisa begini?</a>'
          });
          break;
        case "tidak_ada":
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'ID Pelanggan Tidak ditemukan!!',
            // footer: '<a href>Kenapa Bisa begini?</a>'
          });
      }
    }
  </script>

  <!-- Script Pencarian Barang Fitur Gambar -->

  <script>
    var input_search = $('#cari_barang');
    input_search.on('keyup', function() {
      search(input_search.val());
    })

    function search(kata_kunci) {
      if (kata_kunci !== "") {
        $.ajax({
          url: '<?= base_url("Manajemen_Penjualan/PenjualanBarang/get_data_barang/"); ?>' + kata_kunci,
          type: "POST",
          dataType: "JSON",
          async: false,
          success: function(data) {
            if (data.jumlah_data > 0) {
              $("#result_page").empty();
              for (var i in data.data) {
                console.log(data.data[i]);
                var display2 = '<div id="result"  class="col-md-6 col-lg-3"><div class="card gal-detail thumb"><a type="button" id="wawa" onclick="choose_barang(\'' + data.data[i].tipe_barang + '\',\'' + data.data[i].kode_barang + '\',\'' + data.data[i].nama_barang + '\',\'' + data.data[i].nama_satuan + '\',\'' + data.data[i].jumlah_persediaan + '\',\'' + data.data[i].jumlah_keranjang + '\',\'' + data.data[i].status_jual + '\')" ><img class="img-thumbnail img-responsive" alt="profile-image" src="<?= base_url('assets/images/barang/'); ?>' + data.data[i].gambar + '" alt="Tidak ada Gambar"><h5 >' + data.data[i].nama_barang + '</h4><p class="card-text">' + data.data[i].keterangan + '</p></a></div></div>';
                // var display = '<div id="result" class="col-md-6 col-lg-3"><div class="card"><a id="wawa" onclick="choose_barang(\'' + data.data[i].kode_barang + '\',\'' + data.data[i].nama_barang + '\',\'' + data.data[i].satuan + '\',\'' + data.data[i].jumlah_persediaan + '\',\'' + data.data[i].jumlah_keranjang + '\')"><img class="card-img-top img-fluid" src="<?= base_url('assets/images/barang/'); ?>' + data.data[i].gambar + '" alt="Tidak ada Gambar"><div class="card-body"><h4 class="card-title">' + data.data[i].nama_barang + '</h4></div><div class="card-body"><p class="card-text">' + data.data[i].keterangan + '</p></div></div></a></div>'
                $('#result_page').append(display2).fadeIn('slow');
              }

            } else {
              $("#result_page").empty();
              display_none = '<div class="col-12 text-center"><p>Data Barang ' + kata_kunci + ' tidak ditemukan </p></div>';
              $("#result_page").append(display_none);
            }
          }
        });
      } else {
        $("#result_page").empty();
        display_none = '<div class="col-12 text-center"><p>Cari Data Barang di Kolom Pencarian</p></div>';
        $("#result_page").append(display_none);
      }
    }

    // "choose_barang(\'' + data.data[i].kode_barang + '\',\'' + data.data[i].nama_barang + '\',\'' + data.data[i].satuan + '\',\'' + data.data[i].jumlah_persediaan + '\',\'' + data.data[i].jumlah_keranjang + '\')"


    function choose_barang(tipe_barang, kode_barang, nama_barang, nama_satuan, jumlah_persediaan, jumlah_keranjang, status_jual) {
      console.log(tipe_barang);
      console.log(status_jual);
      if (status_jual == 0) {
        status_jual_alert(nama_barang, status_jual);
      } else {
        if (tipe_barang == 3) {
          quantityalert(kode_barang, "", 9999);
        } else {
          if (jumlah_persediaan == 0) {
            persediaan_habis(nama_barang, nama_satuan, jumlah_persediaan);
          } else {
            quantityalert(kode_barang, nama_satuan, jumlah_persediaan, jumlah_keranjang);
          }

        }

      }

    }
    // script Input Jumlah Pembelian
  </script>

  <!-- Script Pencarian Barang Fitur Select2 -->
  <script>
    $(document).ready(function() {
      $('#select_nama_barang').select2({
        ajax: {
          url: '<?= base_url("Manajemen_Penjualan/PenjualanBarang/get_data_barang_versi_select2"); ?>',
          type: "post",
          dataType: 'json',
          delay: 250,
          // data: function(params) {
          //   return {
          //     search_term: params.term
          //   };
          // },
          processResults: function(data) {
            var results = [];
            for (var i in data.data) {
              results.push({
                "id": data.data[i].kode_barang + ' -  ' + data.data[i].nama_barang + ' -  ' + data.data[i].satuan + ' -  ' + data.data[i].jumlah_persediaan + ' -  ' + data.data[i].jumlah_keranjang,
                "text": data.data[i].kode_barang + ' -  ' + data.data[i].nama_barang
              });
            };
            return {
              results: results
            };
          },
        },
        placeholder: "Pencarian Barang, menggunakan Nama Barang atau Kode Barang .."
      }).on('select2:select', function(evt) {
        var data = $("#select_nama_barang option:selected").val();
        str = data.split("-");
        var kode_barang = str[0];
        var nama_barang = str[1];
        var satuan = str[2];
        var jumlah_persediaan = str[3];
        var jumlah_keranjang = str[4];
        if (jumlah_persediaan == 0) {
          persediaan_habis(nama_barang, satuan, jumlah_persediaan);
        } else {
          quantityalert(kode_barang, satuan, jumlah_persediaan, jumlah_keranjang);
        }

      });
    });
  </script>

  <!-- input ke keranjang belanjaan -->

  <script>
    function push_keranjang_belanja(jumlah, kode_barang) {
      var id_pelanggan = $('#id_pelanggan').val();
      var no_order = $('#no_order').text();
      
      $('#simpan_checkout').attr('disabled',false);
      $.ajax({
        url: "<?= Base_url('Manajemen_Penjualan/PenjualanBarang/push_data_barang'); ?>",
        type: "post",
        data: {
          no_order: no_order,
          id_pelanggan: id_pelanggan,
          jumlah_pembelian: jumlah,
          kode_barang: kode_barang
        },
        cache: false,
        async: false,
        async: false,
        success: function(data) {
          $('#datatable-keranjang-penjualan').DataTable().ajax.reload();
          total_harga_keranjang();
        }
      })
    }

    function set_data_session_no_order_sebelumnya(no_order) {
      sessionStorage.setItem("no_order", no_order);
      console.log(sessionStorage.getItem("no_order"));
    }

    function push_persediaan_temporary_tambah(jumlah_pembelian, kode_barang) {
      $.ajax({
        url: "<?= Base_url('Manajemen_Penjualan/PenjualanBarang/persediaan_temp_tambah/'); ?>",
        type: "post",
        data: {
          kode_barang: kode_barang,
          jumlah_pembelian: jumlah_pembelian,
        },
        cache: false,
        async: false,
        success: function(data) {}
      })
    }

    function push_persediaan_temporary_batal(id) {
      $.ajax({
        url: "<?= Base_url('Manajemen_Penjualan/PenjualanBarang/persediaan_temp_batal/'); ?>",
        type: "post",
        data: {
          id: id,
        },
        cache: false,
        async: false,
        success: function(data) {}
      })
    }

    function total_harga_keranjang() {
      $.ajax({
        url: "<?= base_url("Manajemen_Penjualan/PenjualanBarang/get_sum_keranjang/"); ?>" + $('#no_order').text(),
        type: "post",
        dataType: "JSON",
        async: false,
        success: function(data) {
          if (data.harga_total == null) {
            total = 0;
            $('#terbilang_keranjang').text('Nol Rupiah');
          } else {
            total = formatRupiah(data.harga_total, 'Rp.');
            $('#terbilang_keranjang').text(terbilang(data.harga_total));
          }
          $('#total_keranjang').text(total);

        }
      })
    }
  </script>

  <!-- Update Data Table Keranjang -->
  <script>
    $(document).ready(function() {

      $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
        return {
          "iStart": oSettings._iDisplayStart,
          "iEnd": oSettings.fnDisplayEnd(),
          "iLength": oSettings._iDisplayLength,
          "iTotal": oSettings.fnRecordsTotal(),
          "iFilteredTotal": oSettings.fnRecordsDisplay(),
          "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
          "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
        };
      };

      //Init Datatabel Master Stock Persediaan
      var table = $('#datatable-keranjang-penjualan').DataTable({
        "oLanguage": {
          sProcessing: "Sabar yah...",
          sZeroRecords: "Tidak ada Data..."
        },
        "searching": false,
        "processing": true,
        "ordering": false,
        "serverSide": true,
        "lengthChange": false,
        "paging": false,
        "ajax": {
          "url": '<?= base_url("Manajemen_Penjualan/PenjualanBarang/get_data_keranjang/"); ?>' + $('#no_order').text(),
          "type": "POST",
        },
        "columnDefs": [{
            title: "No",
            data: "kode_barang",
            targets: 0,
            render: function(data, type, full, meta) {
              return data;
            }
          },
          {
            title: "Nama Barang",
            data: "nama_barang",
            targets: 1,
            render: function(data, type, full, meta) {
              return data;
            }
          },
          {
            title: "Harga Satuan",
            data: "harga_satuan",
            targets: 2,
            render: function(data, type, full, meta) {
              var display = formatRupiah(data, 'Rp.');
              return display;
            }
          },
          {
            title: "Jumlah",
            data: "jumlah_pembelian",
            targets: 3,
            render: function(data, type, full, meta) {
              var display = formatSatuan(data);
              return display;
            }
          },
          {
            title: "Total",
            data: "harga_total",
            targets: 4,
            render: function(data, type, full, meta) {
              var display = formatRupiah(data, 'Rp.');
              return display;
            }
          },
          {
            title: "Action",
            data: "id",
            targets: 5,
            render: function(data, type, full, meta) {
              var display = '<a type="button" onClick="warning_delete(\'' + data + '\')" data-button="' + data + '" class="btn btn-icon waves-effect waves-light btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Click untuk melakukan Hapus Data"><i class="fa fa-trash"></i> </a>';
              return display;
            }
          }
        ],
        "rowCallback": function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html(index);
        }
      });


      function formatSatuan(angka) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
          split = number_string.split(','),
          sisa = split[0].length % 3,
          rupiah = split[0].substr(0, sisa),
          ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
      }

    })
  </script>
  <!-- fungsi alert persediaan abis dan hapus data di keranjang -->

  <script>
    function persediaan_habis(nama_barang, satuan, jumlah_persediaan) {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Persediaan! ' + nama_barang + ' Habis!',
      });
      $('#select_nama_barang').val(null).trigger('change');
    }

    function status_jual_alert(nama_barang, status_jual) {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Status Barang ' + nama_barang + ' Tidak Dijual!',
      });
      $('#select_nama_barang').val(null).trigger('change');
    }

    function warning_delete(id) {
      swal.fire({
        title: 'Apa anda yakin akan hapus data ini dari Keranjang Belanja?',
        text: "Data akan di hapus dari Keranjang Belanja..",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          swal.fire(
            'Deleted!',
            'Data telah dihapus!',
            'success'
          )
          push_persediaan_temporary_batal(id);
          deleteData_keranjang(id);
          total_harga_keranjang();
          p
        }
      });
    }

    function deleteData_keranjang(id) {
      $.ajax({
        url: "<?= base_url('Manajemen_Penjualan/PenjualanBarang/delete_data_keranjang/'); ?>" + id,
        async: false,
        success: function(data) {
          $('#datatable-keranjang-penjualan').DataTable().ajax.reload();
          total_harga_keranjang();
        }
      });
    }
  </script>

  <!-- Fungsi Checkout -->

  <script>
    $('#checkout').on('click', function() {
      var data_label_chekcout = $('#data_label_chekcout');
      var nama_pelanggan = $('#nama_pelanggan');
      var total_checkout = $('#total_checkout');
      var total_checkout_terbilang = $('#total_checkout_terbilang');
      var checkout_grand_total = $('#checkout_grand_total');
      var checkout_grand_total_terbilang = $('#checkout_grand_total_terbilang');
      var chekcout_discount = $('#chekcout_discount');
      if (nama_pelanggan.val() !== "") {
        if ($('#total_keranjang').text() !== "Rp. 0") {
          data_label_chekcout.text('Checkout Nomor Order : ' + $('#no_order').text())
          // untuk grand total
          var total = $('#total_keranjang').text().replace('Rp.', '');
          total = total.split(".").join("");
          total = total.split("-").join("");
          var diskon = chekcout_discount.text().replace('Rp.', '');
          diskon = diskon.split(".").join("");
          diskon = diskon.split("-").join("");
          grand_total = parseInt(total) - parseInt(diskon);
          total_checkout.text($('#total_keranjang').text() + ",-");
          total_checkout_terbilang.text("( " + $('#terbilang_keranjang').text() + " )");
          checkout_grand_total.text(formatRupiah(grand_total.toString(), 'Rp.'));
          checkout_grand_total_terbilang.text(terbilang(grand_total.toString()));
          $('#checkout_modal').modal('show');
        } else {
          warning_keranjang_kosong();
        }
      } else {
        warning_pelanggan_kosong();
      }

    });

    function warning_pelanggan_kosong() {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Data Pelanggan Masih Kosong!',
        // footer: '<a href>Why do I have this issue?</a>'
      })
    }

    function warning_keranjang_kosong() {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Keranjang Belanjaan Masih Kosong!',
        // footer: '<a href>Why do I have this issue?</a>'
      })
    }
  </script>

  <!-- script simpan dan bayar chekcout -->

  <script>
    $('#simpan_checkout').on('click', function() {
      console.log('sss');
      var no_order = $('#no_order').text();
      simpan_order(no_order);
      $('#checkout_modal').modal('hide');
    });

    function simpan_order(no_order) {
      $.ajax({
        url: "<?= Base_url('Manajemen_Penjualan/PenjualanBarang/simpan_order/'); ?>",
        type: "post",
        data: {
          no_order: no_order,
          id_pelanggan: '0',
          status: 0,
        },
        cache: false,
        async: false,
        success: function(data) {
          alert('suksess');
        }
      })
    }
  </script>