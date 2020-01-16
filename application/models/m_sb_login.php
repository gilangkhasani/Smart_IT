<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_sb_login extends CI_Model{
	
	function get_all_sb_user($username, $password)
	{
		$this->load->library('user_agent');
		///grab user input
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser().' '.$this->agent->version();
        } else if ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } else if ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }
		
		/*
		Getting MAC Address using PHP
		*/
		ob_start(); // Turn on output buffering
		system('ipconfig /all'); //Execute external program to display output
		$mycom=ob_get_contents(); // Capture the output into a variable
		ob_clean(); // Clean (erase) the output buffer
		$findme = "Physical";
		$pmac = strpos($mycom, $findme); // Find the position of Physical text
		$mac = trim(substr($mycom,($pmac+36),17)); // Get Physical Address
		
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$query=$this->db->get('sb_user_management');
		
		$aktifitas = '';
		if($query -> num_rows() == 1){
			$result = $query->row();
			$aktifitas = 'LOGIN';
		}else{
			$result = "";
			$aktifitas = 'LOGIN GAGAL : Password or Username is WRONG !!!';
		}
		
		/* $data = array (
			'username' 		=> $this->input->post('username'),
			'activity'		=> $aktifitas,
			'ip_address'	=> $this->input->ip_address(),
			'mac_address'	=> $mac,
			'browser_type'	=> $agent,
			'log_date'		=> date('Y-m-d H:i:s'),
			'os'			=> $this->agent->platform()
		);
		$this->db->insert('sb_log',$data); */
		return $result;
		
		/*$this->db->select('*');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$query=$this->db->get('sb_user_management');*/
		if($query -> num_rows() == 1){
			return $query->row();
		}else{
			return "";
		}
	}
	
	function get_profil()
	{
		$this->db->select('*');
		$query = $this->db->get('sb_profil');
		return $query->result();
	}
	
	function get_nama()
	{
		$this->db->select('*');
		$this->db->where('username', $this->session->userdata('username'));
		$query = $this->db->get('sb_user_management');
		return $query->row();
	}
	
	
	function getLogin()
	{
        $this->load->library('user_agent');
		///grab user input
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser().' '.$this->agent->version();
        } else if ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } else if ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }
		/*
		Getting MAC Address using PHP
		*/
		ob_start(); // Turn on output buffering
		system('ipconfig /all'); //Execute external program to display output
		$mycom=ob_get_contents(); // Capture the output into a variable
		ob_clean(); // Clean (erase) the output buffer
		$findme = "Physical";
		$pmac = strpos($mycom, $findme); // Find the position of Physical text
		$mac = trim(substr($mycom,($pmac+36),17)); // Get Physical Address
		
		$this->db->where('email',$this->input->post('email'));
		$this->db->where('password',md5($this->input->post('password')));
		$query = $this->db->get('users');
		
		$aktifitas = '';
		if($query -> num_rows() == 1){
			$result = $query->row();
			$aktifitas = 'LOGIN';
		}else{
			$result = "";
			$aktifitas = 'LOGIN GAGAL : Password or Username is WRONG !!!';
		}
		
		$data = array (
			'email' 		=> $this->input->post('email'),
			'aktifitas'		=> $aktifitas,
			'ip_address'	=> $this->input->ip_address(),
			'mac_address'	=> $mac,
			'browser_type'	=> $agent,
			'os'			=> $this->agent->platform()
		);
		$this->db->insert('log_pengguna',$data);
		return $result;
	}
}