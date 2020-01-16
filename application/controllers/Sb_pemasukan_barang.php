<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb_pemasukan_barang extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		checkLogin();
		$this->load->model('m_sb_barang');
		$this->load->model('m_import_pemasukan');
		$this->load->model('m_sb_login');
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
	}
	
	public function index()
	{
		redirect('Sb_pemasukan_barang/listing');
	}
	
	public function listing()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['nama']=$this->m_sb_login->get_nama();
		$data['periode'] = $this->m_import_pemasukan->get_periode();
		$data['content'] = 'sb_pemasukan_barang/list_pemasukan_barang';
		$this->load->view('template',$data);
	}
	
	public function detail()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['nama']=$this->m_sb_login->get_nama();
		$data['laporan'] = $this->m_import_pemasukan->get_report_laporan_pemasukan();
		$data['content'] = 'sb_pemasukan_barang/report_pemasukan_barang';
		$this->load->view('template',$data);
	}
	
	public function test()
	{
		if($this->input->post('jenis_doc') != ''){
			$jenis_doc = "AND jenis_doc = '".$this->input->post('jenis_doc')."' ";
		}else {
			$jenis_doc = ' ';
		}
		
		if($this->input->post('no_doc') != ''){
			$no_doc = "AND no_doc = '".$this->input->post('no_doc')."' ";
		}else {
			$no_doc = ' ';
		}
		
		if($this->input->post('no_bukti') != ''){
			$no_bukti = "AND no_bukti = '".$this->input->post('no_bukti')."' ";
		}else {
			$no_bukti = ' ';
		}
		
		if($this->input->post('tgl_doc') != '' && $this->input->post('min_tgl_doc') == '' && $this->input->post('max_tgl_doc') == ''){
			$tgl_doc = "AND tgl_doc = '".$this->input->post('tgl_doc')."' ";
		}else {
			$tgl_doc = ' ';
		}
		
		if($this->input->post('tgl_bukti') != '' && $this->input->post('min_tgl_bukti') == '' && $this->input->post('max_tgl_bukti') == ''){
			$tgl_bukti = "AND tgl_bukti = '".$this->input->post('tgl_bukti')."' ";
		}else {
			$tgl_bukti = ' ';
		}
		
		if($this->input->post('tgl_doc') == '' && $this->input->post('min_tgl_doc') != '' && $this->input->post('max_tgl_doc') != ''){
			$tgl_doc = "AND tgl_doc BETWEEN '".$this->input->post('min_tgl_doc')."' AND '".$this->input->post('max_tgl_doc')."' ";
		}else {
			$tgl_doc = ' ';
		}
		
		if($this->input->post('tgl_bukti') == '' && $this->input->post('min_tgl_bukti') != '' && $this->input->post('max_tgl_bukti') != ''){
			$tgl_bukti = "AND tgl_bukti BETWEEN '".$this->input->post('min_tgl_bukti')."' AND '".$this->input->post('max_tgl_bukti')."' ";
		}else {
			$tgl_bukti = ' ';
		}
		
		if($this->input->post('supplier_code') != ''){
			$supplier_code = "AND supplier_code = '".$this->input->post('supplier_code')."' ";
		}else {
			$supplier_code = ' ';
		}
		
		if($this->input->post('jumlah_doc') != ''){
			$jumlah_doc = "AND jumlah_doc = '".$this->input->post('jumlah_doc')."' ";
		}else {
			$jumlah_doc = ' ';
		}
		
		if($this->input->post('barang_code') != ''){
			$barang_code = "AND barang_code = '".$this->input->post('barang_code')."' ";
		}else {
			$barang_code = ' ';
		}
		
		if($this->input->post('valas') != ''){
			$valas = "AND valas = '".$this->input->post('valas')."' ";
		}else {
			$valas = ' ';
		}
		
		if($this->input->post('barang_name') != ''){
			$barang_name = "AND barang_name = '".$this->input->post('barang_name')."' ";
		}else {
			$barang_name = ' ';
		}		
		
		if($this->input->post('nilai_barang') != ''){
			$nilai_barang = "AND nilai_barang = '".$this->input->post('nilai_barang')."' ";
		}else {
			$nilai_barang = ' ';
		}
		
		if($this->input->post('satuan_doc') != ''){
			$satuan_doc = "AND satuan_doc = '".$this->input->post('satuan_doc')."' ";
		}else {
			$satuan_doc = ' ';
		}
		
		echo $jenis_doc;
		echo $no_doc;
		echo $no_bukti;
		echo $tgl_doc;
		echo $tgl_bukti;
		echo $tgl_doc1;
		echo $tgl_bukti1;
		echo $supplier_code;
		echo $jumlah_doc;
		echo $barang_code;
		echo $valas;
		echo $barang_name;
		echo $nilai_barang;
		echo $satuan_doc.'<br/>';
		//echo '<br/>';echo print_r($this->input->post());
	}

}	