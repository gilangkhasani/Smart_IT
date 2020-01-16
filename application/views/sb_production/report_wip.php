<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Laporan Pemasukan Barang per Dokumen</title>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/ui/themes/smoothness/jquery-ui.css">
		<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
		<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
		<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
	<script>		 
		$(document).ready(function() {
			table = $('#example').DataTable();
			table1 = $('#example').dataTable();
			
				$('#example tbody').on( 'click', 'tr', function () {
					if ( table.$('tr.selected').removeClass('selected') ) {
						$(this).addClass('selected');
					}
				} );
				
			// Event listener to the two range filtering inputs to redraw on input
			
			$('#barang_code').on( 'keyup', function () {
				table
					.columns( 0 )
					.search( this.value )
					.draw();
			} );
			
			$('#barang_name').on( 'keyup', function () {
				table
					.columns( 1 )
					.search( this.value )
					.draw();
			} );
			
			$('#satuan_code').on( 'keyup', function () {
				table
					.columns( 2 )
					.search( this.value )
					.draw();
			} );
			
			$('#jumlah_barang').on( 'keyup', function () {
				table
					.columns( 3 )
					.search( this.value )
					.draw();
			} );
		} );
	</script>
</head>
<body>	
	<h3> Laporan Posisi Barang Dalam Proses (WIP)</h3>
	<form action="<?php echo base_url()?>Wipexcel/report_wip" method="post" target="_blank">
		<div>
			<fieldset>
				<legend style="color:blue;font-weight:bold;">Filter</legend>
				<table>
					<tr>
						<td>Kode/Nama Barang</td>
						<td> &nbsp : &nbsp <input type="text" id="barang_code" name="barang_code" style="width:150px;" placeholder="Kode Barang"></td>
						<td>/<input type="text" id="barang_name" name="barang_name" style="width:150px;" placeholder="Nama Barang"></td>
						<td> &nbsp &nbsp &nbsp &nbsp &nbsp <input class="btn-primary" type="submit" id="pdf" style="width:100px;" name="pdf" value="Export to PDF"></td>
					</tr>
					<tr>
						<td>Satuan/Jumlah Barang</td>
						<td> &nbsp : &nbsp <input type="text" id="satuan_code" name="satuan_code" style="width:150px;" placeholder="Satuan"></td>
						<td>/<input type="text" id="jumlah_barang" name="jumlah_barang" style="width:150px;" placeholder="Jumlah"></td>
						<td> &nbsp &nbsp &nbsp &nbsp &nbsp <input class="btn-primary" type="submit" id="excel" style="width:100px;" name="excel" value="Export to Excel"></td>
					</tr>
				</table>
				<br>
			</fieldset>
		</div>
	</form>
	<br/>
	<table id="example" class="table table-hover" border="1px solid black">
		<thead>
			<tr>
				<th><center>Kode Barang</center></th>
				<th><center>Nama Barang</center></th>
				<th><center>Satuan</center></th>
				<th><center>Jumlah</center></th>
				<th><center>Keterangan</center></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($laporan as $laporan) { ?>
			<tr>
				<td><?php echo $laporan->barang_kode;?></td>
				<td><?php echo $laporan->barang_name;?></td>
				<td><?php echo $laporan->satuan_code;?></td>
				<td align="right"><?php echo number_format($laporan->jumlah_barang,2);?></td>
				<td><?php echo $laporan->keterangan;?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>	
	<a href="<?php echo base_url()?>index.php/blog">Back to Menu</a>
</body>
</html>