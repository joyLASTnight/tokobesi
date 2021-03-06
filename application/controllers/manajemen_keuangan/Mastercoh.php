<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mastercoh extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Manajemen_Keuangan/Model_Coh', 'modelCoh');
        $this->load->model('Setting/Model_Pusher', 'modelPusher');
        $this->load->model('Setting/Model_Setting', 'modelSetting');

        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
    }

    public function index()
	{
		if ($this->session->userdata('role') == "1") {
			redirect(base_url("manajemen_keuangan/mastercoh/kasir"));
		}
		if ($this->session->userdata('role') == "4") {
			redirect(base_url("manajemen_keuangan/mastercoh/supervisor"));
		}
		if ($this->session->userdata('role') == "5") {
			redirect(base_url("manajemen_keuangan/mastercoh/manajer"));
		}
	}

    function manajer()
    {
        if ($this->session->userdata('role') != "5") {
            redirect(base_url("dashboard"));
        } else {
            $data['menu'] = $this->modelSetting->data_menu();
            $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();
            $data['css'] = 'manajemen_keuangan/master_coh/manajer/daftar_coh/daftar_coh_css';

            $this->load->view('template/template_header', $data);
            $this->load->view('template/template_menu');
            $this->load->view('manajemen_keuangan/master_coh/manajer/daftar_coh/daftar_coh', $data);
            $this->load->view('template/template_right');
            $this->load->view('manajemen_keuangan/master_coh/manajer/daftar_coh/daftar_coh_modal');
            $this->load->view('template/template_footer');
            $this->load->view('template/template_js');
            $this->load->view('manajemen_keuangan/master_coh/manajer/daftar_coh/daftar_coh_js');
            $this->load->view('template/template_app_js');
        }
    }

    function get_data_master_permintaan()
    {
        $database = $this->modelCoh->get_data_master_permintaan();
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered"  => $database->num_rows(),
            "data" => $data
        );

        $output = json_encode($output);
        echo $output;
    }

    function manajer_approve_coh()
    {
        $post = $this->input->post();
        $this->db->select('*');
        $this->db->from('master_user');
        $this->db->where('username', $this->session->userdata('username'));
        $user = $this->db->get()->row_array();

        $isPasswordTrue = password_verify($post["password"], $user['password']);

        if ($isPasswordTrue) {
            $data = $this->modelCoh->manajer_approve_coh($post);
            echo $data;
        } else {
            echo 'salah';
        }
    }


    function manajer_reject_coh()
    {
        $post = $this->input->post();
        $this->db->select('*');
        $this->db->from('master_user');
        $this->db->where('username', $this->session->userdata('username'));
        $user = $this->db->get()->row_array();

        $isPasswordTrue = password_verify($post["password"], $user['password']);

        if ($isPasswordTrue) {
            $data = $this->modelCoh->manajer_reject_coh($post);
            echo $data;
        } else {
            echo 'salah';
        }

        $id = $this->input->post('id');
        
    }

    // script spv

    function supervisor()
    {
        if ($this->session->userdata('role') != "4") {
            redirect(base_url("dashboard"));
        } else {
            $data['menu'] = $this->modelSetting->data_menu();
            $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();
            $data['css'] = 'manajemen_keuangan/master_coh/supervisor/daftar_coh/daftar_coh_css';

            $this->load->view('template/template_header', $data);
            $this->load->view('template/template_menu');
            $this->load->view('manajemen_keuangan/master_coh/supervisor/daftar_coh/daftar_coh', $data);
            $this->load->view('template/template_right');
            $this->load->view('manajemen_keuangan/master_coh/supervisor/daftar_coh/daftar_coh_modal');
            $this->load->view('template/template_footer');
            $this->load->view('template/template_js');
            $this->load->view('manajemen_keuangan/master_coh/supervisor/daftar_coh/daftar_coh_js');
            $this->load->view('template/template_app_js');
        }
    }

    function detail_data($string)
    {
        $this->db->select('id');
        $this->db->from('master_coh');
        $this->db->where('id', $string);
        $this->db->where('user', $this->session->userdata('username'));
        $cek = $this->db->get()->num_rows();

        $data['menu'] = $this->modelSetting->data_menu();
        $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();
        $data['css'] = 'manajemen_keuangan/master_coh/supervisor/detail_coh/detail_coh_css';

        if ($cek > 0) {
            $data['detail_data'] = $this->modelCoh->detail_master($string);
            $this->load->view('template/template_header', $data);
            $this->load->view('template/template_menu');
            $this->load->view('manajemen_keuangan/master_coh/supervisor/detail_coh/detail_coh', $data);
            $this->load->view('template/template_right');
            $this->load->view('manajemen_keuangan/master_coh/supervisor/detail_coh/detail_coh_modal');
            $this->load->view('template/template_footer');
            $this->load->view('template/template_js');
            $this->load->view('manajemen_keuangan/master_coh/supervisor/detail_coh/detail_coh_js');
            $this->load->view('template/template_app_js');
        } else {
            $this->load->view('template/template_header', $data);
            $this->load->view('template/template_menu');
            $this->load->view('template/template_page_not_found');
            $this->load->view('template/template_right');
            $this->load->view('template/template_footer');
            $this->load->view('template/template_js');
            $this->load->view('template/template_app_js');
        }
    }

    public function get_data_master()
    {
        $database = $this->modelCoh->get_data_master();
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered"  => $database->num_rows(),
            "data" => $data
        );

        $output = json_encode($output);
        echo $output;
    }


    public function get_data_master_kasir_aktif()
    {
        $database = $this->modelCoh->get_data_master_kasir_aktif();
        if($database !== 'kosong'){
        $data = $database->result_array();
        }else{
            $data = [
                'nama_kasir' => null,
                'saldo_awal' => null,
                'saldo_akhir'=> null,
                'status'=>null
            ];
        }

        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered"  => 0,
            "data" => $data
        );       
        $output = json_encode($output);
        echo $output;

        
    }

    

    public function get_data_master_histori()
    {
        $database = $this->modelCoh->get_data_master_histori();
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered"  => $database->num_rows(),
            "data" => $data
        );

        $output = json_encode($output);
        echo $output;
    }

    

    public function get_data_permintaan_spv()
    {
        $post = $this->input->post();
        $database = $this->modelCoh->get_data_permintaan_spv($post);
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered"  => $database->num_rows(),
            "data" => $data
        );

        $output = json_encode($output);
        echo $output;
    }

    public function get_detail_data()
    {
        $nomor_referensi = $this->input->post('no_ref');
        $database = $this->modelCoh->get_detail_data($nomor_referensi);
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered"  => $database->num_rows(),
            "data" => $data
        );

        $output = json_encode($output);
        echo $output;
    }

    public function cek_data()
    {
        $post = $this->input->post();
        $data = $this->modelCoh->cek_data($post);
        echo $data;
    }


    function supervisor_approve_coh()
    {
        $post = $this->input->post();
        $this->db->select('*');
        $this->db->from('master_user');
        $this->db->where('username', $this->session->userdata('username'));
        $user = $this->db->get()->row_array();

        $isPasswordTrue = password_verify($post["password"], $user['password']);

        if ($isPasswordTrue) {
            $data = $this->modelCoh->supervisor_approve_coh($post);
            echo $data;
        } else {
            echo 'salah';
        }
    }


     function supervisor_reject_coh()
    {
        $post = $this->input->post();
        $this->db->select('*');
        $this->db->from('master_user');
        $this->db->where('username', $this->session->userdata('username'));
        $user = $this->db->get()->row_array();

        $isPasswordTrue = password_verify($post["password"], $user['password']);

        if ($isPasswordTrue) {
            $data = $this->modelCoh->supervisor_reject_coh($post);
            echo $data;
        } else {
            echo 'salah';
        }

    }


    public function delete_master_coh()
    {
        $id = $this->input->post('id');
        $this->modelCoh->delete_master_coh($id);
    }

    public function delete_permintaan()
    {
        $id = $this->input->post('id');
        $this->modelCoh->delete_permintaan($id);
    }



    public function get_data_pending()
    {
        $post = $this->input->post();
        $database = $this->modelCoh->get_data_pending($post);
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered"  => $database->num_rows(),
            "data" => $data
        );

        $output = json_encode($output);
        echo $output;
    }

    public function get_data_permintaan()
    {
        $post = $this->input->post();
        $database = $this->modelCoh->get_data_permintaan($post);
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered"  => $database->num_rows(),
            "data" => $data
        );

        $output = json_encode($output);
        echo $output;
    }

    // permintaan

    public function permintaan_tarik_dana()
    {
        $post = $this->input->post();
        $data = $this->modelCoh->permintaan_tarik_dana($post);
        echo $data;
    }

    public function permintaan_setor_dana()
    {
        $post = $this->input->post();
        $data = $this->modelCoh->permintaan_setor_dana($post);
        echo $data;
    }

    public function dana_masuk()
    {
        $post = $this->input->post();
        $data = $this->modelCoh->dana_masuk($post);
        echo $data;
    }

    public function tutup_master_coh()
    {
        $id = $this->input->post('id');
        echo $this->modelCoh->tutup_master_coh($id);
    }

    public function tambah_data()
    {
        $post = $this->input->post();
        $this->modelCoh->start_of_day($post);
    }

    public function get_jumlah_data_pending(){
        $post = $this->input->post();
        $data = $this->modelCoh->get_jumlah_data_pending($post);
        echo $data;
    }

    public function get_jumlah_data_permintaan(){
        $post = $this->input->post();
        $data = $this->modelCoh->get_jumlah_data_permintaan($post);
        echo $data;
    }
       
    // script kasir


    function kasir()
    {
        if ($this->session->userdata('role') != "1") {
            redirect(base_url("dashboard"));
        } else {
            $data['menu'] = $this->modelSetting->data_menu();
            $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();
            $data['css'] = 'manajemen_keuangan/master_coh/kasir/daftar_coh/daftar_coh_css';

            $this->load->view('template/template_header', $data);
            $this->load->view('template/template_menu');
            $this->load->view('manajemen_keuangan/master_coh/kasir/daftar_coh/daftar_coh', $data);
            $this->load->view('template/template_right');
            $this->load->view('manajemen_keuangan/master_coh/kasir/daftar_coh/daftar_coh_modal');
            $this->load->view('template/template_footer');
            $this->load->view('template/template_js');
            $this->load->view('manajemen_keuangan/master_coh/kasir/daftar_coh/daftar_coh_js');
            $this->load->view('template/template_app_js');
        }
    }



    function detail_data_kasir($string)
    {
        $this->db->select('id');
        $this->db->from('master_coh');
        $this->db->where('id', $string);
        $this->db->where('user', $this->session->userdata('username'));
        $cek = $this->db->get()->num_rows();
    
        $data['menu'] = $this->modelSetting->data_menu();
        $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();
        $data['css'] = 'manajemen_keuangan/master_coh/kasir/detail_coh/detail_coh_css';

        if($cek > 0){
            $data['detail_data'] = $this->modelCoh->detail_master($string);
            $this->load->view('template/template_header', $data);
            $this->load->view('template/template_menu');
            $this->load->view('manajemen_keuangan/master_coh/kasir/detail_coh/detail_coh', $data);
            $this->load->view('template/template_right');
            $this->load->view('manajemen_keuangan/master_coh/kasir/detail_coh/detail_coh_modal');
            $this->load->view('template/template_footer');
            $this->load->view('template/template_js');
            $this->load->view('manajemen_keuangan/master_coh/kasir/detail_coh/detail_coh_js');
            $this->load->view('template/template_app_js');
        }else{
            $this->load->view('template/template_header', $data);
            $this->load->view('template/template_menu');
            $this->load->view('template/template_page_not_found');
            $this->load->view('template/template_right');
            $this->load->view('template/template_footer');
            $this->load->view('template/template_js');
            $this->load->view('template/template_app_js');
        }
        
    }

    public function get_data_master_kasir()
    {
        $database = $this->modelCoh->get_data_master_kasir();
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered"  => $database->num_rows(),
            "data" => $data
        );

        $output = json_encode($output);
        echo $output;
    }

    public function get_data_master_kasir_histori()
    {
        $database = $this->modelCoh->get_data_master_kasir_histori();
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered"  => $database->num_rows(),
            "data" => $data
        );

        $output = json_encode($output);
        echo $output;
    }

    public function get_data_permintaan_kasir()
    {
        $post = $this->input->post();
        $database = $this->modelCoh->get_data_permintaan_kasir($post);
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered"  => $database->num_rows(),
            "data" => $data
        );

        $output = json_encode($output);
        echo $output;
    }



    public function spv_no_ref()
    {
        $query = $this->input->get('query');
        $database = $this->modelCoh->spv_no_ref($query);
        $data = $database->result_array();
        $output = json_encode($data);
        echo $output;
    }

    public function data_transfer_kasir()
    {
        $query = $this->input->get('query');
        $database = $this->modelCoh->data_transfer_kasir($query);
        $data = $database->result_array();
        $output = json_encode($data);
        echo $output;
    }

    public function cek_data_kasir()
    {
        $post = $this->input->post();
        $data = $this->modelCoh->cek_data_kasir($post);
        echo $data;
    }

    public function tambah_data_kasir()
    {
        $post = $this->input->post();
        echo $this->modelCoh->start_of_day_kasir($post);
    }

    public function permintaan_tarik_dana_kasir()
    {
        $post = $this->input->post();
        $data = $this->modelCoh->permintaan_tarik_dana_kasir($post);
        echo $data;
    }

    public function permintaan_setor_dana_kasir()
    {
        $post = $this->input->post();
        $data = $this->modelCoh->permintaan_setor_dana_kasir($post);
        echo $data;
    }

    public function permintaan_transfer_dana_kasir()
    {
        $post = $this->input->post();
        $data = $this->modelCoh->permintaan_transfer_dana_kasir($post);
        echo $data;
    }

    public function tutup_master_coh_kasir()
    {
        $id = $this->input->post('id');
        echo $this->modelCoh->tutup_master_coh_kasir($id);
    }

    function kasir_approve_coh()
    {
        $post = $this->input->post();
        $this->db->select('*');
        $this->db->from('master_user');
        $this->db->where('username', $this->session->userdata('username'));
        $user = $this->db->get()->row_array();

        $isPasswordTrue = password_verify($post["password"], $user['password']);

        if ($isPasswordTrue) {
            $data = $this->modelCoh->kasir_approve_coh($post);
            echo $data;
        } else {
            echo 'salah';
        }
    }


    function kasir_reject_coh()
    {
        $post = $this->input->post();
        $this->db->select('*');
        $this->db->from('master_user');
        $this->db->where('username', $this->session->userdata('username'));
        $user = $this->db->get()->row_array();

        $isPasswordTrue = password_verify($post["password"], $user['password']);

        if ($isPasswordTrue) {
            $data = $this->modelCoh->kasir_reject_coh($post);
            echo $data;
        } else {
            echo 'salah';
        }
    }


    function saldo_akhir()
    {
        $no_ref = $this->input->post('no_ref');
        $this->db->select('saldo_akhir');
        $this->db->from('master_coh');
        $this->db->where('nomor_referensi', $no_ref);
        $data = $this->db->get()->row_array();
        echo $data['saldo_akhir'];
    }

}
