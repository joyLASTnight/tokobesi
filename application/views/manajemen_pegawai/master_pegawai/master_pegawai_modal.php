<!-- modal tambah data -->
<div id="add_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tambah Data Pegawai</h4>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
            </div>
            <form autocomplete="off" id="submitForm" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="modal-body">
                    <div id="smartwizard">
                        <ul>
                            <li><a href="#step-1">Data Umum</a></li>
                            <li><a href="#step-2">Data Alamat</a></li>
                            <li><a href="#step-3">Data Pekerjaan</a></li>
                            <li><a href="#step-4">Data Lainnya</a></li>
                        </ul>

                        <div>
                            <div id="step-1">
                                <div id="form-step-0" role="form" data-toggle="validator">
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Nomor Induk Pegawai</label>
                                        <div class="col-9">
                                            <input name="nip" id="nip" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Nomor KTP</label>
                                        <div class="col-9">
                                            <input name="ktp" id="ktp" type="number" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Nama Lengkap</label>
                                        <div class="col-9">
                                            <input name="nama_lengkap" id="nama_lengkap" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Tanggal Lahir</label>
                                        <div class="col-9">
                                            <input name="tanggal_lahir" id="tanggal_lahir" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Jenis Kelamin</label>
                                        <div class="col-9">
                                            <select name="jenis_kelamin" id="jenis_kelamin" class="select2 form-control">
                                                <option value="0">Laki - Laki</option>
                                                <option value="1">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Pendidikan Terkhir</label>
                                        <div class="col-9">
                                            <input name="pendidikan_terakhir" id="pendidikan_terakhir" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-2">
                                <div id="form-step-1" role="form" data-toggle="validator">
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Alamat Rumah</label>
                                        <div class="col-9">
                                            <textarea name="alamat" id="alamat" type="text" rows="2" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Kelurahan</label>
                                        <div class="col-3">
                                            <input name="kelurahan" id="kelurahan" type="text" class="form-control" required>
                                        </div>
                                        <label class="col-3 col-form-label">Kecamatan</label>
                                        <div class="col-3">
                                            <input name="kecamatan" id="kecamatan" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Kota / Kabupaten</label>
                                        <div class="col-9">
                                            <input name="kota" id="kota" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-3">
                                <div id="form-step-2" role="form" data-toggle="validator">
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Jabatan</label>
                                        <div class="col-9">
                                            <input name="jabatan" id="jabatan" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Pembayaran Gaji</label>
                                        <div class="col-9">
                                            <select name="status_gaji" id="status_gaji" class="select2 form-control">
                                                <option value="0">Harian</option>
                                                <option value="1">Bulanan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Gaji Pokok</label>
                                        <div class="col-9">
                                            <input name="gaji_pokok" id="gaji_pokok" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Uang Makan</label>
                                        <div class="col-9">
                                            <input name="uang_makan" id="uang_makan" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Tanggal Mulai Bekerja</label>
                                        <div class="col-9">
                                            <input name="tanggal_masuk" id="tanggal_masuk" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-4">
                                <div id="form-step-3" role="form" data-toggle="validator">
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Nomor Telepon / HP</label>
                                        <div class="col-9">
                                            <input name="nomor_telepon" id="nomor_telepon" type="number" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Nomor Rekening</label>
                                        <div class="col-3">
                                            <input name="nomor_rekening" id="nomor_rekening" type="number" class="form-control" required>
                                        </div>
                                        <label class="col-3 col-form-label">Nama Bank</label>
                                        <div class="col-3">
                                            <input name="nama_bank" id="nama_bank" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">NPWP</label>
                                        <div class="col-9">
                                            <input name="npwp" id="npwp" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Foto Pegawai</label>
                                        <div class="col-5">
                                            <input data-allowed-file-extensions="png jpg jpeg" data-max-file-size="3M" name="gambar" id="gambar" type="file" />
                                        </div>
                                        <small id="id_pelanggan_help" class="form-text text-muted">*Upload Foto Pegawai jika Ada.. (optional)</small>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->