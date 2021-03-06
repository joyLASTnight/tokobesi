<script src="<?= base_url('assets/'); ?>plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>
<!-- Validation js (Parsleyjs) -->
<script type="text/javascript" src="<?= base_url('assets/'); ?>plugins/parsleyjs/dist/parsley.min.js"></script>

<script src="<?= base_url('assets/'); ?>plugins/jquery-mask/jquery.mask.min.js"></script>

<!-- Required datatable js -->
<script src="<?= base_url('assets/'); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables/dataTables.bootstrap4.min.js"></script>

<!-- DatePicker Js -->
<script src="<?= base_url('assets/'); ?>plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- file uploads js -->
<script src="<?= base_url('assets/'); ?>plugins/fileuploads/js/dropify.min.js"></script>

<!-- Chart JS -->
<script src="<?= base_url('assets/'); ?>plugins/chartjs/chart.bundle.min.js"></script>

<!-- Sweet Alert Js  -->
<script src="<?= base_url('assets/'); ?>plugins/sweet-alert/sweetalert2.all.min.js"></script>

<!-- Select2 js -->
<script src="<?= base_url('assets/'); ?>plugins/select2/js/select2.min.js" type="text/javascript"></script>



<!-- script Uploader -->
<script type="text/javascript">
    $('#gambar').dropify({
        messages: {
            'default': 'Drag dan drop Gambar Barang disini',
            'replace': 'Drag dan drop gambar untuk mengganti',
            'remove': 'Hapus',
            'error': 'Ooops, terjadi sesuatu, silahkan coba lagi.'
        },
        tpl: {
            clearButton: '<button type="button" class="dropify-clear">{{ remove }}</button>',
        },
        error: {
            'fileSize': 'File terlalu besar (3 Mb max).',
            'imageFormat': 'Format Gambar tidak Support, hanya ({{ value }} saja).'
        }
    });
    $('#edit_gambar').dropify({
        messages: {
            'default': 'Drag dan drop Gambar Barang disini',
            'replace': 'Drag dan drop gambar untuk mengganti',
            'remove': 'Hapus',
            'error': 'Ooops, terjadi sesuatu, silahkan coba lagi.'
        },
        tpl: {
            clearButton: '<button type="button" class="dropify-clear">{{ remove }}</button>',
        },
        error: {
            'fileSize': 'File terlalu besar (3 Mb max).',
            'imageFormat': 'Format Gambar tidak Support, hanya ({{ value }} saja).'
        },
    });
</script>
<!-- script validasi -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#submitForm').parsley();
        $('.select2').select2({
            minimumResultsForSearch: -1
        });

        $('#edit_satuan').select2().on('select2:select', function() {
            var data = $("#edit_satuan option:selected").text()
            $('#edit_satuan_minimum').val(data);
        })

        var edit_persediaan_minimum_input = document.getElementById('edit_persediaan_minimum');
        edit_persediaan_minimum_input.addEventListener('keyup', function(e) {
            var data = $('#edit_persediaan_minimum').val();
            edit_persediaan_minimum_input.value = this.value.replace(/[^,\d]/g, '').toString();
        });
    });
</script>

