<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb_periode extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		checkLogin();
		checkAdmin();
		$this->load->model('m_sb_periode');
		$this->load->model('m_sb_login');
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
	}
	
	public function index()
	{
		redirect('Sb_periode/listing');
	}
	
	public function listing2()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['periode'] = $this->m_sb_periode->get_all_sb_periode();
		$data['content'] = 'Sb_periode/list_sb_periode';
		$this->load->view('template',$data);
	}
	
	public function listing()
	{
		$this->load->library('pagination');
		
		$config['base_url'] = base_url().'index.php/Sb_Periode/listing';
		$config['total_rows'] = $this->db->count_all('sb_periode');
		$config['per_page'] = 10;  
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(3);
		
		$data['periode'] = $this->m_sb_periode->get_all_sb_periode_limit($config['per_page'],$uri);
		$data['content'] = 'Sb_periode/list_sb_periode';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function add()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['content'] = 'Sb_periode/form_sb_periode';
		$this->load->view('template',$data);
	}
	
	public function save()
	{
		$periode_id = $this->input->post('periode_id');
		$this->m_sb_periode->save_sb_periode($periode_id);
		redirect('Sb_periode');
	}
	
	public function edit($periode_id)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['periode'] = $this->m_sb_periode->get_sb_periode($periode_id);
		$data['content'] = 'Sb_periode/form_sb_periode';
		$this->load->view('template',$data);
	}
	
	public function delete($periode_id)
	{
		$this->m_sb_periode->del_sb_periode($periode_id);
		redirect('Sb_periode');
	}	
	
	public function search()
	{
		$this->db->select('*');
		$this->db->from ('sb_periode');
		$this->db->like($this->input->post('jenis'), $this->input->post('search'));
		
		$query = $this->db->get();
		echo "<tr>
				<th>Periode Id</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Create Date</th>
				<th>Create By</th>
				<th>Modify Date</th>
				<th>Modify By</th>
				<th>Edit</th>
				<!--
				<th>Delete</th>
				!-->
			</tr>";
		$i = 0;
		foreach($query->result()as $row){			
			echo"<tr><td>".$row->periode_id."</td>
				<td>".$row->start_date."</td>
				<td>".$row->end_date."</td>
				<td>".$row->create_date."</td>
				<td>".$row->create_by."</td>
				<td>".$row->modify_date."</td>
				<td>".$row->modify_by."</td>
				<td><a class='btn btn-primary btn-small' href='' style='height:27px; font-size:11px;' data-toggle='modal' data-target='#myModal".$row->periode_id."'>Edit</a></td>
				<!--
				<td><a class='btn btn-danger btn-small' style='height:27px; font-size:11px;' onclick='return confirm(\"Are you sure ?\")' href='".base_url()."index.php/Sb_Periode/delete/".$row->periode_id."'>Delete</a></td>
				!-->
				</tr>
				";
		$i++;
		}
	}
}	