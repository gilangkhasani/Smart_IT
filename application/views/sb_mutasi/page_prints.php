<link rel="icon" type="image/ico" href="<?php echo base_url()?>template_lala/img/smart.jpg">
<style>	
	h4{
		margin-left:30px;
		text-align:center;
	}
	p{
		text-align:center;
		margin-top:5px;
	}
	
	.bordered tbody  
{
    background-color:#FFF;
}
table {
*border-collapse: collapse; /* IE7 and lower */
border-spacing: 0; 
}


.bordered {
    border: solid #ccc 1px;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    border-radius: 6px;
    -webkit-box-shadow: 0 1px 1px #ccc; 
    -moz-box-shadow: 0 1px 1px #ccc; 
    box-shadow: 0 1px 1px #ccc;         
}

.bordered tr:hover {
    background: #fbf8e9;
    -o-transition: all 0.1s ease-in-out;
    -webkit-transition: all 0.1s ease-in-out;
    -moz-transition: all 0.1s ease-in-out;
    -ms-transition: all 0.1s ease-in-out;
    transition: all 0.1s ease-in-out;     
}    
    
.bordered td, .bordered th {
    border-left: 1px solid #ccc;
    border-top: 1px solid #ccc;
    padding: 5px; 
}

.bordered th {
    background-color: #FF8A8A;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#FF4848), to(FF8A8A));
    background-image: -webkit-linear-gradient(top, #FF4848, #FF8A8A);
    background-image:    -moz-linear-gradient(top, #FF4848, #FF8A8A);
    background-image:     -ms-linear-gradient(top, #FF4848, #FF8A8A);
    background-image:      -o-linear-gradient(top, #FF4848, #FF8A8A);
    background-image:         linear-gradient(top, #FF4848, #FF8A8A);
    -webkit-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset; 
    -moz-box-shadow:0 1px 0 rgba(255,255,255,.8) inset;  
    box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;        
    border-top: none;
    text-shadow: 0 1px 0 rgba(255,255,255,.5); 
}

thead   {display: table-header-group;   }
</style>
<script type="text/javascript">
	setTimeout(function(){
		window.print();
	}, 1000);
</script>
	<?php 
	$barang1 = $this->input->post('barang1');
	$barang2 = $this->input->post('barang2');
	if($barang1 == 'Mesin_Sparepart'){
		$barang1 = 'Mesin';
	} else 
	if($barang1 == 'Reject'){
		$barang1 = 'Barang Sisa';
	} else {
		$barang1=str_replace('_', ' ', $barang1);
	}
		$barang2 = str_replace('_', ' ', $barang2);
	?>
	<?php if ($barang1 != 'Barang Jadi'){?>
	<h4>LAPORAN PERTANGGUNGJAWABAN MUTASI <?php echo strtoupper($barang1);?> DAN <?php echo strtoupper($barang2);?></h4>
	<?php } else {?>
	<h4>LAPORAN PERTANGGUNGJAWABAN MUTASI <?php echo strtoupper($barang1);?></h4>
	<?php } ?>
	<?php foreach($profil as $tas){?>
			<p><?php echo $tas->company_name;?>
			<br><?php echo $tas->company_address;?>
			<br>Telp : <?php echo $tas->phone;?> Fax : <?php echo $tas->fax;?></p>
	<?php } ?>
	<?php foreach($periode as $tos){?>
			<p>Periode : <?php echo date("d-F-Y", strtotime($tos->start_date));?> s/d <?php echo date("d-F-Y", strtotime($tos->end_date));?></p>
	<?php } ?>
	
	<table class="bordered" style="font-size:11px; width:100%;">
		<thead>
			<tr>
				<td><center>No</center></td>
				<td><center>Kode Barang</center></td>
				<td><center>Nama Barang</center></td>
				<td><center>Satuan</center></td>
				<td><center>Saldo Awal</center></td>
				<td><center>Pemasukan</center></td>
				<td><center>Pengeluaran</center></td>
				<td><center>Penyesuaian</center></td>
				<td><center>Saldo Akhir</center></td>
				<td><center>Stock Opname</center></td>
				<td><center>Selisih</center></td>
				<td><center>Keterangan</center></td>
			</tr>
		</thead>
		<?php $i=1; 
			$jumlah_stock_awal=0;
			$jumlah_pemasukan=0;
			$jumlah_pengeluaran=0;
			$jumlah_penyesuaian=0;
			$jumlah_saldo_akhir=0;
			$jumlah_stock_opname=0;
			$jumlah_selisih=0;
		?>
		<?php foreach($mutasi as $data_mutasi){ ?>
		<tr>
			<td><center><?php echo $i;?></center></td>
			<td><?php echo $data_mutasi->barang_code?></td>
			<td><?php echo $data_mutasi->barang_name?></td>
			<td><center><?php echo $data_mutasi->satuan_code?></center></td>
			<td align="right"><?php echo number_format($data_mutasi->stock_awal,2)?></td>
			<td align="right"><?php echo number_format($data_mutasi->pemasukan,2)?></td>
			<td align="right"><?php echo number_format($data_mutasi->pengeluaran,2)?></td>
			<td align="right"><?php echo number_format($data_mutasi->penyesuaian,2)?></td>
			<td align="right"><?php echo number_format($data_mutasi->saldo_akhir,2)?></td>
			<td align="right"><?php echo number_format($data_mutasi->stock_opname,2)?></td>
			<td align="right"><?php echo number_format($data_mutasi->selisih,2)?></td>
			<td><?php echo $data_mutasi->keterangan?></td>
		</tr>
		<?php $i++; 
			$jumlah_stock_awal = $jumlah_stock_awal + $data_mutasi->stock_awal;
			$jumlah_pemasukan = $jumlah_pemasukan + $data_mutasi->pemasukan;
			$jumlah_pengeluaran = $jumlah_pengeluaran + $data_mutasi->pengeluaran;
			$jumlah_penyesuaian = $jumlah_penyesuaian + $data_mutasi->penyesuaian;
			$jumlah_saldo_akhir = $jumlah_saldo_akhir + $data_mutasi->saldo_akhir;
			$jumlah_stock_opname = $jumlah_stock_opname + $data_mutasi->stock_opname;
			$jumlah_selisih = $jumlah_selisih + $data_mutasi->selisih;
		?>
		<?php } ?>
		<tr>
			<td colspan="4">GRAND TOTAL :</td>
			<td align="right"><?php echo number_format($jumlah_stock_awal,2)?></td>
			<td align="right"><?php echo number_format($jumlah_pemasukan,2)?></td>
			<td align="right"><?php echo number_format($jumlah_pengeluaran,2)?></td>
			<td align="right"><?php echo number_format($jumlah_penyesuaian,2)?></td>
			<td align="right"><?php echo number_format($jumlah_saldo_akhir,2)?></td>
			<td align="right"><?php echo number_format($jumlah_stock_opname,2)?></td>
			<td align="right"><?php echo number_format($jumlah_selisih,2)?></td>
			<td></td>
		</tr>
	</table>