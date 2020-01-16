<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb_production extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		checkLogin();
		$this->load->model('m_sb_production');
		$this->load->model('m_sb_barang');
		$this->load->model('m_sb_supplier');
		$this->load->model('m_sb_login');
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
	}
	
	public function index()
	{
		redirect('Sb_production/listing');
	}
	
	public function listing2()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['production'] = $this->m_sb_production->getAllProduction();
		$data['content'] = 'sb_production/list_sb_production';
		$this->load->view('template',$data);
	}
	
	public function listing()
	{
		checkAdmin();
		$this->load->library('pagination');
		
		$data['jumlah'] = $this->m_sb_production->getAllProductionCount();
		
		$config['base_url'] = base_url().'index.php/Sb_production/listing';
		$config['total_rows'] = $data['jumlah']->jumlah;
		
		$config['per_page'] = 10;  
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(3);
		
		$data['production'] = $this->m_sb_production->get_all_sb_production_limit($config['per_page'],$uri);
		$data['content'] = 'Sb_production/list_sb_production';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function add()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['content'] = 'sb_production/form_sb_production';
		$this->load->view('template', $data);
	}
	
	public function save()
	{
		checkAdmin();
		$prod_id = $this->input->post('prod_ids');
		$prod_ids = $this->input->post('prod_id');
		$hasil = $this->m_sb_production->get_sb_production($prod_ids);
		
		if($hasil->prod_id == "" || $prod_id != ""){
			$this->m_sb_production->saveBarang($prod_id);
			redirect('Sb_production/listing');
		} else {
			$this->session->set_flashdata('production',' Kode Satuan Sudah Ada Silahkan Isi Kode Satuan yang lain !!!');
			redirect('Sb_production/listing');
		}
	}
	
	public function search_request_id()
	{
		checkAdmin();
		$request_id = $this->input->post('request_id');
		$query = $this->db->query("SELECT * from sb_production_request_hd where request_id = '$request_id'");
		$find = $query->num_rows();
		echo $find;
	}
	
	public function search_prod_id()
	{
		checkAdmin();
		$prod_id = $this->input->post('prod_id');
		$query = $this->db->query("SELECT * from sb_production where prod_id = '$prod_id'");
		$find = $query->num_rows();
		echo $find;
	}
	
	public function edit($prod_id)
	{
		checkAdmin();
		$data['profil']=$this->m_sb_login->get_profil();
		//$data['request'] = $this->m_sb_production->get_request($prod_id);
		$data['prod'] = $this->m_sb_production->get_sb_production($prod_id);
		$data['prod_request_dt'] = $this->m_sb_production->get_sb_production_request_dt($prod_id);
		$data['prod_request_id'] = $this->m_sb_production->get_request_id($prod_id);
		$data['count_request'] = $this->m_sb_production->getCountRequest($prod_id);
		$data['content'] = 'Sb_production/form_sb_production';
		$this->load->view('template',$data);
	}
	
	public function lihat_detail($prod_id)
	{
		checkAdmin();
		$data['profil']=$this->m_sb_login->get_profil();
		$data['prod_dt'] = $this->m_sb_production->get_sb_production_dt($prod_id);
		$data['content'] = 'Sb_production/list_sb_production_dt';
		$this->load->view('Sb_production/list_sb_production_dt',$data);
	}
	
	public function ubah_status($doc_id, $jenis_doc)
	{
		checkAdmin();
		$this->db->query("update sb_doc_export_hd 
		set status='Finish' where doc_id='$doc_id'");
		redirect('Sb_export/listing/'.$jenis_doc);
	}
	
	public function delete($prod_id)
	{
		checkAdmin();
		$this->m_sb_production->del_sb_production($prod_id);
		redirect('Sb_production');
	}
	
	public function get_barang_material()
	{
		checkAdmin();
		$data['profil']=$this->m_sb_login->get_profil();
		$data['barang'] = $this->m_sb_production->get_barang();
		$data['content'] = 'sb_production/list_sb_production_barang';
		$this->load->view('sb_production/list_sb_production_barang',$data);
	}
	
	public function get_barang_jadi()
	{
		checkAdmin();
		$data['profil']=$this->m_sb_login->get_profil();
		$data['barang_jadi'] = $this->m_sb_production->get_all_sb_barang_jadi();
		$data['content'] = 'sb_production/list_sb_barang_jadi';
		$this->load->view('sb_production/list_sb_barang_jadi',$data);
	}
	
	public function get_wip()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['laporan'] = $this->m_sb_production->get_report_laporan_wip();
		$data['content'] = 'sb_production/report_wip';
		$this->load->view('template',$data);
	}
	
	public function update_status($kode)
	{
		checkAdmin();
		$this->m_sb_production->change_status($kode);
		redirect('Sb_production');
	}
	
	public function searchProduction()
	{
		checkAdmin();
		$this->db->select('a.*,(select count(*) 
					from sb_production_request_dt a1 join sb_production_request_hd b1 on (a1.request_id = b1.request_id)
					where b1. prod_id = a.prod_id) as jumlah_barang');
		$this->db->from ('sb_production a');
		$this->db->like(''.$this->input->post('jenis'), $this->input->post('search'));
		$this->db->where('a.status', 'UnFinish');
		
		$query = $this->db->get();
		echo "<tr>
				<th>Kode Produksi</th>
				<th>Tanggal Produksi</th>
				<th>Kode Barang</th>
				<th>Jumlah Barang</th>
				<th>Status</th>
				<th>Request</th>
				<th>Delete</th>
			  </tr>";
		$i = 0;
		foreach($query->result()as $row){			
			echo"<tr>
				<td>".$row->prod_id."</td>
				<td>".$row->tgl_prod."</td>
				<td>".$row->barang_code."</td>
				
				<td><a href='javascript:0' onclick=openWin('".base_url()."index.php/Sb_production/lihat_detail/".$row->prod_id."','popupdetail','600','500');>".$row->jumlah_barang."</a></td>
				
				<td><a class='btn btn-success btn-small' style='height:27px; font-size:11px;' href='".base_url()."index.php/Sb_production/update_statu/".$production->prod_id."'>Finish</a></td>
							
				<td><a class='btn btn-primary btn-small' style='height:27px; font-size:11px;' href='".base_url()."index.php/Sb_production/edit/".$production->prod_id."'>Request</a></td>
							
				<td><a class='btn btn-danger btn-small' style='height:27px; font-size:11px;' onclick='return confirm(\"Are you sure ?\")' href='".base_url()."index.php/Sb_production/delete/".$production->prod_id."'>Delete</a></td>
				</tr>
				";
		$i++;
		}
	}
}	