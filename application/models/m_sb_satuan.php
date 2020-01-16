<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_sb_satuan extends CI_Model{
	
	function save_sb_satuan($satuan_codes)
	{
		$date = new DateTime(date('d-m-Y H:i:s'));
		$result = $date->format('Y-m-d H:i:s');
		
		if($satuan_codes != NULL){
			$this->db->where('satuan_code',$satuan_codes);
			$data = array (
				'satuan_code' => strtoupper($this->input->post('satuan_code')),
				'satuan_name' => $this->input->post('satuan_name'),
				'modify_date' => $result,
				'modify_by' => $this->session->userdata('username')
			);
			$this->db->update('sb_satuan',$data);
			$this->session->set_flashdata('berhasil', 'Data berhasil diubah');
		} else{
			$data = array (
				'satuan_code' => strtoupper($this->input->post('satuan_code')),
				'satuan_name' => $this->input->post('satuan_name'),
				'create_date' => $result,
				'create_by' => $this->session->userdata('username')
			);
			$this->db->insert('sb_satuan',$data);
			$this->session->set_flashdata('berhasil', 'Data berhasil disimpan');
		}
	}
	
	function get_all_sb_satuan()
	{
		$query = $this->db->get('sb_satuan');
		return $query->result();
	}
	
	function get_all_sb_satuan_limit($p,$u)
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
					ROW_NUMBER() OVER (ORDER BY satuan_code) as rowNum 
				  FROM sb_satuan
			) sub 
			WHERE rowNum > $u AND rowNum <= $p ");
		return $query->result();
	}
	
	function get_sb_satuan($satuan_code)
	{
		$this->db->where('satuan_code',$satuan_code);
		$query = $this->db->get('sb_satuan');
		return $query->row();
	}
	
	function get_sb_satuans($satuan_code)
	{
		//$this->db->select('satuan_name');
		$this->db->select('*');
		$this->db->like('satuan_code',$satuan_code);
		$this->db->or_like('satuan_name',$satuan_code);
		$query = $this->db->get('sb_satuan');
		if($query->num_rows > 0){
			foreach ($query->result_array() as $row){
				//$row_set[] = htmlentities(stripslashes($row['satuan_name'])); //build an array
				$new_row['label']=htmlentities(stripslashes($row['satuan_name']));
				$new_row['value']=htmlentities(stripslashes($row['satuan_code']));
				$row_set[] = $new_row; //build an array
			}
			echo json_encode($row_set); //format the array into json data
		}
	}
	
	function del_sb_satuan($satuan_code)
	{
		$this->db->where('satuan_code',$satuan_code);
		$this->db->delete('sb_satuan');
	}
}