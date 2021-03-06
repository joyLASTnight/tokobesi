<!-- Pusher Notif Sendiri -->
<script src="<?= base_url('assets/'); ?>js/pusher.notif.js"></script>


<script>
	var jumlah_data;
	var lunas;
    var tunai;
	$('#btn_cari').on('click', function () {
		var nomor_faktur = $('#nomor_faktur').val();
		$.ajax({
			url: "<?= Base_url('manajemen_penjualan/returpenjualan/getData'); ?>",
			type: "post",
			data: {
				nomor_faktur: nomor_faktur
			},
			dataType: 'json',
			beforeSend: function () {
				$.LoadingOverlay("show");
			},
			success: function (data) {
				if (data == null) {
					Swal.fire(
						'Data tidak ditemukan !',
						'Silahkan Cek Kembali',
						'error'
					)
				} else if (data == "ada") {
					Swal.fire(
						'Oopss',
						nomor_faktur +
						' Sudah pernah melakukan retur, silahkan cek Daftar Retur Penjualan',
						'error'
					)
				} else {
					$('#id_pelanggan').val(data.id_pelanggan);
					$('#nama_pelanggan').val(data.nama_pelanggan);
					$('#nomor_telepon').val(data.nomor_telepon);
					$('#alamat').val(data.alamat);
					$('#tanggal_transaksi').val(data.tanggal_transaksi);
					if (data.status_bayar == 1) {
						var display = "Lunas";
						lunas = true;
					} else {
						var display = "Belum Lunas"
						lunas = false;
					}
					$('#status_pembayaran').val(display);
					$('#total_penjualan').val(formatRupiah(data.total_penjualan, 'Rp.'));
					$('#diskon').val(formatRupiah(data.diskon, 'Rp.'));
					$('#pajak').val(formatRupiah(data.pajak_masukan, 'Rp.'));
					$('#grand_total').val(formatRupiah(data.grand_total, 'Rp.'));
					$('#data_div').attr('hidden', false);
                    $('#div_hitung').attr('hidden',false);
                    $('#div_hitung')
				        .find("input,textarea,select")
				        .val('')
				        .end()
				        .find("input[type=checkbox], input[type=radio]")
				        .end();
					panggil_detail(nomor_faktur)
				}

			},
			complete: function () {
				$.LoadingOverlay("hide");
			}
		})
	});

	function panggil_detail(nomor_faktur) {
		jumlah_data = 1;
		$.ajax({
			url: "<?= Base_url('manajemen_penjualan/returpenjualan/getDetailData'); ?>",
			type: "post",
			data: {
				nomor_faktur: nomor_faktur
			},
			dataType: 'json',
			success: function (data) {
				if (data.length > 0) {
					$('#nomor').empty()
					$('#nama_barang').empty()
					$('#qty').empty()
					$('#harga').empty()
					$('#qty_retur').empty()
					$('#keterangan').empty()
					let nomor = 1;
					for (var i in data) {
						var kode_barang = data[i].kode_barang
						var display_nomor =
							'<input type="text" class="form-control" placeholder="Email" value="' + nomor +
							'" readonly><br>';
						var display_nama_barang = '<input type="text" class="form-control" value="' + data[i]
							.kode_barang + ' - ' + data[i].nama_barang + '" readonly><br>';
						var display_qty = '<input id="qty_jual' + nomor +
							'"  type="text" class="form-control" value="' + data[i].jumlah_penjualan +
							'" readonly><br>';
						var display_harga = '<input data-diskon="' + data[i].diskon + '" id="harga' + nomor +
							'" type="text" class="form-control" value="' + formatRupiah((data[i].harga_jual -
								data[i].diskon).toString(), 'Rp.') + '" readonly><br>';
						var display_qty_retur = '<input id="retur' + nomor + '" data-id="' + data[i].id +
							'" data-kdbarang="' + data[i].kode_barang +
							'" type="text" class="form-control" value="0"><br>';
						var display_keterangan = '<input id="keterangan' + nomor +
							'" type="text" class="form-control" placeholder="Silahkan isi alasan pengembalian barang.."><br>'

						$('#nomor').append(display_nomor)
						$('#nama_barang').append(display_nama_barang)
						$('#qty').append(display_qty)
						$('#harga').append(display_harga)
						$('#qty_retur').append(display_qty_retur)
						$('#keterangan').append(display_keterangan)
						nomor++;
						jumlah_data++;
					}
					$('#detail_div').attr('hidden', false);
				}
			}
		})
	}

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

		var tanparp = angka.replace(/[^0-9]+/g, "");
		var tanparp = tanparp.replace("Rp", "");
		var tanparp = tanparp.replace(",-", "");
		var tanpatitik = tanparp.split(".").join("");
		return tanpatitik;
	}

</script>

