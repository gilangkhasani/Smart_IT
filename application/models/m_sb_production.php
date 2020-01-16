<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_sb_production extends CI_Model{
	
	function saveBarang($prod_id)
	{
	
		$query=$this->db->query('select GETDATE() as waktu');
		$row=$query->row();
		if(isset($_POST['submit'])){
			
			if($prod_id != NULL){
				$this->db->where('prod_id',$prod_id);
				$data = array (
					'tgl_prod'		=> $this->input->post('tgl_prod'),
					'barang_code'	=> $this->input->post('barang_codes'),
					'modify_date' 	=> $row->waktu,
					'modify_by' 	=> $this->session->userdata('first_name').' '.$this->session->userdata('last_name')
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
				
				$last_request = "";
				$last_tgl = "";

				if ($this->input->post('request_id2')[0]==""){
					$this->session->set_flashdata('berhasil', 'Detail barang kosong');
				}else{
					for( $i = 0; $i < count($this->input->post('request_id2')); $i++ ){
						$data_arr = array(
							'prod_id'		=> $this->input->post('prod_id'),
							'request_id'	=> $this->input->post('request_id2')[$i],
							'tgl_request'	=> $this->input->post('tgl_request2')[$i],
							'status'	 	=> 'UnFinish',
							'create_date' 	=> $row->waktu,
							'create_by' 	=> $this->session->userdata('first_name').' '.$this->session->userdata('last_name')
						);
					
						if($data_arr['request_id'] != $last_request){
							$last_request = $data_arr['request_id'];
							$last_tgl = $data_arr['tgl_request'];
							$data_arr[$i] = $last_request;
							$data_arr[$i] = $last_tgl;
							$data_arr2 = array(
								'prod_id'		=> $this->input->post('prod_id'),
								'request_id'	=> $last_request,
								'tgl_request'	=> $last_tgl,
								'status'	 	=> 'Finish',
								'create_date' 	=> $row->waktu,
								'create_by' 	=> $this->session->userdata('first_name').' '.$this->session->userdata('last_name')
							);
							//echo print_r($data_arr2).'<br/>';
							$this->db->insert('sb_production_request_hd', $data_arr2);
						}	
					}
				
					for( $i = 0; $i < count($this->input->post('request_id2')); $i++ ){
						$data_arr = array(
							'request_id' 	=> rtrim($this->input->post('request_id2')[$i]),
							'barang_kode'	=> $this->input->post('barang_kode2')[$i],
							'jumlah_barang'	=> $this->input->post('jumlah_barang2')[$i],
							'jumlah_on_production'	=> $this->input->post('jumlah_barang2')[$i]
						);
						//echo print_r($data_arr).'<br/>';
						$this->db->insert('sb_production_request_dt', $data_arr);
					}
					$this->session->set_flashdata('berhasil', 'Data berhasil diubah');
				}			
			} else {
				
				$data = array (
					'prod_id'		=> $this->input->post('prod_id'),
					'tgl_prod'		=> $this->input->post('tgl_prod'),
					'barang_code'	=> $this->input->post('barang_codes'),
					'status' 		=> 'UnFinish',
					'create_date' => $row->waktu,
					'create_by' => $this->session->userdata('first_name').' '.$this->session->userdata('last_name')
				);
				$this->db->insert('sb_production', $data);
				
				$last_request="";
				$last_tgl="";

				if ($this->input->post('request_id2')[0]==""){
					$this->session->set_flashdata('berhasil', 'Detail barang kosong');
				}else{
					for( $i = 0; $i < count($this->input->post('request_id2')); $i++ ){
						
						$data_arr = array(
							'prod_id'		=> $this->input->post('prod_id'),
							'request_id'	=> $this->input->post('request_id2')[$i],
							'tgl_request'	=> $this->input->post('tgl_request2')[$i],
							'status'	 	=> 'UnFinish',
							'create_date' 	=> $row->waktu,
							'create_by' 	=> $this->session->userdata('first_name').' '.$this->session->userdata('last_name')
						);
						
						if($data_arr['request_id'] != $last_request){
							$last_request=$data_arr['request_id'];
							$last_tgl=$data_arr['tgl_request'];
							$data_arr[$i]=$last_request;
							$data_arr[$i]=$last_tgl;
							$data_arr2 = array(
								'prod_id'		=> $this->input->post('prod_id'),
								'request_id'	=> $last_request,
								'tgl_request'	=> $last_tgl,
								'status'	 	=> 'UnFinish',
								'create_date' 	=> $row->waktu,
								'create_by' 	=> $this->session->userdata('first_name').' '.$this->session->userdata('last_name')
							);
							$this->db->insert('sb_production_request_hd', $data_arr2);
						}	
					}
					
					
					for( $i = 0; $i < count($this->input->post('request_id2')); $i++ ){
						
						$data_arr = array(
							'request_id' 	=> $this->input->post('request_id2')[$i],
							'barang_kode'	=> $this->input->post('barang_kode2')[$i],
							'jumlah_barang'	=> $this->input->post('jumlah_barang2')[$i],
							'jumlah_on_production'	=> $this->input->post('jumlah_barang2')[$i]
						);
						$this->db->insert('sb_production_request_dt', $data_arr);
					}
					$this->session->set_flashdata('berhasil', 'Data berhasil disimpan');
				}
			}
		if(isset($_POST['finish_request'])){
			$this->db->where('request_id', $this->input->post('request_id'));
			$data = array(
				'status' => 'Finish'
			);
			$this->db->update('sb_production_request_hd', $data);
		}
		if(isset($_POST['save_prod'])){
			$data = array(
				'prod_id' => $this->input->post('prod_id'),
				'tgl_prod' => $this->input->post('tgl_prod'),
				'barang_code' => $this->input->post('barang_codes'),
				'status' => 'UnFinish',
				'create_date' => $row->waktu,
				'create_by' => $this->session->userdata('first_name').' '.$this->session->userdata('last_name')
			);
			$this->db->insert('sb_production', $data);
		}
	
	}
	}
	
	function get_all_sb_production_limit($p,$u)
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
				SELECT a.*, (SELECT SUM (a2.jumlah_on_production) 
				FROM sb_production_request_dt a2 JOIN sb_production_request_hd b2
				ON(a2.request_id = b2.request_id)
				WHERE b2.prod_id = a.prod_id) as jumlah_on_production,
				  (select count(*) 
					from sb_production_request_dt a1 
					join sb_production_request_hd b1 
					on (a1.request_id = b1.request_id)
					where b1. prod_id = a.prod_id and b1.status = 'UnFinish') as jumlah_barang,	
					ROW_NUMBER() OVER (ORDER BY prod_id) as rowNum 
				  FROM sb_production a WHERE status = 'UnFinish'
			) sub 
			WHERE rowNum > $u AND rowNum <= $p ");
		return $query->result();
	}
	
	function getAllProductionCount()
	{
		$query = $this->db->query("select count(*)as jumlah	from sb_production  where status='UnFinish'");
		return $query->row();
	}
	
	function getCountRequest($prod_id)
	{
		$query = $this->db->query("select count(*)as jumlah	from sb_production_request_hd  where prod_id= '$prod_id' AND status = 'UnFinish'");
		return $query->row();
	}
	
	function get_sb_production_dt($prod_id)
	{
		$query = $this->db->query("
			SELECT * FROM sb_production_request_dt a 
			JOIN sb_production_request_hd b ON (a.request_id = b.request_id) 
			JOIN sb_barang d ON (a.barang_kode = d.barang_code)
			WHERE b.prod_id = '$prod_id' AND b.status = 'UnFinish'
		");
		return $query->result();
	}
	
	function get_request_id($prod_id)
	{
		$query = $this->db->query (
					"select distinct(c.request_id) as request_id from sb_production a join sb_production_request_hd b
					on(a.prod_id = b.prod_id)
					join sb_production_request_dt c on (b.request_id = c.request_id)
					where a.prod_id = '$prod_id' AND b.status='UnFinish'");
		return $query->result();			
	}
	
	function getAllProduction()
	{
		$query = $this->db->query("select *	from sb_production  where status='UnFinish'");
		return $query->result();
	}
	
	function get_all_sb_barang_jadi()
	{
		$query = $this->db->query("select *	from sb_barang where barang_category='Barang Jadi' OR barang_category = 'Barang Setengah Jadi'");
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
	
	function get_sb_production_request_hd($request_id)
	{
		$this->db->where('request_id',$request_id);
		$query = $this->db->get('sb_production_request_hd');
		return $query->row();
	}
	
	function get_sb_production_request_dt($prod_id)
	{
		$this->db->where('a.prod_id',$prod_id);
		$this->db->where('b.status','UnFinish');
		$this->db->select('*');
		$this->db->from('sb_production a');
		$this->db->join('sb_production_request_hd b', 'a.prod_id=b.prod_id');
		$this->db->join('sb_production_request_dt c', 'b.request_id=c.request_id');
		$this->db->join('sb_barang d', 'd.barang_code=c.barang_kode');
		$query = $this->db->get();
		return $query->result();
	}
	
	function del_sb_production($prod_id)
	{
		$query3 = $this->db->query("select * from sb_production_request_hd where prod_id= '$prod_id'");
		$row3 = $query3->result();
			
			foreach($row3 as $result){
				$this->db->where('request_id', $result->request_id);
				$this->db->delete('sb_production_request_dt');
			}
			//Delete Production Request
			$this->db->where('prod_id',$prod_id);
			$this->db->delete('sb_production_request_hd');
			//Delete Finish Good
			$this->db->where('prod_id',$prod_id);
			$this->db->delete('sb_finish_good');
			//Delete Scrap
			$this->db->where('prod_id',$prod_id);
			$this->db->delete('sb_scrap');
			//Delete Material Return
			$this->db->where('prod_id',$prod_id);
			$this->db->delete('sb_material_return');
			//Delete production
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
		$query = $this->db->query('
					  SELECT	sb_production_request_dt.barang_kode
								,sb_barang.barang_name
								,sb_barang.satuan_code
								,SUM(jumlah_on_production) as jumlah_barang
								,prod_id as keterangan
					  FROM		sb_production_request_dt 
					  INNER JOIN sb_barang ON sb_barang.barang_code=sb_production_request_dt.barang_kode
					  INNER JOIN sb_production_request_hd ON sb_production_request_hd.request_id=sb_production_request_dt.request_id
					  
					  WHERE		jumlah_on_production > 0
					  
					  GROUP BY sb_production_request_dt.barang_kode, sb_barang.barang_name, 
					  sb_barang.satuan_code, sb_production_request_hd.prod_id
								');
		/*$this->db->where('a.jumlah_barang >', 0);
		$this->db->select('*');
		$this->db->from('sb_production_request_dt a');
		$this->db->join('sb_barang b', 'a.barang_kode=b.barang_code');
		$query = $this->db->get();*/
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