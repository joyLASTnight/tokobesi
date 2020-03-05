<!-- Required datatable js -->
<script src="<?= base_url('assets/'); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?= base_url('assets/'); ?>plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables/jszip.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables/pdfmake.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables/vfs_fonts.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables/buttons.html5.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables/buttons.print.min.js"></script>
<!-- DatePicker Js -->
<script src="<?= base_url('assets/'); ?>plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Select2 js -->
<script src="<?= base_url('assets/'); ?>plugins/select2/js/select2.min.js" type="text/javascript"></script>
<!-- script sendiri -->

<script>
    $(document).ready(function() {


        var no_ref = $('#nomor_referensi').val()

        if (no_ref !== "") {

            init_edit_data(no_ref)
        } else {
            $('#tanggal').datepicker({
                autoclose: true,
                todayHighlight: true,
                orientation: "bottom left",
            });
        }
    })

    function init_table(no_ref) {
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


        //Init Datatabel Master Stok Persediaan 
        var table = $('#datatable-daftar-biaya').DataTable({
            "destroy": true,
            "oLanguage": {
                "sProcessing": "Sabar yah...",
                "sZeroRecords": "Tidak ada Data..."
            },
            "buttons": ['copy', 'excel', 'pdf', 'print'],
            "dom": 'Bfrtip',
            "searching": false,
            "fixedColumns": true,
            "processing": true,
            "serverSide": false,
            "ordering": true,
            "ajax": {
                "url": '<?= base_url("manajemen_keuangan/masterbiaya/get_detail_master_biaya/"); ?>',
                "data": {
                    no_ref: no_ref
                },
                "type": "POST",
            },
            "columnDefs": [{
                data: "id",
                width: 5,
                targets: 0,
                render: function(data, type, full, meta) {
                    return "";
                }
            }, {
                data: "nama_biaya",
                targets: 1,
                width: 50,
                render: function(data, type, full, meta) {
                    return data;
                }
            }, {
                data: "ket",
                targets: 2,
                width: 250,
                render: function(data, type, full, meta) {
                    return data;
                }
            }, {
                data: "total",
                targets: 3,
                width: 50,
                render: function(data, type, full, meta) {
                    return formatRupiah(data.toString(), 'Rp.');
                }
            }, {
                data: "id",
                targets: 4,
                width: 20,
                render: function(data, type, full, meta) {
                    var display2 = '<a type="button" onClick = "warning_delete(\'' + data + '\')" class="btn btn-icon waves-effect waves-light btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Delete Data"><i class="fa fa-trash" ></i> </a>';
                    return display2;
                }
            }, ],
            "rowCallback": function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
                // $(row).find('td:eq(2)').css('color', 'blue');

            }

        });
    }
</script>


<!-- Script Membuat Master dan Detail nya -->

<script>
    function tambah_master(no_ref, tanggal, ket) {
        $.ajax({
            url: '<?= base_url("manajemen_keuangan/masterbiaya/tambah_master_biaya"); ?>',
            type: "POST",
            data: {
                nomor_referensi: no_ref,
                tanggal: tanggal,
                keterangan: ket,
            },
            dataType: "JSON",
            async: false,
            beforeSend: function() {
                $.LoadingOverlay("show");
            },
            complete: function() {
                $.LoadingOverlay("hide");
            }
        });
    }
</script>

<!-- Script Button Type -->
<script>
    $('#proses_biaya').on('click', function() {
        var no_ref = $('#nomor_referensi');
        var tanggal = $('#tanggal');
        var ket = $('#keterangan');
        if (no_ref.val() !== "" && tanggal.val() !== "") {
            $('#tambah_data').attr('hidden', false);
            $('#total_biaya_div').attr('hidden', false);
            no_ref.attr('readonly', true);
            tanggal.attr('disabled', true);
            ket.attr('readonly', true);
            $('#apply_random').attr('disabled', true)
            $('#proses_biaya').attr('hidden', true)
            tambah_master(no_ref.val(), tanggal.val(), ket.text())
            init_table(no_ref.val());
            init_total_biaya(no_ref.val());
        } else {
            Swal.fire(
                'Data Stok Opname belum di isi !',
                'Silahkan Cek Kembali',
                'error'
            )
        }
    });
    $('#apply_random').on('click', function() {
        $.ajax({
            url: '<?= base_url("manajemen_keuangan/masterbiaya/random_ref/"); ?>',
            type: "POST",
            dataType: "JSON",
            async: false,
            success: function(data) {
                $('#nomor_referensi').val(data);
            }
        });
    })

    function warning_delete(id) {
        swal.fire({
            title: 'Apa anda yakin?',
            text: "Data akan di Hapus!!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                deleteData(id);
                swal.fire(
                    'Deleted!',
                    'Data telah dihapus!',
                    'success'
                )
            }
        });
    }

    function deleteData(id) {
        var no_ref = $('#nomor_referensi').val();

        $.ajax({
            url: "<?= base_url('manajemen_keuangan/masterbiaya/delete_detail_biaya'); ?>",
            type: "post",
            data: {
                id: id
            },
            async: false,
            success: function(data) {
                $('#datatable-daftar-biaya').DataTable().ajax.reload();
                init_total_biaya(no_ref)
            }
        });
    }