<!-- Script Nominal Harga Formater -->
<script type="text/javascript">
    var edit_harga_satuan = document.getElementById('edit_harga_satuan_dummy');
    edit_harga_satuan.addEventListener('keyup', function(e) {
        var data = $('#edit_harga_satuan_dummy').val();
        edit_harga_satuan.value = formatRupiah(this.value, 'Rp. ');
        $('#edit_harga_satuan').val(normalrupiah(data));
    });

    var edit_harga_kedua = document.getElementById('edit_harga_kedua_dummy');
    edit_harga_kedua.addEventListener('keyup', function(e) {
        var data = $('#edit_harga_kedua_dummy').val();
        edit_harga_kedua.value = formatRupiah(this.value, 'Rp. ');
        $('#edit_harga_kedua').val(normalrupiah(data));
    });

    var edit_harga_ketiga = document.getElementById('edit_harga_ketiga_dummy');
    edit_harga_ketiga.addEventListener('keyup', function(e) {
        var data = $('#edit_harga_ketiga_dummy').val();
        edit_harga_ketiga.value = formatRupiah(this.value, 'Rp. ');
        $('#edit_harga_ketiga').val(normalrupiah(data));
    });

    var harga_pokok = document.getElementById('edit_harga_pokok_dummy');
    harga_pokok.addEventListener('keyup', function(e) {
        var data = $('#edit_harga_pokok_dummy').val();
        harga_pokok.value = formatRupiah(this.value, 'Rp. ');
        $('#edit_harga_pokok').val(normalrupiah(data));
    });

    var komisi_sales = document.getElementById('edit_komisi_sales_dummy');
    komisi_sales.addEventListener('keyup', function(e) {
        var data = $('#edit_komisi_sales_dummy').val();
        komisi_sales.value = formatRupiah(this.value, 'Rp. ');
        $('#edit_komisi_sales').val(normalrupiah(data));
    });

    /* Fungsi formatRupiah */
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

    function normalrupiah(angka) {

        var tanparp = angka.replace("Rp", "");
        var tanpatitik = tanparp.split(".").join("");
        return tanpatitik;
    }
</script>

<!-- Script Auto Generate Kode Barang -->

<script>
    var nama_barang = $('#nama_barang');
    var kode_barang = $('#kode_barang');
    nama_barang.on("keyup", function() {
        string_awalan = nama_barang.val();
        string_awalan = string_awalan.substr(0, 1);
        string_awalan = string_awalan.toUpperCase();
        var tambahan = cekData(string_awalan);
        var res = string_awalan.concat(tambahan);
        kode_barang.val(res);
    });

    function cekData(string) {

        // tambah lagi if untuk string dibawah 1

        $.ajax({
            url: '<?= base_url("manajemen_barang/masterbarang/cekData/"); ?>' + string,
            success: function(result) {
                data = result;
            }
        });
        return data;
    }
</script>

<!-- script close modal reset data -->

<script>
    $(document).ready(function() {
        $('#edit_gambar_modal').on('hidden.bs.modal', function(e) {
            $(this)
                .find("input,textarea,select")
                .val('')
                .end()
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();
            $('.dropify-clear').click();
        });
    });
</script>


