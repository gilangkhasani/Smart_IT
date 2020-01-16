<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb_negara extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		checkLogin();
		checkAdmin();
		$this->load->model('m_sb_negara');
		$this->load->model('m_sb_login');
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
	}
	
	public function index()
	{
		redirect('Sb_negara/listing');
	}
	
	public function listing2()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['negara'] = $this->m_sb_negara->get_all_sb_negara();
		$data['content'] = 'sb_negara/list_sb_negara';
		$this->load->view('template',$data);
	}
	
	
	public function listing()
	{
		$this->load->library('pagination');
		
		$config['base_url'] = base_url().'index.php/sb_negara/listing';
		$config['total_rows'] = $this->db->count_all('sb_negara');
		$config['per_page'] = 10;  
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(3);
		
		$data['negara'] = $this->m_sb_negara->get_all_sb_negara_limit($config['per_page'],$uri);
		$data['negaras'] = $this->m_sb_negara->get_all_sb_negara();
		$data['content'] = 'sb_negara/list_sb_negara';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function add()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['content'] = 'sb_negara/form_sb_negara';
		$this->load->view('template',$data);
	}
	
	public function save()
	{
		$negara_codes = $this->input->post('negara_codes');
		$negara_code = $this->input->post('negara_code');
		$hasil = $this->m_sb_negara->get_sb_negara($negara_code);
		
		if($hasil->negara_code == "" || $negara_codes != ""){
			$this->m_sb_negara->save_sb_negara($negara_codes);
			redirect('Sb_negara/listing');
		} else {
			$this->session->set_flashdata('negara',' Kode Negara Sudah Ada Silahkan Isi Kode Negara yang lain !!!');
			redirect('Sb_negara/listing');
		}
	}
	
	public function update_save()
	{
		$negara_codes = $this->input->post('negara_codes');
		$this->m_sb_negara->save_sb_negara($negara_codes);
		redirect('Sb_negara');
	}
	
	public function edit($negara_codes)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['negara'] = $this->m_sb_negara->get_sb_negara($negara_codes);
		$data['content'] = 'sb_negara/form_sb_negara';
		$this->load->view('template',$data);
	}
	
	public function delete($negara_codes)
	{
		$this->m_sb_negara->del_sb_negara($negara_codes);
		redirect('Sb_negara');
	}
	
	public function search_negara()
	{
		$negara_code = $this->input->post('negara_code');
		$query = $this->db->query("SELECT * from sb_negara where negara_code = '$negara_code'");
		$find = $query->num_rows();
		echo $find;
	}
	
	public function search()
	{
		$this->db->select('*');
		$this->db->from ('sb_negara');
		$this->db->like($this->input->post('jenis'), $this->input->post('search'));
		
		
		
		$query = $this->db->get();
		echo "<tr>
				<th>Negara Code</th>
				<th>Negara Name</th>
				<th>Create Date</th>
				<th>Create By</th>
				<th>Modify Date</th>
				<th>Modify By</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>";
		$i = 0;
		foreach($query->result()as $row){			
			echo"<tr><td>".$row->negara_code."</td>
				<td>".$row->negara_name."</td>
				<td>".$row->create_date."</td>
				<td>".$row->create_by."</td>
				<td>".$row->modify_date."</td>
				<td>".$row->modify_by."</td>
				<td><a onclick=\"modalEdit('$row->negara_code','$row->negara_name');\" class='btn btn-primary btn-small' href='' style='height:27px; font-size:11px;' data-toggle='modal' data-target='#myModal1'>Edit</a></td>
				<td><a class='btn btn-danger btn-small' style='height:27px; font-size:11px;' onclick='return confirm(\"Are you sure ?\")' href='".base_url()."index.php/Sb_negara/delete/".$row->negara_code."'>Delete</a></td></tr>
				";
		$i++;
		}
	}
}	