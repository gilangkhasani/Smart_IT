<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb_mutasi extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		checkLogin();
		$this->load->model('m_sb_barang');
		$this->load->model('m_sb_mutasi');
		$this->load->model('m_sb_login');
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
	}
	
	public function index()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		redirect('Sb_mutasi/listing');
	}
	
	public function listing()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['periode'] = $this->m_sb_mutasi->get_periode();
		$data['content'] = 'sb_mutasi/list_periode';
		$this->load->view('template',$data);
	}
	
	public function detail($barang1, $barang2, $periode)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		if($barang1 == 'Mesin_Sparepart'){
			$barang1 = 'Mesin/Sparepart';
		} else {
			$barang1=str_replace('_', ' ', $barang1);
		}
		$barang2=str_replace('_', ' ', $barang2);
		$data['laporan'] = $this->m_sb_mutasi->get_report_laporan_mutasi($barang1, $barang2, $periode);
		$data['content'] = 'sb_mutasi/report_mutasi_bb_bp';
		$this->load->view('template',$data);
	}
}	