<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_sb_import extends CI_Model{
	
	
	function saveBarang($doc_id)
	{
		$date = new DateTime(date('d-m-Y H:i:s'));
		$result = $date->format('Y-m-d H:i:s');
		
		$query=$this->db->query('select GETDATE() as waktu');
		$row=$query->row();
		
		if($doc_id != NULL){
			$this->db->where('doc_id',$doc_id);
			$data = array (
				'jenis_doc'		=> $this->input->post('jenis_doc'),
				'no_doc'		=> $this->input->post('no_doc'),
				'tgl_doc'		=> $this->input->post('tgl_doc'),
				'supplier_code'	=> $this->input->post('supplier_code'),
				'valas'			=> $this->input->post('valas'),
				'modify_by'		=> $this->session->userdata('username'),
				'modify_date'	=> $row->waktu
			);
			$this->db->update('sb_doc_import_hd', $data);
			
			$this->db->where('doc_id',$doc_id);
			$this->db->delete('sb_doc_import_dt');
			
			if ($this->input->post('barang_code')[0]==""){
				$this->session->set_flashdata('berhasil', 'Detail barang masih kosong');
			}else{
				for( $i = 0; $i < count($this->input->post('barang_code')); $i++ ){
					$data_arr = array(
						'doc_id' 		=> $doc_id,
						'barang_code'	=> $this->input->post('barang_code')[$i],
						'satuan_doc'	=> $this->input->post('satuan_doc')[$i],
						'jumlah_doc' 	=> $this->input->post('jumlah_doc')[$i],
						'nilai_konversi'=> $this->input->post('nilai_konversi')[$i],
						'jumlah_barang' => ($this->input->post('nilai_konversi')[$i]*$this->input->post('jumlah_doc')[$i]),
						'nilai_barang' 	=> $this->input->post('nilai_barang')[$i]
					);
				
					$this->db->insert('sb_doc_import_dt', $data_arr);
				}
				$this->session->set_flashdata('berhasil', 'Data berhasil diubah');
			}
		} else {
			$id = $this->db->query('SELECT ISNULL(MAX(SUBSTRING(doc_id,9,6)),0) + 1 AS doc_id FROM sb_doc_import_hd');
			$doc_id = $id->row();
			
			$i = $doc_id->doc_id; //max id
			if( strlen($i) == 1 ){
				$say='00000'.$i;
			} elseif( strlen($i) == 2 ){
				$say='0000'.$i;
			} elseif( strlen($i) == 3 ){
				$say='000'.$i;
			} elseif( strlen($i) == 4 ){
				$say='00'.$i;
			} elseif( strlen($i) == 5 ){
				$say='0'.$i;
			} elseif( strlen($i) == 6 ){
				$say=$i;
			}
			$date = date('my');
			$head = 'IN-'.$date;
			
			$id = $head.'-'.$say;
			
			$data = array (
				'doc_id'		=> $id,
				'jenis_doc'		=> $this->input->post('jenis_doc'),
				'no_doc'		=> $this->input->post('no_doc'),
				'tgl_doc'		=> $this->input->post('tgl_doc'),
				'supplier_code'	=> $this->input->post('supplier_code'),
				'valas'			=> $this->input->post('valas'),
				'status'		=> 'UnFinish',
				'create_by'		=> $this->session->userdata('username'),
				'create_date'	=> $row->waktu
			);
			$this->db->insert('sb_doc_import_hd', $data);
			
			//$query = $this->db->query('SELECT ISNULL(MAX(SUBSTRING(doc_id,9,6)),0) + 1 AS doc_id FROM sb_doc_import_dt');
			//$row = $query->row();
			
			if ($this->input->post('barang_code')[0]==""){
				$this->session->set_flashdata('berhasil', 'Detail barang masih kosong');
			}else{
				for( $i = 0; $i < count($this->input->post('barang_code')); $i++ ){
					$data_arr = array(
						'doc_id' 		=> $id,
						'barang_code'	=> $this->input->post('barang_code')[$i],
						'satuan_doc'	=> $this->input->post('satuan_doc')[$i],
						'jumlah_doc' 	=> $this->input->post('jumlah_doc')[$i],
						'nilai_konversi'=> $this->input->post('nilai_konversi')[$i],
						'jumlah_barang' => ($this->input->post('nilai_konversi')[$i]*$this->input->post('jumlah_doc')[$i]),
						'nilai_barang' 	=> $this->input->post('nilai_barang')[$i]
				);
					$this->db->insert('sb_doc_import_dt', $data_arr);
				}
				$this->session->set_flashdata('berhasil', 'Data berhasil disimpan');
			}
		}
	}
	
	function get_all_sb_import_count($jenis)
	{
		$this->db->where('status','UnFinish');
		$this->db->select('count(*) as jumlah');
		$this->db->from('sb_doc_import_hd');
		$this->db->where('jenis_doc',$jenis);
		$query = $this->db->get();
		return $query->row();
	}
	
	function get_all_sb_import_limit($jenis,$p,$u)
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
				  SELECT a.*, b.supplier_name, 
					(
						select count(*)
						from sb_doc_import_dt
						where doc_id=a.doc_id
					)as jumlah,
					ROW_NUMBER() OVER (ORDER BY doc_id) as rowNum 
				  FROM sb_doc_import_hd a
				  JOIN sb_supplier b 
				  ON(a.supplier_code = b.supplier_code)
				  WHERE jenis_doc = '$jenis' AND a.status = 'UnFinish'
			) sub 
			WHERE rowNum > $u AND rowNum <= $p ");
		return $query->result();
	}
	
	function getAllImport($jenis)
	{
		$query = $this->db->query("select a.*, 
							(
							select count(*)
							from sb_doc_import_dt
							where doc_id=a.doc_id
							)as jumlah
							from sb_doc_import_hd a
							where a.jenis_doc='$jenis' and a.status = 'UnFinish'");
		return $query->result();
	}
	
	function get_sb_import_hd($doc_id)
	{
		$this->db->where('doc_id',$doc_id);
		$query = $this->db->get('sb_doc_import_hd');
		return $query->row();
	}
	
	function get_sb_import_dt($doc_id)
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
		$this->db->where('doc_id',$doc_id);
		$this->db->select("*,
			((SELECT ISNULL(SUM(sb_saldo_awal.saldo_awal),0)
						FROM sb_saldo_awal
						WHERE sb_saldo_awal.barang_code=b.barang_code and sb_saldo_awal.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +
				(SELECT	ISNULL(SUM(sb_doc_import_dt.jumlah_barang),0)
						FROM sb_doc_import_dt
						INNER JOIN sb_doc_import_hd on sb_doc_import_dt.doc_id=sb_doc_import_hd.doc_id
						WHERE sb_doc_import_dt.barang_code=b.barang_code and sb_doc_import_hd.status='Finish' and
						sb_doc_import_hd.tgl_bukti Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +
				(SELECT	ISNULL(SUM(sb_finish_good.jumlah),0)
						FROM sb_finish_good
						WHERE sb_finish_good.barang_code=b.barang_code and sb_finish_good.tgl_penerimaan Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +				
				(SELECT	ISNULL(SUM(sb_scrap.jumlah),0)
						FROM sb_scrap
						WHERE sb_scrap.barang_code=b.barang_code and sb_scrap.tgl_penerimaan Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) +				
				(SELECT	ISNULL(SUM(sb_material_return.jumlah),0)
						FROM sb_material_return
						WHERE sb_material_return.barang_code=b.barang_code and sb_material_return.tgl_penerimaan Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode'))) -
				(SELECT	ISNULL(SUM(sb_doc_export_dt.jumlah_barang),0)
						FROM sb_doc_export_dt
						INNER JOIN sb_doc_export_hd on sb_doc_export_dt.doc_id=sb_doc_export_hd.doc_id
						WHERE sb_doc_export_dt.barang_code=b.barang_code and sb_doc_export_hd.status='Finish' and
						sb_doc_export_hd.tgl_bukti Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) -						
				(SELECT	ISNULL(SUM(sb_production_request_dt.jumlah_barang),0)
						FROM sb_production_request_dt
						INNER JOIN sb_production_request_hd on sb_production_request_dt.request_id=sb_production_request_hd.request_id
						WHERE sb_production_request_dt.barang_kode=b.barang_code and sb_production_request_hd.status='Finish' and
						sb_production_request_hd.tgl_request Between 
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode'))	+
				(SELECT ISNULL(SUM(sb_penyesuaian.penyesuaian),0)
						FROM sb_penyesuaian
						WHERE sb_penyesuaian.barang_code=b.barang_code and sb_penyesuaian.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) as saldo_akhir
		");
		$this->db->from('sb_doc_import_dt a');
		$this->db->join('sb_barang b', 'a.barang_code=b.barang_code');
		$query = $this->db->get();
		return $query->result();
	}
	
	
	function del_sb_import($doc_id)
	{
		$this->db->where('doc_id',$doc_id);
		$this->db->delete('sb_doc_import_dt');
		
		$this->db->where('doc_id',$doc_id);
		$this->db->delete('sb_doc_import_hd');
	}
	
	function get_sb_supplier($supplier_code)
	{
		$this->db->select('*');
		$this->db->like('supplier_code',$supplier_code);
		$query = $this->db->get('sb_supplier');
		if($query->num_rows > 0){
			foreach ($query->result_array() as $row){
				//$row_set[] = htmlentities(stripslashes($row['satuan_name'])); //build an array
				$new_row['label']=htmlentities(stripslashes($row['supplier_name']));
				$new_row['value']=htmlentities(stripslashes($row['supplier_code']));
				$row_set[] = $new_row; //build an array
			}
			echo json_encode($row_set); //format the array into json data
		}
	}
}	