<!-- Script Edit Modal -->
<script type="text/javascript">
    function show_edit_modal(kode_barang) {
        fetchdata(kode_barang);
    }

    function fetchdata(kode_barang) {
        var edit_data_label = $('#edit_data_label');
        var edit_kode_barang = $('#edit_kode_barang');
        var edit_nama_barang = $('#edit_nama_barang');
        var edit_harga_satuan_dummy = $('#edit_harga_satuan_dummy');
        var edit_harga_satuan = $('#edit_harga_satuan');
        var edit_satuan = $('#edit_satuan');
        var edit_tanggal_input = $('#edit_tanggal_input');
        var edit_image = $('#edit_gambar_dropfy');
        //var edit_image = $('#edit_image');

        $.ajax({
            url: '<?= base_url("manajemen_barang/masterbarang/view_edit_data/"); ?>' + kode_barang,
            type: "POST",
            dataType: "JSON",
            async: false,
            success: function(data) {
                rupiah = formatRupiah(data.harga_satuan, 'Rp.');
                edit_data_label.text("Edit Data Barang Kode :" + data.kode_barang);
                edit_kode_barang.val(data.kode_barang);
                edit_nama_barang.val(data.nama_barang);
                edit_harga_satuan_dummy.val(rupiah);
                edit_harga_satuan.val(data.harga_satuan);
                edit_satuan.val(data.satuan);
                edit_tanggal_input.text(data.tanggal_input);
                edit_image.attr('data-default-file', "<?= base_url('assets/images/barang/'); ?>" + data.gambar);
                //edit_image.attr('src',"<?= base_url('assets/images/barang/'); ?>" + data.gambar);
                $('#edit_Modal').modal('show');
            }
        });
    }

    // Edit Harga Satuan

    var edit_rupiah = document.getElementById('edit_harga_satuan_dummy');
    edit_rupiah.addEventListener('keyup', function(e) {
        var data = $('#edit_harga_satuan_dummy').val();
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        edit_rupiah.value = formatRupiah(this.value, 'Rp. ');
        $('#edit_harga_satuan').val(normalrupiah(data));
    });

    // submit edit data
    $(document).ready(function() {
        function warning_edit_umum(kode_barang) {
            swal.fire({
                title: 'Apa anda yakin akan mengubah data ini?',
                text: "Semua Data Barang dengan kode " + kode_barang + " juga akan terubah",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                confirmButtonText: 'Ya, Ubah ini!'
            }).then((result) => {
                if (result.value) {
                    $('#edit_button_umum_div').attr("hidden", true);
                    $('#edit_trigger_umum').attr("hidden", false);
                    edit_Data_Umum(kode_barang);
                    setData(kode_barang);
                    set_readonly('umum', true);
                    swal.fire(
                        'Edited!!!',
                        'Data Umum ' + kode_barang + ' telah diubah!',
                        'success'
                    );
                }
            });
        }

        function edit_Data_Umum(kode_barang) {
            var data = new FormData(document.getElementById("form_umum"));
            $.ajax({
                url: "<?= Base_url('manajemen_barang/masterbarang/edit_data_umum/'); ?>" + kode_barang,
                type: "post",
                data: data,
                async: false,
                processData: false,
                contentType: false,
                success: function(data) {

                }
            });
        }
        $('#form_umum').submit(function(e) {
            var kode_barang = $('#hide_kode_barang').text();
            e.preventDefault();
            warning_edit_umum(kode_barang);
        });

        function warning_edit_harga(kode_barang) {
            swal.fire({
                title: 'Apa anda yakin akan mengubah data ini?',
                text: "Semua Data Barang dengan kode " + kode_barang + " juga akan terubah",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                confirmButtonText: 'Ya, Ubah ini!'
            }).then((result) => {
                if (result.value) {
                    $('#edit_button_harga_div').attr("hidden", true);
                    $('#edit_trigger_harga').attr("hidden", false);
                    edit_Data_Harga(kode_barang);
                    setData(kode_barang);
                    set_readonly('harga', true);
                    swal.fire(
                        'Edited!!!',
                        'Data Harga ' + kode_barang + ' telah diubah!',
                        'success'
                    );
                }
            });
        }

        function edit_Data_Harga(kode_barang) {
            var data = new FormData(document.getElementById("form_harga"));
            $.ajax({
                url: "<?= Base_url('manajemen_barang/masterbarang/edit_data_harga/'); ?>" + kode_barang,
                type: "post",
                data: data,
                async: false,
                processData: false,
                contentType: false,
                success: function(data) {

                }
            })

        }
        $('#form_harga').submit(function(e) {
            var kode_barang = $('#hide_kode_barang').text();
            e.preventDefault();
            warning_edit_harga(kode_barang);
        });

        function warning_edit_komisi(kode_barang) {
            swal.fire({
                title: 'Apa anda yakin akan mengubah data ini?',
                text: "Semua Data Barang dengan kode " + kode_barang + " juga akan terubah",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                confirmButtonText: 'Ya, Ubah ini!'
            }).then((result) => {
                if (result.value) {
                    $('#edit_button_komisi_div').attr("hidden", true);
                    $('#edit_trigger_komisi').attr("hidden", false);
                    edit_data_komisi(kode_barang);
                    setData(kode_barang);
                    set_readonly('komisi', true);
                    swal.fire(
                        'Edited!!!',
                        'Data Komisi ' + kode_barang + ' telah diubah!',
                        'success'
                    );
                }
            });
        }

        function edit_data_komisi(kode_barang) {
            var data = new FormData(document.getElementById("form_komisi"));
            $.ajax({
                url: "<?= Base_url('manajemen_barang/masterbarang/edit_data_komisi/'); ?>" + kode_barang,
                type: "post",
                data: data,
                async: false,
                processData: false,
                contentType: false,
                success: function(data) {

                }
            })

        }
        $('#form_komisi').submit(function(e) {
            var kode_barang = $('#hide_kode_barang').text();
            e.preventDefault();
            warning_edit_komisi(kode_barang);
        });

        function warning_edit_lainnya(kode_barang) {
            swal.fire({
                title: 'Apa anda yakin akan mengubah data ini?',
                text: "Semua Data Barang dengan kode " + kode_barang + " juga akan terubah",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                confirmButtonText: 'Ya, Ubah ini!'
            }).then((result) => {
                if (result.value) {
                    $('#edit_button_lainnya_div').attr("hidden", true);
                    $('#edit_trigger_lainnya').attr("hidden", false);
                    edit_data_lainnya(kode_barang);
                    setData(kode_barang);
                    set_readonly('lainnya', true);
                    swal.fire(
                        'Edited!!!',
                        'Data Lainnya ' + kode_barang + ' telah diubah!',
                        'success'
                    );
                }
            });
        }

        function edit_data_lainnya(kode_barang) {
            var data = new FormData(document.getElementById("form_lainnya"));
            $.ajax({
                url: "<?= Base_url('manajemen_barang/masterbarang/edit_data_lainnya/'); ?>" + kode_barang,
                type: "post",
                data: data,
                async: false,
                processData: false,
                contentType: false,
                success: function(data) {

                }
            })

        }
        $('#form_lainnya').submit(function(e) {
            var kode_barang = $('#hide_kode_barang').text();
            e.preventDefault();
            warning_edit_lainnya(kode_barang);
        });

    });
