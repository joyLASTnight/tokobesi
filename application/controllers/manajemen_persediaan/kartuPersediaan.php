<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KartuPersediaan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('string');
        $this->load->model('Manajemen_Persediaan/Model_Persediaan_Barang', 'modelPersediaan');
        $this->load->model('Setting/Model_Setting', 'modelSetting');
    }

    public function index()
    {
        $data['kartu'] = $this->modelPersediaan->get_kartu_persediaan();
        $data['css'] = 'manajemen_persediaan/kartu_persediaan/kartu_persediaan_css';
        $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();
        $this->load->view('template/template_header', $data);
        $this->load->view('template/template_menu');
        $this->load->view('manajemen_persediaan/kartu_persediaan/kartu_persediaan', $data);
        $this->load->view('template/template_right');
        $this->load->view('template/template_js');
        $this->load->view('manajemen_persediaan/kartu_persediaan/kartu_persediaan_js');
        $this->load->view('template/template_app_js');
    }

    public function get_data()
    {
        $output = $this->modelPersediaan->get_kartu_persediaan();
    }

    public function get_data_ajax()
    {
        $database = $this->modelPersediaan->get_kartu_persediaan_ajax();
        $data = $database->result_array();

        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered"  => 22,
            "data" =>  array()
        );

        foreach ($data as $data2) {
            $value['detail'] = $data2;
            $output['data'][] = $value;
        }
        $output = json_encode($output);
        echo $output;
    }
}
