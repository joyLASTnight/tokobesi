<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Manajemen_Penjualan/Model_Invoice', 'modelInvoice');
        $this->load->model('Setting/Model_Setting', 'modelSetting');
        $this->load->library('pdf');
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
    }

    function index(){
        $setting_perusahaan = $this->modelSetting->get_data_perusahaan();
        $no_order_penjualan = "OUT2735891";
        $data_order = $this->modelInvoice->get_data_order($no_order_penjualan);
        $detail_order = $this->modelInvoice->get_detail_order($no_order_penjualan);

        $tanggal_transaksi = $this->tgl_indo(date("Y-m-d-D", strtotime($data_order['tanggal_transaksi'])));


        $pdf = new FPDF('p','mm','letter');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',11);
        // mencetak string
        
        $pdf->Cell(100,6,$setting_perusahaan['nama_perusahaan'],0,0,'L');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(96,6,'Faktur Penjualan',0,1,'R');
        $pdf->MultiCell(60,5,nl2br($setting_perusahaan['alamat_perusahaan']),0,'J');
        
        $pdf->Cell(100,5,'Telp : '.$setting_perusahaan['nomor_telepon'].' / Fax : '.$setting_perusahaan['nomor_fax'],0,1,'L');
        
        $pdf->Cell(100,5,'Email : '.$setting_perusahaan['alamat_email'],0,1,'L');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,5,'',0,1);
        $pdf->Line(206,35,11,35);
 
        $pdf->Cell(30,5,'Nama Pelanggan',0,0);
        $pdf->Cell(5,5,':',0,0);
        $pdf->Cell(50,5,$data_order['nama_pelanggan'],0,0);
        $pdf->Cell(45);
        $pdf->Cell(30,5,'Nomor Faktur',0,0);
        $pdf->Cell(5,5,':',0,0);
        $pdf->Cell(50,5,$data_order['no_faktur'],0,1);
        
        $pdf->Cell(30,5,'Alamat',0,0);
        $pdf->Cell(5,5,':',0,0);
        $pdf->Cell(50,5,$data_order['alamat'],0,0);
        $pdf->Cell(45);
         $pdf->Cell(30,5,'Tanggal Faktur',0,0);
        $pdf->Cell(5,5,':',0,0);
        $pdf->Cell(50,5,$tanggal_transaksi,0,1);
        
        // header
        $pdf->Line(206,47,11,47);
        $pdf->Cell(10,5,'',0,1);
        $pdf->SetFont('Arial','B',7);
        
        $pdf->Cell(7,6,'#',1,0);
        $pdf->Cell(25,6,'Kode Barang',1,0);
        $pdf->Cell(60,6,'Nama Barang',1,0);
        $pdf->Cell(15,6,'Satuan',1,0);
        $pdf->Cell(20,6,'Harga',1,0);
        $pdf->Cell(15,6,'Qty',1,0);
        $pdf->Cell(20,6,'Diskon',1,0);
        $pdf->Cell(35,6,'Total',1,1);
        $pdf->SetFont('Arial','',7);
        
        // foreach ($detail_order as $row){
        //     $pdf->Cell(20,6,$row->nim,1,0);
        //     $pdf->Cell(85,6,$row->nama_lengkap,1,0);
        //     $pdf->Cell(27,6,$row->no_hp,1,0);
        //     $pdf->Cell(25,6,$row->tanggal_lahir,1,1); 
        // }
        $no = 0;
        foreach ($detail_order as $key => $value) {
            $no++;
            
            $pdf->Cell(7,6,$no,1,0);
            $pdf->Cell(25,6,$value['kode_barang'],1,0);
            $pdf->Cell(60,6,$value['nama_barang'],1,0);
            $pdf->Cell(15,6,$value['kode_satuan'],1,0); 
            $pdf->Cell(20,6,$this->rupiah($value['harga_jual']),1,0); 
            $pdf->Cell(15,6,$value['jumlah_penjualan'],1,0); 
            $pdf->Cell(20,6,$this->rupiah($value['diskon']),1,0); 
            $pdf->Cell(35,6,$this->rupiah($value['total_harga']),1,1); 
        }

        $pdf->Cell(10,7,'',0,1);
        
        $pdf->SetFont('Arial','U',8);
        $pdf->Cell(30,6,'Note',1,0);
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(100);
        $pdf->Cell(30,6,'Sub Total',1,0);
        $pdf->Cell(5,6,':',1,0);
        $pdf->Cell(20,6,$data_order['total_penjualan'],1,1);
        
        $pdf->Cell(90,6,nl2br($setting_perusahaan['catatan_faktur_cash']),1,0);
        $pdf->Cell(145);
        $pdf->Cell(30,6,'Alamat',0,0);
        $pdf->Cell(5,6,':',0,0);
        $pdf->Cell(50,6,$data_order['alamat'],0,1);



        $pdf->Output();

    }

    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }

    function tgl_indo($tanggal)
                {
                    $bulan = array(
                        1 =>   'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember'
                    );
                    $pecahkan = explode('-', $tanggal);

                    // variabel pecahkan 0 = tanggal
                    // variabel pecahkan 1 = bulan
                    // variabel pecahkan 2 = tahun

                    switch ($pecahkan[3]) {
                        case 'Sun':
                            $hari_ini = "Minggu";
                            break;

                        case 'Mon':
                            $hari_ini = "Senin";
                            break;

                        case 'Tue':
                            $hari_ini = "Selasa";
                            break;

                        case 'Wed':
                            $hari_ini = "Rabu";
                            break;

                        case 'Thu':
                            $hari_ini = "Kamis";
                            break;

                        case 'Fri':
                            $hari_ini = "Jumat";
                            break;

                        case 'Sat':
                            $hari_ini = "Sabtu";
                            break;

                        default:
                            $hari_ini = "Tidak di ketahui";
                            break;
                    }

                    return $hari_ini . ', ' . $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
                }

}