
<?php
	$this->fpdf->FPDF('P','cm','A4');
	$this->fpdf->AddPage();
	$this->fpdf->Ln();
	$this->fpdf->setFont('Arial','B',9);
	$this->fpdf->Image(base_url() . "bootstrap/img/smart.jpg", 1, 1, 4);
	$this->fpdf->SetFont('helvetica',''	,10);
	$this->fpdf->Cell(19,0.5,'PT.SMART REKAN CIPTA KREASI',0,0,'C');
	$this->fpdf->Ln();
	$this->fpdf->Cell(19,0.5,'Graha Cempaka Mas Blok B - 11 Jl.Letjen Suprapto Jakarta Pusat',0,0,'C');
	$this->fpdf->Ln();
	$this->fpdf->Cell(19,0.5,'Telp. (021) 4217647 Fax. (021) 4217648',0,0,'C');
	$this->fpdf->Ln();
	$this->fpdf->Cell(19,0.5,'Laporan Export ',0,0,'C');
	
	$this->fpdf->Ln(1);
	$this->fpdf->SetFont('Times','B',9);
	$this->fpdf->Cell(2 , 1, 'No' , 1, 'LR', 'C');
	$this->fpdf->Cell(3.9, 1, 'Kode Barang' , 1, 'LR', 'C');
	$this->fpdf->Cell(3.9, 1, 'Nama Barang' , 1, 'LR', 'C');
	$this->fpdf->Cell(3.9, 1, 'Kode Satuan' , 1, 'LR', 'C');
	$this->fpdf->Cell(3.9,1, 'Jumlah barang' , 1, 'LR', 'C');
	$this->fpdf->Cell(3.9,1, 'Keterangan' , 1, 'LR', 'C');
	foreach($wip as $data){
	$this->fpdf->Ln();
	$this->fpdf->SetFont('Times','',9);
	$this->fpdf->Cell(2 , 1, $data->no , 1, 'LR', 'C');
	$this->fpdf->Cell(3.9,1, $data->barang_kode , 1, 'LR', 'C');
	$this->fpdf->Cell(3.9,1, $data->barang_name , 1, 'LR', 'C');
	$this->fpdf->Cell(3.9, 1, $data->satuan_code , 1, 'LR', 'C');
	$this->fpdf->Cell(3.9,1, $data->jumlah_barang , 1, 'LR', 'C');
	$this->fpdf->Cell(3.9,1, $data->keterangan , 1, 'LR', 'C');
	}
	$this->fpdf->Output();
	
//no, a.jenis_doc,a.no_doc,a.tgl_doc,a.no_bukti,a.tgl_bukti,a.supplier_code,
					//b.barang_code,c.barang_name,b.jumlah_doc,b.satuan_doc,a.valas,b.nilai_barang	
?>