<script>
	$('#hitung').on('click', function () {
		$.LoadingOverlay("show");
		var retur_total = 0;
		var retur_diskon = 0;
		var retur_pajak = 0;
		var retur_grand_total = 0;
		var error = 0;
		for (i = 1; i < jumlah_data; i++) {
			var qty_jual = $('#qty_jual' + i).val();
			var qty = $('#retur' + i).val();
			var harga = $('#harga' + i).val();
			var diskon = $('#harga' + i).data('diskon');
			if (parseInt(qty) > parseInt(qty_jual)) {
				Swal.fire(
					'Oopss',
					'Jumlah Retur Lebih Banyak dari Penjualan',
					'error'
				)
				error++;
				break;
				$('#proses').attr('hidden', true);
			} else {
				total = qty * normalrupiah(harga);
				retur_total = retur_total + total;
				retur_diskon = retur_diskon + diskon;
			}
		}

		if ($('#pajak').val() !== "Rp. 0") {
			retur_pajak = ((retur_total - retur_diskon) * 0.1)
		} else {
			retur_pajak = 0
		}
		if (error < 1) {
			retur_grand_total = retur_total - retur_diskon + retur_pajak;
			$('#retur_total').val(formatRupiah(retur_total.toString(), 'Rp.'));
			$('#retur_diskon').val(formatRupiah(retur_diskon.toString(), 'Rp.'));
			$('#retur_pajak').val(formatRupiah(retur_pajak.toString(), 'Rp.'));
			$('#retur_grand_total').val(formatRupiah(retur_grand_total.toString(), 'Rp.'));
			$('#proses').attr('hidden', false)
		}
		$.LoadingOverlay("hide");



	})

	$('#proses').on('click', function () {
		if ($('#retur_total').val() !== "" && $('#retur_total').val() !== "Rp. 0") {
			var text;
			if (lunas == true) {
				text = 'Status Faktur Lunas'
			} else {
				text = 'Status Faktur Belum Lunas'
			}
			Swal.fire({
				title: 'Proses Retur ?',
				text: text,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Proses!'
			}).then((result) => {
				if (result.value) {
					if (lunas == true) {
						proses_retur()
					} else {
						Swal.fire({
							title: 'Metode Pembayaran ?',
							text: 'Pengembalian Dana',
							icon: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Tunai',
                            cancelButtonText: 'Potong Pinjaman'
						}).then((result) => {
							if (result.value) {
                                tunai = true;
                                proses_retur()
                            }else{
                                tunai = false;
                                proses_retur()
                            }
						})
					}
				}
			})
		} else {
			Swal.fire(
				'Data belum di isi !',
				'Silahkan Cek Kembali',
				'error'
			)
		}
	})

	function proses_retur() {
		var nomor_faktur = $('#nomor_faktur').val();
		var id_pelanggan = $('#id_pelanggan').val();
		var tanggal_transaksi = $('#tanggal_transaksi').val();
		var retur_total = normalrupiah($('#retur_total').val());
		var retur_diskon = normalrupiah($('#retur_diskon').val());
		var retur_pajak = normalrupiah($('#retur_pajak').val());
		var retur_grand_total = normalrupiah($('#retur_grand_total').val());

		var result = do_retur_master(nomor_faktur, id_pelanggan, retur_total, retur_diskon, retur_pajak, retur_grand_total,
			tanggal_transaksi, tunai)
		if (result !== 'kurang') {
			console.log('aww');
			for (i = 1; i < jumlah_data; i++) {
				var id = $('#retur' + i).data('id');
				var kode_barang = $('#retur' + i).data('kdbarang');
				var qty = $('#retur' + i).val();
				var harga = $('#harga' + i).val();
				var diskon = $('#harga' + i).data('diskon');
				var keterangan = $('#keterangan' + i).val();
				var retur_total = qty * normalrupiah(harga);
				if (qty > 0) {
					do_retur_detail(id, nomor_faktur, kode_barang, keterangan, qty, harga, diskon, retur_total,
						tanggal_transaksi)
				}
			}
			$('.btn').attr('disabled', true);
			setTimeout(function () {
				window.location.href =
					"<?php echo base_url('manajemen_penjualan/returpenjualan/faktur/'); ?>RTR-" + nomor_faktur;
			}, 5000);
			Swal.fire(
				'Proses retur selesai !',
				'',
				'success'
			).then((result) => {
				window.location.href =
					"<?php echo base_url('manajemen_penjualan/returpenjualan/faktur/'); ?>RTR-" + nomor_faktur;
			});
		} else {
			Swal.fire(
				'Ooppss !',
				'Dana Tidak Cukup',
				'error'
			)
		}


	}

	function do_retur_master(nomor_faktur, id_pelanggan, retur_total, retur_diskon, retur_pajak, retur_grand_total,
		tanggal_transaksi, tunai) {
		var result;
		$.ajax({
			url: "<?= Base_url('manajemen_penjualan/returpenjualan/tambahdatamaster'); ?>",
			type: "post",
			async: false,
			data: {
				nomor_faktur: nomor_faktur,
				id_pelanggan: id_pelanggan,
				retur_total: retur_total,
				retur_diskon: retur_diskon,
				retur_pajak: retur_pajak,
				retur_grand_total: retur_grand_total,
				tanggal_transaksi: tanggal_transaksi,
                tunai : tunai
			},
			beforeSend: function () {
				$.LoadingOverlay("show");
			},
			complete: function () {
				$.LoadingOverlay("hide");
			},
			success: function (data) {
				result = data;
			}
		})
		return result;
	}

	function do_retur_detail(id, nomor_faktur, kode_barang, keterangan, qty, harga, diskon, retur_total,
		tanggal_transaksi) {
		$.ajax({
			url: "<?= Base_url('manajemen_penjualan/returpenjualan/tambahdatadetail'); ?>",
			type: "post",
			data: {
				id_detail_penjualan: id,
				nomor_faktur: nomor_faktur,
				kode_barang: kode_barang,
				keterangan: keterangan,
				qty: qty,
				harga: harga,
				diskon: diskon,
				retur_total: retur_total,
				tanggal_transaksi: tanggal_transaksi
			},
			async: false,
			dataType: 'json',
			beforeSend: function () {
				$.LoadingOverlay("show");
			},
			complete: function () {
				$.LoadingOverlay("hide");
			}
		})
	}

</script>
