<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_wip extends CI_Model{
	
	function make_report_laporan_wip()
	{
		if($this->input->post('barang_code') != ''){
			$barang_code = "AND barang_code = '".$this->input->post('barang_code')."' ";
		}else {
			$barang_code = ' ';
		}
		
		if($this->input->post('barang_name') != ''){
			$barang_name = "AND barang_name = '".$this->input->post('barang_name')."' ";
		}else {
			$barang_name = ' ';
		}
		
		if($this->input->post('satuan_code') != ''){
			$satuan_code = "AND satuan_code = '".$this->input->post('satuan_code')."' ";
		}else {
			$satuan_code = ' ';
		}
		
		
		$query = $this->db->query
			("
			  SELECT	ROW_NUMBER() OVER (ORDER BY sb_production_request_dt.barang_kode) AS no, 
			  sb_production_request_dt.barang_kode
						,sb_barang.barang_name
						,sb_barang.satuan_code
						,SUM(jumlah_on_production) as jumlah_barang
						,prod_id as keterangan
			  FROM		sb_production_request_dt 
			  INNER JOIN sb_barang ON sb_barang.barang_code=sb_production_request_dt.barang_kode
			  INNER JOIN sb_production_request_hd ON sb_production_request_hd.request_id=sb_production_request_dt.request_id
			  
			  WHERE		jumlah_on_production > 0
			  
			  $barang_code $barang_name $satuan_code
			  GROUP BY sb_production_request_dt.barang_kode, sb_barang.barang_name, 
			  sb_barang.satuan_code, sb_production_request_hd.prod_id
			");
		return $query;				
	}
	
	function make_report_laporan_wip_pdf()
	{
		if($this->input->post('barang_code') != ''){
			$barang_code = "AND barang_code = '".$this->input->post('barang_code')."' ";
		}else {
			$barang_code = ' ';
		}
		
		if($this->input->post('barang_name') != ''){
			$barang_name = "AND barang_name = '".$this->input->post('barang_name')."' ";
		}else {
			$barang_name = ' ';
		}
		
		if($this->input->post('satuan_code') != ''){
			$satuan_code = "AND satuan_code = '".$this->input->post('satuan_code')."' ";
		}else {
			$satuan_code = ' ';
		}
		
		$query = $this->db->query
			("
			  SELECT ROW_NUMBER() OVER (ORDER BY sb_production_request_dt.barang_kode) AS no, 
			  sb_production_request_dt.barang_kode
						,sb_barang.barang_name
						,sb_barang.satuan_code
						,SUM(jumlah_on_production) as jumlah_barang
						,prod_id as keterangan
			  FROM		sb_production_request_dt 
			  INNER JOIN sb_barang ON sb_barang.barang_code=sb_production_request_dt.barang_kode
			  INNER JOIN sb_production_request_hd ON sb_production_request_hd.request_id=sb_production_request_dt.request_id
			  WHERE		jumlah_on_production > 0
			  $barang_code $barang_name $satuan_code
			  GROUP BY sb_production_request_dt.barang_kode, sb_barang.barang_name, 
			  sb_barang.satuan_code, sb_production_request_hd.prod_id
			  ");
		return $query->result();				
	}
}