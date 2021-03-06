<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Piutang extends CI_Model
{

    function get_data_piutang($post)
    {
        $periode = $this->modelSetting->get_data_periode();

        $this->db->select('*, master_user.nama as nama_pegawai, DATE_FORMAT(master_piutang.tanggal_jatuh_tempo, "%d %b %Y") as tanggal_tempo, DATE_FORMAT(master_piutang.tanggal_input, "%d %b %Y") as tanggal');
        $this->db->from('master_piutang');
        $this->db->join('master_user', 'master_user.username = master_piutang.user');
        $this->db->where('tanggal_input >=', date('Y-m-d', strtotime($post['tanggal_awal'])));
        $this->db->where('tanggal_input <=', date('Y-m-d', strtotime($post['tanggal_akhir'])));
        $this->db->where('master_piutang.periode', $periode);
        $this->db->order_by('tanggal_input', 'DESC');
        $output = $this->db->get();
        return $output;
    }

    function get_data_sales($nomor_faktur)
    {
        $this->db->select('master_penjualan.sales,master_user.nama as nama_sales');
        $this->db->from('master_penjualan');
        $this->db->join('master_user', 'master_user.username = master_penjualan.sales');
        $this->db->where('no_faktur', $nomor_faktur);
        $output = $this->db->get()->row_array();
        if (!isset($output)) {
            return "";
        } else {
            return $output['nama_sales'];
        }
    }

    function get_data_pelanggan($nomor_faktur)
    {
        $this->db->select('master_pelanggan.nama_pelanggan as nama_pelanggan');
        $this->db->from('master_penjualan');
        $this->db->join('master_piutang', 'master_piutang.no_faktur = master_penjualan.no_faktur');
        $this->db->join('master_pelanggan', 'master_pelanggan.id_pelanggan = master_penjualan.id_pelanggan');
        $this->db->where('master_penjualan.no_faktur', $nomor_faktur);
        $output = $this->db->get()->row_array();
        return $output['nama_pelanggan'];
    }

    function get_data_detail_piutang($nomor_faktur)
    {
        $this->db->select('*');
        $this->db->from('master_piutang');
        $this->db->where('no_faktur', $nomor_faktur);
        $output = $this->db->get()->row_array();
        return $output;
    }

    function datapembayaran($post)
    {
        $periode = $this->modelSetting->get_data_periode();
        
        $this->db->select('*, master_user.nama as nama_pegawai, DATE_FORMAT(detail_piutang.tanggal, "%d %b %Y") as tanggal');
        $this->db->from('detail_piutang');
        $this->db->join('master_user', 'master_user.username = detail_piutang.user');
        $this->db->where('detail_piutang.tanggal >=', date('Y-m-d', strtotime($post['tanggal_awal'])));
        $this->db->where('detail_piutang.tanggal <=', date('Y-m-d', strtotime($post['tanggal_akhir'])));
        $this->db->where('detail_piutang.periode', $periode);
        $this->db->order_by('detail_piutang.tanggal', 'DESC');
        $output = $this->db->get();
        return $output;
    }


    function get_detail_pembayaran($nomor_faktur)
    {
        $this->db->select('*, DATE_FORMAT(tanggal, "%d %b %Y") as tanggal');
        $this->db->from('detail_piutang');
        $this->db->where('nomor_faktur', $nomor_faktur);
        $this->db->order_by('detail_piutang.tanggal', 'ASC');
        return $this->db->get();
    }

    function tambah_pembayaran($post)
    {
        $nominal_pembayaran = str_replace(".", "", $post['nominal_pembayaran']);
        $nominal_pembayaran = str_replace("Rp ", "", $nominal_pembayaran);
        $data = [
            'nomor_faktur' => $post['nomor_faktur'],
            'tanggal' => date('Y-m-d H:i:s', strtotime($post['tanggal'])),
            'nominal_pembayaran' => $nominal_pembayaran,
            'sisa_piutang' => $this->_sisa_piutang($post['nomor_faktur'], $nominal_pembayaran),
            'keterangan' => $post['keterangan'],
            'user' => $this->session->userdata['username'],
            'bukti' => $this->_uploadBukti(),
        ];
        $this->db->insert('detail_piutang', $data);
    }

    function update_master($post)
    {
        $total_pembayaran = $this->_total_pembayaran($post['nomor_faktur']);
        $this->db->select('total_tagihan');
        $this->db->from('master_piutang');
        $this->db->where('no_faktur', $post['nomor_faktur']);
        $total_tagihan = $this->db->get()->row_array();

        $data = [
            'total_pembayaran' => $total_pembayaran,
            'sisa_piutang' => $total_tagihan['total_tagihan']  - $total_pembayaran,
        ];

        $this->db->where('no_faktur', $post['nomor_faktur']);
        $this->db->update('master_piutang', $data);
    }

    private function _sisa_piutang($nomor_faktur, $nominal_pembayaran)
    {
        $this->db->select('sisa_piutang');
        $this->db->from('master_piutang');
        $this->db->where('no_faktur', $nomor_faktur);
        $data = $this->db->get()->row_array();
        $sisa_piutang = $data['sisa_piutang'];

        $output =  $sisa_piutang - $nominal_pembayaran;
        if ($output == 0) {
            $this->_ganti_status($nomor_faktur);
        }
        return $output;
    }

    private function _ganti_status($nomor_faktur)
    {
        $data = [
            'status_bayar' => 1,
        ];
        $this->db->where('no_faktur', $nomor_faktur);
        $this->db->update('master_penjualan', $data);
    }

    private function _total_pembayaran($nomor_faktur)
    {
        $this->db->select_sum('nominal_pembayaran');
        $this->db->from('detail_piutang');
        $this->db->where('nomor_faktur', $nomor_faktur);
        $output = $this->db->get()->row_array();

        return $output['nominal_pembayaran'];
    }

    private function _uploadBukti()
    {
        $config['upload_path'] = './assets/upload/bukti/piutang/';
        $config['allowed_types'] = 'jpeg|jpg|png|pdf';
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $config['max_size'] = 4096; // 4MB
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('bukti')) {
            echo  $this->upload->display_errors();

            return $this->upload->data('file_name');
        } else {
            echo  $this->upload->display_errors();

            return "";
        }
    }

    function saldo_piutang()
    {
        $periode = $this->modelSetting->get_data_periode();

        $this->db->select_sum('sisa_piutang');
        $this->db->from('master_piutang');
        $this->db->where('periode', $periode);
        $output = $this->db->get()->row_array();
        return $output['sisa_piutang'];
    }

    function saldo_piutang_detail($nomor_faktur)
    {
        $this->db->select('sisa_piutang');
        $this->db->from('master_piutang');
        $this->db->where('no_faktur', $nomor_faktur);
        $output = $this->db->get()->row_array();
        return $output['sisa_piutang'];
    }

    function status_bayar($nomor_faktur)
    {
        $this->db->select('status_bayar');
        $this->db->from('master_penjualan');
        $this->db->where('no_faktur', $nomor_faktur);
        $output = $this->db->get()->row_array();
        return $output['status_bayar'];
    }

    function set_lampiran($id)
    {
        $data = array(
            'bukti' => $this->_uploadBukti(),
        );
        $this->db->where('id', $id);
        $this->db->update('detail_piutang', $data);
    }

    function delete_data($id)
    {
        $this->db->select('nominal_pembayaran, nomor_faktur');
        $this->db->from('detail_piutang');
        $this->db->where('id', $id);
        $data = $this->db->get()->row_array();

        $nominal_pembayaran = $data['nominal_pembayaran'];
        $data_utang = $this->_carisisapiutang($data['nomor_faktur']);

        $data = array(
            'total_pembayaran' => $data_utang['total_pembayaran'] - $nominal_pembayaran,
            'sisa_piutang' => $data_utang['sisa_piutang'] + $nominal_pembayaran,
        );
        $this->db->where('no_faktur', $data_utang['no_faktur']);
        $this->db->update('master_piutang', $data);

        $this->_delete_lampiran($id);
        $this->db->where('id', $id);
        $this->db->delete('detail_piutang');
    }

    private function _carisisapiutang($nomor_faktur)
    {
        $this->db->select('*');
        $this->db->from('master_piutang');
        $this->db->where('no_faktur', $nomor_faktur);
        $output = $this->db->get()->row_array();

        if ($output['sisa_piutang'] == 0) {
            $data = [
                'status_bayar' => 0,
            ];
            $this->db->where('no_faktur', $nomor_faktur);
            $this->db->update('master_penjualan', $data);
        }
        return $output;
    }

    private function _delete_lampiran($id)
    {
        // delete image

        $this->db->select('*');
        $this->db->from('detail_piutang');
        $this->db->where('id', $id);
        $data = $this->db->get()->row_array();
        $data = $data['bukti'];
        if ($data !== "") {
            unlink('./assets/upload/bukti/piutang/' . $data);
        } else {
        }
    }
}
