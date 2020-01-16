<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_sb_users extends CI_Model{

	function save_sb_users($usernames)
	{
		
		$query = $this->db->query('SELECT GETDATE() AS waktu');
		$row = $query->row();
		
		if($usernames != NULL){
			$this->db->where('username',$usernames);
			$data = array (
				'username' => $this->input->post('username'),
				//'password' => md5($this->input->post('password')),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'modify_date' => $row->waktu,
				'modify_by' => $this->session->userdata('username')
			);
			$this->db->update('sb_user_management',$data);
			$this->session->set_flashdata('berhasil', 'Data berhasil diubah');
		} else{
			$data = array (
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password')),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'usertype' => $this->input->post('usertype'),
				'create_date' => $row->waktu,
				'create_by' => $this->session->userdata('username')
			);
			$this->db->insert('sb_user_management',$data);
			$this->session->set_flashdata('berhasil', 'Data berhasil disimpan');
		}
	}
	
	function get_all_sb_user_limit($p,$u)
	{
		if(!$u){
			$u = 0;
			$p;
		} else {
			$u;
			$p = $p + $u;
		}
		$query = $this->db->query("SELECT * 
			FROM 
			( 
				  SELECT *, 
					ROW_NUMBER() OVER (ORDER BY first_name) as rowNum 
				  FROM sb_user_management
			) sub 
			WHERE rowNum > $u AND rowNum <= $p ");
		return $query->result();
	}
	
	function get_user_password($old_password)
	{
		$this->db->select('*');
		$this->db->where('password', $old_password);
		$query=$this->db->get('sb_user_management');
		if($query -> num_rows() == 1){
			return $query->row();
		}else{
			return "";
		}
	}	
	
	function save_change_password($username)
	{
		$this->db->where('username',$username);
			$data = array (
				'password' => md5($this->input->post('new_password'))
			);
		$this->db->update('sb_user_management',$data);	
	}
	
	function get_all_sb_users()
	{
		$query = $this->db->get('sb_user_management');
		return $query->result();
	}
	
	function get_sb_users($username)
	{
		$this->db->where('username',$username);
		$query = $this->db->get('sb_user_management');
		return $query->row();
	}
	
	function del_sb_users($username)
	{
		$this->db->where('username',$username);
		$this->db->delete('sb_user_management');
	}
}	