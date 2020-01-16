<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb_pengeluaran_barang extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		checkLogin();
		$this->load->model('m_sb_barang');
		$this->load->model('m_sb_login');
		$this->load->model('m_eksport_pengeluaran');
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
	}
	
	public function index()
	{
		redirect('Sb_pengeluaran_barang/listing');
	}
	
	public function listing()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['nama']=$this->m_sb_login->get_nama();
		$data['periode'] = $this->m_eksport_pengeluaran->get_periode();
		$data['content'] = 'sb_pengeluaran_barang/list_pengeluaran_barang';
		$this->load->view('template',$data);
	}
	
	public function detail()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['nama']=$this->m_sb_login->get_nama();
		$data['laporan'] = $this->m_eksport_pengeluaran->get_report_laporan_pengeluaran();
		$data['content'] = 'sb_pengeluaran_barang/report_pengeluaran_barang';
		$this->load->view('template',$data);
	}
}	