</script>

<!-- Tampilkan Modal Edit Gambar -->

<script>
    $(document).ready(function() {
        $('#edit_gambar_button').on('click', function() {
            $('#edit_gambar_modal').modal('show');
        });

        // Upload Gambar
        $('#edit_gambar_form').submit(function(e) {
            e.preventDefault();
            var kode_barang = $('#hide_kode_barang').text();
            var data = new FormData(document.getElementById("edit_gambar_form"));
            data.append('kode_barang', kode_barang);
            $.ajax({
                url: '<?= base_url("manajemen_barang/masterbarang/SetGambarBaru/"); ?>' + kode_barang,
                type: "post",
                data: data,
                async: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#edit_gambar_modal').modal('hide');
                    setGambarBaru(kode_barang);
                }
            })
        });

        function setGambarBaru(kode_barang) {
            $.ajax({
                url: '<?= base_url("manajemen_barang/masterbarang/GetGambarBaru/"); ?>' + kode_barang,
                type: "POST",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    var drEvent = $('#edit_gambar').dropify();
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    $('#gambar_barang').fadeOut(2000, function() {
                        // $('#gambar_barang').remove();
                        // display = '<img id="gambar_barang" src="<?= base_url('assets/images/barang/'); ?>' + data.gambar + '" class="img-thumbnail" alt="profile-image">';
                        $('#gambar_barang').attr('src', "<?= base_url('assets/images/barang/'); ?>" + data.gambar)
                        // $('#div_gambar').append(display)
                        $('#gambar_barang').fadeIn(2000);
                    });
                    Swal.fire(
                        'Sukses!',
                        'Data Supplier telah berhasil di tambahkan.',
                        'success'
                    );
                }
            });

        }
    });
</script>


<!-- Trigger Edit Button -->

