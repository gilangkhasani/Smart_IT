
<?php
	$this->fpdf->FPDF('L','cm','A4');
	$this->fpdf->AddPage();
	$this->fpdf->Ln();
	$this->fpdf->SetFont('helvetica',''	,10);
	$this->fpdf->Cell(27,0.5,'LAPORAN PERTANGGUNGJAWABAN MUTASI BAHAN BAKU BAHAN PENOLONG',0,0,'C');
	foreach($profil as $data1){
	$this->fpdf->Ln();
	$this->fpdf->Cell(27,0.5,$data1->company_name,0,0,'C');
	}
	foreach($periode as $data){
	$this->fpdf->Ln();
	$this->fpdf->Cell(27,0.5,'Periode '.date("d-F-Y", strtotime($data->start_date)).' S/D '.date("d-F-Y", strtotime($data->end_date)),0,0,'C');
	}
	$html = "<table border='1'>
	<tr>
		<td>lalafgfd</td>
		<td>laladsvds</td>
	</tr>
	</table>";
	
	$this->fpdf->WriteHTML($html);
	
	$this->fpdf->AddPage();
	$this->fpdf->SetAutoPageBreak(true);
	$this->fpdf->AcceptPageBreak();
	$this->fpdf->SetY(-2);
	//setting cell untuk waktu pencetakan 
	$this->fpdf->Cell(9.5, 0.5, 'Printed on : '.date('d/m/Y H:i'),0,'LR','L');

	//setting cell untuk page number 
	 
	$this->fpdf->Cell(9.5, 0.5, 'Page '.$this->fpdf->PageNo().'/{nb}',0,0,'R');
	$this->fpdf->Output();
	
//no, a.jenis_doc,a.no_doc,a.tgl_doc,a.no_bukti,a.tgl_bukti,a.supplier_code,
					//b.barang_code,c.barang_name,b.jumlah_doc,b.satuan_doc,a.valas,b.nilai_barang	
?>
