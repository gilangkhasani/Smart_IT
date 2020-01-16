<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb_inventory extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		checkLogin();
		checkAdmin();
		$this->load->model('m_sb_inventory');
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
		$data['profil']=$this->m_sb_login->get_profil();
		redirect('Sb_inventory/listing');
	}
	
	public function listing2()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['inventory'] = $this->m_sb_inventory->getAllInventory();
		$data['content'] = 'sb_inventory/list_sb_finish_good';
		$this->load->view('template',$data);
	}
	
	public function listing()
	{
		$this->load->library('pagination');
		
		$data['jumlah'] = $this->m_sb_inventory->getAllProductionCount();
		
		$config['base_url'] = base_url().'index.php/Sb_inventory/listing';
		$config['total_rows'] = $data['jumlah']->jumlah;
		$config['per_page'] = 10;  
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(3);
		
		$data['inventory'] = $this->m_sb_inventory->get_all_sb_inventory_limit($config['per_page'],$uri);
		$data['content'] = 'sb_inventory/list_sb_finish_good';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function listing_scrap()
	{
		$this->load->library('pagination');
		
		$data['jumlah'] = $this->m_sb_inventory->getAllProductionCount();
		
		$config['base_url'] = base_url().'index.php/Sb_inventory/listing_scrap';
		$config['total_rows'] = $data['jumlah']->jumlah;
		$config['per_page'] = 10;  
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(3);
		
		$data['inventory'] = $this->m_sb_inventory->get_all_sb_inventory_limit($config['per_page'],$uri);
		$data['content'] = 'sb_inventory/list_sb_scrap';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function listing_wip()
	{
		$this->load->library('pagination');
		
		$data['jumlah'] = $this->m_sb_inventory->getAllProductionCount();
		
		$config['base_url'] = base_url().'index.php/Sb_inventory/listing_wip';
		$config['total_rows'] = $data['jumlah']->jumlah;
		$config['per_page'] = 10;  
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(3);
		
		$data['inventory'] = $this->m_sb_inventory->get_all_sb_inventory_limit($config['per_page'],$uri);
		$data['content'] = 'sb_inventory/list_wip';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function listing_reject()
	{
		$this->load->library('pagination');
		
		$data['jumlah'] = $this->m_sb_inventory->getAllProductionCount();
		
		$config['base_url'] = base_url().'index.php/Sb_inventory/listing_reject';
		$config['total_rows'] = $data['jumlah']->jumlah;
		$config['per_page'] = 10;  
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(3);
		
		$data['inventory'] = $this->m_sb_inventory->get_all_sb_inventory_limit($config['per_page'],$uri);
		$data['content'] = 'sb_inventory/list_sb_reject';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function listing_material_return()
	{
		$this->load->library('pagination');
		
		$data['jumlah'] = $this->m_sb_inventory->getAllProductionCount();
		
		$config['base_url'] = base_url().'index.php/Sb_inventory/listing_material_return';
		$config['total_rows'] = $data['jumlah']->jumlah;
		$config['per_page'] = 10;  
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(3);
		
		$data['inventory'] = $this->m_sb_inventory->get_all_sb_inventory_limit($config['per_page'],$uri);
		$data['content'] = 'sb_inventory/list_sb_material_return';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function change_finish_good($prod_id)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['prod'] = $this->m_sb_inventory->get_sb_production($prod_id);
		$data['prod_request_dt'] = $this->m_sb_inventory->get_finish_good($prod_id);
		$data['content'] = 'Sb_inventory/form_sb_finish_good';
		$this->load->view('template',$data);
	}
	
	public function change_scrap($prod_id)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['prod'] = $this->m_sb_inventory->get_sb_production($prod_id);
		$data['prod_request_dt'] = $this->m_sb_inventory->get_scrap($prod_id);
		$data['content'] = 'Sb_inventory/form_sb_scrap';
		$this->load->view('template',$data);
	}
	
	public function change_reject($prod_id)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['prod'] = $this->m_sb_inventory->get_sb_production($prod_id);
		$data['prod_request_dt'] = $this->m_sb_inventory->get_sb_production_request_dt($prod_id);
		$data['content'] = 'Sb_inventory/form_sb_reject';
		$this->load->view('template',$data);
	}
	
	public function change_wip($prod_id)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['prod'] = $this->m_sb_inventory->get_sb_production($prod_id);
		$data['prod_request_dt'] = $this->m_sb_inventory->get_sb_production_request_dt($prod_id);
		$data['content'] = 'Sb_inventory/form_wip';
		$this->load->view('template',$data);
	}
	
	public function change_material($prod_id)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['prod'] = $this->m_sb_inventory->get_sb_production($prod_id);
		$data['prod_request_dt'] = $this->m_sb_inventory->get_sb_production_request_dt($prod_id);
		$data['content'] = 'Sb_inventory/form_sb_material';
		$this->load->view('template',$data);
	}
	
	public function get_scrap()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['scrap'] = $this->m_sb_inventory->get_all_sb_scrap();
		$data['content'] = 'sb_inventory/list_sb_scrap_pop';
		$this->load->view('sb_inventory/list_sb_scrap_pop',$data);
	}
	
	public function add()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['content'] = 'sb_production/form_sb_production';
		$this->load->view('template', $data);
	}
	
	public function save()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$prod_id = $this->input->post('prod_ids');
		$this->m_sb_inventory->saveFinishGood($prod_id);
		redirect('Sb_inventory/change_finish_good/'.$prod_id);
	}
	
	public function save_wip()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$prod_id = $this->input->post('prod_ids');
		$this->m_sb_inventory->saveFinishGood($prod_id);
		redirect('Sb_inventory/change_wip/'.$prod_id);
	}
	
	public function save_scrap()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$prod_id = $this->input->post('prod_ids');
		$this->m_sb_inventory->saveBarangScrap($prod_id);
		redirect('Sb_inventory/change_scrap/'.$prod_id);
	}
	
	public function save_material()
	{
		$prod_id = $this->input->post('prod_ids');
		$this->m_sb_inventory->saveBarangMaterial($prod_id);
		redirect('Sb_inventory/change_material/'.$prod_id);
	}
	
	public function edit($prod_id)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		//$data['request'] = $this->m_sb_production->get_request($prod_id);
		$data['prod'] = $this->m_sb_production->get_sb_production($prod_id);
		$data['prod_request_dt'] = $this->m_sb_production->get_sb_production_request_dt($prod_id);
		$data['content'] = 'Sb_production/form_sb_production';
		$this->load->view('template',$data);
	}
	
	public function lihat_detail($doc_id)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['export_dt'] = $this->m_sb_export->get_sb_export_dt($doc_id);
		$data['content'] = 'Sb_export/list_sb_export_dt';
		$this->load->view('template',$data);
	}
	
	public function ubah_status($doc_id, $jenis_doc)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$this->db->query("update sb_doc_export_hd 
		set status='Finish' where doc_id='$doc_id'");
		redirect('Sb_export/listing/'.$jenis_doc);
	}
	
	public function delete($prod_id)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$this->m_sb_production->del_sb_production($prod_id);
		redirect('Sb_production');
	}
	
	public function get_barang_material()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['barang'] = $this->m_sb_production->get_barang();
		$data['content'] = 'sb_production/list_sb_production_barang';
		$this->load->view('sb_production/list_sb_production_barang',$data);
	}
	
	public function get_barang_jadi()
	{
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
		$data['profil']=$this->m_sb_login->get_profil();
		$this->m_sb_production->change_status($kode);
		redirect('Sb_production');
	}
	
	public function searchProductionPlan()
	{
		$this->db->select('a.*,
					(select isnull(sum(jumlah_on_production), 0)
						from sb_production_request_dt a1
						join sb_production_request_hd b1
						on(a1.request_id=b1.request_id)
						where b1.prod_id=a.prod_id
					)as jumlah_finish');
		$this->db->from ('sb_production a');
		$this->db->like(''.$this->input->post('jenis'), $this->input->post('search'));
		$this->db->where('a.status', 'UnFinish');
		
		$query = $this->db->get();
		if($this->uri->segment(3) == 'listing_scrap'){
			$head = 'Scrap';
			$uri = 'change_scrap';
		} else if($this->uri->segment(3) == 'listing_material_return'){
			$head = 'Return';
			$uri = 'change_material';
		} else {
			$head = 'Finish';
			$uri = 'change_finish_good';
		}
			
		echo "<tr>
				<th>Kode Produksi</th>
				<th>Tanggal Produksi</th>
				<th>Kode Barang</th>
				<th>Jumlah Barang</th>
				<th>".$head."</th>
			  </tr>";
		$i = 0;
		foreach($query->result()as $row){			
			echo"<tr>
				<td>".$row->prod_id."</td>
				<td>".$row->tgl_prod."</td>
				<td>".$row->barang_code."</td>
				<td>".$row->jumlah_finish."</td>
				<td><a class='btn btn-success btn-small' style='height:27px; font-size:11px;' href='".base_url()."index.php/Sb_inventory/".$uri."/".$row->prod_id."'>".$head."</a></td>
				</tr>
				";
		$i++;
		}
	}
}	