
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
	
	$this->fpdf->Ln(1);
	$this->fpdf->SetFont('Times','B',8);
	$this->fpdf->Cell(1.5 , 1, 'No' , 1, 'LR', 'C');
	$this->fpdf->Cell(3 , 1, 'KODE BARANG' , 1, 'LR', 'C');
	$this->fpdf->Cell(5 , 1, 'NAMA BARANG' , 1, 'LR','C');
	$this->fpdf->Cell(1.5 , 1, 'SAT' , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, 'SALDO AWAL' , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, 'PEMASUKAN' , 1, 'LR', 'C');
	$this->fpdf->Cell(2.2 , 1, 'PENGELUARAN' , 1, 'LR', 'C');
	$this->fpdf->Cell(2.2 , 1, 'PENYESUAIAN' , 1, 'LR', 'C');
	$this->fpdf->Cell(2.1 , 1, 'SALDO AKHIR' , 1, 'LR', 'C');
	$this->fpdf->Cell(2.4 , 1, 'STOCK OPNAME' , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 1, 'SELISIH' , 1, 'LR', 'C');
	$this->fpdf->Cell(2.2 , 1, 'KETERANGAN' , 1, 'LR', 'C');
	
		
	$jumlah_stock_awal=0;
	$jumlah_pemasukan=0;
	$jumlah_pengeluaran=0;
	$jumlah_penyesuaian=0;
	$jumlah_saldo_akhir=0;
	$jumlah_stock_opname=0;
	$jumlah_selisih=0;
	$no=1;
	foreach($mutasi as $data){
	
	if (strlen($data->barang_name) > 13){
		$jum=0.7;
		$jam=0.7;
	}else{
		$jum=0.7;
		$jam=0.7;
	}
	$x=$this->fpdf->GetX(); 
	$y=$this->fpdf->GetY();
	$this->fpdf->SetXY($x+$jum,$y);
	
	$this->fpdf->Ln();
	$this->fpdf->SetFont('Times','',9);
	$this->fpdf->Cell(1.5 , $jam, $no , 1, 'LR', 'C');
	$this->fpdf->Cell(3 , $jam, $data->barang_code , 1, 'LR', 'L');
	$this->fpdf->Cell(5 , $jum, $data->barang_name, 1, 'LR', 'C');
	$this->fpdf->Cell(1.5 , $jam, $data->satuan_code ,1, 'LR','C');
	$this->fpdf->Cell(2 , $jam, $data->stock_awal , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , $jam, $data->pemasukan , 1, 'LR', 'C');
	$this->fpdf->Cell(2.2 , $jam, $data->pengeluaran , 1, 'LR', 'C');
	$this->fpdf->Cell(2.2 , $jam, $data->penyesuaian , 1, 'LR', 'C');
	$this->fpdf->Cell(2.1 , $jam, $data->saldo_akhir , 1, 'LR', 'C');
	$this->fpdf->Cell(2.4 , $jam, $data->stock_opname , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , $jam, $data->selisih , 1, 'LR', 'C');
	$this->fpdf->Cell(2.2 , $jam, $data->keterangan , 1, 'LR', 'C');
	
	$jumlah_stock_awal = $jumlah_stock_awal + $data->stock_awal;
	$jumlah_pemasukan = $jumlah_pemasukan + $data->pemasukan;
	$jumlah_pengeluaran = $jumlah_pengeluaran + $data->pengeluaran;
	$jumlah_penyesuaian = $jumlah_penyesuaian + $data->penyesuaian;
	$jumlah_saldo_akhir = $jumlah_saldo_akhir + $data->saldo_akhir;
	$jumlah_stock_opname = $jumlah_stock_opname + $data->stock_opname;
	$jumlah_selisih = $jumlah_selisih + $data->selisih;
	$no++;
	}
	$this->fpdf->Ln();
	$this->fpdf->SetFont('Times','',9);
	$this->fpdf->Cell(1.5 , 0.7, '' , 1, 'LR', 'C');
	$this->fpdf->Cell(3 , 0.7, 'GRAND TOTAL :' , 1, 'LR', 'L');
	$this->fpdf->Cell(6.5 , 0.7, '' , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 0.7, $jumlah_stock_awal.'.00' , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 0.7, $jumlah_pemasukan.'.00' , 1, 'LR', 'C');
	$this->fpdf->Cell(2.2 , 0.7, $jumlah_pengeluaran.'.00' , 1, 'LR', 'C');
	$this->fpdf->Cell(2.2 , 0.7, $jumlah_penyesuaian.'.00' , 1, 'LR', 'C');
	$this->fpdf->Cell(2.1 , 0.7, $jumlah_saldo_akhir.'.00' , 1, 'LR', 'C');
	$this->fpdf->Cell(2.4 , 0.7, $jumlah_stock_opname.'.00' , 1, 'LR', 'C');
	$this->fpdf->Cell(2 , 0.7, $jumlah_selisih.'.00' , 1, 'LR', 'C');
	$this->fpdf->Cell(2.2 , 0.7, '' , 1, 'LR', 'C');
	
	$this->fpdf->Output();
	
//no, a.jenis_doc,a.no_doc,a.tgl_doc,a.no_bukti,a.tgl_bukti,a.supplier_code,
					//b.barang_code,c.barang_name,b.jumlah_doc,b.satuan_doc,a.valas,b.nilai_barang	
?>
