<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saldoawalpersediaan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Manajemen_Persediaan/Model_Saldo_Awal_Persediaan', 'modelSaldoAwal');
        $this->load->model('Setting/Model_Setting', 'modelSetting');

        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        $data['menu'] = $this->modelSetting->data_menu();
        $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();

        $data['css'] = 'manajemen_persediaan/saldo_awal_persediaan/saldo_awal_persediaan_css';

        $this->load->view('template/template_header', $data);
        $this->load->view('template/template_menu');
        $this->load->view('manajemen_persediaan/saldo_awal_persediaan/saldo_awal_persediaan');
        $this->load->view('template/template_right');
        $this->load->view('manajemen_persediaan/saldo_awal_persediaan/saldo_awal_persediaan_modal');
        $this->load->view('template/template_footer');
        $this->load->view('template/template_js');
        $this->load->view('manajemen_persediaan/saldo_awal_persediaan/saldo_awal_persediaan_js');
        $this->load->view('template/template_app_js');
    }

    public function getData()
    {
        $string = $this->input->post('query');
        $data = $this->modelSaldoAwal->getData($string);
        $output = array(
            "data" => $data
        );

        $output = json_encode($output);
        echo $output;
    }

    public function getAllData()
    {
        $database = $this->modelSaldoAwal->getAllData();
        $data = $database->result_array();
        $output = array(
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered"  => $database->num_rows(),
            "data" =>  $data
        );

        $output = json_encode($output);
        echo $output;
    }


    public function tambah_data()
    {
        $post = $this->input->post();
        $this->modelSaldoAwal->tambah_data($post);
    }

    public function view_edit_data($id)
    {
        $data = $this->modelSaldoAwal->view_edit_data($id);
        $output = json_encode($data);
        echo $output;
    }

    public function edit_data($id)
    {
        $post = $this->input->post();
        $this->modelSaldoAwal->edit_data($id, $post);
    }

    public function delete_data($id)
    {
        $this->modelSaldoAwal->delete_data($id);
    }

    public function subTotal()
    {
        $data = $this->modelSaldoAwal->subTotal();
        // $output = array(
        //     "data" => $data
        // );
        $output = json_encode($data);
        echo $output;
    }
}
