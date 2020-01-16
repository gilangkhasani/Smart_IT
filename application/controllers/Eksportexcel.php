<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eksportexcel extends CI_Controller {
		
	public function __construct() {
        parent::__construct();
		checkLogin();
		$this->load->library('PHPExcel/IOFactory');
		$this->load->model('m_sb_barang');
		$this->load->model('m_eksport_pengeluaran');
		$this->load->model('m_sb_login');
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
	}
 
    public function index() {
        $objPHPExcel = new PHPExcel();
 
                // Set properties
        $objPHPExcel->getProperties()
					->setCreator("SMA Insan Cendekia Alkautsar") //creator
                    ->setTitle("Jadwal pelajaran");  //file title
 
        $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
        $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
 
        $objget->setTitle('Sample Sheet'); //sheet title
        $objset->setCellValue('A1',"This is Sample Excel File"); //insert cell value
        $objget->getStyle('A1')->getFont()->setBold(true)  // set font weight
                ->setSize(15);    //set font size
		/* set column width			
		$objPHPExcel->getActiveSheet()
		->getColumnDimension('D')
		->setWidth(12);
		*/
		/* set row height
		$objPHPExcel->getActiveSheet()
		->getRowDimension('10')
		->setRowHeight(100);
		*/
		/* Merge and Center 
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:B1")->applyFromArray($style);
			Merge and Center for all cells
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getDefaultStyle()->applyFromArray($style);
		*/
        //table header
        $cols = array("A","B","C","D","E","F");
		$val = array("No","Member ID","Member Username","Member Address","Member Phone","Member Status");
        for ($a = 0; $a < 6; $a++) {
			$objset->setCellValue($cols[$a].'3', $val[$a]);
			//set borders
			$objget->getStyle($cols[$a].'3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objget->getStyle($cols[$a].'3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objget->getStyle($cols[$a].'3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objget->getStyle($cols[$a].'3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	 
			//set alignment
			$objget->getStyle($cols[$a].'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//set font weight
			$objget->getStyle($cols[$a].'3')->getFont()->setBold(true) ;
        } 
            //taruh baris data disini
 
            //simpan dalam file sample.xls
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');                
		$objWriter->save('assets/file/sample.xls');
		redirect('Blog');	
	}
	
	public function report_pengeluaran()
	{
		if(isset($_POST['excel'])) {
		//do your restore code

			$data1 = $this->m_eksport_pengeluaran->make_report_laporan_pengeluaran();
			
			if(!$data1)
				return false;
			// Starting the PHPExcel library
			$this->load->library('PHPExcel');
			$this->load->library('PHPExcel/IOFactory');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setTitle("Laporan Pengeluaran Barang Per Dokumen")->setDescription("none");
			$objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getDefaultStyle()
    		->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			// Field names in the first row
			$fields = $data1->list_fields();
			//$col = 5;
			//Header Title
			$sheet = $objPHPExcel->getActiveSheet();
			$sheet->setCellValueByColumnAndRow(0, 1, "LAPORAN PENGELUARAN BARANG PER DOKUMEN PABEAN");
			$query = $this->db->get("sb_profil");
			if ($query->num_rows() > 0) {
				$row = $query->row();
				
				$sheet->setCellValueByColumnAndRow(0, 2, $row->company_name);
				$sheet->setCellValueByColumnAndRow(0, 3, $row->company_address);
				$sheet->setCellValueByColumnAndRow(0, 4, "Telp. ".$row->phone." Fax.".$row->fax);
			}
			$sheet->setCellValueByColumnAndRow(0, 6, "No");
			$sheet->setCellValueByColumnAndRow(1, 6, "Dokumen");
			$sheet->setCellValueByColumnAndRow(4, 6, "Bukti Pemasukan");
			$sheet->setCellValueByColumnAndRow(6, 6, "Supplier");
			$sheet->setCellValueByColumnAndRow(7, 6, "Kode Barang");
			$sheet->setCellValueByColumnAndRow(8, 6, "Nama Barang");
			$sheet->setCellValueByColumnAndRow(9, 6, "Satuan");
			$sheet->setCellValueByColumnAndRow(10, 6, "Jumlah");
			$sheet->setCellValueByColumnAndRow(11, 6, "Valas");
			$sheet->setCellValueByColumnAndRow(12, 6, "Nilai Barang");
			$sheet->setCellValue('B7', 'jenis');
			$sheet->setCellValue('C7', 'Nomor');
			$sheet->setCellValue('D7', 'Tanggal');
			$sheet->setCellValue('E7', 'Nomor');
			$sheet->setCellValue('F7', 'Tanggal');
			$sheet->mergeCells('A1:M1');
			$sheet->mergeCells('A2:M2');
			$sheet->mergeCells('A3:M3');
			$sheet->mergeCells('A4:M4');
			$sheet->mergeCells('A5:M5');
			$sheet->mergeCells('A6:A7');
			$sheet->mergeCells('B6:D6');
			$sheet->mergeCells('E6:F6');
			$sheet->mergeCells('G6:G7');
			$sheet->mergeCells('H6:H7');
			$sheet->mergeCells('I6:I7');
			$sheet->mergeCells('J6:J7');
			$sheet->mergeCells('K6:K7');
			$sheet->mergeCells('L6:L7');
			$sheet->mergeCells('M6:M7');
			$sheet->getColumnDimension('D')->setWidth(12);
			$sheet->getColumnDimension('F')->setWidth(12);
			$sheet->getColumnDimension('H')->setWidth(12);
			$sheet->getColumnDimension('I')->setWidth(12);
			$sheet->getColumnDimension('M')->setWidth(12);
			$sheet->getColumnDimension('G')->setWidth(16);
			
			$style = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				)
			);
			
			$sheet->getDefaultStyle()->applyFromArray($style);
			// Isi
			$row = 8;
			foreach($data1->result() as $data)
			{
				$col = 0;
				foreach ($fields as $field)
				{
					
					//$sheet->getCellByColumnAndRow($col, $row)->setValueExplicit($data->$field, PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
					$col++;
				}
				$row++;
			}
			
			$last_row = ($sheet->getHighestRow());
			$sheet->getStyle('M8:M'.$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('K8:K'.$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			
			$sheet
			->getStyle( 'M8:M'.$last_row )
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  
			$sheet
			->getStyle( 'K8:K'.$last_row )
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
			$objPHPExcel->setActiveSheetIndex(0);
			$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
			// Sending headers to force the user to download the file
			
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="Laporan Pengeluaran Barang Per Dokumen '.date('d-M-y').'.xls"');
			header('Cache-Control: max-age=0');
			$objWriter->save('php://output');
		}
		 if(isset($_POST['pdf'])){
			//do your delete code
    		/*$this->load->library('fpdf');
			define('FPDF_FONTPATH',$this->config->item('fonts_path'));
			$data['export'] = $this->m_eksport_pengeluaran->make_report_laporan_pengeluaran_pdf();
			$data['profil'] = $this->m_eksport_pengeluaran->get_profile();
			$this->load->view('sb_pengeluaran_barang/cetakExportPDF', $data);
			header('Content-type: application/pdf');
			header('Content-Disposition: attachment;filename="Laporan Pengeluaran Barang Per Dokumen_'.date('dMy').'.pdf"');
			header('Cache-Control: max-age=0');*/
			
			$data['export'] = $this->m_eksport_pengeluaran->make_report_laporan_pengeluaran_pdf();
			$data['profil'] = $this->m_eksport_pengeluaran->get_profile();
			$data['nama']=$this->m_sb_login->get_nama();
			$this->load->view('sb_pengeluaran_barang/page_prints',$data);
		} 
	}
	
}