<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sb_barang extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		checkLogin();
		checkAdmin();
		$this->load->model('m_sb_barang');
		$this->load->model('m_sb_satuan');
		$this->load->model('m_sb_login');
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
	}
	
	public function index()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		redirect('Sb_barang/listing');
	}
	
	public function listing2($jenis)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$jenis=str_replace('_', ' ', $jenis);
		if($jenis == 'Mesin Sparepart'){
			$jenis = 'Mesin/Sparepart';
		} else {
			$jenis;
		}
		$data['barang'] = $this->m_sb_barang->get_all_sb_barang($jenis);
		$data['content'] = 'sb_barang/list_sb_barang';
		$this->load->view('template',$data);
	}
	
	public function listing($jenis)
	{
		$this->load->library('pagination');
		
		$jenis2 = $jenis;
		$jenis=str_replace('_', ' ', $jenis);
		if($jenis == 'Mesin Sparepart'){
			$jenis = 'Mesin/Sparepart';
		} else {
			$jenis;
		}
		
		$data['jumlah'] = $this->m_sb_barang->get_all_sb_barang_count($jenis);
		
		$config['base_url'] = base_url().'index.php/Sb_barang/listing/'.$jenis2;
		$config['total_rows'] = $data['jumlah']->jumlah;
		$config['per_page'] = 10; 
		$config['uri_segment'] = 4;	
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(4);
		
		$data['barang'] = $this->m_sb_barang->get_all_sb_barang_active_limit($jenis, $config['per_page'],$uri);
		$data['content'] = 'sb_barang/list_sb_barang';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function listing_void2($jenis)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$jenis=str_replace('_', ' ', $jenis);
		if($jenis == 'Mesin Sparepart'){
			$jenis = 'Mesin/Sparepart';
		} else {
			$jenis;
		}
		$data['barang'] = $this->m_sb_barang->get_all_sb_barang_void($jenis);
		$data['content'] = 'sb_barang/list_sb_barang_void';
		$this->load->view('template',$data);
	}
	
	public function listing_void($jenis)
	{
		$this->load->library('pagination');
		
		$jenis=str_replace('_', ' ', $jenis);
		if($jenis == 'Mesin Sparepart'){
			$jenis = 'Mesin/Sparepart';
		} else {
			$jenis;
		}
		
		$data['jumlah'] = $this->m_sb_barang->get_all_sb_barang_count_void($jenis);
		
		$config['base_url'] = base_url().'index.php/sb_barang/listing_void/'.$jenis;
		$config['total_rows'] = $data['jumlah']->jumlah;
		$config['per_page'] = 10;  
		
		$this->pagination->initialize($config);
		
		$uri = $this->uri->segment(4);
		
		$data['barang'] = $this->m_sb_barang->get_all_sb_barang_void_limit($jenis, $config['per_page'],$uri);
		$data['content'] = 'sb_barang/list_sb_barang_void';
		$data['profil']=$this->m_sb_login->get_profil();
		$this->load->view('template',$data);
	}
	
	public function add()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['content'] = 'sb_barang/form_sb_barang';
		$this->load->view('template', $data);
	}
	
	public function save()
	{
		
		$barang_codes = $this->input->post('barang_codes');
		$barang_code = $this->input->post('barang_code');
		$hasil = $this->m_sb_barang->get_sb_barang($barang_code);
		
		if($hasil->barang_code == "" || $barang_codes != ""){
			$this->m_sb_barang->save_sb_barang($barang_codes);
			$jenis = $this->input->post('barang_category');
			$jenis = str_replace(' ', '_', $jenis);
			if($jenis == 'Mesin/Sparepart'){
				$jenis = 'Mesin_Sparepart';
			} else {
				$jenis;
			}
			redirect('Sb_barang/listing/'.$jenis);
		} else {
			$this->session->set_flashdata('barang',' Kode Barang Sudah Ada Silahkan Isi Kode Barang yang lain !!!');
			$jenis = $this->input->post('barang_category');
			if($jenis == 'Mesin/Sparepart'){
				$jenis = 'Mesin_Sparepart';
			} else {
				$jenis;
			}
			$jenis = str_replace(' ', '_', $jenis);
			redirect('Sb_barang/listing/'.$jenis);
		}
	}
	
	public function search_barang()
	{
		$barang_code = $this->input->post('barang_code');
		$query = $this->db->query("SELECT * from sb_barang where barang_code = '$barang_code'");
		$find = $query->num_rows();
		echo $find;
	}
	
	public function update_save()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$barang_code = $this->input->post('barang_codes');
		$this->m_sb_barang->save_sb_barang($barang_code);
		$jenis = $this->input->post('barang_category');
		
		if($jenis == 'Mesin/Sparepart'){
			$jenis = 'Mesin_Sparepart';
		} else {
			$jenis = str_replace(' ', '_', $jenis);
		}
		redirect('Sb_barang/listing/'.$jenis);
	}
	
	public function edit($barang_code)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$data['barang'] = $this->m_sb_barang->get_sb_barang($barang_code);
		$data['saldo_awal'] = $this->m_sb_barang->get_saldo_barang($barang_code);
		$data['satuan'] = $this->m_sb_satuan->get_sb_satuan($data['barang']->satuan_code);
		$data['content'] = 'sb_barang/form_sb_barang';
		$this->load->view('template',$data);
	}
	
	public function get_saldo_awal($barang_code)
	{	
		$data['profil']=$this->m_sb_login->get_profil();
		$data['barang'] = $this->m_sb_barang->get_saldo_barang($barang_code);
	}
	
	public function delete($barang_code)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$this->m_sb_barang->del_sb_barang($barang_code);
		redirect('Sb_barang/listing/'.$this->uri->segment(4));
	}
	
	public function getKode()
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$barang_code=$this->input->post('barang_code');
		$this->db->query('select * from sb_barang where barang_code like "%'.$barang_code.'%"');
		return $query->result_array();
	}
	
	public function updateVoid($barang_code,$url)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$this->m_sb_barang->update_void_sb_barang($barang_code);
		redirect('Sb_barang/listing_void/'.$url);
	}
	
	public function updateActive($barang_code,$url)
	{
		$data['profil']=$this->m_sb_login->get_profil();
		$this->m_sb_barang->update_active_sb_barang($barang_code);
		redirect('Sb_barang/listing/'.$url);
	}
	
	public function searchactive($jenis)
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
			
		$jenis=str_replace('_', ' ', $jenis);
		if($jenis == 'Mesin Sparepart'){
			$jenis = 'Mesin/Sparepart';
		} else {
			$jenis;
		}
		$this->db->select("sb_barang.*,ISNULL(((SELECT ISNULL(sb_saldo_awal.saldo_awal,0)
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
						(Select end_date From sb_Periode Where periode_id = '$periode')),0) as saldo_akhir");
		$this->db->from ('sb_barang sb_barang');
		$this->db->like('sb_barang.'.$this->input->post('jenis'), $this->input->post('search'));
		$this->db->where('sb_barang.barang_category', $jenis);
		$this->db->where('sb_barang.barang_status', 'Active');
		
		
		$query = $this->db->get();
		echo "<tr>
				<th>Kode Barang</th>
				<th>Nama Barang</th>
				<th>Kode Satuan</th>
				<th>Kode HS</th>
				<th>Saldo</th>
				<th>Void</th>
				<th>Edit</th>
				<!--
				<th>Delete</th>
				!-->
			</tr>";
		$i = 0;
		foreach($query->result()as $row){			
			echo"<tr><td>".$row->barang_code."</td>
				<td>".$row->barang_name."</td>
				<td>".$row->satuan_code."</td>
				<td>".$row->hs_code."</td>
				<td>".$row->saldo_akhir."</td>
				<td><a class='btn btn-success btn-small' style='height:27px; font-size:11px;' href='". base_url()."index.php/Sb_barang/updateVoid/".$row->barang_code."/".$this->uri->segment(3)."'>Void</a></td>
				<td><a onclick=\"modalEdit('$row->barang_code','$row->barang_name','$row->satuan_code','$row->hs_code');\" class='btn btn-primary btn-small' href='' style='height:27px; font-size:11px;' data-toggle='modal' data-target='#myModal1'>Edit</a></td>
				<!--
				<td><a class='btn btn-danger btn-small' style='height:27px; font-size:11px;' onclick='return confirm(\"Are you sure ?\")' href='".base_url()."index.php/Sb_barang/delete/".$row->barang_code."/".str_replace(' ', '_', $row->barang_category)."'>Delete</a></td></tr>
				!-->
				";
		$i++;
		}
	}
	
	public function searchVoid($jenis)
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
	
		$jenis=str_replace('_', ' ', $jenis);
		if($jenis == 'Mesin Sparepart'){
			$jenis = 'Mesin/Sparepart';
		} else {
			$jenis;
		}
		$this->db->select("sb_barang.*,ISNULL(((SELECT ISNULL(sb_saldo_awal.saldo_awal,0)
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
						(Select end_date From sb_Periode Where periode_id = '$periode')),0) as saldo_akhir");
		$this->db->from ('sb_barang sb_barang');
		$this->db->like('sb_barang.'.$this->input->post('jenis'), $this->input->post('search'));
		$this->db->where('sb_barang.barang_category', $jenis);
		$this->db->where('sb_barang.barang_status', 'Void');
		
		
		$query = $this->db->get();
		echo "<tr>
				<th>Kode Barang</th>
				<th>Nama Barang</th>
				<th>Kode Satuan</th>
				<th>Kode HS</th>
				<th>Saldo</th>
				<th>Void</th>
				<!--
				<th>Edit</th>
				<th>Delete</th>
				!-->
			</tr>";
		$i = 0;
		foreach($query->result()as $row){			
			echo"<tr><td>".$row->barang_code."</td>
				<td>".$row->barang_name."</td>
				<td>".$row->satuan_code."</td>
				<td>".$row->hs_code."</td>
				<td>".$row->saldo_awal."</td>
				<td><a class='btn btn-success btn-small' style='height:27px; font-size:11px;' href='". base_url()."index.php/Sb_barang/updateActive/".$row->barang_code."/".$this->uri->segment(3)."'>Active</a></td>
				<!--
				<td><a class='btn btn-primary btn-small' href='' style='height:27px; font-size:11px;' data-toggle='modal' data-target='#myModal".$row->barang_code."'>Edit</a></td>
				
				<td><a class='btn btn-danger btn-small' style='height:27px; font-size:11px;' onclick='return confirm(\"Are you sure ?\")' href='".base_url()."index.php/Sb_barang/delete/".$row->barang_code."/".str_replace(' ', '_', $row->barang_category)."'>Delete</a></td>
				!-->
				</tr>
				";
		$i++;
		}
	}
}