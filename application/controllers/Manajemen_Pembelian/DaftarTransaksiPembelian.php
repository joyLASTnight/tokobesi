<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daftartransaksipembelian extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Manajemen_Pembelian/Model_Daftar_Transaksi_Pembelian', 'modelDaftarTransaksiPembelian');
        $this->load->model('Setting/Model_Setting', 'modelSetting');

        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        $data['menu'] = $this->modelSetting->data_menu();
        $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();

        $data['css'] = 'manajemen_pembelian/daftar_transaksi_pembelian/daftar_transaksi_pembelian_css';

        $this->load->view('template/template_header', $data);
        $this->load->view('template/template_menu');
        $this->load->view('manajemen_pembelian/daftar_transaksi_pembelian/daftar_transaksi_pembelian');
        $this->load->view('template/template_right');
        $this->load->view('manajemen_pembelian/daftar_transaksi_pembelian/daftar_transaksi_pembelian_modal', $data);
        $this->load->view('template/template_footer');
        $this->load->view('template/template_js');
        $this->load->view('manajemen_pembelian/daftar_transaksi_pembelian/daftar_transaksi_pembelian_js');
        $this->load->view('template/template_app_js');
    }

    public function getData()
    {
        $post = $this->input->post();
        $database = $this->modelDaftarTransaksiPembelian->get_data($post);
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results('master_pembelian'),
            "recordsFiltered"  => $database->num_rows(),
            "data" => array()
        );

        foreach ($data as $key => $value) {
            if ($value['status_bayar'] == 0) {
                $data =  $this->modelDaftarTransaksiPembelian->get_data_kredit($value['nomor_transaksi']);
                $value['kredit'] = $data;
                $output['data'][] = $value;
            } else {
                $value['kredit'] = "";
                $output['data'][] = $value;
            }
        }

        $output = json_encode($output);
        echo $output;
    }



    public function delete_data()
    {
        $nomor_transaksi = $this->input->post('nomor_transaksi');
        if (empty($nomor_transaksi)) {
        } else {
           $data = $this->modelDaftarTransaksiPembelian->delete_data($nomor_transaksi); 
           echo $data;
        }
    }

    public function setlampiran()
    {
        $nomor_transaksi = $this->input->post('nomor_transaksi');
        $this->modelDaftarTransaksiPembelian->set_lampiran($nomor_transaksi);
    }
}
