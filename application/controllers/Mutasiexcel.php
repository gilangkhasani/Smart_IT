<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutasiexcel extends CI_Controller {	

		public function __construct() {
			parent::__construct();
			checkLogin();
			$this->load->library('PHPExcel/IOFactory');
			$this->load->model('m_sb_mutasi');
			$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
			$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			$this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
			$this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
			$this->output->set_header('Pragma: no-cache');
		}
		
		public function report_mutasi_bb_bp()
		{
			if(isset($_POST['excel'])) 
			{
			//do your restore code
				$periode_id = $this->input->post('periode_id');
				$barang1 = $this->input->post('barang1');
				$barang2 = $this->input->post('barang2');
				$barang_category = $this->input->post('barang_category');
				
				if($barang1 == 'Mesin_Sparepart'){
					$barang1 = 'Mesin/Sparepart';
				} else {
					$barang1=str_replace('_', ' ', $barang1);
				}
				$barang2 = str_replace('_', ' ', $barang2);
				
				$this->db->where('periode_id',$periode_id);
				$query = $this->db->get('sb_periode');
				$row = $query->row();
				
				if(($this->input->post('barang_category') != null && $this->input->post('barang_code') == null) || $this->input->post('barang_category') != null && $this->input->post('barang_code') != null){
					$data1 = $this->m_sb_mutasi->make_report_laporan_mutasi_excel($periode_id,$barang_category);
				} else if ($this->input->post('barang_category') == null && $this->input->post('barang_code') != null){
					$data1 = $this->m_sb_mutasi->make_report_laporan_mutasi_excel_barang_code($periode_id,$barang1,$barang2);
				} else {
					$data1 = $this->m_sb_mutasi->get_report_laporan_mutasi_excel($barang1, $barang2, $periode_id);
				}
				
				$start_date = date("d-F-Y", strtotime($row->start_date));
				$end_date = date("d-F-Y", strtotime($row->end_date));
				
				$periode = 'Periode '.$start_date.' S.D '.$end_date;
				
				if(!$data1)
					return false;
				// Starting the PHPExcel library
				$this->load->library('PHPExcel');
				$this->load->library('PHPExcel/IOFactory');
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setTitle("Laporan Pertanggung Jawaban Mutasi".strtoupper($barang1)." Dan ".strtoupper($barang2)." ".$periode)->setDescription("none");
				$objPHPExcel->setActiveSheetIndex(0);
				// Field names in the first row
				$fields = $data1->list_fields();
				//$col = 5;
				//Header Title
				$sheet = $objPHPExcel->getActiveSheet();
				$sheet->setCellValueByColumnAndRow(0, 1, "LAPORAN PERTANGGUNGJAWABAN MUTASI ".strtoupper($barang1)." DAN ".strtoupper($barang2));
				
				$query = $this->db->get("sb_profil");
				if ($query->num_rows() > 0) {
					$row = $query->row();
					$sheet->setCellValueByColumnAndRow(0, 2, $row->company_name);
				}
				$sheet->setCellValueByColumnAndRow(0, 3, $periode);
				$sheet->setCellValue('A5', 'NO');
				$sheet->setCellValue('B5', 'KODE BARANG');
				$sheet->setCellValue('C5', 'NAMA BARANG');
				$sheet->setCellValue('D5', 'SAT');
				$sheet->setCellValue('E5', 'JENIS');
				$sheet->setCellValue('F5', 'SALDO AWAL');
				$sheet->setCellValue('G5', 'PEMASUKAN');
				$sheet->setCellValue('H5', 'PENGELUARAN');
				$sheet->setCellValue('I5', 'PENYESUAIAN');
				$sheet->setCellValue('J5', 'SALDO AKHIR');
				$sheet->setCellValue('K5', 'STOK OPNAME');
				$sheet->setCellValue('L5', 'SELISIH');
				$sheet->setCellValue('M5', 'KETERANGAN');
				$sheet->mergeCells('A1:M1');
				$sheet->mergeCells('A2:M2');
				$sheet->mergeCells('A3:M3');
				$sheet->mergeCells('A4:M4');
				$sheet->getColumnDimension('A')->setWidth(6);
				$sheet->getColumnDimension('B')->setWidth(16);
				$sheet->getColumnDimension('C')->setWidth(16);
				$sheet->getColumnDimension('D')->setWidth(8);
				$sheet->getColumnDimension('E')->setWidth(16);
				$sheet->getColumnDimension('F')->setWidth(16);
				$sheet->getColumnDimension('G')->setWidth(16);
				$sheet->getColumnDimension('H')->setWidth(16);
				$sheet->getColumnDimension('I')->setWidth(16);
				$sheet->getColumnDimension('J')->setWidth(16);
				$sheet->getColumnDimension('K')->setWidth(16);
				$sheet->getColumnDimension('L')->setWidth(14);
				$sheet->getColumnDimension('M')->setWidth(16);
				
				$style = array(
					'alignment' => array(
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					)
				);
				
				$sheet->getDefaultStyle()->applyFromArray($style);
				// Isi
				$row = 6;
				foreach($data1->result() as $data)
				{
					$col = 0;
					foreach ($fields as $field)
					{
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
						$col++;
					}
					$row++;
				}
				
				$last_row = ($sheet->getHighestRow()+1);
				$last_row2 = ($sheet->getHighestRow());
				if($data1->num_rows() > 0){
					
					$sheet->setCellValueByColumnAndRow(0, $last_row, "Grand Total");
					$sheet->mergeCells('A'.$last_row.':E'.$last_row.'');
					$sheet->setCellValue('F'.$last_row.'', '=SUBTOTAL(9,F6:F'.$last_row2.')');
					$sheet->setCellValue('G'.$last_row.'', '=SUBTOTAL(9,G6:G'.$last_row2.')');
					$sheet->setCellValue('H'.$last_row.'', '=SUBTOTAL(9,H6:H'.$last_row2.')');
					$sheet->setCellValue('I'.$last_row.'', '=SUBTOTAL(9,I6:I'.$last_row2.')');
					$sheet->setCellValue('J'.$last_row.'', '=SUBTOTAL(9,J6:J'.$last_row2.')');
					$sheet->setCellValue('K'.$last_row.'', '=SUBTOTAL(9,K6:K'.$last_row2.')');
					$sheet->setCellValue('L'.$last_row.'', '=SUBTOTAL(9,L6:L'.$last_row2.')');
					$sheet->setCellValue('M'.$last_row.'', '-');
				}
				$sheet->getStyle('F6:F'.$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sheet->getStyle('G6:G'.$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sheet->getStyle('H6:H'.$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sheet->getStyle('I6:I'.$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sheet->getStyle('J6:J'.$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sheet->getStyle('K6:K'.$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sheet->getStyle('L6:L'.$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				
				$sheet
				->getStyle( 'F6:F'.$last_row )
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  
				$sheet
				->getStyle( 'G6:G'.$last_row )
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$sheet
				->getStyle( 'H6:H'.$last_row )
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$sheet
				->getStyle( 'I6:I'.$last_row )
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$sheet
				->getStyle( 'J6:J'.$last_row )
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$sheet
				->getStyle( 'K6:K'.$last_row )
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$sheet
				->getStyle( 'L6:L'.$last_row )
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				$objPHPExcel->setActiveSheetIndex(0);
				$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
				// Sending headers to force the user to download the file
				
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="Laporan Pertanggung jawaban Mutasi '.$barang1.' '.$barang2.' '.$periode.'.xls"');
				header('Cache-Control: max-age=0');
				$objWriter->save('php://output');
			}
			if(isset($_POST['pdf'])){
				$barang1 = $this->input->post('barang1');
				$barang2 = $this->input->post('barang2');
				if($barang1 == 'Mesin_Sparepart'){
					$barang1 = 'Mesin/Sparepart';
				} else {
					$barang1=str_replace('_', ' ', $barang1);
				}
				$barang2 = str_replace('_', ' ', $barang2);
				$periode_id = $this->input->post('periode_id');
				$data['periode'] = $this->m_sb_mutasi->get_periodes($periode_id);
				$data['profil'] = $this->m_sb_mutasi->get_profile();
				$barang_category = $this->input->post('barang_category');
				
				
				if(($this->input->post('barang_category') != null && $this->input->post('barang_code') == null) || $this->input->post('barang_category') != null && $this->input->post('barang_code') != null){
					$data['mutasi'] = $this->m_sb_mutasi->make_report_laporan_mutasi_excel($periode_id,$barang_category);
				} else if ($this->input->post('barang_category') == null && $this->input->post('barang_code') != null){
					$data['mutasi'] = $this->m_sb_mutasi->make_report_laporan_mutasi_excel_barang_code($periode_id,$barang1,$barang2);
				} else {
					$data['mutasi'] = $this->m_sb_mutasi->get_report_laporan_mutasi_pdf($barang1, $barang2, $periode_id);
				}	
				/*
				$data['mutasi']=$this->m_sb_mutasi->make_report_laporan_mutasi_pdf($periode_id,$barang_category);
				
				if($barang_category == ""){
					$data['mutasi'] = $this->m_sb_mutasi->get_report_laporan_mutasi_pdf($barang1, $barang2, $periode_id);
				}
				*/
				$this->load->view('sb_mutasi/page_prints',$data);	
			}
		}
		
		private function _gen_pdf($html,$paper='A4')
		{
			 ob_end_clean();
			 $CI =& get_instance();
			 $CI->load->library('MPDF56/mpdf');
			 $mpdf=new mPDF();
			 $mpdf->AddPage('L', // L - landscape, P - portrait
						'', '', '', '',
						5, // margin_left
						5, // margin right
						5, // margin top
						5, // margin bottom
						18, // margin header
						12); // margin footer
			 $mpdf->debug = true;
			 $mpdf->WriteHTML($html);
			 $mpdf->Output();
			 header('Content-type: application/pdf');
			header('Content-Disposition: attachment;filename="Laporan Pertanggung jawaban Mutasi.pdf"');
			header('Cache-Control: max-age=0');
		}
}	