<style>	
	h4{
		margin-left:30px;
		text-align:center;
	}
	p{
		text-align:center;
		margin-top:5px;
	}
</style>	
	<h4>LAPORAN PERTANGGUNGJAWABAN MUTASI BAHAN BAKU BAHAN PENOLONG</h4>
	<?php foreach($profil as $tas){?>
			<p><?php echo $tas->company_name;?></p>
	<?php } ?>
	<?php foreach($periode as $tos){?>
			<p><?php echo date("d-F-Y", strtotime($tos->start_date));?> S/D <?php echo date("d-F-Y", strtotime($tos->end_date));?></p>
	<?php } ?>
	
	<table border="1" style="font-size:11px; width:100%;">
		<tr>
			<td><center>No</center></td>
			<td><center>KODE BARANG</center></td>
			<td><center>NAMA BARANG</center></td>
			<td><center>SAT</center></td>
			<td><center>SALDO AWAL</center></td>
			<td><center>PEMASUKAN</center></td>
			<td><center>PENGELUARAN</center></td>
			<td><center>PENYESUAIAN</center></td>
			<td><center>SALDO AKHIR</center></td>
			<td><center>STOCK OPNAME</center></td>
			<td><center>SELISIH</center></td>
			<td><center>KETERANGAN</center></td>
		</tr>
		<?php $i=1; ?>
		<?php foreach($mutasi as $data_mutasi){ ?>
		<tr>
			<td><center><?php echo $i;?></center></td>
			<td><?php echo $data_mutasi->barang_code?></td>
			<td><?php echo $data_mutasi->barang_name?></td>
			<td><center><?php echo $data_mutasi->satuan_code?></center></td>
			<td><?php echo $data_mutasi->stock_awal?></td>
			<td><?php echo $data_mutasi->pemasukan?></td>
			<td><?php echo $data_mutasi->pengeluaran?></td>
			<td><?php echo $data_mutasi->penyesuaian?></td>
			<td><?php echo $data_mutasi->saldo_akhir?></td>
			<td><?php echo $data_mutasi->stock_opname?></td>
			<td><?php echo $data_mutasi->selisih?></td>
			<td><?php echo $data_mutasi->keterangan?></td>
			
			<!--<td style="font-size:8px"><?php echo $data_mutasi->barang_name?></td>
			<td style="font-size:8px"><center><?php echo $data_mutasi->satuan_code?></center></td>
			<td style="font-size:8px"><?php echo $data_mutasi->stock_code?></td>
			<td style="font-size:8px"><?php echo $data_mutasi->pemasukan?></td>
			<td style="font-size:8px"><?php echo $data_mutasi->pengeluaran?></td>
			<td style="font-size:8px"><?php echo $data_mutasi->penyesuaian?></td>
			<td style="font-size:8px"><?php echo $data_mutasi->saldo_akhir?></td>
			<td style="font-size:8px"><?php echo $data_mutasi->stock_opname?></td>
			<td style="font-size:8px"><?php echo $data_mutasi->selisih?></td>
			<td style="font-size:8px"><?php echo $data_mutasi->keterangan?></td>-->
		</tr>
		<?php $i++; ?>
		<?php } ?>
	</table>