<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_sb_inventory extends CI_Model{
	
	function saveFinishGood($prod_id)
	{		
		$query=$this->db->query('select GETDATE() as waktu');
		$row=$query->row();
	
		if(isset($_POST['submit'])){
		
			if($prod_id != NULL){
				$this->db->where('prod_id',$prod_id);
				$data = array (
					'tgl_prod'		=> $this->input->post('tgl_prod'),
					'barang_code'		=> $this->input->post('barang_codes')
				);
				$this->db->update('sb_production', $data);
				
				$query3 = $this->db->query("select * from sb_production_request_hd where prod_id= '$prod_id' and status='UnFinish'");
				$row3 = $query3->result();
				
				foreach($row3 as $result){
					$this->db->where('request_id', $result->request_id);
					$this->db->delete('sb_production_request_dt');
				}
				
				$this->db->where('prod_id',$prod_id);
				$this->db->where('status', 'UnFinish');
				$this->db->delete('sb_production_request_hd');
				
				for ($i=0; $i < count(array_unique($this->input->post('request_id2'), SORT_REGULAR)); $i++){
					$data1 = array (
					'prod_id'		=> $this->input->post('prod_id'),
					'request_id'	=> rtrim($this->input->post('request_id2')[$i]),
					'tgl_request'	=> $this->input->post('tgl_request2')[$i]
					);
					$this->db->insert('sb_production_request_hd', $data1);
				}
				
				
				for( $i = 0; $i < count($this->input->post('request_id2')); $i++ ){
					
					$data_arr = array(
						'request_id' 	=> rtrim($this->input->post('request_id2')[$i]),
						'barang_kode'	=> $this->input->post('barang_kode2')[$i],
						'jumlah_barang'	=> $this->input->post('jumlah_barang2')[$i]
					);
					
					$this->db->insert('sb_production_request_dt', $data_arr);
				}			
			} else {
				$id = $this->db->query('SELECT ISNULL(MAX(doc_id),0) + 1 AS doc_id FROM sb_doc_export_hd');
				$doc_id = $id->row();
				
				$data = array (
					'prod_id'		=> $this->input->post('prod_id'),
					'tgl_prod'		=> $this->input->post('tgl_prod'),
					'barang_code'	=> $this->input->post('barang_codes')
				);
				$this->db->insert('sb_production', $data);
				
				for ($i=0; $i < count(array_unique($this->input->post('request_id2'), SORT_REGULAR)); $i++){
					$data1 = array (
					'prod_id'		=> $this->input->post('prod_id'),
					'request_id'	=> $this->input->post('request_id2')[$i],
					'tgl_request'	=> $this->input->post('tgl_request2')[$i]
					);
					$this->db->insert('sb_production_request_hd', $data1);
				}
				
				
				for( $i = 0; $i < count($this->input->post('request_id2')); $i++ ){
					
					$data_arr = array(
						'request_id' 	=> $this->input->post('request_id2')[$i],
						'barang_kode'	=> $this->input->post('barang_kode2')[$i],
						'jumlah_barang'	=> $this->input->post('jumlah_barang2')[$i]
					);
					
					$this->db->insert('sb_production_request_dt', $data_arr);
				}
			}
		}
		if(isset($_POST['selesai'])){
			$request_id = $this->input->post('request_id');
			$barang_code = $this->input->post('barang_code');
			$query = $this->db->query ("select jumlah_on_production from sb_production_request_dt
			where request_id = '$request_id' AND barang_kode = '$barang_code'");
			$row=$query->row();
			$total = $row->jumlah_on_production - $this->input->post('jumlah_barang');
			echo $total;
			$query2 = $this->db->query("update sb_production_request_dt set jumlah_on_production = $total
			where request_id = '$request_id' AND barang_kode = '$barang_code'");
			/*
			$this->db->where('request_id', $this->input->post('request_id'));
			$this->db->where('barang_kode', $this->input->post('barang_code'));
			$data = array(
				'jumlah_on_production' => $total
			);
			$this->db->update('sb_production_request_dt', $data);*/
		}
		if(isset($_POST['save_prod'])){
			$jumlah=$this->input->post('jumlah');
			$jumlah2=$this->input->post('jumlah2');
			if($jumlah!="" && $jumlah!=0){
				$data = array(
					'prod_id' => $this->input->post('prod_id'),
					'barang_code' => $this->input->post('barang_codes'),
					'jumlah' => $this->input->post('jumlah'),
					'no_penerimaan' => $this->input->post('no_penerimaan'),
					'tgl_penerimaan' => $this->input->post('tgl_penerimaan'),
					'create_date' => $row->waktu,
					'create_by' => $this->session->userdata('first_name').' '.$this->session->userdata('last_name')
				);
				$this->db->insert('sb_finish_good', $data);
			$this->session->set_flashdata('berhasil', 'Data berhasil disimpan');
			}if($jumlah2!="" && $jumlah2!=0){
				$data = array(
					'prod_id' => $this->input->post('prod_id'),
					'barang_code' => $this->input->post('barang_codes'),
					'jumlah' => $this->input->post('jumlah2'),
					'no_penerimaan' => $this->input->post('no_penerimaan'),
					'tgl_penerimaan' => $this->input->post('tgl_penerimaan'),
					'create_date' => $row->waktu,
					'create_by' => $this->session->userdata('first_name').' '.$this->session->userdata('last_name')
				);
				$this->db->insert('sb_reject', $data);
			$this->session->set_flashdata('berhasil', 'Data berhasil disimpan');
			}
		}
	}
	
	function saveBarangScrap($prod_id)
	{		
		$query=$this->db->query('select GETDATE() as waktu');
		$row=$query->row();
	
		if(isset($_POST['submit'])){
			
			if($prod_id != NULL){
				$this->db->where('prod_id',$prod_id);
				$data = array (
					'tgl_prod'		=> $this->input->post('tgl_prod'),
					'barang_code'		=> $this->input->post('barang_codes')
				);
				$this->db->update('sb_production', $data);
				
				$query3 = $this->db->query("select * from sb_production_request_hd where prod_id=$prod_id and status='UnFinish'");
				$row3 = $query3->result();
				
				foreach($row3 as $result){
					$this->db->where('request_id', $result->request_id);
					$this->db->delete('sb_production_request_dt');
				}
				
				$this->db->where('prod_id',$prod_id);
				$this->db->where('status', 'UnFinish');
				$this->db->delete('sb_production_request_hd');
				
				for ($i=0; $i < count(array_unique($this->input->post('request_id2'), SORT_REGULAR)); $i++){
					$data1 = array (
					'prod_id'		=> $this->input->post('prod_id'),
					'request_id'	=> rtrim($this->input->post('request_id2')[$i]),
					'tgl_request'	=> $this->input->post('tgl_request2')[$i]
					);
					$this->db->insert('sb_production_request_hd', $data1);
				}
				
				
				for( $i = 0; $i < count($this->input->post('request_id2')); $i++ ){
					
					$data_arr = array(
						'request_id' 	=> rtrim($this->input->post('request_id2')[$i]),
						'barang_kode'	=> $this->input->post('barang_kode2')[$i],
						'jumlah_barang'	=> $this->input->post('jumlah_barang2')[$i]
					);
					
					$this->db->insert('sb_production_request_dt', $data_arr);
				}			
			} else {
				$id = $this->db->query('SELECT ISNULL(MAX(doc_id),0) + 1 AS doc_id FROM sb_doc_export_hd');
				$doc_id = $id->row();
				
				$data = array (
					'prod_id'		=> $this->input->post('prod_id'),
					'tgl_prod'		=> $this->input->post('tgl_prod'),
					'barang_code'	=> $this->input->post('barang_codes')
				);
				$this->db->insert('sb_production', $data);
				
				for ($i=0; $i < count(array_unique($this->input->post('request_id2'), SORT_REGULAR)); $i++){
					$data1 = array (
					'prod_id'		=> $this->input->post('prod_id'),
					'request_id'	=> $this->input->post('request_id2')[$i],
					'tgl_request'	=> $this->input->post('tgl_request2')[$i]
					);
					$this->db->insert('sb_production_request_hd', $data1);
				}
				
				
				for( $i = 0; $i < count($this->input->post('request_id2')); $i++ ){
					
					$data_arr = array(
						'request_id' 	=> $this->input->post('request_id2')[$i],
						'barang_kode'	=> $this->input->post('barang_kode2')[$i],
						'jumlah_barang'	=> $this->input->post('jumlah_barang2')[$i]
					);
					
					$this->db->insert('sb_production_request_dt', $data_arr);
				}
			}
		}
		if(isset($_POST['selesai'])){
			$request_id = $this->input->post('request_id');
			$barang_code = $this->input->post('barang_code');
			$query = $this->db->query ("select jumlah_on_production from sb_production_request_dt
			where request_id = '$request_id' AND barang_kode = '$barang_code'");
			$row=$query->row();
			$total = $row->jumlah_on_production - $this->input->post('jumlah_barang');
			
			echo $total;
			$query2 = $this->db->query("update sb_production_request_dt set jumlah_on_production = $total
			where request_id = '$request_id' AND barang_kode = '$barang_code'");
			
			/*
			$this->db->where('request_id', $this->input->post('request_id'));
			$this->db->where('barang_kode', $this->input->post('barang_code'));
			$data = array(
				'jumlah_on_production' => $total
			);
			$this->db->update('sb_production_request_dt', $data);*/
		}
		if(isset($_POST['save_prod'])){
			$data = array(
				'prod_id' => $this->input->post('prod_id'),
				'barang_code' => $this->input->post('barang_codess'),
				'jumlah' => $this->input->post('jumlah'),
				'no_penerimaan' => $this->input->post('no_penerimaan'),
				'tgl_penerimaan' => $this->input->post('tgl_penerimaan'),
				'create_date' => $row->waktu,
				'create_by' => $this->session->userdata('first_name').' '.$this->session->userdata('last_name')
			);
			$this->db->insert('sb_scrap', $data);
		}
	}
	
	function saveBarangMaterial($prod_id)
	{		
		$query=$this->db->query('select GETDATE() as waktu');
		$row=$query->row();
	
		if(isset($_POST['submit'])){
			
			if($prod_id != NULL){
				$this->db->where('prod_id',$prod_id);
				$data = array (
					'tgl_prod'		=> $this->input->post('tgl_prod'),
					'barang_code'		=> $this->input->post('barang_codes')
				);
				$this->db->update('sb_production', $data);
				
				$query3 = $this->db->query("select * from sb_production_request_hd where prod_id=$prod_id and status='UnFinish'");
				$row3 = $query3->result();
				
				foreach($row3 as $result){
					$this->db->where('request_id', $result->request_id);
					$this->db->delete('sb_production_request_dt');
				}
				
				$this->db->where('prod_id',$prod_id);
				$this->db->where('status', 'UnFinish');
				$this->db->delete('sb_production_request_hd');
				
				for ($i=0; $i < count(array_unique($this->input->post('request_id2'), SORT_REGULAR)); $i++){
					$data1 = array (
					'prod_id'		=> $this->input->post('prod_id'),
					'request_id'	=> rtrim($this->input->post('request_id2')[$i]),
					'tgl_request'	=> $this->input->post('tgl_request2')[$i]
					);
					$this->db->insert('sb_production_request_hd', $data1);
				}
				
				
				for( $i = 0; $i < count($this->input->post('request_id2')); $i++ ){
					
					$data_arr = array(
						'request_id' 	=> rtrim($this->input->post('request_id2')[$i]),
						'barang_kode'	=> $this->input->post('barang_kode2')[$i],
						'jumlah_barang'	=> $this->input->post('jumlah_barang2')[$i]
					);
					
					$this->db->insert('sb_production_request_dt', $data_arr);
				}			
			} else {
				$id = $this->db->query('SELECT ISNULL(MAX(doc_id),0) + 1 AS doc_id FROM sb_doc_export_hd');
				$doc_id = $id->row();
				
				$data = array (
					'prod_id'		=> $this->input->post('prod_id'),
					'tgl_prod'		=> $this->input->post('tgl_prod'),
					'barang_code'	=> $this->input->post('barang_codes')
				);
				$this->db->insert('sb_production', $data);
				
				for ($i=0; $i < count(array_unique($this->input->post('request_id2'), SORT_REGULAR)); $i++){
					$data1 = array (
					'prod_id'		=> $this->input->post('prod_id'),
					'request_id'	=> $this->input->post('request_id2')[$i],
					'tgl_request'	=> $this->input->post('tgl_request2')[$i]
					);
					$this->db->insert('sb_production_request_hd', $data1);
				}
				
				
				for( $i = 0; $i < count($this->input->post('request_id2')); $i++ ){
					
					$data_arr = array(
						'request_id' 	=> $this->input->post('request_id2')[$i],
						'barang_kode'	=> $this->input->post('barang_kode2')[$i],
						'jumlah_barang'	=> $this->input->post('jumlah_barang2')[$i]
					);
					
					$this->db->insert('sb_production_request_dt', $data_arr);
				}
			}
		}
		if(isset($_POST['selesai'])){
			$jumlah=$this->input->post('jumlah_barang');
			$jumlah2=$this->input->post('jumlah_barang3');
			
			if($jumlah!="" && $jumlah!=0){
				$data = array(
					'prod_id' => $this->input->post('prod_id'),
					'barang_code' => $this->input->post('barang_code'),
					'jumlah' => $this->input->post('jumlah_barang'),
					'no_penerimaan' => $this->input->post('no_penerimaan'),
					'tgl_penerimaan' => $this->input->post('tgl_penerimaan'),
					'create_date' => $row->waktu,
					'create_by' => $this->session->userdata('first_name').' '.$this->session->userdata('last_name')
				);
				$this->db->insert('sb_material_return', $data);
				
				$request_id = $this->input->post('request_id3');
				$barang_code = $this->input->post('barang_code');
				
				$query = $this->db->query ("select jumlah_on_production from sb_production_request_dt
				where request_id = '$request_id' AND barang_kode = '$barang_code'");
				
				$row=$query->row();
				$total = $row->jumlah_on_production - $this->input->post('jumlah_barang');
				
				$query2 = $this->db->query("update sb_production_request_dt set jumlah_on_production = $total
				where request_id = '$request_id' AND barang_kode = '$barang_code'");
			
			}if($jumlah2!="" && $jumlah2!=0){
				$data = array(
					'prod_id' => $this->input->post('prod_id'),
					'barang_code' => $this->input->post('barang_code'),
					'jumlah' => $this->input->post('jumlah_barang3'),
					'no_penerimaan' => $this->input->post('no_penerimaan'),
					'tgl_penerimaan' => $this->input->post('tgl_penerimaan'),
					'create_date' => $row->waktu,
					'create_by' => $this->session->userdata('first_name').' '.$this->session->userdata('last_name')
				);
				$this->db->insert('sb_reject', $data);
				
				$request_id = $this->input->post('request_id3');
				$barang_code = $this->input->post('barang_code');
				
				$query = $this->db->query ("select jumlah_on_production from sb_production_request_dt
				where request_id = '$request_id' AND barang_kode = '$barang_code'");
				
				$row=$query->row();
				$total = $row->jumlah_on_production - $this->input->post('jumlah_barang3');
				
				$query2 = $this->db->query("update sb_production_request_dt set jumlah_on_production = $total
				where request_id = '$request_id' AND barang_kode = '$barang_code'");
			}
		}
		if(isset($_POST['save_prod'])){
			$jumlah=$this->input->post('jumlah');
			$jumlah2=$this->input->post('jumlah2');
			if($jumlah!="" && $jumlah!=0){
				$data = array(
					'prod_id' => $this->input->post('prod_id'),
					'barang_code' => $this->input->post('barang_codes'),
					'jumlah' => $this->input->post('jumlah'),
					'no_penerimaan' => $this->input->post('no_penerimaan'),
					'tgl_penerimaan' => $this->input->post('tgl_penerimaan'),
					'create_date' => $row->waktu,
					'create_by' => $this->session->userdata('first_name').' '.$this->session->userdata('last_name')
				);
				$this->db->insert('sb_finish_good', $data);
			}if($jumlah2!="" && $jumlah2!=0){
				$data = array(
					'prod_id' => $this->input->post('prod_id'),
					'barang_code' => $this->input->post('barang_codes'),
					'jumlah' => $this->input->post('jumlah2'),
					'no_penerimaan' => $this->input->post('no_penerimaan'),
					'tgl_penerimaan' => $this->input->post('tgl_penerimaan'),
					'create_date' => $row->waktu,
					'create_by' => $this->session->userdata('first_name').' '.$this->session->userdata('last_name')
				);
				$this->db->insert('sb_reject', $data);
			}
		}
	}
	
	function getAllInventory()
	{
		$query = $this->db->query("select *, 
		(select isnull(sum(jumlah_on_production), 0)
		from sb_production_request_dt a1
		join sb_production_request_hd b1
		on(a1.request_id=b1.request_id)
		where b1.prod_id=a.prod_id
		)as jumlah_finish
		from sb_production a");
		return $query->result();
	}
	
	function get_all_sb_inventory_limit($p,$u)
	{
		if(!$u){
			$u = 0;
			$p;
		} else {
			$u;
			$p = $p + $u;
		}
		if($this->uri->segment(2) == 'listing'){
			$jumlah = 'select isnull(sum(jumlah), 0)
						from sb_finish_good b1
						where b1.prod_id=a.prod_id';
		} else if ($this->uri->segment(2) == 'listing_scrap'){
			$jumlah = 'select isnull(sum(jumlah), 0)
						from sb_scrap b1
						where b1.prod_id=a.prod_id';
		} else {
			$jumlah = 'select isnull(sum(jumlah), 0)
						from sb_material_return b1
						where b1.prod_id=a.prod_id';
		}
		
		$query = $this->db->query("SELECT * 
			FROM 
			( 
				  SELECT *,
					($jumlah
					)as jumlah_finish, 
					ROW_NUMBER() OVER (ORDER BY prod_id) as rowNum 
				  FROM sb_production a where a.status != 'Finish'
			) sub 
			WHERE rowNum > $u AND rowNum <= $p ");
		return $query->result();
	}
	
	function getAllProductionCount()
	{
		$query = $this->db->query("select count(*)as jumlah	from sb_production  where status='UnFinish'");
		return $query->row();
	}
	
	function get_all_sb_scrap()
	{
		$query = $this->db->query("select *	from sb_barang where barang_category='Scrap' ");
		return $query->result();
	}
	
	function get_request()
	{
		$query = $this->db->query("select *	from sb_barang");
		return $query->result();
	}
	
	function get_barang()
	{
		$query = $this->db->query("select *	from sb_barang");
		return $query->result();
	}
	
	function get_sb_production($prod_id)
	{
		$this->db->where('prod_id',$prod_id);
		$query = $this->db->get('sb_production');
		return $query->row();
	}
	
	function get_sb_production_request_dt($prod_id)
	{
		$this->db->where('a.prod_id',$prod_id);
		$this->db->where('c.jumlah_on_production >', 0);
		$this->db->select('*');
		$this->db->from('sb_production a');
		$this->db->join('sb_production_request_hd b', 'a.prod_id=b.prod_id');
		$this->db->join('sb_production_request_dt c', 'b.request_id=c.request_id');
		$this->db->join('sb_barang d', 'd.barang_code=c.barang_kode');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_finish_good($prod_id)
	{
		/*
		$this->db->where('a.prod_id',$prod_id);
		$this->db->select('*, a.jumlah as jumlah_finish, c.jumlah as jumlah_reject');
		$this->db->from('sb_finish_good a');
		$this->db->join('sb_production_request_hd b', 'a.prod_id=b.prod_id');
		$this->db->join('sb_reject c', 'b.prod_id=c.prod_id');
		$query = $this->db->get();
		*/
		$query = $this->db->query("
			select sb_finish_good.*, (select ISNULL(SUM(sb_reject.jumlah),0) from sb_reject 
			where sb_reject.no_penerimaan = sb_finish_good.no_penerimaan) as Reject
			from sb_finish_good where sb_finish_good.prod_id= '$prod_id'
			order by tgl_penerimaan desc
		");
		return $query->result();
	}
	
	function get_scrap($prod_id)
	{
		$this->db->where('a.prod_id',$prod_id);
		$this->db->select('*');
		$this->db->from('sb_scrap a');
		$query = $this->db->get();
		return $query->result();
	}
	
	function del_sb_production($prod_id)
	{
		$query3 = $this->db->query("select * from sb_production_request_hd where prod_id=$prod_id");
		$row3 = $query3->result();
			
			foreach($row3 as $result){
				$this->db->where('request_id', $result->request_id);
				$this->db->delete('sb_production_request_dt');
			}
			
			$this->db->where('prod_id',$prod_id);
			$this->db->delete('sb_production_request_hd');
			
			$this->db->where('prod_id',$prod_id);
			$this->db->delete('sb_production');
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
	 
	function get_report_laporan_wip()
	{
		$this->db->where('a.jumlah_barang >', 0);
		$this->db->select('*');
		$this->db->from('sb_production_request_dt a');
		$this->db->join('sb_barang b', 'a.barang_kode=b.barang_code');
		$query = $this->db->get();
		return $query->result();
	}
	
	function change_status($kode)
	{
		$this->db->where('prod_id', $kode);
		$data = array(
			'status' => 'Finish'
		);
		$this->db->update('sb_production', $data);
		$this->db->where('prod_id', $kode);
		$this->db->update('sb_production_request_hd', $data);
	}
}	