<script>
    $(document).ready(function() {
        // trigger button umum di click
        var edit_button_umum = $('#edit_trigger_umum');
        var edit_button_umum_div = $('#edit_button_umum_div');
        var edit_batal_umum = $('#edit_batal_umum');
        var edit_button_harga = $('#edit_trigger_harga');
        var edit_button_harga_div = $('#edit_button_harga_div');
        var edit_batal_harga = $('#edit_batal_harga');
        var edit_button_komisi = $('#edit_trigger_komisi');
        var edit_button_komisi_div = $('#edit_button_komisi_div');
        var edit_batal_komisi = $('#edit_batal_komisi');
        var edit_button_lainnya = $('#edit_trigger_lainnya');
        var edit_button_lainnya_div = $('#edit_button_lainnya_div');
        var edit_batal_lainnya = $('#edit_batal_lainnya');

        // UMUM - CLICK EDIT
        edit_button_umum.on('click', function() {
            edit_button_umum_div.attr("hidden", false);
            edit_button_umum.attr("hidden", true);
            set_readonly('umum', false);
        });
        // UMUM - CLICK BATAL
        edit_batal_umum.on('click', function() {
            edit_button_umum_div.attr("hidden", true);
            edit_button_umum.attr("hidden", false);
            set_readonly('umum', true);
            setData($('#hide_kode_barang').text());
        });

        // HARGA - CLICK EDIT
        edit_button_harga.on('click', function() {
            edit_button_harga_div.attr("hidden", false);
            edit_button_harga.attr("hidden", true);
            set_readonly('harga', false);
        });
        // HARGA - CLICK BATAL
        edit_batal_harga.on('click', function() {
            edit_button_harga_div.attr("hidden", true);
            edit_button_harga.attr("hidden", false);
            set_readonly('harga', true);
            setData($('#hide_kode_barang').text());
        });

        // KOMISI - CLICK EDIT
        edit_button_komisi.on('click', function() {
            edit_button_komisi_div.attr("hidden", false);
            edit_button_komisi.attr("hidden", true);
            set_readonly('komisi', false);
        });
        // KOMISI - CLICK BATAL
        edit_batal_komisi.on('click', function() {
            edit_button_komisi_div.attr("hidden", true);
            edit_button_komisi.attr("hidden", false);
            set_readonly('komisi', true);
            setData($('#hide_kode_barang').text());
        });

        // LAINNYA - CLICK EDIT
        edit_button_lainnya.on('click', function() {
            edit_button_lainnya_div.attr("hidden", false);
            edit_button_lainnya.attr("hidden", true);
            set_readonly('lainnya', false);
        });
        // LAINNYA - CLICK BATAL
        edit_batal_lainnya.on('click', function() {
            edit_button_lainnya_div.attr("hidden", true);
            edit_button_lainnya.attr("hidden", false);
            set_readonly('lainnya', true);
            setData($('#hide_kode_barang').text());
        });
        // Fungsi Set Kolom Jadi Not Readonly
    });

    function set_readonly(div, bol) {
        if (div == "umum") {
            if (bol == false) {
                $('#edit_tipe_barang').attr("disabled", bol);
                $('#edit_jenis_barang').attr("disabled", bol);
                $('#edit_merek_barang').attr("disabled", bol);
                $('#edit_nama_barang').attr("readonly", bol);
                $('#edit_kode_supplier').attr("disabled", bol);
                $('#edit_keterangan').attr("readonly", bol);
            } else {
                $('#edit_tipe_barang').attr("disabled", bol);
                $('#edit_jenis_barang').attr("disabled", bol);
                $('#edit_merek_barang').attr("disabled", bol);
                $('#edit_nama_barang').attr("readonly", bol);
                $('#edit_kode_supplier').attr("disabled", bol);
                $('#edit_keterangan').attr("readonly", bol);
            }
        } else if (div == "harga") {
            if (bol == false) {
                $('#edit_satuan').attr("disabled", bol);
                $('#edit_persediaan_minimum').attr("readonly", bol);
                $('#edit_harga_pokok_dummy').attr("readonly", bol);
                $('#edit_harga_satuan_dummy').attr("readonly", bol);
                $('#edit_harga_kedua_dummy').attr("readonly", bol);
                $('#edit_harga_ketiga_dummy').attr("readonly", bol);
                $('#metode_hpp').attr("disabled", bol);
                $('#edit_status_jual').attr("disabled", bol);
            } else {
                $('#edit_persediaan_minimum').attr("readonly", bol);
                $('#edit_satuan').attr("disabled", bol);
                $('#edit_harga_pokok_dummy').attr("readonly", bol);
                $('#edit_harga_satuan_dummy').attr("readonly", bol);
                $('#edit_harga_kedua_dummy').attr("readonly", bol);
                $('#edit_harga_ketiga_dummy').attr("readonly", bol);
                $('#metode_hpp').attr("disabled", bol);
                $('#edit_status_jual').attr("disabled", bol);
            }
        } else if (div == "komisi") {
            if (bol == false) {
                $('#edit_komisi_sales_dummy').attr("readonly", bol);
            } else {
                $('#edit_komisi_sales_dummy').attr("readonly", bol);
            }
        } else if (div == "lainnya") {
            if (bol == false) {
                $('#edit_status_jual').attr("disabled", bol);
            } else {
                $('#edit_status_jual').attr("disabled", bol);
            }
        }
    }

    setData($('#hide_kode_barang').text());
    // Fungsi Set Data Ke Kolom Pertama Kali
    function setData(kode_barang) {
        var edit_tipe_barang = $('#edit_tipe_barang');
        var edit_jenis_barang = $('#edit_jenis_barang');
        var edit_merek_barang = $('#edit_merek_barang');
        var edit_kode_barang = $('#edit_kode_barang');
        var edit_nama_barang = $('#edit_nama_barang');
        var edit_kode_supplier = $('#edit_kode_supplier');
        var edit_keterangan = $('#edit_keterangan');
        var edit_satuan = $('#edit_satuan');
        var edit_persediaan_minimum = $('#edit_persediaan_minimum');
        var edit_satuan_minimum = $('#edit_satuan_minimum');
        var edit_harga_pokok_dummy = $('#edit_harga_pokok_dummy');
        var edit_harga_pokok = $('#edit_harga_pokok');
        var edit_harga_satuan_dummy = $('#edit_harga_satuan_dummy');
        var edit_harga_satuan = $('#edit_harga_satuan');
        var edit_harga_kedua_dummy = $('#edit_harga_kedua_dummy');
        var edit_harga_kedua = $('#edit_harga_kedua');
        var edit_harga_ketiga_dummy = $('#edit_harga_ketiga_dummy');
        var edit_harga_ketiga = $('#edit_harga_ketiga');
        var edit_komisi_sales_dummy = $('#edit_komisi_sales_dummy');
        var edit_komisi_sales = $('#edit_komisi_sales');
        var edit_metode_hpp = $('#metode_hpp');
        var edit_status_jual = $('#edit_status_jual');
        var edit_tanggal_input = $('#edit_tanggal_input');
        //var edit_image = $('#edit_image');

        $.ajax({
            url: '<?= base_url("manajemen_barang/masterbarang/get_data_for_detail/"); ?>' + kode_barang,
            type: "POST",
            dataType: "JSON",
            async: false,
            success: function(data) {
                rupiahJual = formatRupiah(data.harga_satuan, 'Rp.');
                rupiahKedua = formatRupiah(data.harga_kedua, 'Rp.');
                rupiahKetiga = formatRupiah(data.harga_ketiga, 'Rp.');
                rupiahPokok = formatRupiah(data.harga_pokok, 'Rp.');
                rupiahKomisi = formatRupiah(data.komisi_sales, 'Rp.');
                edit_tipe_barang.val(data.tipe_barang).trigger('change');
                edit_jenis_barang.val(data.jenis_barang).trigger('change');
                edit_merek_barang.val(data.merek_barang).trigger('change');
                edit_kode_barang.val(data.kode_barang);
                edit_nama_barang.val(data.nama_barang);
                edit_kode_supplier.val(data.kode_supplier).trigger('change');
                edit_keterangan.val(data.keterangan);

                edit_satuan.val(data.kode_satuan).trigger('change');
                edit_persediaan_minimum.val(data.persediaan_minimum);
                edit_satuan_minimum.val($('#edit_satuan option:selected').text());
                edit_harga_pokok_dummy.val(rupiahPokok);
                edit_harga_pokok.val(data.harga_pokok);
                edit_harga_satuan_dummy.val(rupiahJual);
                edit_harga_satuan.val(data.harga_satuan);
                edit_harga_kedua_dummy.val(rupiahKedua);
                edit_harga_kedua.val(data.harga_kedua);
                edit_harga_ketiga_dummy.val(rupiahKetiga);
                edit_harga_ketiga.val(data.harga_ketiga);
                edit_komisi_sales_dummy.val(rupiahKomisi);
                edit_komisi_sales.val(data.komisi_sales);
                edit_metode_hpp.val(data.metode_hpp).trigger('change');
                edit_status_jual.val(data.status_jual).trigger('change');
                edit_tanggal_input.text(data.tanggal_input);
                // edit_image.attr('data-default-file', "<?= base_url('assets/images/barang/'); ?>" + data.gambar);
                //edit_image.attr('src',"<?= base_url('assets/images/barang/'); ?>" + data.gambar);
            }
        });
    }
