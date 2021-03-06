<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Retur_Pembelian extends CI_Model
{

    function get_data($post)
    {
        $no_faktur = $post['nomor_transaksi'];
        $this->db->select('*');
        $this->db->from('master_pembelian');
        $this->db->join('master_supplier', 'master_supplier.kode_supplier = master_pembelian.kode_supplier');
        $this->db->where('nomor_transaksi', $no_faktur);
        $output = $this->db->get()->row_array();
        return $output;
    }

    function get_detail_data($post)
    {
        $no_faktur = $post['nomor_transaksi'];
        $this->db->select('*');
        $this->db->from('detail_pembelian');
        $this->db->join('master_barang', 'master_barang.kode_barang = detail_pembelian.kode_barang');
        $this->db->where('nomor_transaksi', $no_faktur);
        $output = $this->db->get()->result_array();
        return $output;
    }

    function tambah_data_master($post)
    {
        $cekDouble = $this->cek_double($post['nomor_transaksi']);

        if ($cekDouble > 0) {
            $this->db->where('nomor_transaksi', 'RTR-' . $post['nomor_transaksi']);
            $this->db->delete('master_retur_pembelian');
        }
        $data = [
            "nomor_transaksi" => 'RTR-' . $post['nomor_transaksi'],
            "nomor_transaksi_asli" => $post['nomor_transaksi'],
            "kode_supplier" => $post['kode_supplier'],
            "retur_total" => $post['retur_total'],
            "retur_diskon" => $post['retur_diskon'],
            "retur_pajak" => $post['retur_pajak'],
            "retur_grand_total" => $post['retur_grand_total'],
            'tanggal_transaksi' => date('Y-m-d H:i:s', strtotime($post['tanggal_transaksi'])),
            'user' => $this->session->userdata['username'],
            'periode'=>$this->modelSetting->get_data_periode()

        ];
        $this->db->insert('master_retur_pembelian', $data);
    }

    function tambah_data_detail($post)
    {
        $nomor_transaksi = $this->cek_last_faktur();
        $data = [
            "id_detail_pembelian" => $post['id_detail_pembelian'],
            "nomor_transaksi" => 'RTR-' . $post['nomor_transaksi'],
            "kode_barang" => $post['kode_barang'],
            "keterangan" => $post['keterangan'],
            "jumlah_retur" => $post['qty'],
            "harga_retur" => $this->normal($post['harga']),
            "diskon" => $post['diskon'],
            "total_retur" => $post['retur_total'],
            'tanggal_transaksi' => date('Y-m-d H:i:s', strtotime($post['tanggal_transaksi'])),
            'user' => $this->session->userdata['username'],
            'periode'=>$this->modelSetting->get_data_periode()

        ];
        $this->db->insert('detail_retur_pembelian', $data);

        $this->_debet_persediaan($post);
    }

    private function _debet_persediaan($post){
        $this->db->select('*');
        $this->db->from('detail_pembelian');
        $this->db->where('id', $post['id_detail_pembelian']);
        $data = $this->db->get()->row_array();
        $saldo = $data['saldo'];

        $data = [
            'saldo' => $saldo - $post['qty']
        ];

        $this->db->where('id', $post['id_detail_pembelian']);
        $this->db->update('detail_pembelian', $data);

    }

    private function cek_double($nomor_transaksi)
    {
        $this->db->select('nomor_transaksi');
        $this->db->from('master_retur_pembelian');
        $this->db->where('nomor_transaksi', 'RTR-' . $nomor_transaksi);
        return $this->db->get()->num_rows();
    }

    private function cek_last_faktur()
    {
        $this->db->select('nomor_transaksi');
        $this->db->from('master_retur_pembelian');
        $this->db->order_by('tanggal', 'ASC');
        $data = $this->db->get()->row_array();
        return $data['nomor_transaksi'];
    }

    function get_data_retur($post)
    {
        $periode = $this->modelSetting->get_data_periode();

        $this->db->select('master_retur_pembelian.*,master_supplier.nama_supplier, master_user.nama as nama_pegawai ');
        $this->db->from('master_retur_pembelian');
        $this->db->join('master_supplier', 'master_supplier.kode_supplier = master_retur_pembelian.kode_supplier');
        $this->db->join('master_user', 'master_user.username = master_retur_pembelian.user');
        $this->db->where('tanggal >=', date('Y-m-d', strtotime($post['tanggal_awal'])));
        $this->db->where('tanggal <=', date('Y-m-d', strtotime($post['tanggal_akhir'])));
        $this->db->where('master_retur_pembelian.periode', $periode);
        $this->db->order_by('tanggal', 'DESC');
        $output = $this->db->get();
        return $output;
    }


    function delete_data($nomor_transaksi)
    {

        $this->db->select('*');
        $this->db->from('detail_retur_pembelian');
        $this->db->where('nomor_transaksi', $nomor_transaksi);
        $output = $this->db->get()->result_array();

        foreach ($output as $key => $value) {
            $this->db->select('*');
            $this->db->from('detail_pembelian');
            $this->db->where('id', $value['id_detail_pembelian']);
            $data = $this->db->get()->row_array();
            $saldo = $data['saldo'];

            $update = [
                'saldo' => $saldo + $value['jumlah_retur']
            ];
            $this->db->where('id', $value['id_detail_pembelian']);
            $this->db->update('detail_pembelian', $update);
        }

        $this->db->where('nomor_transaksi', $nomor_transaksi);
        $this->db->delete('master_retur_pembelian');

        return "ok";
    }


    // faktur retur penjualan

    function get_data_faktur($nomor_transaksi) // udah include nominal pembayaran dan status
    {
        $this->db->select('*, master_user.nama as nama_pegawai');
        $this->db->from('master_retur_pembelian');
        $this->db->join('master_user', 'master_user.username = master_retur_pembelian.user');
        $this->db->join('master_supplier', 'master_supplier.kode_supplier = master_retur_pembelian.kode_supplier');
        $this->db->where('nomor_transaksi', $nomor_transaksi);
        return $this->db->get()->row_array();
    }

    function get_detail_faktur($nomor_transaksi)
    {
        $this->db->select('*');
        $this->db->from('detail_retur_pembelian');
        $this->db->join('master_barang', 'master_barang.kode_barang = detail_retur_pembelian.kode_barang');
        $this->db->join('master_satuan_barang', 'master_satuan_barang.id_satuan = master_barang.kode_satuan');
        $this->db->where('nomor_transaksi', $nomor_transaksi);
        return $this->db->get()->result_array();
    }

    function normal($value)
    {
        $value = str_replace("Rp.", "", $value);
        $value = str_replace(".", "", $value);
        return str_replace(",", "", $value);
    }
}
