<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_eksport_pengeluaran extends CI_Model{

	function get_periode()
	{
		$query = $this->db->query('SELECT * FROM sb_periode WHERE CONVERT (date, GETDATE()) > end_date');
		return $query->result();
	}
	
	function get_report_laporan_pengeluaran()
	{
		$query = $this->db->query
					("SELECT ROW_NUMBER() OVER (ORDER BY a.jenis_doc ASC, a.tgl_bukti DESC) AS no, a.jenis_doc,a.no_doc,CONVERT(date,a.tgl_doc) as tgl_doc,CONVERT(date,a.tgl_bukti) as tgl_bukti,a.no_bukti,e.supplier_name,
						b.barang_code,c.barang_name,b.jumlah_doc,b.satuan_doc,a.valas,b.nilai_barang
						FROM sb_doc_export_hd a 
						JOIN sb_doc_export_dt b ON (a.doc_id = b.doc_id)
						JOIN sb_barang c ON (b.barang_code = c.barang_code)
						JOIN sb_supplier e ON (a.supplier_code = e.supplier_code)
						WHERE YEAR(a.tgl_bukti) < DATEADD(YEAR, 1, GETDATE())
						AND a.status='Finish'
						ORDER BY a.jenis_doc ASC, a.tgl_bukti DESC");
		return $query->result();
	}
	
	function make_report_laporan_pengeluaran()
	{
		if($this->input->post('jenis_doc') != ''){
			$jenis_doc = "AND jenis_doc = '".$this->input->post('jenis_doc')."' ";
		}else {
			$jenis_doc = ' ';
		}
		
		if($this->input->post('no_doc') != ''){
			$no_doc = "AND no_doc like '%".$this->input->post('no_doc')."%' ";
		}else {
			$no_doc = ' ';
		}
		
		if($this->input->post('no_bukti') != ''){
			$no_bukti = "AND no_bukti like '%".$this->input->post('no_bukti')."%' ";
		}else {
			$no_bukti = ' ';
		}
		
		if($this->input->post('tgl_doc') != '' && $this->input->post('min_tgl_doc') == '' && $this->input->post('max_tgl_doc') == ''){
			$tgl_doc = "AND tgl_doc like '%".$this->input->post('tgl_doc')."%' ";
		}else {
			$tgl_doc = ' ';
		}
		
		if($this->input->post('tgl_bukti') != '' && $this->input->post('min_tgl_bukti') == '' && $this->input->post('max_tgl_bukti') == ''){
			$tgl_bukti = "AND tgl_bukti like '%".$this->input->post('tgl_bukti')."%' ";
		}else {
			$tgl_bukti = ' ';
		}
		
		if($this->input->post('tgl_doc') == '' && $this->input->post('min_tgl_doc') != '' && $this->input->post('max_tgl_doc') != ''){
			$tgl_doc = "AND tgl_doc BETWEEN '".$this->input->post('min_tgl_doc')."' AND '".$this->input->post('max_tgl_doc')."' ";
		}else {
			$tgl_doc = ' ';
		}
		
		if($this->input->post('tgl_bukti') == '' && $this->input->post('min_tgl_bukti') != '' && $this->input->post('max_tgl_bukti') != ''){
			$tgl_bukti = "AND tgl_bukti BETWEEN '".$this->input->post('min_tgl_bukti')."' AND '".$this->input->post('max_tgl_bukti')."' ";
		}else {
			$tgl_bukti = ' ';
		}
		
		if($this->input->post('supplier_code') != ''){
			$supplier_code = "AND f.supplier_name like '%".$this->input->post('supplier_code')."%' ";
		}else {
			$supplier_code = ' ';
		}
		
		if($this->input->post('jumlah_doc') != ''){
			$jumlah_doc = "AND jumlah_doc like '%".$this->input->post('jumlah_doc')."%' ";
		}else {
			$jumlah_doc = ' ';
		}
		
		if($this->input->post('barang_code') != ''){
			$barang_code = "AND c.barang_code like '%".$this->input->post('barang_code')."%' ";
		}else {
			$barang_code = ' ';
		}
		
		if($this->input->post('valas') != ''){
			$valas = "AND valas like '%".$this->input->post('valas')."%' ";
		}else {
			$valas = ' ';
		}
		
		if($this->input->post('barang_name') != ''){
			$barang_name = "AND barang_name like '%".$this->input->post('barang_name')."%' ";
		}else {
			$barang_name = ' ';
		}		
		
		if($this->input->post('nilai_barang') != ''){
			$nilai_barang = "AND nilai_barang like '%".$this->input->post('nilai_barang')."%' ";
		}else {
			$nilai_barang = ' ';
		}
		
		if($this->input->post('satuan_doc') != ''){
			$satuan_doc = "AND satuan_doc like '%".$this->input->post('satuan_doc')."%' ";
		}else {
			$satuan_doc = ' ';
		}
	
		$query = $this->db->query
					("SELECT ROW_NUMBER() OVER (ORDER BY a.jenis_doc ASC, a.tgl_bukti DESC) AS no, a.jenis_doc,a.no_doc,CONVERT(date,a.tgl_doc) AS tgl_doc,a.no_bukti,CONVERT(date,a.tgl_bukti) AS tgl_bukti,f.supplier_name,
					b.barang_code,c.barang_name,b.satuan_doc,b.jumlah_doc,a.valas,b.nilai_barang
						FROM sb_doc_export_hd a 
						JOIN sb_doc_export_dt b ON (a.doc_id = b.doc_id)
						JOIN sb_barang c ON (b.barang_code = c.barang_code)
						JOIN sb_supplier f ON (a.supplier_code = f.supplier_code)
						WHERE YEAR(a.tgl_bukti) < DATEADD(YEAR, 1, GETDATE())
						AND a.status='Finish'
						$jenis_doc $no_doc $no_bukti $tgl_doc $tgl_bukti $supplier_code
						$jumlah_doc $barang_code $valas $barang_name $nilai_barang $satuan_doc
						ORDER BY a.jenis_doc ASC, a.tgl_bukti DESC");
		return $query;				
	}
	
	function make_report_laporan_pengeluaran_pdf()
	{
		if($this->input->post('jenis_doc') != ''){
			$jenis_doc = "AND jenis_doc = '".$this->input->post('jenis_doc')."' ";
		}else {
			$jenis_doc = ' ';
		}
		
		if($this->input->post('no_doc') != ''){
			$no_doc = "AND no_doc like '%".$this->input->post('no_doc')."%' ";
		}else {
			$no_doc = ' ';
		}
		
		if($this->input->post('no_bukti') != ''){
			$no_bukti = "AND no_bukti like '%".$this->input->post('no_bukti')."%' ";
		}else {
			$no_bukti = ' ';
		}
		
		if($this->input->post('tgl_doc') != '' && $this->input->post('min_tgl_doc') == '' && $this->input->post('max_tgl_doc') == ''){
			$tgl_doc = "AND tgl_doc like '%".$this->input->post('tgl_doc')."%' ";
		}else {
			$tgl_doc = ' ';
		}
		
		if($this->input->post('tgl_bukti') != '' && $this->input->post('min_tgl_bukti') == '' && $this->input->post('max_tgl_bukti') == ''){
			$tgl_bukti = "AND tgl_bukti like '%".$this->input->post('tgl_bukti')."%' ";
		}else {
			$tgl_bukti = ' ';
		}
		
		if($this->input->post('tgl_doc') == '' && $this->input->post('min_tgl_doc') != '' && $this->input->post('max_tgl_doc') != ''){
			$tgl_doc = "AND tgl_doc BETWEEN '".$this->input->post('min_tgl_doc')."' AND '".$this->input->post('max_tgl_doc')."' ";
		}else {
			$tgl_doc = ' ';
		}
		
		if($this->input->post('tgl_bukti') == '' && $this->input->post('min_tgl_bukti') != '' && $this->input->post('max_tgl_bukti') != ''){
			$tgl_bukti = "AND tgl_bukti BETWEEN '".$this->input->post('min_tgl_bukti')."' AND '".$this->input->post('max_tgl_bukti')."' ";
		}else {
			$tgl_bukti = ' ';
		}
		
		if($this->input->post('supplier_code') != ''){
			$supplier_code = "AND f.supplier_name like '%".$this->input->post('supplier_code')."%' ";
		}else {
			$supplier_code = ' ';
		}
		
		if($this->input->post('jumlah_doc') != ''){
			$jumlah_doc = "AND jumlah_doc like '%".$this->input->post('jumlah_doc')."%' ";
		}else {
			$jumlah_doc = ' ';
		}
		
		if($this->input->post('barang_code') != ''){
			$barang_code = "AND c.barang_code like '%".$this->input->post('barang_code')."%' ";
		}else {
			$barang_code = ' ';
		}
		
		if($this->input->post('valas') != ''){
			$valas = "AND valas like '%".$this->input->post('valas')."%' ";
		}else {
			$valas = ' ';
		}
		
		if($this->input->post('barang_name') != ''){
			$barang_name = "AND barang_name like '%".$this->input->post('barang_name')."%' ";
		}else {
			$barang_name = ' ';
		}		
		
		if($this->input->post('nilai_barang') != ''){
			$nilai_barang = "AND nilai_barang like '%".$this->input->post('nilai_barang')."%' ";
		}else {
			$nilai_barang = ' ';
		}
		
		if($this->input->post('satuan_doc') != ''){
			$satuan_doc = "AND satuan_doc like '%".$this->input->post('satuan_doc')."%' ";
		}else {
			$satuan_doc = ' ';
		}
	
		$query = $this->db->query
					("SELECT ROW_NUMBER() OVER (ORDER BY a.jenis_doc ASC, a.tgl_bukti DESC) AS no, a.jenis_doc,a.no_doc,CONVERT(date,a.tgl_doc) AS tgl_doc,a.no_bukti,CONVERT(date,a.tgl_bukti) AS tgl_bukti,f.supplier_name,
					b.barang_code,c.barang_name,b.satuan_doc,b.jumlah_doc,a.valas,b.nilai_barang
						FROM sb_doc_export_hd a 
						JOIN sb_doc_export_dt b ON (a.doc_id = b.doc_id)
						JOIN sb_barang c ON (b.barang_code = c.barang_code)
						JOIN sb_supplier f ON (a.supplier_code = f.supplier_code)
						WHERE YEAR(a.tgl_bukti) < DATEADD(YEAR, 1, GETDATE())
						AND a.status='Finish'
						$jenis_doc $no_doc $no_bukti $tgl_doc $tgl_bukti $supplier_code
						$jumlah_doc $barang_code $valas $barang_name $nilai_barang $satuan_doc
						ORDER BY a.jenis_doc ASC, a.tgl_bukti DESC");
		return $query->result();				
	}
	
	function get_profile()
	{
		$this->db->select('*');
		$query = $this->db->get('sb_profil');
		return $query->result(); 
	}
}