</script>
<!-- Set Data Ke Tampilan -->




<!-- Init Chart -->

<script>
    var kode_barang = $('#hide_kode_barang').text();
    var label_tanggal = new Array()

    function renderChart(data, labels) {
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Penjualan',
                    data: data,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                }]
            },
            options: {},
        });
    }

    function getChartData(tanggal_awal, tanggal_akhir) {

        $.ajax({
            type: "POST",
            dataType: "JSON",
            async: false,
            data: {
                kode_barang: kode_barang,
                tanggal_awal: tanggal_awal,
                tanggal_akhir: tanggal_akhir
            },
            url: '<?= base_url("manajemen_barang/masterbarang/get_statistik_penjualan/"); ?>',
            success: function(data) {
                var nilai = [];
                var labels = [];
                for (var i in data) {

                    nilai.push(data[i].nilai); // push nilai penjualan
                    labels.push(data[i].tanggal); // push nilai penjualan

                    // var t = data[i].tanggal.split(/[- :]/);

                    // // Apply each element to the Date function
                    // var d = new Date(Date.UTC(t[0], t[1] - 1, t[2], t[3], t[4], t[5]));
                    // var a = d.getDate() + " - " + d.getMonth();

                    // labels.push(a);
                }
                renderChart(nilai, labels);
            },
        });
    }


    $('#tanggal_awal').on('click', function() {

    })

    $(document).ready(function() {
        $('#tanggal_awal').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        $('#tanggal_akhir').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        var date = new Date();
        $('#tanggal_akhir').datepicker("setDate", date)
        date.setDate(date.getDate() - 7)
        $('#tanggal_awal').datepicker("setDate", date)

        var awal = $('#tanggal_awal').val();
        var akhir = $('#tanggal_akhir').val();

        getChartData(awal, akhir);

        $("#tanggal_awal").on('change', function() {
            var awal = $('#tanggal_awal').val();
            var akhir = $('#tanggal_akhir').val();
            getChartData(awal, akhir);
        });

        $("#tanggal_akhir").on('change', function() {
            var awal = $('#tanggal_awal').val();
            var akhir = $('#tanggal_akhir').val();
            getChartData(awal, akhir);
        });
    });
</script>