<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Pembelian_Barang extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'string'));
    }

    public function get_data_keranjang_clear($no_order)
    {
        //  cek dulu apakah sudah di save apa blm

        $this->db->where('no_order_pembelian', $no_order);
        $this->db->delete('temp_tabel_keranjang_pembelian');

        $this->db->where('no_order', $no_order);
        $this->db->delete('tabel_perhitungan_order');

        $data['no_order_pembelian'] = $no_order;
        $this->_delete_detail_pembelian_temp($data);
    }

    function get_data_supplier()
    {
        $this->db->select('*');
        $this->db->from('master_supplier');
        return $this->db->get()->result_array();
    }

    function get_data_barang($string)
    {
        if ($string == null) {
            $this->db->select('master_persediaan.*, master_barang.*, master_satuan_barang.nama_satuan');
            $this->db->from('master_persediaan');
            $this->db->join('master_barang', 'master_barang.kode_barang = master_persediaan.kode_barang');
            $this->db->join('master_satuan_barang', 'master_satuan_barang.id_satuan = master_barang.kode_satuan');
            $output = $this->db->get();
            return $output;
        } else {
            $this->db->select('master_persediaan.*, master_barang.*, master_satuan_barang.nama_satuan');
            $this->db->from('master_persediaan');
            $this->db->join('master_barang', 'master_barang.kode_barang = master_persediaan.kode_barang');
            $this->db->join('master_satuan_barang', 'master_satuan_barang.id_satuan = master_barang.kode_satuan');
            $this->db->like("master_persediaan.kode_barang", $string);
            $this->db->or_like("nama_barang", $string);
            $output = $this->db->get();
            return $output;
        }
    }

    function push_data_barang()
    {
        $post = $this->input->post();
        $data = [
            'no_order_pembelian' => $post['no_order_pembelian'],
            'tanggal_transaksi' => date('Y-m-d H:i:s', strtotime($post['tanggal_transaksi'] . date("His"))),
            'kode_barang' => $post['kode_barang'],
            'jumlah_pembelian' => $post["jumlah_pembelian"],
            'harga_beli' => $post["harga_beli"],
            'diskon' => $post["diskon"],
            'total_harga' => $post["harga_beli"] * $post['jumlah_pembelian'] - $post['diskon'],
            'tanggal_input' => date("Y-m-d H:i:s"),
        ];
        $this->db->insert('temp_tabel_keranjang_pembelian', $data);
    }

    function push_total_perhitungan($post)
    {

        $this->db->select_sum('diskon');
        $this->db->where('no_order_pembelian', $post['no_order_pembelian']);
        $diskon = $this->db->get('temp_tabel_keranjang_pembelian')->row_array();

        $this->db->select_sum('total_harga');
        $this->db->where('no_order_pembelian', $post['no_order_pembelian']);
        $total_harga = $this->db->get('temp_tabel_keranjang_pembelian')->row_array();

        $total_keranjang = $total_harga['total_harga'] + $diskon['diskon'];

        $grand_total = (($total_keranjang - $diskon['diskon']) + $post['pajak']) + $post['ongkir'];

        $this->db->select('*');
        $this->db->from('tabel_perhitungan_order');
        $this->db->where('no_order', $post['no_order_pembelian']);
        $cek = $this->db->get()->num_rows();

        $data = array(
            'no_order' => $post['no_order_pembelian'],
            'total_keranjang' => $total_keranjang,
            'diskon' => $diskon['diskon'],
            'pajak' => $post['pajak'],
            'ongkir' => $post['ongkir'],
            'grand_total' => $grand_total
        );

        if ($cek < 1) {
            $this->db->insert('tabel_perhitungan_order', $data);
        } else {
            $this->db->query("DELETE From tabel_perhitungan_order Where no_order = '" . $post['no_order_pembelian'] . "'"); // delete dulu
            $this->db->insert('tabel_perhitungan_order', $data); // lalu tambah
        }
    }

    function get_data_keranjang($no_order_pembelian)
    {
        $this->db->select('temp_tabel_keranjang_pembelian.*, master_barang.*');
        $this->db->from('temp_tabel_keranjang_pembelian');
        $this->db->join('master_barang', 'master_barang.kode_barang = temp_tabel_keranjang_pembelian.kode_barang');
        $this->db->where('no_order_pembelian', $no_order_pembelian);
        $output = $this->db->get();
        return $output;
    }

    function delete_data_keranjang($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('temp_tabel_keranjang_pembelian');
    }

    function push_grand_total($post)
    {
        $this->db->select('*');
        $this->db->from('tabel_perhitungan_order');
        $this->db->where('no_order', $post['no_order_pembelian']);
        $cek = $this->db->get()->num_rows();
        $data = array(
            'no_order' => $post['no_order_pembelian'],
            'total_keranjang' => $post['total_pembelian'],
            'diskon' => $post['diskon'],
            'pajak' => $post['pajak_keluaran'],
            'ongkir' => 0,
            'grand_total' => $post['grand_total']
        );
        if ($cek < 1) {
            $this->db->insert('tabel_perhitungan_order', $data);
        } else {
            $this->db->query("DELETE From tabel_perhitungan_order Where no_order = '" . $post['no_order_pembelian'] . "'"); // delete dulu
            $this->db->insert('tabel_perhitungan_order', $data); // lalu tambah
        }
    }

    function get_total_perhitungan($no_order)
    {
        $this->db->select('*');
        $this->db->from('tabel_perhitungan_order');
        $this->db->where('no_order', $no_order);
        $output = $this->db->get()->row_array();
        return $output;
    }

    function get_sum_keranjang($no_order)
    {
        $this->db->select_sum('diskon');
        $this->db->where('no_order_pembelian', $no_order);
        $diskon = $this->db->get('temp_tabel_keranjang_pembelian')->row_array();

        $this->db->select_sum('total_harga');
        $this->db->where('no_order_pembelian', $no_order);
        $total_harga = $this->db->get('temp_tabel_keranjang_pembelian')->row_array();
        $output = array(
            "total_pembelian" => $total_harga['total_harga'] + $diskon['diskon'],
            "diskon" => $diskon['diskon'],
            "total_harga" => $total_harga['total_harga']
        );

        return $output;
    }


    function proses_tunai($post)
    {
        $data = array(
            'no_order_pembelian' => $post['no_order_pembelian'],
            'nomor_transaksi' => $post['nomor_transaksi'],
            'tanggal_transaksi' => date('Y-m-d H:i:s', strtotime($post['tanggal_transaksi'] . date("His"))),
            'kode_supplier' => $post['kode_supplier'],
            'tanggal_input' =>  date("Y-m-d H:i:s"),
            'status_bayar' => 1, // 1 untuk lunas 0 untuk nyicil cashbon
            'user' => $this->session->userdata['username'],
        );

        $this->db->insert('master_pembelian', $data);

        // update data total pembelian
        $this->db->query("UPDATE master_pembelian INNER JOIN tabel_perhitungan_order ON tabel_perhitungan_order.no_order = master_pembelian.no_order_pembelian SET master_pembelian.total_pembelian = tabel_perhitungan_order.total_keranjang, master_pembelian.diskon = tabel_perhitungan_order.diskon, master_pembelian.pajak_keluaran = tabel_perhitungan_order.pajak, master_pembelian.ongkir = tabel_perhitungan_order.ongkir, master_pembelian.grand_total = tabel_perhitungan_order.grand_total where  tabel_perhitungan_order.no_order = '" . $post['no_order_pembelian'] . "'");


        $this->_tambah_detail_pembelian($post);

        // $this->_tambah_data_persediaan($post);

        $this->_tambah_detail_persediaan($post);

        $this->_delete_detail_pembelian_temp($post);

        echo "ayee";
    }

    function proses_kredit($post)
    {
        $data = array(
            'no_order_pembelian' => $post['no_order_pembelian'],
            'nomor_transaksi' => $post['nomor_transaksi'],
            'tanggal_transaksi' => date('Y-m-d H:i:s', strtotime($post['tanggal_transaksi'])),
            'kode_supplier' => $post['kode_supplier'],
            'tanggal_input' =>  date("Y-m-d H:i:s"),
            'status_bayar' => 0, // 1 untuk lunas 0 untuk nyicil cashbon
            'user' => $this->session->userdata['username'],
        );

        $this->db->insert('master_pembelian', $data);

        // update data total pembelian
        $this->db->query("UPDATE master_pembelian INNER JOIN tabel_perhitungan_order ON tabel_perhitungan_order.no_order = master_pembelian.no_order_pembelian SET master_pembelian.total_pembelian = tabel_perhitungan_order.total_keranjang, master_pembelian.diskon = tabel_perhitungan_order.diskon, master_pembelian.pajak_keluaran = tabel_perhitungan_order.pajak, master_pembelian.ongkir = tabel_perhitungan_order.ongkir, master_pembelian.grand_total = tabel_perhitungan_order.grand_total where  tabel_perhitungan_order.no_order = '" . $post['no_order_pembelian'] . "'");


        $this->_tambah_detail_pembelian($post);
        $this->_delete_detail_pembelian_temp($post);
        // $this->_tambah_data_persediaan($post);
        // $this->_tambah_detail_persediaan($post);
        $this->_proses_kredit($post);
    }


    private function _proses_kredit($post)
    {
        $this->db->select('grand_total');
        $this->db->from('master_pembelian');
        $this->db->where('nomor_transaksi', $post['nomor_transaksi']);
        $grand_total = $this->db->get()->row_array();
        $sisa_pembayaran = $grand_total['grand_total'] - $post['down_payment'];

        $data = array(
            'nomor_transaksi' => $post['nomor_transaksi'],
            'tanggal_jatuh_tempo' => date('Y-m-d H:i:s', strtotime($post['tanggal_jatuh_tempo'])),
            'down_payment' => $post['down_payment'],
            'sisa_utang' => $sisa_pembayaran,
            'tanggal_input' =>  date("Y-m-d H:i:s"),
            'user' => $this->session->userdata['username'],
        );
        $this->db->insert('master_utang', $data);
    }

    private function _tambah_detail_pembelian($post)
    {
        $nomor_transaksi = $post['nomor_transaksi'];

        $this->db->query("INSERT INTO `detail_pembelian`(`nomor_transaksi`,`tanggal_transaksi`, `no_order_pembelian`, `kode_barang`, `jumlah_pembelian`,`harga_beli`,`diskon`,`total_harga`,`tanggal_input`,`saldo`) SELECT '" .  $nomor_transaksi . "', `tanggal_transaksi`, `no_order_pembelian`, `kode_barang`, `jumlah_pembelian`,`harga_beli`,`diskon`,`total_harga`,`tanggal_input`,`jumlah_pembelian` FROM temp_tabel_keranjang_pembelian WHERE no_order_pembelian = '" . $post['no_order_pembelian'] . "'");
    }

    private function _delete_detail_pembelian_temp($post)
    {
        $this->db->where('no_order_pembelian', $post['no_order_pembelian']);
        $this->db->delete('temp_tabel_keranjang_pembelian');
    }

    private function _tambah_data_persediaan($post)
    {
        $this->db->select('*');
        $this->db->from('detail_pembelian');
        $this->db->where('no_order_pembelian', $post['no_order_pembelian']);
        $data = $this->db->get()->result_array();

        foreach ($data as $key => $value) {
            $this->db->select('*');
            $this->db->from('master_persediaan');
            $this->db->where('kode_barang', $value['kode_barang']);
            $jumlah_lama = $this->db->get()->row_array();

            $update = [
                'jumlah_persediaan' => $value['jumlah_pembelian'] + $jumlah_lama['jumlah_persediaan'],
                'tanggal_input' => date("Y-m-d H:i:s"),
            ];
            $this->db->where('kode_barang', $value['kode_barang']);
            $this->db->update('master_persediaan', $update);
        }
    }

    private function _tambah_detail_persediaan($post)
    {
        $this->db->query("INSERT INTO `detail_persediaan`(`tanggal_transaksi`, `nomor_transaksi`, `kode_barang`, `jumlah`,`harga_beli`,`saldo`) SELECT `tanggal_transaksi`, `nomor_transaksi`, `kode_barang`, `jumlah_pembelian`,`harga_beli`, `jumlah_pembelian` FROM detail_pembelian WHERE nomor_transaksi = '" . $post['nomor_transaksi'] . "'");
    }
}
