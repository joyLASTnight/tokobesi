<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <div class="card m-b-20">
                        <div id="div_gambar">
                            <img id="gambar_barang" src="<?= base_url('assets/images/barang/') . $detail['gambar']; ?>" class="img-thumbnail" alt="profile-image">
                        </div>
                        <p hidden id="hide_kode_barang"><?= $kode_barang; ?></p>
                        <div class="card-body">
                            <div>
                                <button type="submit" id="edit_gambar_button" name="edit_gambar_button" class="btn btn-primary waves-effect waves-light"><i class="fa fa-image"></i> Ganti Gambar</button>
                            </div>
                            <hr>
                            <div>
                                <h4 class="card-title">Nama Produk</h4>
                                <p class="card-text">Deskripsi Produk</p>
                            </div>

                        </div>
                    </div>
                    <!--/ meta -->
                </div>
                <div class="col-sm-9">
                    <div class="card-box">
                        <div>
                            <h4 class="header-title m-t-0 m-b-30">Detail Barang XXXX</h4>
                            <h6 class="text-muted">Last Update : <i id="edit_tanggal_input" readonly> </i></h6>
                        </div>

                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item">
                                <a href="#data_umum" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    Data Umum
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile2" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    Satuan & Harga
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#messages2" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    Diskon / Potongan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#settings2" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    Statisktik Penjualan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#settings2" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    Lain - Lain
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade show active" id="data_umum">
                                <form data-parsley-validate novalidate autocomplete="off" id="form_umum" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Tipe Barang</label>
                                            <div class="col-9">
                                                <select name="edit_tipe_barang" id="edit_tipe_barang" class="form-control select2" required disabled>
                                                    <option value="0" selected disabled hidden>-Tipe-</option>
                                                    <?php foreach ($tipe as $value) : ?>
                                                        <option value=<?= $value['id_tipe']; ?>><?= $value['nama_tipe']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Kode Barang</label>
                                            <div class="col-9">
                                                <input name="edit_kode_barang" id="edit_kode_barang" type="text" class="form-control" placeholder="Generate otomatis oleh sistem" readonly required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Jenis Barang</label>
                                            <div class="col-3">
                                                <select name="edit_jenis_barang" id="edit_jenis_barang" class="form-control select2" disabled>
                                                    <option value="0" selected disabled hidden>-Jenis-</option>
                                                    <?php foreach ($jenis as $value) : ?>
                                                        <option value=<?= $value['id_jenis_barang']; ?>><?= $value['nama_jenis_barang']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <label class="col-3 col-form-label text-right">Merek Barang</label>
                                            <div class="col-3">
                                                <select name="edit_merek_barang" id="edit_merek_barang" class="form-control select2" disabled>
                                                    <option value="0" selected disabled hidden>-Merek-</option>
                                                    <?php foreach ($merek as $value) : ?>
                                                        <option value=<?= $value['id_merek_barang']; ?>><?= $value['nama_merek_barang']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <small id="inputhelp" class="form-text text-muted">*Optional</small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Nama Barang</label>
                                            <div class="col-9">
                                                <input readonly name="edit_nama_barang" id="edit_nama_barang" type="text" class="form-control" placeholder="Nama Barang yang Akan di Input.. contoh : Besi" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Nama Supplier</label>
                                            <div class="col-9">
                                                <select name="edit_kode_supplier" id="edit_kode_supplier" class="select2 form-control" disabled>
                                                    <option class="text-muted" value="0" selected disabled hidden>-Supplier-</option>
                                                    <?php foreach ($supplier as $value) : ?>
                                                        <option value=<?= $value['kode_supplier']; ?>><?= $value['nama_supplier']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <small id="inputhelp" class="form-text text-muted">*Optional</small>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Deskripsi Barang</label>
                                            <div class="col-9">
                                                <textarea readonly type="text" id="edit_keterangan" name="edit_keterangan" rows="2" class="form-control" placeholder="(optional)"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div>
                                            <button type="button" id="edit_trigger_umum" name="edit_trigger_umum" class="btn btn-success waves-effect waves-light"><i class="fa fa-edit"></i> Edit</button>
                                        </div>
                                        <div id="edit_button_umum_div" hidden>
                                            <button id="edit_batal_umum" name="edit_batal_umum" type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                            <button type="submit" id="submit_batal_umum" name="submit_batal_umum" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check"></i> Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="profile2">
                                <form data-parsley-validate novalidate autocomplete="off" id="form_harga" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Harga Pokok</label>
                                            <div class="col-9">
                                                <input readonly type="text" id="edit_harga_pokok_dummy" name="edit_harga_pokok_dummy" placeholder="Hanya Angka" class="form-control" required>
                                                <input type="text" name="edit_harga_pokok" id="edit_harga_pokok" placeholder="Hanya Angka" class="form-control" hidden>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Harga Jual</label>
                                            <div class="col-9">
                                                <input readonly type="text" id="edit_harga_satuan_dummy" name="edit_harga_satuan_dummy" placeholder="Hanya Angka" class="form-control" required>
                                                <input type="text" name="edit_harga_satuan" id="edit_harga_satuan" placeholder="Hanya Angka" class="form-control" hidden>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Satuan Dasar</label>
                                            <div class="col-9">
                                                <select name="edit_satuan" id="edit_satuan" class="form-control" placeholder="ssss" required disabled>
                                                    <!-- <option value="0" selected disabled hidden>-- Satuan Barang --</option> -->
                                                    <?php foreach ($satuan as $value) : ?>
                                                        <option value=<?= $value['id_satuan']; ?>><?= $value['nama_satuan']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Persediaan Minimum</label>
                                            <div class="col-5">
                                                <input readonly type="text" id="edit_persediaan_minimum" name="edit_persediaan_minimum" placeholder="Hanya Angka" class="form-control" required>
                                            </div>
                                            <label class="col-1 col-form-label">/</label>
                                            <div class="col-3">
                                                <input type="text" id="edit_satuan_minimum" name="edit_satuan_minimum" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Status Jual</label>
                                            <div class="col-9">
                                                <select name="edit_status_jual" id="edit_status_jual" class="form-control select2" placeholder="ssss" required disabled>
                                                    <option value="0" selected disabled hidden>-Status-</option>
                                                    <option value="1">Dijual</option>
                                                    <option value="1">Tidak Dijual</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <div>
                                            <button type="button" id="edit_trigger_harga" name="edit_trigger_umum" class="btn btn-success waves-effect waves-light"><i class="fa fa-edit"></i> Edit</button>
                                        </div>
                                        <div id="edit_button_harga_div" hidden>
                                            <button id="edit_batal_harga" name="edit_batal_harga" type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                            <button type="submit" id="submit_batal_harga" name="submit_batal_harga" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check"></i> Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="messages2">
                                <p>Etsy mixtape wayfarers, ethical
                                    wes anderson tofu before they sold out mcsweeney's organic lomo
                                    retro fanny pack lo-fi farm-to-table readymade. Messenger bag
                                    gentrify pitchfork tattooed craft beer, iphone skateboard locavore
                                    carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy
                                    irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg
                                    banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy
                                    retro mlkshk vice blog. Scenester cred you probably haven't heard of
                                    them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu
                                    synth chambray yr.</p>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="settings2">
                                <p>Trust fund seitan letterpress,
                                    keytar raw denim keffiyeh etsy art party before they sold out master
                                    cleanse gluten-free squid scenester freegan cosby sweater. Fanny
                                    pack portland seitan DIY, art party locavore wolf cliche high life
                                    echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before
                                    they sold out farm-to-table VHS viral locavore cosby sweater. Lomo
                                    wolf viral, mustache readymade thundercats keffiyeh craft beer marfa
                                    ethical. Wolf salvia freegan, sartorial keffiyeh echo park
                                    vegan.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
    <?php $this->view('template/template_footer'); ?>

</div>

<div id="edit_gambar_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="edit_data_label"></h4>
            </div>
            <form data-parsley-validate novalidate autocomplete="off" id="edit_gambar_form" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Upload Gambar Baru</label>
                        <div>
                            <input data-allowed-file-extensions="png jpg jpeg" data-max-file-size="3M" name="edit_gambar" id="edit_gambar" required type="file" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="edit_gambar_close" name="edit_gambar_close" type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                    <button type="submit" name="edit_gambar_ganti" class="btn btn-primary waves-effect waves-light">Upload</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>