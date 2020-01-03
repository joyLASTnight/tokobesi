<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <button name="contoh" id="contoh" data-target="#add_Modal" data-toggle="modal" class="btn btn-success btn-rounded w-md waves-effect waves-light m-b-20">
                            <i class="fa fa-plus"></i>
                            <span>Tambah Data</span>
                        </button>
                        <div class="row pull-right">
                            <label class="col-4 col-form-label">Cari Data</label>
                            <div class="col-8">
                                <input type="text" class="form-control" id="searchInput" placeholder="Kata Kunci..">
                            </div>
                        </div>
                        <table id="datatable-master-supplier" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div> <!-- content -->
    <?php $this->view('template/template_footer'); ?>

</div>

<!-- modal tambah data -->
<div id="add_Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tambah Data Supplier</h4>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
            </div>
            <div class="modal-body">
                <form data-parsley-validate novalidate autocomplete="off" id="submitForm" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Kode Supplier</label>
                        <div class="col-9">
                            <input name="kode_supplier" id="kode_supplier" type="text" class="form-control" placeholder="Generate otomatis oleh sistem" readonly required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Nama Suplier</label>
                        <div class="col-9">
                            <input name="nama_supplier" id="nama_supplier" type="text" class="form-control" placeholder="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Alamat</label>
                        <div class="col-9">
                            <textarea type="text" id="alamat" name="alamat" rows="2" placeholder="" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Nomor Telepon</label>
                        <div class="col-9">
                            <input name="nomor_telepon" id="nomor_telepon" type="text" class="form-control" placeholder="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Nomor NPWP</label>
                        <div class="col-9">
                            <input name="npwp" id="npwp"  type="text" class="form-control" placeholder="hanya angka 15 Digir, otomatis format NPWP..">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Nomor Rekening</label>
                        <!-- <label class="col-1 col-form-label">1. </label>
                        <div class="col-3">
                            <input name="edit_nama_bank" id="nama_bank" type="text" class="form-control" placeholder="">
                        </div>
                        <div class="col-4">
                            <input name="nomor_rekening" id="nomor_rekening" type="text" class="form-control" placeholder="" required>
                        </div>
                        <div class="col-1">
                        <button class="btn btn-icon waves-effect btn-success m-b-5"> <i class="fa fa-plus"></i> </button> -->
                        <div class="col-2">
                            <input name="bank_rekening" id="bank_rekening" type="text" class="form-control" placeholder="Nama Bank" required>
                        </div>
                        <div class="col-3">
                            <input name="nomor_rekening" id="nomor_rekening" type="text" class="form-control" placeholder="Nomor Rekening" required>
                        </div>
                        <div class="col-4">
                            <input name="nama_rekening" id="nama_rekening" type="text" class="form-control" placeholder="Nama di Rekening" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Keterangan</label>
                        <div class="col-9">
                            <textarea type="text" id="keterangan" name="keterangan" rows="2" placeholder="" class="form-control" required></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button id="md-close" name="button-close" type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" name="button-add" class="btn btn-primary waves-effect waves-light">Submit</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="edit_Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="edit_data_label">Edit Data Supplier</h4>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
            </div>
            <div class="modal-body">
                <form data-parsley-validate novalidate autocomplete="off" id="edit_form" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Kode Supplier</label>
                        <div class="col-9">
                            <input name="edit_kode_supplier" id="edit_kode_supplier" type="text" class="form-control" placeholder="Generate otomatis oleh sistem" readonly required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Nama Suplier</label>
                        <div class="col-9">
                            <input name="edit_nama_supplier" id="edit_nama_supplier" type="text" class="form-control" placeholder="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Alamat</label>
                        <div class="col-9">
                            <textarea type="text" id="edit_alamat" name="edit_alamat" rows="2" placeholder="" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Nomor Telepon</label>
                        <div class="col-9">
                            <input name="edit_nomor_telepon" id="edit_nomor_telepon" type="text" class="form-control" placeholder="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Nomor NPWP</label>
                        <div class="col-9">
                            <input name="edit_npwp" id="edit_npwp" type="text" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Nomor Rekening</label>
                        <!-- <label class="col-1 col-form-label">1. </label>
                        <div class="col-3">
                            <input name="edit_nama_bank" id="nama_bank" type="text" class="form-control" placeholder="">
                        </div>
                        <div class="col-4">
                            <input name="nomor_rekening" id="nomor_rekening" type="text" class="form-control" placeholder="" required>
                        </div>
                        <div class="col-1">
                        <button class="btn btn-icon waves-effect btn-success m-b-5"> <i class="fa fa-plus"></i> </button> -->
                        <div class="col-2">
                            <input name="edit_bank_rekening" id="edit_bank_rekening" type="text" class="form-control" placeholder="Nama Bank" required>
                        </div>
                        <div class="col-3">
                            <input name="edit_nomor_rekening" id="edit_nomor_rekening" type="text" class="form-control" placeholder="Nomor Rekening" required>
                        </div>
                        <div class="col-4">
                            <input name="edit_nama_rekening" id="edit_nama_rekening" type="text" class="form-control" placeholder="Nama di Rekening" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Keterangan</label>
                        <div class="col-9">
                            <textarea type="text" id="edit_keterangan" name="edit_keterangan" rows="2" placeholder="" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="form-group pull-right">
                        <h6 class="text-muted col-12">Terakhir Edit : <i id="edit_tanggal_input" readonly> </i></h6>
                    </div>
            </div>
            <div class="modal-footer">
                <button id="edit_md-close" name="button-close" type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" name="button-add" class="btn btn-primary waves-effect waves-light">Submit</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div id="view_Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="view_data_label">View Data Supplier</h4>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
            </div>
            <div class="modal-body">
                 <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a href="#detail_barang" id="nav_detail_barang" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                        Detail Barang
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#data_penjualan" id="nav_data_penjualan" data-toggle="tab" aria-expanded="true" class="nav-link">
                                        Data Penjualan
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade show active" id="detail_barang">
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Kode Supplier</label>
                                        <div class="col-9">
                                            <input name="view_kode_supplier" id="view_kode_supplier" type="text" class="form-control" placeholder="Generate otomatis oleh sistem" readonly required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Nama Suplier</label>
                                        <div class="col-9">
                                            <input name="view_nama_supplier" id="view_nama_supplier" type="text" class="form-control" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Alamat</label>
                                        <div class="col-9">
                                            <textarea type="text" id="view_alamat" name="view_alamat" rows="2" placeholder="" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Nomor Telepon</label>
                                        <div class="col-9">
                                            <input name="view_nomor_telepon" id="view_nomor_telepon" type="text" class="form-control" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Nomor NPWP</label>
                                        <div class="col-9">
                                            <input name="view_npwp" id="view_npwp" type="text" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Nomor Rekening</label>
                                        <!-- <label class="col-1 col-form-label">1. </label>
                                        <div class="col-3">
                                            <input name="edit_nama_bank" id="nama_bank" type="text" class="form-control" placeholder="">
                                        </div>
                                        <div class="col-4">
                                            <input name="nomor_rekening" id="nomor_rekening" type="text" class="form-control" placeholder="" required>
                                        </div>
                                        <div class="col-1">
                                        <button class="btn btn-icon waves-effect btn-success m-b-5"> <i class="fa fa-plus"></i> </button> -->
                                        <div class="col-2">
                                            <input name="view_bank_rekening" id="view_bank_rekening" type="text" class="form-control" placeholder="Nama Bank" required>
                                        </div>
                                        <div class="col-3">
                                            <input name="view_nomor_rekening" id="view_nomor_rekening" type="text" class="form-control" placeholder="Nomor Rekening" required>
                                        </div>
                                        <div class="col-4">
                                            <input name="view_nama_rekening" id="view_nama_rekening" type="text" class="form-control" placeholder="Nama di Rekening" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Keterangan</label>
                                        <div class="col-9">
                                            <textarea type="text" id="view_keterangan" name="view_keterangan" rows="2" placeholder="" class="form-control" required></textarea>
                                        </div>
                                    </div>
</div>
</div>
            </div>
            <div class="modal-footer">
                <button id="view_Md-close" name="button-close" type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>