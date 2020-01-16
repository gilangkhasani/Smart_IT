<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb_history extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		checkLogin();
		checkAdmin();
		$this->load->model('m_sb_barang');
		$this->load->model('m_sb_satuan');
		$this->load->model('m_sb_login');
		$this->load->model('m_sb_history');
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
	}
	
	public function history_barang()
	{
		
		$this->load->library('pagination');
		
		$config['base_url'] = base_url().'index.php/sb_barang/history_barang/';
		$config['total_rows'] = $this->db->count_all('sb_barang');
		$config['per_page'] = 10;  
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(3);
		
		$data['barang'] = $this->m_sb_history->list_history_sb_barang_limit($config['per_page'],$uri);
		$data['content'] = 'Sb_barang/list_sb_barang_history';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function search_history_barang()
	{
		$data['pret'] = $this->m_sb_history->list_history_sb_barang();
		echo "<tr>
					<th>Kode Barang</th>
					<th>Nama Barang</th>
					<th>Kode Satuan</th>
					<th>Kode Hs</th>
					<th>Barang Category</th>
					<th>Barang Status</th>
					<th>Create Date</th>
					<th>Create By</th>
					<th>Modify Date</th>
					<th>Modify By</th>
				</tr>";
		$i = 0;
		foreach($data['pret']as $row){			
			echo"<tr>
				<td>".$row->barang_code."</td>
				<td>".$row->barang_name."</td>
				<td>".$row->satuan_code."</td>
				<td>".$row->hs_code."</td>
				<td>".$row->barang_category."</td>
				<td>".$row->barang_status."</td>
				<td>".$row->create_date."</td>
				<td>".$row->create_by."</td>
				<td>".$row->modify_date."</td>
				<td>".$row->modify_by."</td>
				</tr>";
		$i++;
		}
	}
	
	public function history_satuan()
	{
		$this->load->library('pagination');
		
		$config['base_url'] = base_url().'index.php/Sb_satuan/history_satuan/';
		$config['total_rows'] = $this->db->count_all('sb_satuan');
		$config['per_page'] = 10;  
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(3);
		
		$data['satuan'] = $this->m_sb_history->list_history_sb_satuan_limit($config['per_page'],$uri);
		$data['content'] = 'Sb_satuan/list_sb_satuan_history';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function search_history_satuan()
	{
		$data['pret'] = $this->m_sb_history->list_history_sb_satuan();
		echo 	"<tr>
					<th>Kode Satuan</th>
					<th>Nama Satuan</th>
					<th>Create Date</th>
					<th>Create By</th>
					<th>Modify Date</th>
					<th>Modify By</th>
				</tr>";
		$i = 0;
		foreach($data['pret']as $row){			
			echo"<tr>
					<td>".$row->satuan_code."</td>
					<td>".$row->satuan_name."</td>
					<td>".$row->create_date."</td>
					<td>".$row->create_by."</td>
					<td>".$row->modify_date."</td>
					<td>".$row->modify_by."</td>
				</tr>";
		$i++;
		}
	}
	
	public function history_menu()
	{
		$data['content'] = 'Sb_history/list_sb_history_menu';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function search_history_menu()
	{
		$data['pret'] = $this->m_sb_history->list_history_sb_menu();
		echo 	"<tr>
					<th>Kode</th>
					<th>Input Data</th>
					<th>Create Date</th>
					<th>Create By</th>
					<th>Modify Date</th>
					<th>Modify By</th>
				</tr>";
		$i = 0;
		foreach($data['pret']as $row){			
			echo"<tr>
					<td>".$row->kode."</td>
					<td>".$row->input."</td>
					<td>".$row->create_date."</td>
					<td>".$row->create_by."</td>
					<td>".$row->modify_date."</td>
					<td>".$row->modify_by."</td>
				</tr>";
		$i++;
		}
		
	}
}