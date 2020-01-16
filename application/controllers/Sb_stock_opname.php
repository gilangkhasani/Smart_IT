<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb_stock_opname extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		checkLogin();
		checkAdmin();
		$this->load->model('m_sb_stock_opname');
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
		redirect('Sb_stock_opname/listing');
	}
	
	public function listing()
	{
		$this->load->library('pagination');
		
		$config['base_url'] = base_url().'index.php/Sb_stock_opname/listing';
		$config['total_rows'] = $this->m_sb_stock_opname->get_all_count_periode();
		$config['per_page'] = 10;  
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(3);
		
		$data['barang'] = $this->m_sb_stock_opname->get_all_sb_stock_opname_limit($config['per_page'],$uri);
		$data['content'] = 'sb_stock_opname/list_sb_stock_opname';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function insert()
	{
		$this->m_sb_stock_opname->insert_sb_stock_opname();
		redirect('Sb_stock_opname');
	}
	
	public function save()
	{
		$barang_codes = $this->input->post('barang_codes');
		$this->m_sb_stock_opname->save_sb_stock_opname($barang_codes);
		redirect('Sb_stock_opname');
	}
	
	public function delete($barang_codes)
	{
		$this->m_sb_stock_opname->del_sb_stock_opname($barang_codes);
		redirect('Sb_stock_opname');
	}
	
	public function search_stock_opname()
	{
		$this->db->select('*');
		$this->db->from ('sb_stock_opname');
		$this->db->like($this->input->post('jenis'), $this->input->post('search'));

		$query = $this->db->get();
		echo "<tr>
				<th>Barang Code</th>
				<th>Stock Opname</th>
				<th>Periode Id</th>
				<th>Keterangan</th>
				<th>Create Date</th>
				<th>Create By</th>
				<th>Modify Date</th>
				<th>Modify By</th>
				<th>Edit</th>
			</tr>";
		$i = 0;
		foreach($query->result()as $row){			
			echo"<tr><td>".$row->barang_code."</td>
				<td>".$row->stock_opname."</td>
				<td>".$row->periode_id."</td>
				<td>".$row->keterangan."</td>
				<td>".$row->create_date."</td>
				<td>".$row->create_by."</td>
				<td>".$row->modify_date."</td>
				<td>".$row->modify_by."</td>
				<td><a class='btn btn-primary btn-small' href='' style='height:27px; font-size:11px;' data-toggle='modal' data-target='#myModal".$row->barang_code."'>Edit</a></td>
				</tr>
				";
		$i++;
		}
	}
}