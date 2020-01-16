<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb_satuan extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		checkLogin();
		checkAdmin();
		$this->load->model('m_sb_satuan');
		$this->load->model('m_sb_login');
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
	}
	
	public function index()
	{
		redirect('Sb_satuan/listing');
	}
	
	public function listing2()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['satuan'] = $this->m_sb_satuan->get_all_sb_satuan();
		$data['content'] = 'sb_satuan/list_sb_satuan';
		$this->load->view('template',$data);
	}
	
	public function listing()
	{
		$this->load->library('pagination');
		
		$config['base_url'] = base_url().'index.php/sb_satuan/listing';
		$config['total_rows'] = $this->db->count_all('sb_satuan');
		$config['per_page'] = 10;  
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(3);
		
		$data['satuan'] = $this->m_sb_satuan->get_all_sb_satuan_limit($config['per_page'],$uri);
		$data['content'] = 'sb_satuan/list_sb_satuan';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function add()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['content'] = 'sb_satuan/form_sb_satuan';
		$this->load->view('template',$data);
	}
	
	public function save()
	{
		$satuan_codes = $this->input->post('satuan_codes');
		$satuan_code = $this->input->post('satuan_code');
		$hasil = $this->m_sb_satuan->get_sb_satuan($satuan_code);
		
		if($hasil->satuan_code == "" || $satuan_codes != ""){
			$this->m_sb_satuan->save_sb_satuan($satuan_codes);
			redirect('Sb_satuan/listing');
		} else {
			$this->session->set_flashdata('satuan',' Kode Satuan Sudah Ada Silahkan Isi Kode Satuan yang lain !!!');
			redirect('Sb_satuan/listing');
		}
	}
	
	public function search_satuan()
	{
		$satuan_code = $this->input->post('satuan_code');
		$query = $this->db->query("SELECT * from sb_satuan where satuan_code = '$satuan_code'");
		$find = $query->num_rows();
		echo $find;
	}
	
	public function update_save()
	{
		$satuan_codes = $this->input->post('satuan_codes');
		$this->m_sb_satuan->save_sb_satuan($satuan_codes);
		redirect('Sb_satuan');
	}
	
	public function edit($satuan_code)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['satuan'] = $this->m_sb_satuan->get_sb_satuan($satuan_code);
		$data['content'] = 'sb_satuan/form_sb_satuan';
		$this->load->view('template',$data);
	}
	
	public function delete($satuan_code)
	{
		$this->m_sb_satuan->del_sb_satuan($satuan_code);
		redirect('Sb_satuan');
	}
	
	public function get_Sb_satuan()
	{
		 if(isset($_GET['term'])){
			$satuan_code = strtolower($_GET['term']);
			$this->m_sb_satuan->get_sb_satuans($satuan_code);
		}
	}
	
	public function search()
	{
		$this->db->select('*');
		$this->db->from ('sb_satuan');
		$this->db->like($this->input->post('jenis'), $this->input->post('search'));
		
		
		
		$query = $this->db->get();
		echo "<tr>
				<th>Satuan Code</th>
				<th>Satuan Name</th>
				<th>Create Date</th>
				<th>Create By</th>
				<th>Modify Date</th>
				<th>Modify By</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>";
		$i = 0;
		foreach($query->result()as $row){			
			echo"<tr><td>".$row->satuan_code."</td>
				<td>".$row->satuan_name."</td>
				<td>".$row->create_date."</td>
				<td>".$row->create_by."</td>
				<td>".$row->modify_date."</td>
				<td>".$row->modify_by."</td>
				<td><a onclick=\"modalEdit('$row->satuan_code','$row->satuan_name');\" class='btn btn-primary btn-small' href='' style='height:27px; font-size:11px;' data-toggle='modal' data-target='#myModal1'>Edit</a></td>
				<td><a class='btn btn-danger btn-small' style='height:27px; font-size:11px;' onclick='return confirm(\"Are you sure ?\")' href='".base_url()."index.php/Sb_satuan/delete/".$row->satuan_code."'>Delete</a></td></tr>
				";
		$i++;
		}
	}
}	