</script>

<!-- script modal -->

<script>
    $('#tambah_data').on('click', function() {
        init_kategori();
        $('#add_data').modal('show');
    })
</script>

<!-- Init data kategori biaya dan total_biaya -->

<script>
    function init_kategori() {
        $('#kategori_biaya').select2({
            dropdownParent: $('#add_data'),
            ajax: {
                url: '<?= base_url("manajemen_keuangan/masterbiaya/get_kategori_biaya/"); ?>',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        query: params.term, // search term
                    };
                },
                processResults: function(data) {
                    var results = [];
                    $.each(data, function(index, item) {
                        results.push({
                            id: item.id,
                            text: item.nama_biaya,
                        });
                    });
                    return {
                        results: results
                    };
                },
            },
        })
    }

    function init_total_biaya(no_ref) {
        var no_ref = $('#nomor_referensi').val();

        $.ajax({
            url: '<?= base_url("manajemen_keuangan/masterbiaya/get_master_total"); ?>',
            type: "POST",
            data: {
                no_ref: no_ref,
            },
            dataType: "JSON",
            async: false,
            success: function(data) {
                var display = formatRupiah(data.toString(), 'Rp.');
                $('#sum_total_biaya').val(display);
            }
        });
    }
</script>


<!-- Init Angka Rupiah -->
<script>
    var total_biaya = document.getElementById('total_biaya');
    total_biaya.addEventListener('keyup', function(e) {
        total_biaya.value = formatRupiah(this.value, 'Rp.');
    });

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
</script>

<!-- script tambah detail biaya -->

<script>
    $(document).ready(function() {
        $('#submitForm').submit(function(e) {
            e.preventDefault();
            var data = new FormData(document.getElementById("submitForm"));
            var no_ref = $('#nomor_referensi').val();
            data.append('nomor_referensi', no_ref);
            $.ajax({
                url: "<?= Base_url('manajemen_keuangan/masterbiaya/tambah_detail_biaya'); ?>",
                type: "post",
                data: data,
                async: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#datatable-daftar-biaya').DataTable().ajax.reload();
                    $('#add_data').modal('hide');
                    Swal.fire(
                        'Sukses!',
                        '',
                        'success'
                    )
                    init_total_biaya(no_ref)
                }
            })
        });
    });
</script>

<!-- Script Tutup Master -->

<script>
    $('#tutup').on('click', function() {
        var total_biaya = $('#total_biaya').val()
        var no_ref = $('#nomor_referensi').val()
        swal.fire({
            title: 'Apa anda yakin?',
            text: "Master Biaya " + no_ref + " akan di Buku ke Pengeluaran ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.value) {
                proses_tutup(no_ref, total_biaya);
            }
        });
    })

    function proses_tutup(no_ref, total_biaya) {
        $.ajax({
            url: '<?= base_url("manajemen_keuangan/masterbiaya/proses_tutup"); ?>',
            type: "POST",
            data: {
                no_ref: no_ref,
                total_biaya: total_biaya
            },
            async: false,
            beforeSend: function() {
                $.LoadingOverlay("show");
            },
            success: function(data) {
                $('.btn').attr('hidden', true);
                setTimeout(function() {
                    window.location.href = "<?= base_url('manajemen_keuangan/masterbiaya/detail_data/'); ?>" + no_ref
                }, 3000);
                Swal.fire(
                    'Terbuku !',
                    '',
                    'success'
                ).then((result) => {
                    window.location.href = "<?= base_url('manajemen_keuangan/masterbiaya/detail_data/'); ?>" + no_ref
                });
            },
            complete: function() {
                $.LoadingOverlay("hide");
            }
        });
    }
</script>

<!-- Init Edit Data kalo edit -->

<script>
    function init_edit_data() {
        var tanggal = $('#tanggal');
        var ket = $('#keterangan');
        var no_ref = $('#nomor_referensi');

        $('#tambah_data').attr('hidden', false);
        $('#total_biaya_div').attr('hidden', false);
        no_ref.attr('readonly', true);
        tanggal.attr('readonly', true);
        ket.attr('readonly', true);
        $('#proses_biaya').attr('hidden', true)
        $('#apply_random').attr('disabled', true)
        init_table(no_ref.val());
        init_total_biaya(no_ref.val());
    };
</script>