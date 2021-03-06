<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Setting/Model_Setting', 'modelSetting');
        $this->load->model('Manajemen_Penjualan/Model_Daftar_Transaksi_Penjualan', 'modelDaftarTransaksiPenjualan');
        $this->load->model('Manajemen_Keuangan/Model_Coh', 'modelCoh');
        $this->load->model('Laporan/Model_Laba', 'modelLaba');
        $this->load->model('Manajemen_Persediaan/Model_Master_Persediaan', 'modelMasterPersediaan');
        $this->load->model('Dashboard/Model_Dashboard', 'modelDashboard');
        $this->load->model('Dashboard/Model_Dashboard_Kasir', 'modelDashboardKasir');
        $this->load->model('Dashboard/Model_Dashboard_Admin', 'modelDashboardAdmin');
        $this->load->model('Dashboard/Model_Dashboard_Supervisor', 'modelDashboardSpv');
        $this->load->model('Dashboard/Model_Dashboard_Manajer', 'modelDashboardManajer');
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
    }
    public function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }

    // dashboard manajer
    public function data()
    {
        $periode = $this->modelSetting->get_data_periode();

        $data['total_laba'] = $this->total_laba($periode);
        $data['total_beban'] = $this->total_beban($periode);
        $data['total_utang'] = $this->modelDashboardManajer->data_utang(date("Y-01-01"), $periode);
        $data['total_piutang'] = $this->modelDashboardManajer->data_piutang(date("Y-01-01"), $periode);

        $data['transaksi'] = $this->modelDashboard->data_transaksi(date("Y-m-d"), $periode);
        $data['total_penjualan'] = $this->modelDashboard->data_penjualan(date("Y-m-d"), $periode);
        $data['total_pembelian'] = $this->modelDashboard->data_pembelian(date("Y-m-d"), $periode);
        $data['total_produk_terjual'] = $this->modelDashboard->data_produk_terjual(date("Y-m-d"), $periode);

        $data['trend_transaksi'] = $this->modelDashboard->trend_transaksi(date("Y-m-d"), $periode);
        $data['trend_penjualan'] = $this->modelDashboard->trend_penjualan(date("Y-m-d"), $periode);
        $data['trend_pembelian'] = $this->modelDashboard->trend_pembelian(date("Y-m-d"), $periode);
        $data['trend_produk_terjual'] = $this->modelDashboard->trend_produk_terjual(date("Y-m-d"), $periode);

        $data['dropdown_penjualan'] = $this->modelDashboard->dropdown_penjualan($periode);
        $data['dropdown_pembelian'] = $this->modelDashboard->dropdown_pembelian($periode);
        $data['dropdown_produk_terjual'] = $this->modelDashboard->dropdown_produk_terjual($periode);
        $data['dropdown_transaksi_penjualan'] = $this->modelDashboard->dropdown_transaksi_penjualan($periode);

        $output = json_encode($data);
        echo $output;
    }

    public function total_laba($periode)
    {
        $hari = date("d");
        $bulan = date("m");
        $tahun = date("Y");

        $data = $this->modelLaba->laba_berjalan($hari, $bulan, $tahun, $periode);

        return $data;
    }

    public function total_beban($periode)
    {
        $hari = date("d");
        $bulan = date("m");
        $tahun = date("Y");

        $beban_operasional = $this->modelLaba->total_beban_operasional($hari, $bulan, $tahun, $periode);
        $beban_gaji = $this->modelLaba->total_beban_gaji($hari, $bulan, $tahun, $periode);
        $data = $beban_operasional + $beban_gaji;
        return $data;

    }

    public function top_sales()
    {
        $bulan = $this->input->post('bulan');
        $data = $this->modelDashboard->data_top_sales($bulan);

        foreach ($data as $key => $value) {
            $data[$key]['detail'] = $this->modelDashboard->detail_sales($value['sales']);
        }

        $output = json_encode($data);
        echo $output;
    }

    public function data_penjualan_kasir_hari_ini()
    {
        $kasir = $this->session->userdata['username'];
        $database = $this->modelDashboardKasir->get_data_penjualan_hari_ini(date("Y-m-d"), $kasir);
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results('master_penjualan'),
            "recordsFiltered" => $database->num_rows(),
            "data" => array(),
        );

        foreach ($data as $key => $value) {
            if ($value['status_bayar'] == 0) {
                $data = $this->modelDaftarTransaksiPenjualan->get_data_kredit($value['no_faktur']);
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

    public function laporan_kasir()
    {
        $role = $this->session->userdata['role'];
        if ($role == 1) {
            $user = $this->session->userdata['username'];
        } else {
            $user = null;
        }
        $data = $this->modelDashboardKasir->laporan_kasir($user);

        $output = json_encode($data);
        echo $output;
    }

    public function laporan_spv()
    {
        $role = $this->session->userdata['role'];
        if ($role == 1) {
            $user = $this->session->userdata['username'];
        } else {
            $user = null;
        }
        $data = $this->modelDashboardSpv->laporan_spv($user);

        $output = json_encode($data);
        echo $output;
    }

    public function data_penjualan_terakhir()
    {
        $periode = $this->modelSetting->get_data_periode();

        $database = $this->modelDashboard->get_data_penjualan_terakhir(date("Y-m-d 00-00-00"), $periode);
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results('master_penjualan'),
            "recordsFiltered" => $database->num_rows(),
            "data" => array(),
        );

        foreach ($data as $key => $value) {
            if ($value['status_bayar'] == 0) {
                $data = $this->modelDaftarTransaksiPenjualan->get_data_kredit($value['no_faktur']);
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

    public function data_total_laba()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        $data['label'] = $this->modelDashboard->calendar($bulan, $tahun);
        $total = 0;
        foreach ($data['label'] as $key => $value) {
            $laba = $this->modelDashboardManajer->get_data_laba_harian($value, $bulan, $tahun);
            $total = $total + $laba;
            $data['total'][] = $total;
            $data['harian'][] = $laba;
        }

        $output = json_encode($data);
        echo $output;
    }

    public function data_top_produk()
    {
        $option = $this->input->post('option');
        $data = $this->modelDashboard->topProduk($option);
        if ($data == null) {
            $dataset['nama_barang'][] = "Belum ada data";
            $dataset['jumlah_penjualan'][] = 0;
        } else {
            foreach ($data as $key => $value) {
                $dataset['nama_barang'][] = $value['nama_barang'];
                $dataset['jumlah_penjualan'][] = $value['jumlah_penjualan'];
            }
        }
        $output = json_encode($dataset);
        echo $output;
    }

    public function data_produktifitas_sales()
    {
        $kode_sales = $this->input->post('kode_sales');
        $data = $this->modelDashboard->data_produktifitas_sales($kode_sales);
        if ($data == null) {
            $dataset['bulan'][] = "belum ada data";
            $dataset['value'][] = 0;
        } else {
            foreach ($data as $key => $value) {
                $dataset['bulan'][] = $value['bulan'];
                $dataset['value'][] = $value['total_penjualan'];
            }
        }

        $output = json_encode($dataset);
        echo $output;
    }

    public function cek()
    {
        $data = $this->modelDashboard->get_data_laba_harian(18, 03, 2020);
        $output = json_encode($data);
        echo $output;
    }

    public function cek2($no_faktur)
    {
        $data = $this->modelDashboard->cari_harga_pokok($no_faktur);
        $output = json_encode($data);
        echo $output;
    }

    // dashboard kasir
    public function data_penjualan_terakhir_kasir()
    {
        $database = $this->modelDashboardKasir->get_data_penjualan_terakhir();
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results('master_penjualan'),
            "recordsFiltered" => $database->num_rows(),
            "data" => array(),
        );

        foreach ($data as $key => $value) {
            if ($value['status_bayar'] == 0) {
                $data = $this->modelDaftarTransaksiPenjualan->get_data_kredit($value['no_faktur']);
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

    // dashboard admin

    public function getDataPendingPO()
    {
        $post = $this->input->post();
        $database = $this->modelDashboardAdmin->get_data_po();
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results('master_penjualan'),
            "recordsFiltered" => $database->num_rows(),
            "data" => array(),
        );

        foreach ($data as $key => $value) {
            $sales = $this->modelDashboardAdmin->data_sales($value['sales']);
            $admin = $this->modelDashboardAdmin->data_admin($value['admin']);
            $pelanggan = $this->modelDashboardAdmin->data_pelanggan($value['id_pelanggan']);

            $value['sales'] = $sales;
            $value['admin'] = $admin;
            $value['pelanggan'] = $pelanggan;

            $output['data'][] = $value;
        }

        $output = json_encode($output);
        echo $output;
    }

    public function data_pembelian_terakhir()
    {
        $post = $this->input->post();
        $database = $this->modelDashboardAdmin->get_data($post);
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results('master_pembelian'),
            "recordsFiltered" => $database->num_rows(),
            "data" => array(),
        );

        foreach ($data as $key => $value) {
            if ($value['status_bayar'] == 0) {
                $data = $this->modelDashboardAdmin->get_data_kredit($value['nomor_transaksi']);
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

    // dashboard spv
    public function data_pending_spv()
    {
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array(),
        );

        $data_stok_opname = $this->modelDashboardSpv->data_pending_stok_opname();
        $data_insentif = $this->modelDashboardSpv->data_pending_insentif();
        $data_coh = $this->modelCoh->get_data_pending_user($this->session->userdata('username'));

        foreach ($data_stok_opname as $key => $value) {
            $pending = [
                'tanggal' => $value['tanggal'],
                'task' => 'Stok Opname No Ref # ' . $value['nomor_referensi'],
                'link' => 'manajemen_persediaan/reviewstokopname/review_detail/' . $value['nomor_referensi'],
            ];

            $output['data'][] = $pending;
        }

        foreach ($data_insentif as $key => $value) {
            $pending = [
                'tanggal' => $value['tanggal'],
                'task' => 'Isentif a.n ' . $value['nama'],
                'link' => 'manajemen_pegawai/insentifsales/',
            ];
            $output['data'][] = $pending;
        }

        foreach ($data_coh as $key => $value) {

            $nominal = $this->rupiah($value['nominal']);

            if ($value['jenis_permintaan'] == '3') {
                $task = 'Permintaan Cash Awal Sebesar <b class="text-danger">' . $nominal . '</b> dari ' . $value['nama_pegawai'];
            } else if ($value['jenis_permintaan'] == '1') {
                $task = 'Permintaan Penarikan Dana Sebesar <b class="text-danger">' . $nominal . '</b> dari ' . $value['nama_pegawai'];
            } else if ($value['jenis_permintaan'] == '2') {
                $task = 'Permintaan Setoran Dana Sebesar <b class="text-danger">' . $nominal . '</b> dari ' . $value['nama_pegawai'];
            } else if ($value['jenis_permintaan'] == '5') {
                $task = 'Permintaan Penutupan Dana dari ' . $value['nama_pegawai'];
            }

            $pending = [
                'tanggal' => $value['jam'],
                'task' => $task,
                'link' => 'manajemen_keuangan/mastercoh/',
            ];
            $output['data'][] = $pending;
        }

        $output = json_encode($output);
        echo $output;
        // print_r($data_coh);
    }

    // dashboard manajer

    public function data_piutang()
    {
        $post = $this->input->post();
        $database = $this->modelDashboard->get_data_piutang($post);
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results('master_piutang'),
            "recordsFiltered" => $database->num_rows(),
            "data" => array(),
        );

        foreach ($data as $key => $value) {
            $output['data'][] = $value;
        }
        $output = json_encode($output);
        echo $output;
    }

    public function data_utang()
    {
        $post = $this->input->post();
        $database = $this->modelDashboard->get_data_utang($post);
        $data = $database->result_array();
        $output = array(
            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->db->count_all_results('master_utang'),
            "recordsFiltered" => $database->num_rows(),
            "data" => array(),
        );

        foreach ($data as $key => $value) {
            $output['data'][] = $value;
        }
        $output = json_encode($output);
        echo $output;
    }

    public function get_data_persediaan()
    {
        $post = $this->input->post();

        $database = $this->modelMasterPersediaan->getDataBarang();
        $dataBarang = $database->result_array();
        $output = array(
            "recordsTotal" => $this->db->count_all_results(),
            "recordsFiltered" => $database->num_rows(),
            "data" => array(),
        );

        foreach ($dataBarang as $key => $value) {
            $saldoAwal = $this->modelMasterPersediaan->saldoAwal($value['kode_barang'], $post);
            if ($saldoAwal == null) {
                $saldoAwal['qty_awal'] = 0;
                $saldoAwal['saldo_awal'] = 0;
                $saldoAwal['harga_awal'] = 0;
            }

            $saldoMasuk = $this->modelMasterPersediaan->saldoMasuk($value['kode_barang'], $post);

            $saldoKeluar = $this->modelMasterPersediaan->saldoKeluar($value['kode_barang'], $post);

            $saldoCart = $this->modelMasterPersediaan->saldoCart($value['kode_barang'], $post);
            $saldoCartPo = $this->modelMasterPersediaan->saldoCartPo($value['kode_barang'], $post);

            $saldoAkhir = $this->modelMasterPersediaan->saldoAkhir($saldoAwal, $saldoMasuk, $saldoKeluar, $saldoCart, $saldoCartPo);

            $value['saldo_awal'] = $saldoAwal;

            $value['saldo_masuk'] = $saldoMasuk;

            $value['saldo_keluar'] = $saldoKeluar;
            $value['saldo_cart'] = $saldoCart;
            $value['saldo_cart_po'] = $saldoCartPo;
            $value['saldo_akhir'] = $saldoAkhir;
            if ($saldoAkhir !== 0) {
                $output['data'][] = $value;
            }
        }

        $output = json_encode($output);
        echo $output;
    }

    // VIEW
    public function index()
    {
        if ($this->session->userdata('role') == "1") {
            redirect(base_url("dashboard/kasir"));
        }
        if ($this->session->userdata('role') == "2") {
            redirect(base_url("dashboard/admin"));
        }
        if ($this->session->userdata('role') == "3") {
            redirect(base_url("dashboard/sales"));
        }
        if ($this->session->userdata('role') == "4") {
            redirect(base_url("dashboard/supervisor"));
        }
        if ($this->session->userdata('role') == "5") {
            redirect(base_url("dashboard/manajer"));
        }
        if ($this->session->userdata('role') == "6") {
            redirect(base_url("dashboard/superuser"));
        }
    }
    public function cekcek()
    {
        print_r($this->session->userdata());
    }

    public function kasir()
    {
        $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();
        $data['menu'] = $this->modelSetting->data_menu();
        $data['css'] = 'dashboard/kasir/dashboard_css';
        if ($this->session->userdata('role') != "1") {
            redirect(base_url("dashboard"));
        } else {
            $this->load->view('template/template_header', $data);
            $this->load->view('template/template_menu', $data);
            $this->load->view('dashboard/kasir/dashboard', $data);
            $this->load->view('template/template_right');
            $this->load->view('dashboard/kasir/dashboard_modal');
            $this->load->view('template/template_footer');
            $this->load->view('template/template_js');
            $this->load->view('dashboard/kasir/dashboard_js');
            $this->load->view('template/template_app_js');
        }
    }

    public function admin()
    {
        $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();
        $data['menu'] = $this->modelSetting->data_menu();
        $data['css'] = 'dashboard/admin/dashboard_css';
        if ($this->session->userdata('role') != "2") {
            redirect(base_url("dashboard"));
        } else {
            $this->load->view('template/template_header', $data);
            $this->load->view('template/template_menu', $data);
            $this->load->view('dashboard/admin/dashboard', $data);
            $this->load->view('template/template_right');
            $this->load->view('template/template_footer');
            $this->load->view('template/template_js');
            $this->load->view('dashboard/admin/dashboard_js');
            $this->load->view('template/template_app_js');
        }
    }

    public function sales()
    {
        $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();
        $data['menu'] = $this->modelSetting->data_menu();
        $data['css'] = 'dashboard/sales/dashboard_css';
        if ($this->session->userdata('role') != "3") {
            redirect(base_url("dashboard"));
        } else {
            $this->load->view('template/template_header', $data);
            $this->load->view('template/template_sales/template_menu_sales');
            $this->load->view('dashboard/sales/dashboard', $data);
            $this->load->view('template/template_right');
            $this->load->view('template/template_footer');
            $this->load->view('template/template_js');
            $this->load->view('dashboard/sales/dashboard_js');
            $this->load->view('template/template_app_js');
        }
    }

    public function supervisor()
    {
        $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();
        $data['menu'] = $this->modelSetting->data_menu();
        $data['css'] = 'dashboard/supervisor/dashboard_css';
        if ($this->session->userdata('role') != "4") {
            redirect(base_url("dashboard"));
        } else {
            $this->load->view('template/template_header', $data);
            $this->load->view('template/template_menu', $data);
            $this->load->view('dashboard/supervisor/dashboard', $data);
            $this->load->view('template/template_right');
            $this->load->view('template/template_footer');
            $this->load->view('template/template_js');
            $this->load->view('dashboard/supervisor/dashboard_js');
            $this->load->view('template/template_app_js');
        }
    }

    public function manajer()
    {

        $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();
        $data['menu'] = $this->modelSetting->data_menu();
        $data['css'] = 'dashboard/manajer/dashboard_css';

        if ($this->session->userdata('role') != "5") {
            redirect(base_url("dashboard"));
        } else {
            $data['sales'] = $this->modelDashboard->getDataSales();
            $this->load->view('template/template_header', $data);
            $this->load->view('template/template_menu', $data);
            $this->load->view('dashboard/manajer/dashboard', $data);
            $this->load->view('template/template_right');
            $this->load->view('dashboard/kasir/dashboard_modal');
            $this->load->view('template/template_footer');
            $this->load->view('template/template_js');
            $this->load->view('dashboard/manajer/dashboard_js');
            $this->load->view('dashboard/manajer/dashboard_notif_js');
            $this->load->view('template/template_app_js');
        }
    }

    public function superuser()
    {

        $data['setting_perusahaan'] = $this->modelSetting->get_data_perusahaan();
        $data['menu'] = $this->modelSetting->data_menu();

        $data['css'] = 'dashboard/manajer/dashboard_css';

        if ($this->session->userdata('role') != "6") {
            redirect(base_url("dashboard"));
        } else {

            $data['sales'] = $this->modelDashboard->getDataSales();
            $this->load->view('template/template_header', $data);
            $this->load->view('template/template_menu', $data);
            $this->load->view('template/template_right');
            $this->load->view('template/template_footer');
            $this->load->view('template/template_js');
            $this->load->view('dashboard/manajer/dashboard_js');
            $this->load->view('template/template_app_js');
        }
    }

    // manajer

}
