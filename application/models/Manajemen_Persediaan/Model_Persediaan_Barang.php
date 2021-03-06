<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Persediaan_Barang extends CI_Model
{
    function get_kartu_persediaan_ajax($kode_barang)
    {
        $periode = $this->modelSetting->get_data_periode();
        $query =  $this->db->query("SELECT *, @saldo := @saldo+qty as saldo FROM ( SELECT 'masuk' trans_type, nomor_transaksi as nomor_transaksi, tanggal_transaksi, kode_barang, jumlah_pembelian as qty, harga_beli FROM detail_pembelian WHERE kode_barang = '" . $kode_barang . "' AND periode = '".$periode."' UNION ALL SELECT 'keluar' trans_type, nomor_faktur, tanggal_transaksi, kode_barang, -jumlah_penjualan as qty, harga_jual FROM detail_penjualan WHERE kode_barang = '" . $kode_barang . "' AND periode = '".$periode."' UNION ALL SELECT 'saldo awal' trans_type, nomor_faktur, DATE_FORMAT(tanggal_saldo,'%d-%b-%Y') as tanggal_transaksi, kode_barang, qty_awal, harga_awal FROM master_saldo_awal WHERE kode_barang = '" . $kode_barang . "' AND periode = '".$periode."' UNION ALL SELECT 'masuk' trans_type, nomor_faktur, tanggal_input as tanggal_transaksi, kode_barang, saldo_retur as qty, harga_pokok as harga_beli FROM detail_retur_barang_penjualan WHERE kode_barang = '" . $kode_barang . "' AND periode = '".$periode."' UNION ALL SELECT 'keluar' trans_type, nomor_transaksi, tanggal as tanggal_transaksi, kode_barang, jumlah_retur as qty, harga_retur as harga_beli FROM detail_retur_pembelian WHERE kode_barang = '" . $kode_barang . "' AND periode = '".$periode."' ) tx JOIN ( select @saldo:= 0 ) sx on 1=1 ORDER BY tanggal_transaksi ASC");

        // $query =  $this->db->query("SELECT *, @saldo := @saldo+qty as saldo FROM ( SELECT 'Masuk' trans_type, nomor_transaksi as nomor_transaksi, tanggal_transaksi, kode_barang, jumlah_pembelian as qty, harga_beli FROM detail_pembelian WHERE kode_barang = '" . $kode_barang . "' UNION ALL SELECT 'Keluar' trans_type, nomor_faktur, tanggal_transaksi, kode_barang, -jumlah_penjualan as qty, harga_jual FROM detail_penjualan WHERE kode_barang = '" . $kode_barang . "') tx JOIN ( select @saldo:= 0 ) sx on 1=1 ORDER BY tanggal_transaksi");

        return $query;
    }


    function detail_masuk($kode_barang)
    {
        $this->db->select('*');
        $this->db->from('detail_pembelian');
        $this->db->where('kode_barang',$kode_barang);
        $data = $this->db->get()->row_array();
        $output = [
            'trans_type' => "masuk",
            'nomor_transaksi' => $data['nomor_transaksi'],
            'tanggal_transaksi' => $data['tanggal_transaksi'],
            'nomor_transaksi' => $data['nomor_transaksi'],
            'kode_barang' => $data['kode_barang'],
            'qty' => $data['jumlah_pembelian'],
            'saldo' => $data['jumlah_pembelian'],
        ];
    }


    function get_kartu_persediaan()
    {
        $query =  $this->db->query("SELECT *, @saldo := @saldo+qty as saldo FROM ( SELECT 'Masuk' trans_type, nomor_transaksi as nomor_transaksi, tanggal_transaksi, kode_barang, jumlah_pembelian as qty, harga_beli FROM detail_pembelian WHERE kode_barang = 'K001' UNION ALL SELECT 'Keluar' trans_type, nomor_faktur, tanggal_transaksi, kode_barang, -jumlah_penjualan as qty, harga_jual FROM detail_penjualan WHERE kode_barang = 'K001') tx JOIN ( select @saldo:= 0 ) sx on 1=1 ORDER BY tanggal_transaksi");

        return $query->result_array();
    }

    function get_data_barang($string)
    {
        $this->db->select('*');
        $this->db->from('master_barang');
        $this->db->like('kode_barang', $string);
        $this->db->or_like('nama_barang', $string);
        return $this->db->get();
    }

    function getDetailBarang($kode_barang)
    {
        $this->db->select('*');
        $this->db->from('master_barang');
        $this->db->join('master_satuan_barang', 'master_satuan_barang.id_satuan = master_barang.kode_satuan');
        $this->db->where('kode_barang', $kode_barang);
        return $this->db->get()->row_array();
    }

    function get_data_persediaan($kode_barang)
    {

        // cek saldo awal dulu
        $this->db->select('saldo_awal');
        $this->db->from('master_saldo_awal');
        $this->db->where('kode_barang', $kode_barang);
        $awal = $this->db->get()->row_array();
        if ($awal !== null) {
            $qty_awal = $awal['saldo_awal'];
        } else {
            $qty_awal = 0;
        }

        //cek saldo pembelian
        $this->db->select_sum('saldo');
        $this->db->where('kode_barang', $kode_barang);
        $result = $this->db->get('detail_pembelian')->row();
        $qty_saldo =  $result->saldo;

        // cek saldo retur

        $this->db->select_sum('saldo_tersedia');
        $this->db->where('kode_barang', $kode_barang);
        $result = $this->db->get('detail_retur_barang_penjualan')->row();
        $qty_saldo_retur_penjualan =  $result->saldo_tersedia;

        // $this->db->select_sum('jumlah_penjualan');
        // $this->db->where('kode_barang', $kode_barang);
        // $result = $this->db->get('detail_penjualan')->row();
        // $qty_terjual =  $result->jumlah_penjualan;

        // cek saldo yang ada di keranjang tapi masi temporari
        $this->db->select_sum('jumlah_penjualan');
        $this->db->where('kode_barang', $kode_barang);
        $result = $this->db->get('temp_tabel_keranjang_penjualan')->row();
        $qty_temp =  $result->jumlah_penjualan;


        // data dari purchase order yg masih pending di sales atau admin
        $this->db->select_sum('jumlah_penjualan');
        $this->db->where('kode_barang', $kode_barang);
        $this->db->where('status !=', 99);
        $this->db->where('status !=', 2);
        $result = $this->db->get('temp_purchase_order')->row();
        $qty_po =  $result->jumlah_penjualan;

        return  $qty_awal + ($qty_saldo + $qty_saldo_retur_penjualan) - $qty_temp - $qty_po;
    }
}
