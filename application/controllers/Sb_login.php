<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb_login extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_sb_login');
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
	}
	
	public function index()
	{
		redirect('Sb_login/login');
	}
	
	public function login()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('sb_login/form_sb_login', $data);
	}
	
	public function doLogin()
	{
		$username = $this->input->post('username');
		$pass = $this->input->post('password');
		$password = md5($pass);
		$login = $this->m_sb_login->get_all_sb_user($username,$password);
		if($login != ""){
				$data = array(
					'logged_in' 		=> TRUE,
					'first_name' 		=> $login->first_name,
					'last_name' 		=> $login->last_name,
					'username' 			=> $login->username,
					'password'	 		=> $login->password,
					'usertype'	 		=> $login->usertype,
				);
				$this->session->set_userdata($data);
				redirect('blog');
			} else {
				$this->session->set_flashdata('message','Username or Password is WRONG !!!');
				redirect('Sb_login/login');
			}
	}
	
	/*public function doLogout()
	{
		
	
		$this->session->sess_destroy();
		redirect('Sb_login/login');
	}*/
	
	public function doLogout()
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
		
		/* $data = array (
			'username' 		=> $this->session->userdata('username'),
			'activity'		=> 'LOGOUT',
			'ip_address'	=> $this->input->ip_address(),
			'mac_address'	=> $mac,
			'browser_type'	=> $agent,
			'log_date'		=> date('Y-m-d H:i:s'),
			'os'			=> $this->agent->platform()
		);
		$this->db->insert('sb_log',$data); */
		
		$this->session->sess_destroy();
		redirect('Sb_login/login');
	}
}