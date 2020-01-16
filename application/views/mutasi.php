public function report_mutasi_barang_jadi()
	{
		if(isset($_POST['excel'])) {
		//do your restore code

			$data1 = $this->m_eksport_pengeluaran->make_report_laporan_pengeluaran();
			
			$today=date('Y-m-d', strtotime(date('Y-m-d')));
			
			$from = date('Y-m-d', strtotime("01/01/".date("Y")));
			$to = date('Y-m-d', strtotime("05/01/".date("Y")));
			
			$from1 = date('Y-m-d', strtotime("05/01/".date("Y")));
			$to1 = date('Y-m-d', strtotime("09/01/".date("Y")));
			
			if (($today >= $from) && ($today <= $to)) {
				$per = '01-Januari-2014 S.D 31-April-2014 ';
			}
			else if (($today >= $from1) && ($today <= $to1)) {
				$per = '01-Mei-2014 S.D 31-Agustus-2014 ';
			}
			else {
				$per = '01-September-2014 S.D 31-December-2014 ';
			}
			//$periode = 'P'.date('Y').'-'.$per;
			$periode = 'Periode '.$per;
			
			if(!$data1)
				return false;
			// Starting the PHPExcel library
			$this->load->library('PHPExcel');
			$this->load->library('PHPExcel/IOFactory');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setTitle("Laporan Pertanggung Jawaban Mutasi Barang Jadi ".$periode)->setDescription("none");
			$objPHPExcel->setActiveSheetIndex(0);
			// Field names in the first row
			$fields = $data1->list_fields();
			//$col = 5;
			//Header Title
			$sheet = $objPHPExcel->getActiveSheet();
			$sheet->setCellValueByColumnAndRow(0, 1, "LAPORAN PERTANGGUNGJAWABAN MUTASI BARANG JADI");
			$sheet->setCellValueByColumnAndRow(0, 2, "PT TES");
			$sheet->setCellValueByColumnAndRow(0, 3, $periode);
			$sheet->setCellValue('A5', 'NO');
			$sheet->setCellValue('B5', 'KODE BARANG');
			$sheet->setCellValue('C5', 'NAMA BARANG');
			$sheet->setCellValue('D5', 'SAT');
			$sheet->setCellValue('E5', 'SALDO AWAL');
			$sheet->setCellValue('F5', 'PEMASUKAN');
			$sheet->setCellValue('G5', 'PENGELUARAN');
			$sheet->setCellValue('H5', 'PENYESUAIN');
			$sheet->setCellValue('I5', 'SALDO AKHIR');
			$sheet->setCellValue('J5', 'STOK OPNAME');
			$sheet->setCellValue('K5', 'SELISIH');
			$sheet->setCellValue('L5', 'SALDO BARANG');
			$sheet->setCellValue('M5', 'KETERANGAN');
			$sheet->mergeCells('A1:M1');
			$sheet->mergeCells('A2:M2');
			$sheet->mergeCells('A3:M3');
			$sheet->mergeCells('A4:M4');
			$sheet->getColumnDimension('A')->setWidth(14);
			$sheet->getColumnDimension('B')->setWidth(14);
			$sheet->getColumnDimension('C')->setWidth(14);
			$sheet->getColumnDimension('D')->setWidth(14);
			$sheet->getColumnDimension('E')->setWidth(14);
			$sheet->getColumnDimension('F')->setWidth(14);
			$sheet->getColumnDimension('G')->setWidth(14);
			$sheet->getColumnDimension('H')->setWidth(14);
			$sheet->getColumnDimension('I')->setWidth(14);
			$sheet->getColumnDimension('J')->setWidth(14);
			$sheet->getColumnDimension('K')->setWidth(14);
			$sheet->getColumnDimension('L')->setWidth(14);
			$sheet->getColumnDimension('M')->setWidth(14);
			
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
			$objPHPExcel->setActiveSheetIndex(0);
			$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
			// Sending headers to force the user to download the file
			
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="Laporan Pertanggungjawaban Mutasi Barang Jadi '.$periode.'.xls');
			header('Cache-Control: max-age=0');
			$objWriter->save('php://output');
		}
		===================================================
		===================================================
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
			$sheet->getColumnDimension('L')->setWidth(16);
			$sheet->getColumnDimension('M')->setWidth(14);