<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_sb_stock_opname extends CI_Model{
	
	function save_sb_stock_opname($barang_code)
	{
		$query2 = $this->db->query('SELECT GETDATE() as waktu');
		$row2 = $query2->row();
		
		$query = $this->db->query("SELECT stock_opname FROM sb_stock_opname WHERE barang_code = '$barang_code'");
		$row = $query->row();
		
		$penyesuaian = $row->stock_opname + $this->input->post('penyesuaian');
		$data = array (
			'stock_opname' => $penyesuaian
		);
		$this->db->where('barang_code',$barang_code);
		$this->db->update('sb_stock_opname',$data);
		
		$data1 = array (
			'barang_code'	=> $this->input->post('barang_code'),
			'penyesuaian' 	=> $this->input->post('penyesuaian'),
			'periode_id'	=> $this->input->post('periode_id'),
			'create_date'	=> $row2->waktu,
			'create_by'		=> $this->session->userdata('username')
		);
		$this->db->insert('sb_penyesuaian',$data1);
	}
	
	function insert_sb_stock_opname()
	{
		$today = date('Y-m-d');
		$today=date('Y-m-d', strtotime($today)).'<br/>';;
			
		$from = date('Y-m-d', strtotime("01/01/".date("Y")));
		$to = date('Y-m-d', strtotime("05/01/".date("Y")));
				
		$from1 = date('Y-m-d', strtotime("05/01/".date("Y")));
		$to1 = date('Y-m-d', strtotime("09/01/".date("Y")));
				
		if (($today >= $from) && ($today <= $to)) {
			$per = '01';
		}
		else if (($today >= $from1) && ($today <= $to1)) {
			$per = '02';
		}
		else {
			$per = '03';
		}
			$periode = 'PR-'.date('Y').'-'.$per;
			
		$query = $this->db->query("PROD_STOCK_OPNAME @periode = '$periode'");
	}
	
	function get_all_sb_stock_opname_limit($p,$u)
	{
		if(!$u){
			$u = 0;
			$p;
		} else {
			$u;
			$p = $p + $u;
		}
		
		$today = date('Y-m-d');
		$today=date('Y-m-d', strtotime($today)).'<br/>';;
			
		$from = date('Y-m-d', strtotime("01/01/".date("Y")));
		$to = date('Y-m-d', strtotime("05/01/".date("Y")));
				
		$from1 = date('Y-m-d', strtotime("05/01/".date("Y")));
		$to1 = date('Y-m-d', strtotime("09/01/".date("Y")));
				
		if (($today >= $from) && ($today <= $to)) {
			$per = '01';
		}
		else if (($today >= $from1) && ($today <= $to1)) {
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
		$query = $this->db->query("SELECT * 
			FROM 
			( 
				  SELECT *, 
					ROW_NUMBER() OVER (ORDER BY barang_code) as rowNum 
				  FROM sb_stock_opname 
			) sub 
			WHERE rowNum > $u AND rowNum <= $p AND periode_id = '$periode'");
		return $query->result();
	}
	
	function get_all_count_periode()
	{
		/*$today = date('Y-m-d');
		$today=date('Y-m-d', strtotime($today));;
			
		$from = date('Y-m-d', strtotime("01/01/".date("Y")));
		$to = date('Y-m-d', strtotime("05/01/".date("Y")));
				
		$from1 = date('Y-m-d', strtotime("05/01/".date("Y")));
		$to1 = date('Y-m-d', strtotime("09/01/".date("Y")));
		
		if (($today >= $from) && ($today <= $to)) {
			$per = '01';
		}
		else if (($today >= $from1) && ($today <= $to1)) {
			$per = '02';
		}
		else {
			$per = '03';
		}
			$periode = 'PR-'.date('Y').'-'.$per;*/
		/*
		$this->db->select_max('periode_id');
		$query = $this->db->get('sb_periode');	
		$row = $query->row();
		$periode = $row->periode_id;
		*/
		$query=$this->db->query('select max(periode_id) as last_periode from sb_periode');
		$row=$query->row();
		
		$this->db->like('periode_id', $row->last_periode);
		$this->db->from('sb_stock_opname');
		$this->db->count_all_results();
		/*$query = $this->db->query("SELECT count(*)
				  FROM sb_stock_opname where periode_id='$periode'");
		return $query->row();*/
	}
	
	function del_sb_stock_opname($barang_code)
	{
		$this->db->where('barang_code',$barang_code);
		$this->db->delete('sb_stock_opname');
	}
}