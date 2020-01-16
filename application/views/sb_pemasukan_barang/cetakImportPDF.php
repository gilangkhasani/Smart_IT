
<?php

	$this->fpdf->FPDF('L','cm','A4');
	$this->fpdf->AddPage();
	$this->fpdf->Ln();
	$this->fpdf->setFont('Arial','B',9);
	$this->fpdf->Image(base_url() . "bootstrap/img/smart.jpg", 6, 1, 4);
	$this->fpdf->SetFont('helvetica',''	,10);
	
	foreach($profil as $data1){
	$this->fpdf->Cell(28,0.5,$data1->company_name,0,0,'C');
	$this->fpdf->Ln();
	$this->fpdf->Cell(28,0.5,$data1->company_address,0,0,'C');
	$this->fpdf->Ln();
	$this->fpdf->Cell(28,0.5,'Telp : '.$data1->phone.' Fax : '.$data1->fax,0,0,'C');
	$this->fpdf->Ln();
	$this->fpdf->Cell(28,0.5,'Laporan Import ',0,0,'C');
	}
		
	$this->fpdf->Ln(1);
	$this->fpdf->SetFont('Times','B',9);
	$this->fpdf->Cell(1.5 , 2, 'No' , 1, 'LR', 'C');
	$this->fpdf->Cell(6.5 , 1, 'Dokumen' , 1, 'LR', 'C');
	$this->fpdf->Cell(4.5 , 1, 'Bukti Pengeluaran' , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 2, 'Supplier Code' , 1, 'LR', 'C');
	$this->fpdf->Cell(3 ,2 , 'Barang Code' , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 2, 'Barang Name' , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 2, 'Satuan' , 1, 'LR', 'C');
	$this->fpdf->Cell(2.2 , 2, 'Jumlah Barang' , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 2, 'Valas' , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 2, 'Nilai Barang' , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, '' , 0, 'LR', 'C');
	$this->fpdf->Ln(1);
	$this->fpdf->SetFont('Times','',9);
	$this->fpdf->Cell(1.5 , 2, '' , 2, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, 'Jenis Doc' , 1, 'LR', 'C');
	$this->fpdf->Cell(2.5 , 1, 'No Doc' , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, 'Tgl Doc' , 1, 'LR', 'C');
	$this->fpdf->Cell(2.5 , 1, 'No Bukti' , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, 'Tgl Bukti' , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 2, '' , 2, 'LR', 'C');
	$this->fpdf->Cell(3 , 2, '' , 2, 'LR', 'C');
	$this->fpdf->Cell(2 , 2, '' , 2, 'LR', 'C');
	$this->fpdf->Cell(2 , 2, '' , 2, 'LR', 'C');
	$this->fpdf->Cell(2.2 , 2, '' , 2, 'LR', 'C');
	$this->fpdf->Cell(2 , 2, '' , 2, 'LR', 'C');
	$this->fpdf->Cell(2 , 2, '' , 2, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, '' , 2, 'LR', 'C');
	foreach($import as $data){
	$this->fpdf->Ln();
	$this->fpdf->SetFont('Times','',9);
	$this->fpdf->Cell(1.5 , 1, $data->no , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, $data->jenis_doc , 1, 'LR', 'L');
	$this->fpdf->Cell(2.5 , 1, $data->no_doc , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, $data->tgl_doc , 1, 'LR', 'C');
	$this->fpdf->Cell(2.5 , 1, $data->no_bukti , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, $data->tgl_bukti , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, $data->supplier_name , 1, 'LR', 'C');
	$this->fpdf->Cell(3 , 1, $data->barang_code , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, $data->barang_name , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, $data->satuan_doc , 1, 'LR', 'C');
	$this->fpdf->Cell(2.2 , 1, $data->jumlah_doc , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, $data->valas , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, $data->nilai_barang , 1, 'LR', 'C');
	}
	$this->fpdf->Output();
	
//no, a.jenis_doc,a.no_doc,a.tgl_doc,a.no_bukti,a.tgl_bukti,a.supplier_code,
					//b.barang_code,c.barang_name,b.jumlah_doc,b.satuan_doc,a.valas,b.nilai_barang	
?>
