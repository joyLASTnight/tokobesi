<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stokopname extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Manajemen_Persediaan/Model_Master_Persediaan', 'modelMasterPersediaan');
        $this->load->model('Setting/Model_Setting', 'modelSetting');
        $this->load->helper(array('form', 'url'));

        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        $data['menu'] = $this->modelSetting->data_menu();
        $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();

        $data['css'] = 'manajemen_persediaan/stok_opname/daftar_data/stok_opname_css';

        $this->load->view('template/template_header', $data);
        $this->load->view('template/template_menu');
        $this->load->view('manajemen_persediaan/stok_opname/daftar_data/stok_opname');
        $this->load->view('template/template_right');
        // $this->load->view('manajemen_persediaan/stok_opname/stok_opname_modal');
        $this->load->view('template/template_footer');
        $this->load->view('template/template_js');
        $this->load->view('manajemen_persediaan/stok_opname/daftar_data/stok_opname_js');
        $this->load->view('template/template_app_js');
    }


    public function tambah_data()
    {
        $data['menu'] = $this->modelSetting->data_menu();
        $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();

        $data['css'] = 'manajemen_persediaan/stok_opname/tambah_data/tambah_stok_opname_css';

        $this->load->view('template/template_header', $data);
        $this->load->view('template/template_menu');
        $this->load->view('manajemen_persediaan/stok_opname/tambah_data/tambah_stok_opname');
        $this->load->view('template/template_right');
        $this->load->view('manajemen_persediaan/stok_opname/tambah_data/tambah_stok_opname_modal');
        $this->load->view('template/template_footer');
        $this->load->view('template/template_js');
        $this->load->view('manajemen_persediaan/stok_opname/tambah_data/tambah_stok_opname_js');
        $this->load->view('template/template_app_js');
    }

    public function detail_stokopname($no_ref)
    {
        $data['menu'] = $this->modelSetting->data_menu();
        $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();

        $data['css'] = 'manajemen_persediaan/stok_opname/detail_data/detail_stok_opname_css';
        $data['stok_opname'] = $this->modelMasterPersediaan->getDetailMasterStokOpname($no_ref);
        $this->load->view('template/template_header', $data);
        $this->load->view('template/template_menu');
        $this->load->view('manajemen_persediaan/stok_opname/detail_data/detail_stok_opname', $data);
        $this->load->view('template/template_right');
        $this->load->view('manajemen_persediaan/stok_opname/detail_data/detail_stok_opname_modal');
        $this->load->view('template/template_footer');
        $this->load->view('template/template_js');
        $this->load->view('manajemen_persediaan/stok_opname/detail_data/detail_stok_opname_js');
        $this->load->view('template/template_app_js');
    }

    public function getDetailMasterStokOpname()
    {
        $no_ref = $this->input->post('no_ref');
        $data = $this->modelMasterPersediaan->getDetailMasterStokOpname($no_ref);
        $output = json_encode($data);
        echo $output;
    }


    public function getDataStokOpname($no_ref)
    {
        $database = $this->modelMasterPersediaan->getDataStokOpname($no_ref);
        $dataBarang = $database->result_array();
        $output = array(
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered"  => $database->num_rows(),
            "data" => array()
        );

        foreach ($dataBarang as $key => $value) {

            $data_barang = $this->modelMasterPersediaan->dataBarang($value['kode_barang']);

            $value['data_barang'] = $data_barang;

            $output['data'][] = $value;
        }

        $output = json_encode($output);
        echo $output;
    }

    public function getMasterStokOpnameUser()
    {
        $database = $this->modelMasterPersediaan->getMasterStokOpnameUser();
        $dataBarang = $database->result_array();
        $output = array(
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered"  => $database->num_rows(),
            "data" => $dataBarang
        );

        $output = json_encode($output);
        echo $output;
    }

    public function random_ref()
    {
        $number = $this->modelMasterPersediaan->random_ref();
        $output =  "REF" . $number;
        $output = json_encode($output);
        echo $output;
    }

    public function tambah_stokopname()
    {
        $post = $this->input->post();
        $this->modelMasterPersediaan->tambah_data($post);
        $this->modelMasterPersediaan->tambah_detail_data($post);
    }

    public function import_data()
    {
        $no_ref = $this->input->post('nomor_referensi');
        $this->modelMasterPersediaan->update_data_by_upload($no_ref);
    }

    public function show_detail_selisih_stok_opname()
    {
        $id_detail = $this->input->post('id');
        $detail = $this->modelMasterPersediaan->detailStokOpname($id_detail);
        $output = $detail;

        $detail_detail = $this->modelMasterPersediaan->detail_detailStokOpname($id_detail);
        if ($detail_detail == null) {
            $detail_detail = null;
        };

        $output['data'] = $this->modelMasterPersediaan->detail_detailStokOpname($id_detail);
        $output['koreksi'] = $this->modelMasterPersediaan->koreksi($id_detail);
        $output = json_encode($output);
        echo $output;
    }

    public function tambah_detail_selisih()
    {
        $post = $this->input->post();
        $output = $this->modelMasterPersediaan->tambah_detail_selisih($post);
        echo $output;
    }

    public function delete_detail_selisih()
    {
        $post = $this->input->post();
        $this->modelMasterPersediaan->delete_detail_selisih($post);
        echo  $this->modelMasterPersediaan->koreksi($post['id_ref']);
    }
    public function edit_detail_selisih()
    {
        $post = $this->input->post();
        $this->modelMasterPersediaan->edit_detail_selisih($post);
        echo  $this->modelMasterPersediaan->koreksi($post['id_ref']);
    }

    public function tambah_saldo_fisik()
    {
        $post = $this->input->post();
        $this->modelMasterPersediaan->tambah_saldo_fisik($post);
    }

    public function delete_master_stok_opname()
    {
        $no_ref = $this->input->post('no_ref');
        $this->modelMasterPersediaan->delete_master_stok_opname($no_ref);
    }

    public function proses_spv()
    {
        $post = $this->input->post();
        $this->modelMasterPersediaan->proses_spv($post);
    }
}
