<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wipexcel extends CI_Controller {
		
	public function __construct() {
        parent::__construct();
		checkLogin();
		$this->load->library('PHPExcel/IOFactory');
		$this->load->model('m_sb_barang');
		$this->load->model('m_wip');
		$this->load->model('m_sb_login');
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
	}
 
    public function report_wip()
	{
		if(isset($_POST['excel'])) {
		//do your restore code

			$data1 = $this->m_wip->make_report_laporan_wip();
			
			if(!$data1)
				return false;
			// Starting the PHPExcel library
			$this->load->library('PHPExcel');
			$this->load->library('PHPExcel/IOFactory');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setTitle("Laporan Posisi Barang Dalam Proses")->setDescription("none");
			$objPHPExcel->setActiveSheetIndex(0);
			// Field names in the first row
			$fields = $data1->list_fields();
			$col = 0;
			//Header
			$sheet = $objPHPExcel->getActiveSheet();
			$sheet = $objPHPExcel->getActiveSheet();
			$sheet->setCellValueByColumnAndRow(0, 1, "LAPORAN POSISI BARANG DALAM PROSES");
			$query = $this->db->get("sb_profil");
			if ($query->num_rows() > 0) {
				$row = $query->row();
			$sheet->setCellValueByColumnAndRow(0, 2, $row->company_name);
			$sheet->setCellValueByColumnAndRow(0, 3, $row->company_address);
			$sheet->setCellValueByColumnAndRow(0, 4, "Telp. ".$row->phone." Fax.".$row->fax);
			}
			$sheet->setCellValue('A5', 'No');
			$sheet->setCellValue('B5', 'Kode Barang');
			$sheet->setCellValue('C5', 'Nama Barang');
			$sheet->setCellValue('D5', 'Satuan');
			$sheet->setCellValue('E5', 'Jumlah Barang');
			$sheet->setCellValue('F5', 'Keterangan');
			$sheet->mergeCells('A1:F1');
			$sheet->mergeCells('A2:F2');
			$sheet->mergeCells('A3:F3');
			$sheet->mergeCells('A4:F4');
			$sheet->getColumnDimension('A')->setWidth(12);
			$sheet->getColumnDimension('B')->setWidth(12);
			$sheet->getColumnDimension('C')->setWidth(16);
			$sheet->getColumnDimension('D')->setWidth(12);
			$sheet->getColumnDimension('E')->setWidth(16);
			$sheet->getColumnDimension('F')->setWidth(12);
			
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
			$last_row = ($sheet->getHighestRow());
			
			$sheet->getStyle('E6:E'.$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet
				->getStyle( 'E6:E'.$last_row )
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->setActiveSheetIndex(0);
			$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
			// Sending headers to force the user to download the file
			
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="Laporan Posisi Barang Dalam Proses '.date('d-M-y').'.xls"');
			header('Cache-Control: max-age=0');
			$objWriter->save('php://output');
			//redirect('Blog');
			
		}
		 if(isset($_POST['pdf'])){
			//do your delete code
			//$this->load->library('fpdf');
			//define('FPDF_FONTPATH',$this->config->item('fonts_path'));
			$data['profil']=$this->m_sb_login->get_profil();
			$data['nama']=$this->m_sb_login->get_nama();
			$data['wip'] = $this->m_wip->make_report_laporan_wip_pdf();
			$this->load->view('sb_production/page_prints',$data);
			/*header('Content-type: application/pdf');
			header('Content-Disposition: attachment;filename="Laporan Posisi Barang Dalam Proses '.date('d-M-y').'.pdf"');
			header('Cache-Control: max-age=0');*/
		} 
	}
	
}