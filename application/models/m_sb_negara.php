<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_sb_negara extends CI_Model{
	
	function save_sb_negara($negara_codes)
	{
		$date = new DateTime(date('d-m-Y H:i:s'));
		$result = $date->format('Y-m-d H:i:s');
		
		if($negara_codes != NULL){
			$this->db->where('negara_code',$negara_codes);
			$data = array (
				'negara_code' => strtoupper($this->input->post('negara_code')),
				'negara_name' => $this->input->post('negara_name'),
				'modify_date' => $result,
				'modify_by' => $this->session->userdata('username')
			);
			$this->db->update('sb_negara',$data);
			$this->session->set_flashdata('berhasil', 'Data berhasil diubah');
		} else{
			$data = array (
				'negara_code' => strtoupper($this->input->post('negara_code')),
				'negara_name' => $this->input->post('negara_name'),
				'create_date' => $result,
				'create_by' => $this->session->userdata('username')
			);
			$this->db->insert('sb_negara',$data);
			$this->session->set_flashdata('berhasil', 'Data berhasil disimpan');
		}
	}
	
	function get_all_sb_negara()
	{
		$query = $this->db->get('sb_negara');
		return $query->result();
	}
	
	function get_all_sb_negara_limit($p,$u)
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
					ROW_NUMBER() OVER (ORDER BY negara_code) as rowNum 
				  FROM sb_negara
			) sub 
			WHERE rowNum > $u AND rowNum <= $p ");
		return $query->result();
	}
	
	function get_sb_negara($negara_codes)
	{
		$this->db->where('negara_code',$negara_codes);
		$query = $this->db->get('sb_negara');
		return $query->row();
	}
	
	function del_sb_negara($negara_codes)
	{
		$this->db->where('negara_code',$negara_codes);
		$this->db->delete('sb_negara');
	}
	
	function cek_negara_code($negara_code){
		$query=$this->db->query('select negara_code from sb_negara where negara_code='.$negara_code.'');
		return $query->result();
	}
}