<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_sb_history extends CI_Model{

	function list_history_sb_barang_limit($p,$u)
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
				  SELECT a.*,b.saldo_awal,b.periode_id, 
					ROW_NUMBER() OVER (ORDER BY a.barang_code) as rowNum 
				  FROM sb_barang a JOIN sb_saldo_awal b 
				  ON (a.barang_code = b.barang_code)
			) sub 
			WHERE rowNum > $u AND rowNum <= $p ");
		return $query->result();
	}
	
	function list_history_sb_barang()
	{
		$create_date = $this->input->post('create_date');
		$modify_date = $this->input->post('modify_date');
		$query = $this->db->query("
			SELECT * FROM sb_barang WHERE CONVERT(DATE, create_date, 106) = '$create_date' 
			OR CONVERT(DATE, modify_date, 106) = '$modify_date'");
		return $query->result();
	}
	
	function list_history_sb_satuan_limit($p,$u)
	{
		if(!$u){
			$u = 0;
			$p;
		} else {
			$u;
			$p = $p + $u;
		}
		$query = $this->db->query("
		SELECT * FROM 
			( 
				SELECT *, 
					ROW_NUMBER() OVER (ORDER BY satuan_code) as rowNum 
				FROM sb_satuan
			) sub 
			WHERE rowNum > $u AND rowNum <= $p ");
		return $query->result();
	}
	
	function list_history_sb_satuan()
	{
		$create_date = $this->input->post('create_date');
		$modify_date = $this->input->post('modify_date');
		$query = $this->db->query("
			SELECT * FROM sb_satuan WHERE CONVERT(DATE, create_date, 106) = '$create_date' 
			OR CONVERT(DATE, modify_date, 106) = '$modify_date'");
		return $query->result();
	}
	
	function list_history_sb_menu()
	{
		$create_date = $this->input->post('create_date');
		$modify_date = $this->input->post('modify_date');
		$create_by = $this->input->post('create_by');
		$modify_by = $this->input->post('modify_by');
		$menu = $this->input->post('menu');

		if($menu == 'sb_doc_export_hd'){
			$query = $this->db->query("
				SELECT doc_id AS kode, 'Input Data Export '+jenis_doc AS input, create_date, create_by, modify_date, modify_by 
				FROM $menu 
				WHERE CONVERT(DATE, create_date, 106) = '$create_date' 
				OR CONVERT(DATE, modify_date, 106) = '$modify_date'
				OR modify_by LIKE '%$modify_by%'
				OR create_by LIKE '%$create_by%'
			");
		} else if($menu == 'sb_doc_import_hd'){
			$query = $this->db->query("
				SELECT doc_id AS kode, 'Input Data Import '+jenis_doc AS input, create_date, create_by, modify_date, modify_by 
				FROM $menu 
				WHERE CONVERT(DATE, create_date, 106) = '$create_date' 
				OR CONVERT(DATE, modify_date, 106) = '$modify_date'
				OR modify_by LIKE '%$modify_by%'
				OR create_by LIKE '%$create_by%'
			");
		} else {
			if($menu == 'sb_satuan'){
				$kode = 'satuan_code';
				$input = 'Input Data Satuan';
			} else if($menu == 'sb_barang'){
				$kode = 'barang_code';
				$input = 'Input Data Barang';
			} else if($menu == 'sb_negara'){
				$kode = 'negara_code';
				$input = 'Input Data Negara';
			} else if($menu == 'sb_supplier'){
				$kode = 'supplier_code';
				$input = 'Input Data Supplier';
			} else if($menu == 'sb_supplier'){
				$kode = 'supplier_code';
				$input = 'Input Data Supplier';
			} else if($menu == 'sb_doc_export_hd'){
				$kode = 'doc_id';
				$input = 'Input Data Export';
			} else if($menu == 'sb_doc_import_hd'){
				$kode = 'doc_id';
				$input = 'Input Data Import';
			} else {
				$kode = 'prod_id';
				$input = 'Input Data Product';
			}
			
			$query = $this->db->query("
				SELECT $kode AS kode, '$input' AS input, create_date, create_by, modify_date, modify_by 
				FROM $menu 
				WHERE CONVERT(DATE, create_date, 106) = '$create_date' 
				OR CONVERT(DATE, modify_date, 106) = '$modify_date'
				OR modify_by LIKE '%$modify_by%'
				OR create_by LIKE '%$create_by%'
				");
		}	
		return $query->result();
	}
}	