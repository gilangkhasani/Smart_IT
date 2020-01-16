<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_sb_supplier extends CI_Model{
	
	function save_sb_supplier($supplier_code)
	{
		$query2 = $this->db->query('SELECT GETDATE() as waktu');
		$row2 = $query2->row();
		
		if($supplier_code != NULL){
			$this->db->where('supplier_code',$supplier_code);
			$data = array (
				'supplier_name' => $this->input->post('supplier_name'),
				'supplier_address' => $this->input->post('supplier_address'),
				'negara_code' => $this->input->post('negara_code'),
				'npwp' => $this->input->post('npwp'),
				'no_izin_tpb' => $this->input->post('no_izin_tpb'),
				'modify_date' => $row2->waktu,
				'modify_by' => $this->session->userdata('username')
			);
			$this->db->update('sb_supplier',$data);
			$this->session->set_flashdata('berhasil',' Data Berhasil di Ubah');
		} else{
			$data = array (
				'supplier_code' => $this->input->post('supplier_code'),
				'supplier_name' => $this->input->post('supplier_name'),
				'supplier_address' => $this->input->post('supplier_address'),
				'negara_code' => $this->input->post('negara_code'),
				'npwp' => $this->input->post('npwp'),
				'no_izin_tpb' => $this->input->post('no_izin_tpb'),
				'create_date' => $row2->waktu,
				'create_by' => $this->session->userdata('username')
			);
			$this->db->insert('sb_supplier',$data);
			$this->session->set_flashdata('berhasil',' Data Berhasil disimpan');
		}
	}
	
	function get_all_sb_supplier_limit($p,$u)
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
					ROW_NUMBER() OVER (ORDER BY supplier_code) as rowNum 
				  FROM sb_supplier
			) sub 
			WHERE rowNum > $u AND rowNum <= $p ");
		return $query->result();
	}
	
	function get_all_sb_supplier()
	{
		$query = $this->db->get('sb_supplier');
		return $query->result();
	}
	
	function get_sb_supplier($supplier_code)
	{
		$this->db->where('supplier_code',$supplier_code);
		$query = $this->db->get('sb_supplier');
		return $query->row();
	}
	
	function get_sb_suppliers($negara_code)
	{
		//$this->db->select('satuan_name');
		$this->db->select('negara_code');
		$this->db->like('negara_code',$negara_code);
		$this->db->or_like('negara_name',$negara_code);
		$query = $this->db->get('sb_negara');
		if($query->num_rows > 0){
			foreach ($query->result_array() as $row){
				//$row_set[] = htmlentities(stripslashes($row['satuan_name'])); //build an array
				//$new_row['label']=htmlentities(stripslashes($row['negara_code']));
				$row_set[]=htmlentities(stripslashes($row['negara_code']));
				//$row_set[] = $new_row; //build an array
			}
			echo json_encode($row_set); //format the array into json data
		}
	}
	
	function del_sb_supplier($supplier_code)
	{
		$this->db->where('supplier_code',$supplier_code);
		$this->db->delete('sb_supplier');
	}
}