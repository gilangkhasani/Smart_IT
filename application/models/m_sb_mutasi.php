<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_sb_mutasi extends CI_Model{

	function get_periode()
	{
		$query = $this->db->query('SELECT * FROM sb_periode');
		return $query->result();
	}
	
	function get_report_laporan_mutasi($barang1, $barang2, $periode)
	{
		$query = $this->db->query("PROD_MUTASI @cek = 'L', @barang_category = '', @periode = '$periode', @barang_category_l1 = '$barang1', @barang_category_l2 = '$barang2' ");
		return $query->result();
	}
	
	function make_report_laporan_mutasi($periode,$barang_category)
	{	
		//$barang_category = $this->input->post('barang_category');
		$query = $this->db->query("PROD_MUTASI @cek = 'F', @barang_category = '$barang_category', @periode = '$periode', @barang_category_l1 = '', @barang_category_l2 = '' ");
		return $query->result();
	}
	
	function get_report_laporan_mutasi_excel($barang1, $barang2, $periode)
	{
		$query = $this->db->query("PROD_MUTASI @cek = 'L', @barang_category = '', @periode = '$periode', @barang_category_l1 = '$barang1', @barang_category_l2 = '$barang2' ");
		return $query;
	}
	
	function make_report_laporan_mutasi_excel($periode,$barang_category)
	{	
		
		if($this->input->post('barang_category') != ''){
			$barang_category = "AND sb_barang.barang_category = '".$this->input->post('barang_category')."' ";
		}else {
			$barang_category = '';
		}
		
		if($this->input->post('barang_code') != ''){
			$barang_code = "AND sb_barang.barang_code like '%".$this->input->post('barang_code')."%' ";
		}else {
			$barang_code = '';
		}
		
		$query = $this->db->query("
			SELECT ROW_NUMBER() OVER (ORDER BY sb_barang.barang_category, sb_barang.barang_code) AS no,
			sb_barang.barang_code, sb_barang.barang_name, sb_barang.satuan_code, sb_barang.barang_category,	
				(SELECT ISNULL(SUM(sb_saldo_awal.saldo_awal),0)
						FROM sb_saldo_awal
						WHERE sb_saldo_awal.barang_code=sb_barang.barang_code and sb_saldo_awal.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) as stock_awal,
						
				((SELECT	ISNULL(SUM(sb_doc_import_dt.jumlah_barang),0)
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
						(Select end_date From sb_Periode Where periode_id = '$periode'))) as pemasukan,
						
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
						(Select end_date From sb_Periode Where periode_id = '$periode')))	as pengeluaran,
						
				(SELECT ISNULL(SUM(sb_penyesuaian.penyesuaian),0)
						FROM sb_penyesuaian
						WHERE sb_penyesuaian.barang_code=sb_barang.barang_code and sb_penyesuaian.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) as penyesuaian,
				
				(((SELECT ISNULL(SUM(sb_saldo_awal.saldo_awal),0)
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
						(Select end_date From sb_Periode Where periode_id = '$periode')))	-
				((SELECT  ISNULL(SUM(sb_doc_export_dt.jumlah_barang),0)
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
						(Select end_date From sb_Periode Where periode_id = '$periode'))) +
				(SELECT ISNULL(SUM(sb_penyesuaian.penyesuaian),0)
						FROM sb_penyesuaian
						WHERE sb_penyesuaian.barang_code=sb_barang.barang_code and sb_penyesuaian.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode'))) as saldo_akhir,
							
				(SELECT ISNULL(SUM(sb_stock_opname.stock_opname),0)
						FROM sb_stock_opname
						WHERE sb_stock_opname.barang_code=sb_barang.barang_code and sb_stock_opname.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) as stock_opname,
				
				((SELECT ISNULL(SUM(sb_stock_opname.stock_opname),
				(((SELECT ISNULL(SUM(sb_saldo_awal.saldo_awal),0)
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
						(Select end_date From sb_Periode Where periode_id = '$periode')))	-
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
						(Select end_date From sb_Periode Where periode_id = '$periode'))) +
				(SELECT ISNULL(SUM(sb_penyesuaian.penyesuaian),0)
						FROM sb_penyesuaian
						WHERE sb_penyesuaian.barang_code=sb_barang.barang_code and sb_penyesuaian.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode'))) )
						FROM sb_stock_opname
						WHERE sb_stock_opname.barang_code=sb_barang.barang_code and sb_stock_opname.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode'))) -
				
				(((SELECT ISNULL(SUM(sb_saldo_awal.saldo_awal),0)
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
						(Select end_date From sb_Periode Where periode_id = '$periode')))	-
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
						(Select end_date From sb_Periode Where periode_id = '$periode'))) +
				(SELECT ISNULL(SUM(sb_penyesuaian.penyesuaian),0)
						FROM sb_penyesuaian
						WHERE sb_penyesuaian.barang_code=sb_barang.barang_code and sb_penyesuaian.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) ) as selisih,
				
				(SELECT ISNULL(sb_stock_opname.keterangan,'')
						FROM sb_stock_opname
						WHERE sb_stock_opname.barang_code=sb_barang.barang_code and sb_stock_opname.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) as keterangan
						
		FROM	sb_barang 
		
		WHERE	sb_barang.barang_status='Active' And
				(SELECT ISNULL(sb_saldo_awal.saldo_awal,0)
						FROM sb_saldo_awal
						WHERE sb_saldo_awal.barang_code=sb_barang.barang_code and sb_saldo_awal.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) > 0 
				$barang_category $barang_code
		
				OR
				
				sb_barang.barang_status='Active' And 
				((SELECT ISNULL(SUM(sb_doc_import_dt.jumlah_barang),0)
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
						(Select end_date From sb_Periode Where periode_id = '$periode'))) > 0 
				$barang_category $barang_code
			;
		");
		
		//$query = $this->db->query("PROD_MUTASI @cek = 'F', @barang_category = '$barang_category', @periode = '$periode', @barang_category_l1 = '', @barang_category_l2 = '' ");
		if(isset($_POST['pdf'])){
			return $query->result();
		} else {
			return $query;
		}
	}
	
	function make_report_laporan_mutasi_excel_barang_code($periode,$barang1,$barang2)
	{	
		
		if($this->input->post('barang_code') != ''){
			$barang_code = "AND sb_barang.barang_code like '%".$this->input->post('barang_code')."%' ";
		}else {
			$barang_code = '';
		}
		
		$query = $this->db->query("
			SELECT ROW_NUMBER() OVER (ORDER BY sb_barang.barang_category, sb_barang.barang_code) AS no,
			sb_barang.barang_code, sb_barang.barang_name, sb_barang.satuan_code, sb_barang.barang_category,	
				(SELECT ISNULL(SUM(sb_saldo_awal.saldo_awal),0)
						FROM sb_saldo_awal
						WHERE sb_saldo_awal.barang_code=sb_barang.barang_code and sb_saldo_awal.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) as stock_awal,
						
				((SELECT	ISNULL(SUM(sb_doc_import_dt.jumlah_barang),0)
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
						(Select end_date From sb_Periode Where periode_id = '$periode'))) as pemasukan,
						
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
						(Select end_date From sb_Periode Where periode_id = '$periode')))	as pengeluaran,
						
				(SELECT ISNULL(SUM(sb_penyesuaian.penyesuaian),0)
						FROM sb_penyesuaian
						WHERE sb_penyesuaian.barang_code=sb_barang.barang_code and sb_penyesuaian.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) as penyesuaian,
				
				(((SELECT ISNULL(SUM(sb_saldo_awal.saldo_awal),0)
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
						(Select end_date From sb_Periode Where periode_id = '$periode')))	-
				((SELECT  ISNULL(SUM(sb_doc_export_dt.jumlah_barang),0)
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
						(Select end_date From sb_Periode Where periode_id = '$periode'))) +
				(SELECT ISNULL(SUM(sb_penyesuaian.penyesuaian),0)
						FROM sb_penyesuaian
						WHERE sb_penyesuaian.barang_code=sb_barang.barang_code and sb_penyesuaian.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode'))) as saldo_akhir,
							
				(SELECT ISNULL(SUM(sb_stock_opname.stock_opname),0)
						FROM sb_stock_opname
						WHERE sb_stock_opname.barang_code=sb_barang.barang_code and sb_stock_opname.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) as stock_opname,
				
				((SELECT ISNULL(SUM(sb_stock_opname.stock_opname),
				(((SELECT ISNULL(SUM(sb_saldo_awal.saldo_awal),0)
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
						(Select end_date From sb_Periode Where periode_id = '$periode')))	-
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
						(Select end_date From sb_Periode Where periode_id = '$periode'))) +
				(SELECT ISNULL(SUM(sb_penyesuaian.penyesuaian),0)
						FROM sb_penyesuaian
						WHERE sb_penyesuaian.barang_code=sb_barang.barang_code and sb_penyesuaian.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode'))) )
						FROM sb_stock_opname
						WHERE sb_stock_opname.barang_code=sb_barang.barang_code and sb_stock_opname.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode'))) -
				
				(((SELECT ISNULL(SUM(sb_saldo_awal.saldo_awal),0)
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
						(Select end_date From sb_Periode Where periode_id = '$periode')))	-
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
						(Select end_date From sb_Periode Where periode_id = '$periode'))) +
				(SELECT ISNULL(SUM(sb_penyesuaian.penyesuaian),0)
						FROM sb_penyesuaian
						WHERE sb_penyesuaian.barang_code=sb_barang.barang_code and sb_penyesuaian.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) ) as selisih,
				
				(SELECT ISNULL(sb_stock_opname.keterangan,'')
						FROM sb_stock_opname
						WHERE sb_stock_opname.barang_code=sb_barang.barang_code and sb_stock_opname.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) as keterangan
						
		FROM	sb_barang 
		
		WHERE	sb_barang.barang_status='Active' And
				(SELECT ISNULL(sb_saldo_awal.saldo_awal,0)
						FROM sb_saldo_awal
						WHERE sb_saldo_awal.barang_code=sb_barang.barang_code and sb_saldo_awal.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) > 0 
				/*AND b.periode_id = '$periode'*/
				AND sb_barang.barang_category = '$barang1' $barang_code
		
				OR
				
				sb_barang.barang_status='Active' And 
				((SELECT	ISNULL(SUM(sb_doc_import_dt.jumlah_barang),0)
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
						(Select end_date From sb_Periode Where periode_id = '$periode'))) > 0 
				/*AND b.periode_id = '$periode'*/
				AND sb_barang.barang_category = '$barang1' $barang_code
				
				OR
				
				sb_barang.barang_status='Active' And
				(SELECT ISNULL(sb_saldo_awal.saldo_awal,0)
						FROM sb_saldo_awal
						WHERE sb_saldo_awal.barang_code=sb_barang.barang_code and sb_saldo_awal.create_date Between
						(Select start_date From sb_Periode Where periode_id = '$periode') And 
						(Select end_date From sb_Periode Where periode_id = '$periode')) > 0 
				/*AND b.periode_id = '$periode'*/
				AND sb_barang.barang_category = '$barang2' $barang_code
		
				OR
				
				sb_barang.barang_status='Active' And 
				((SELECT	ISNULL(SUM(sb_doc_import_dt.jumlah_barang),0)
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
						(Select end_date From sb_Periode Where periode_id = '$periode'))) > 0 
				/*AND b.periode_id = '$periode'*/
				AND sb_barang.barang_category = '$barang2' $barang_code
			;
		");
		
		//$query = $this->db->query("PROD_MUTASI @cek = 'F', @barang_category = '$barang_category', @periode = '$periode', @barang_category_l1 = '', @barang_category_l2 = '' ");
		if(isset($_POST['pdf'])){
			return $query->result();
		} else {
			return $query;
		}
	}
	
	function get_report_laporan_mutasi_pdf($barang1, $barang2, $periode)
	{
		$query = $this->db->query("PROD_MUTASI @cek = 'L', @barang_category = '', @periode = '$periode', @barang_category_l1 = '$barang1', @barang_category_l2 = '$barang2' ");
		return $query->result();
	}
	
	function make_report_laporan_mutasi_pdf($periode,$barang_category)
	{	
		//$barang_category = $this->input->post('barang_category');
		$query = $this->db->query("PROD_MUTASI @cek = 'F', @barang_category = '$barang_category', @periode = '$periode', @barang_category_l1 = '', @barang_category_l2 = '' ");
		return $query->result();
	}
	
	function get_periodes($periode_id)
	{
		$this->db->where('periode_id',$periode_id);
		$query = $this->db->get('sb_periode');
		return $query->result(); 
	}
	
	function get_profile()
	{
		$this->db->select('*');
		$query = $this->db->get('sb_profil');
		return $query->result(); 
	}
}