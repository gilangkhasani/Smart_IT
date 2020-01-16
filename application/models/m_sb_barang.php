<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_sb_barang extends CI_Model{
	
	function save_sb_barang($barang_code)
	{
		//$date = new DateTime(date('d-m-Y H:i:s'));
		//$result = $date->format('Y-m-d H:i:s');
		
		$query2 = $this->db->query('SELECT GETDATE() as waktu');
		$row2 = $query2->row();
		
		if($barang_code != NULL){
			$this->db->where('barang_code',$barang_code);
			$data = array (
				'barang_name' => $this->input->post('barang_name'),
				'hs_code' => $this->input->post('hs_code'),
				'satuan_code' => $this->input->post('satuan_code'),
				'modify_date' => $row2->waktu,
				'modify_by' => $this->session->userdata('username')
			);
			$this->db->update('sb_barang',$data);
			$this->session->set_flashdata('berhasil', 'Data berhasil diubah');
			/*
			$this->db->where('barang_code',$barang_code);
			$data2 = array (
				'saldo_awal' => $this->input->post('saldo_awal'),
				'periode_id' => $this->input->post('periode_id'),
				'modify_date' => $row2->waktu,
				'modify_by' => $this->session->userdata('username')
			);
			$this->db->update('sb_saldo_awal',$data2);
			*/
		} else{
			$data = array (
				'barang_code' => $this->input->post('barang_code'),
				'barang_name' => $this->input->post('barang_name'),
				'hs_code' => $this->input->post('hs_code'),
				'satuan_code' => $this->input->post('satuan_code'),
				'barang_category' => $this->input->post('barang_category'),
				'barang_status' => 'Active',
				'create_date' => $row2->waktu,
				'create_by' => $this->session->userdata('username')
			);
			$this->db->insert('sb_barang',$data);
			
			if($this->input->post('saldo_awal') > 0 && $this->input->post('saldo_awal') != ''){
				$data2 = array (
					'barang_code' => $this->input->post('barang_code'),
					'saldo_awal' => $this->input->post('saldo_awal'),
					'periode_id' => $this->input->post('periode_id'),
					'create_date' => $row2->waktu,
					'create_by' => $this->session->userdata('username')
				);
				$this->db->insert('sb_saldo_awal',$data2);
			}
			$this->session->set_flashdata('berhasil', 'Data berhasil disimpan');
		}
	}
	
	function get_all_sb_barang_active_limit($jenis,$p,$u)
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
				SELECT sb_barang.*,
					ROW_NUMBER() OVER (ORDER BY sb_barang.barang_code) as rowNum, 
					
				ISNULL(((SELECT ISNULL(sb_saldo_awal.saldo_awal,0)
						FROM sb_saldo_awal
						WHERE sb_saldo_awal.barang_code=sb_barang.barang_code and sb_saldo_awal.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +
				(SELECT	ISNULL(SUM(sb_doc_import_dt.jumlah_barang),0)
						FROM sb_doc_import_dt
						INNER JOIN sb_doc_import_hd on sb_doc_import_dt.doc_id=sb_doc_import_hd.doc_id
						WHERE sb_doc_import_dt.barang_code=sb_barang.barang_code and sb_doc_import_hd.status='Finish' and
						sb_doc_import_hd.tgl_bukti Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +
				(SELECT	ISNULL(SUM(sb_finish_good.jumlah),0)
						FROM sb_finish_good
						WHERE sb_finish_good.barang_code=sb_barang.barang_code and sb_finish_good.tgl_penerimaan Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +				
				(SELECT	ISNULL(SUM(sb_scrap.jumlah),0)
						FROM sb_scrap
						WHERE sb_scrap.barang_code=sb_barang.barang_code and sb_scrap.tgl_penerimaan Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +				
				(SELECT	ISNULL(SUM(sb_material_return.jumlah),0)
						FROM sb_material_return
						WHERE sb_material_return.barang_code=sb_barang.barang_code and sb_material_return.tgl_penerimaan Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode'))) -
				((SELECT	ISNULL(SUM(sb_doc_export_dt.jumlah_barang),0)
						FROM sb_doc_export_dt
						INNER JOIN sb_doc_export_hd on sb_doc_export_dt.doc_id=sb_doc_export_hd.doc_id
						WHERE sb_doc_export_dt.barang_code=sb_barang.barang_code and sb_doc_export_hd.status='Finish' and
						sb_doc_export_hd.tgl_bukti Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +						
				(SELECT	ISNULL(SUM(sb_production_request_dt.jumlah_barang),0)
						FROM sb_production_request_dt
						INNER JOIN sb_production_request_hd on sb_production_request_dt.request_id=sb_production_request_hd.request_id
						WHERE sb_production_request_dt.barang_kode=sb_barang.barang_code and sb_production_request_hd.status='Finish' and
						sb_production_request_hd.tgl_request Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')))	+
				(SELECT ISNULL(SUM(sb_penyesuaian.penyesuaian),0)
						FROM sb_penyesuaian
						WHERE sb_penyesuaian.barang_code=sb_barang.barang_code and sb_penyesuaian.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')),0) as saldo_akhir
			FROM sb_barang sb_barang 
			WHERE sb_barang.barang_status = 'Active' AND sb_barang.barang_category = '$jenis' 
			) sub 
			WHERE rowNum > $u AND rowNum <= $p ");
		return $query->result();
	}
	
	function get_all_sb_barang_void_limit($jenis,$p,$u)
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
				SELECT sb_barang.*,
					ROW_NUMBER() OVER (ORDER BY sb_barang.barang_code) as rowNum, 
					
				ISNULL(((SELECT ISNULL(sb_saldo_awal.saldo_awal,0)
						FROM sb_saldo_awal
						WHERE sb_saldo_awal.barang_code=sb_barang.barang_code and sb_saldo_awal.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +
				(SELECT	ISNULL(SUM(sb_doc_import_dt.jumlah_barang),0)
						FROM sb_doc_import_dt
						INNER JOIN sb_doc_import_hd on sb_doc_import_dt.doc_id=sb_doc_import_hd.doc_id
						WHERE sb_doc_import_dt.barang_code=sb_barang.barang_code and sb_doc_import_hd.status='Finish' and
						sb_doc_import_hd.tgl_bukti Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +
				(SELECT	ISNULL(SUM(sb_finish_good.jumlah),0)
						FROM sb_finish_good
						WHERE sb_finish_good.barang_code=sb_barang.barang_code and sb_finish_good.tgl_penerimaan Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +				
				(SELECT	ISNULL(SUM(sb_scrap.jumlah),0)
						FROM sb_scrap
						WHERE sb_scrap.barang_code=sb_barang.barang_code and sb_scrap.tgl_penerimaan Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +				
				(SELECT	ISNULL(SUM(sb_material_return.jumlah),0)
						FROM sb_material_return
						WHERE sb_material_return.barang_code=sb_barang.barang_code and sb_material_return.tgl_penerimaan Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode'))) -
				((SELECT	ISNULL(SUM(sb_doc_export_dt.jumlah_barang),0)
						FROM sb_doc_export_dt
						INNER JOIN sb_doc_export_hd on sb_doc_export_dt.doc_id=sb_doc_export_hd.doc_id
						WHERE sb_doc_export_dt.barang_code=sb_barang.barang_code and sb_doc_export_hd.status='Finish' and
						sb_doc_export_hd.tgl_bukti Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +						
				(SELECT	ISNULL(SUM(sb_production_request_dt.jumlah_barang),0)
						FROM sb_production_request_dt
						INNER JOIN sb_production_request_hd on sb_production_request_dt.request_id=sb_production_request_hd.request_id
						WHERE sb_production_request_dt.barang_kode=sb_barang.barang_code and sb_production_request_hd.status='Finish' and
						sb_production_request_hd.tgl_request Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')))	+
				(SELECT ISNULL(SUM(sb_penyesuaian.penyesuaian),0)
						FROM sb_penyesuaian
						WHERE sb_penyesuaian.barang_code=sb_barang.barang_code and sb_penyesuaian.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')),0) as saldo_akhir
			FROM sb_barang sb_barang 
			WHERE sb_barang.barang_status = 'Void' AND sb_barang.barang_category = '$jenis' 
			) sub 
			WHERE rowNum > $u AND rowNum <= $p  ");
		return $query->result();
	}
	
	function get_all_sb_barang($jenis)
	{
		$this->db->where('barang_status','Active');
		$this->db->select('a.*, b.saldo_awal, b.periode_id');
		$this->db->from('sb_barang a');
		$this->db->join('sb_saldo_awal b','a.barang_code=b.barang_code');
		$this->db->where('a.barang_category',$jenis);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_all_sb_barang_count($jenis)
	{
		$this->db->where('barang_status','Active');
		$this->db->select('count(*) as jumlah');
		$this->db->from('sb_barang a');
		$this->db->where('a.barang_category',$jenis);
		$query = $this->db->get();
		return $query->row();
	}
	
	function get_all_sb_barang_count_void($jenis)
	{
		$this->db->where('barang_status','Void');
		$this->db->select('count(*) as jumlah');
		$this->db->from('sb_barang a');
		$this->db->where('a.barang_category',$jenis);
		$query = $this->db->get();
		return $query->row();
	}
	
	function get_all_sb_barang_void($jenis)
	{
		$this->db->where('barang_status','Void');
		$this->db->select('a.*, b.saldo_awal, b.periode_id');
		$this->db->from('sb_barang a');
		$this->db->join('sb_saldo_awal b','a.barang_code=b.barang_code');
		$this->db->where('a.barang_category',$jenis);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_sb_barang($barang_code)
	{
		$this->db->where('barang_code',$barang_code);
		$query = $this->db->get('sb_barang');
		return $query->row();
	}
	
	function get_saldo_barang($barang_code)
	{
		$this->db->where('barang_code',$barang_code);
		$query = $this->db->get('sb_saldo_awal');
		return $query->row();
	}
	
	function del_sb_barang($barang_code)
	{
		$this->db->where('barang_code',$barang_code);
		$this->db->delete('sb_barang');
		$this->db->where('barang_code',$barang_code);
		$this->db->delete('sb_saldo_awal');
		
	}
	
	function update_active_sb_barang($barang_code)
	{
		$this->db->where('barang_code',$barang_code);
		$data = array (
			'barang_status' => 'Active'
		);
		$this->db->update('sb_barang',$data);
	}
	
	function update_void_sb_barang($barang_code)
	{
		$this->db->where('barang_code',$barang_code);
		$data = array (
			'barang_status' => 'Void'
		);
		$this->db->update('sb_barang',$data);
	}
	
	function get_barang_dan_saldo()
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
		/*
		$this->db->select_max('periode_id');
		$query = $this->db->get('sb_periode');	
		$row = $query->row();
		$periode = $row->periode_id;
		*/
		$query = $this->db->query
		("
					SELECT sb_barang.*,
					ROW_NUMBER() OVER (ORDER BY sb_barang.barang_code) as rowNum, 
					
				ISNULL(((SELECT ISNULL(sb_saldo_awal.saldo_awal,0)
						FROM sb_saldo_awal
						WHERE sb_saldo_awal.barang_code=sb_barang.barang_code and sb_saldo_awal.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +
				(SELECT	ISNULL(SUM(sb_doc_import_dt.jumlah_barang),0)
						FROM sb_doc_import_dt
						INNER JOIN sb_doc_import_hd on sb_doc_import_dt.doc_id=sb_doc_import_hd.doc_id
						WHERE sb_doc_import_dt.barang_code=sb_barang.barang_code and sb_doc_import_hd.status='Finish' and
						sb_doc_import_hd.tgl_bukti Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +
				(SELECT	ISNULL(SUM(sb_finish_good.jumlah),0)
						FROM sb_finish_good
						WHERE sb_finish_good.barang_code=sb_barang.barang_code and sb_finish_good.tgl_penerimaan Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +				
				(SELECT	ISNULL(SUM(sb_scrap.jumlah),0)
						FROM sb_scrap
						WHERE sb_scrap.barang_code=sb_barang.barang_code and sb_scrap.tgl_penerimaan Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +				
				(SELECT	ISNULL(SUM(sb_material_return.jumlah),0)
						FROM sb_material_return
						WHERE sb_material_return.barang_code=sb_barang.barang_code and sb_material_return.tgl_penerimaan Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode'))) -
				((SELECT	ISNULL(SUM(sb_doc_export_dt.jumlah_barang),0)
						FROM sb_doc_export_dt
						INNER JOIN sb_doc_export_hd on sb_doc_export_dt.doc_id=sb_doc_export_hd.doc_id
						WHERE sb_doc_export_dt.barang_code=sb_barang.barang_code and sb_doc_export_hd.status='Finish' and
						sb_doc_export_hd.tgl_bukti Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +						
				(SELECT	ISNULL(SUM(sb_production_request_dt.jumlah_barang),0)
						FROM sb_production_request_dt
						INNER JOIN sb_production_request_hd on sb_production_request_dt.request_id=sb_production_request_hd.request_id
						WHERE sb_production_request_dt.barang_kode=sb_barang.barang_code and sb_production_request_hd.status='Finish' and
						sb_production_request_hd.tgl_request Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')))	+
				(SELECT ISNULL(SUM(sb_penyesuaian.penyesuaian),0)
						FROM sb_penyesuaian
						WHERE sb_penyesuaian.barang_code=sb_barang.barang_code and sb_penyesuaian.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')),0) as saldo_akhir
			FROM sb_barang sb_barang 
		");
		return $query->result();
	}
}