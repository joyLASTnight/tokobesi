<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <div class="row pull-right">
                            <label class="col-sm-4 col-form-label">Cari Data</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="searchInput" placeholder="Kata Kunci ....">
                            </div>
                        </div>
                        <div class="card-box table-responsive">
                            <!-- <p class="text-muted font-14 m-b-30">
                            The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
                        </p> -->
                            <table id="datatable-master-persediaan" class="table table-striped table-bordered" cellspacing="0" width="100%">

                                <!-- <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Bk_001</td>
                                            <td>Batu Bata</td>
                                            <td>100 Pcs</td>
                                            <td>1.000</td>
                                            <td>Detail</td>
                                        </tr>
                                        </tbody> -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->

    <?php $this->view('template/template_footer'); ?>

</div>