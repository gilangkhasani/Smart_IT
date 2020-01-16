<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb_users extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		checkLogin();
		checkAdmin();
		$this->load->model('m_sb_users');
		$this->load->model('m_sb_login');
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
	}
	
	public function index()
	{
		redirect('Sb_users/listing');
	}

	public function listing2()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['user'] = $this->m_sb_users->get_all_sb_users();
		$data['content'] = 'sb_user/list_sb_user';
		$this->load->view('template',$data);
	}
	
	public function listing()
	{
		$this->load->library('pagination');
		
		$config['base_url'] = base_url().'index.php/sb_users/listing';
		$config['total_rows'] = $this->db->count_all('sb_user_management');
		$config['per_page'] = 10;  
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(3);
		
		$data['user'] = $this->m_sb_users->get_all_sb_user_limit($config['per_page'],$uri);
		$data['content'] = 'Sb_user/list_sb_user';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function add()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['content'] = 'sb_users/form_sb_user';
		$this->load->view('template', $data);
	}
	
	public function save()
	{
		$usernames = $this->input->post('usernames');
		$username = $this->input->post('username');
		$hasil = $this->m_sb_users->get_sb_users($username);
		
		if($hasil->username == "" || $usernames != ""){
			$this->m_sb_users->save_sb_users($usernames);
			redirect('Sb_users/listing');
		} else {
			$this->session->set_flashdata('users',' Kode users Sudah Ada Silahkan Isi Kode users yang lain !!!');
			redirect('Sb_users/listing');
		}
	}
	
	public function update_save()
	{
		$usernames = $this->input->post('usernames');
		$this->m_sb_users->save_sb_users($usernames);
		redirect('Sb_users');
	}
	
	public function search_users()
	{
		$username = $this->input->post('username');
		$query = $this->db->query("SELECT * from sb_user_management where username = '$username'");
		$find = $query->num_rows();
		echo $find;
	}
	
	public function edit($username)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['user'] = $this->m_sb_users->get_sb_users($username);
		$data['content'] = 'sb_users/form_sb_user';
		$this->load->view('sb_user/form_sb_user', $data);
	}
	
	public function delete($username)
	{
		$this->m_sb_users->del_sb_users($username);
		redirect('Sb_users');
	}
	
	public function changePassword()
	{
		$old_password = md5($this->input->post('old_password'));
		$username = $this->session->userdata('username');
		$ambil = $this->m_sb_users->get_user_password($old_password);
		if($ambil != ""){
			$this->m_sb_users->save_change_password($username);
		}
		redirect('Blog');
	}
	
	public function search()
	{
		$this->db->select('*');
		$this->db->from ('sb_user_management');
		$this->db->like($this->input->post('jenis'), $this->input->post('search'));
		
		
		
		$query = $this->db->get();
		echo "<tr>
				<th>Username</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Create Date</th>
				<th>Create By</th>
				<th>Modify Date</th>
				<th>Modify By</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>";
		$i = 0;
		foreach($query->result()as $row){			
			echo"<tr><td>".$row->username."</td>
				<td>".$row->first_name."</td>
				<td>".$row->last_name."</td>
				<td>".$row->create_date."</td>
				<td>".$row->create_by."</td>
				<td>".$row->modify_date."</td>
				<td>".$row->modify_by."</td>
				<td><a class='btn btn-primary btn-small' href='' style='height:27px; font-size:11px;' data-toggle='modal' data-target='#myModal".$row->username."'>Edit</a></td>
				<td><a class='btn btn-danger btn-small' style='height:27px; font-size:11px;' onclick='return confirm(\"Are you sure ?\")' href='".base_url()."index.php/Sb_users/delete/".$row->username."'>Delete</a></td></tr>
				";
		$i++;
		}
	}
}