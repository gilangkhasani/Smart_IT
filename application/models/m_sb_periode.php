<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_sb_periode extends CI_Model{
	
	function save_sb_periode($periode_id)
	{
		$query2 = $this->db->query('SELECT GETDATE() as waktu');
		$row2 = $query2->row();
		
		$from = date('Y-m-d', strtotime("01/01/".date("Y")));
		$to = date('Y-m-d', strtotime("05/01/".date("Y")));
			
		$from1 = date('Y-m-d', strtotime("05/01/".date("Y")));
		$to1 = date('Y-m-d', strtotime("09/01/".date("Y")));
			
		if (($this->input->post('start_date') >= $from) && ($this->input->post('end_date') <= $to)) {
		  $per = '01';
		}
		else if (($this->input->post('start_date') >= $from1) && ($this->input->post('end_date') <= $to1)) {
		  $per = '02';
		}
		else {
			$per = '03';
		}
		$periode = 'PR-'.date('Y').'-'.$per;
		/*
		$this->db->select_max('periode_id');
		$query = $this->db->get('sb_periode');	
		$row = $query->row();
		$periode = $row->periode_id;
		*/
		if($periode_id != NULL){
			$this->db->where('periode_id',$periode_id);
			$data = array (
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'modify_date' => $row2->waktu,
				'modify_by' => $this->session->userdata('username')
			);
			$this->db->update('sb_periode',$data);
			$this->session->set_flashdata('berhasil', 'Data berhasil diubah');
		} else{
			$query = $this->db->query('SELECT MAX(periode_id) AS periode_id FROM sb_periode');
			$row = $query->row();
			$periode_id = $row->periode_id;
			
			$query = $this->db->query(
				"SELECT * 
				FROM sb_stock_opname a JOIN sb_barang b 
				ON (a.barang_code = b.barang_code)
				WHERE a.periode_id = '$periode'"
			);
			
			foreach($query->result() as $result){
				$data = array (
					'barang_code' => $result->barang_code,
					'barang_name' => $result->barang_name,
					'hs_code' => $result->hs_code,
					'satuan_code' => $result->satuan_code,
					'barang_category' => $result->barang_category,
					'barang_status' => 'Active',
					'create_date' => $row2->waktu,
					'create_by' => $this->session->userdata('username')
				);
				$this->db->insert('sb_barang',$data);
				
				$data2 = array (
					'barang_code' => $result->barang_code,
					'saldo_awal' => $result->stock_opname,
					'periode_id' => $periode,
					'create_date' => $row2->waktu,
					'create_by' => $this->session->userdata('username')
				);
				$this->db->insert('sb_saldo_awal',$data2);
			}
			
			$data = array (
				'periode_id' => $periode,
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'create_date' => $row2->waktu,
				'create_by' => $this->session->userdata('username')
			);
			$this->db->insert('sb_periode',$data);
			$this->session->set_flashdata('berhasil', 'Data berhasil disimpan');
			
		}
	}
	
	function get_all_sb_periode_limit($p,$u)
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
					ROW_NUMBER() OVER (ORDER BY periode_id) as rowNum 
				  FROM sb_periode
			) sub 
			WHERE rowNum > $u AND rowNum <= $p ");
		return $query->result();
	}
	
	function get_all_sb_periode()
	{
		$query = $this->db->get('sb_periode');
		return $query->result();
	}
	
	function get_sb_periode($periode_id)
	{
		$this->db->where('periode_id',$periode_id);
		$query = $this->db->get('sb_periode');
		return $query->row();
	}
	
	function del_sb_periode($periode_id)
	{
		$this->db->where('periode_id',$periode_id);
		$this->db->delete('sb_periode');
	}
}