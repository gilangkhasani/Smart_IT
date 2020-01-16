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
	<h2> Laporan Posisi Barang Dalam Proses (WIP)</h2>
	<form action="<?php echo base_url()?>Wipexcel/report_wip" method="post" target="_blank">
		<div style="width:650px;">
			<fieldset>
				<legend style="color:blue;font-weight:bold;">Search</legend>
				<table>
					<tr>
						<td>Kode Barang</td>
						<td>: <input type="text" id="barang_code" name="barang_code" placeholder="Kode Barang"></td>
					</tr>
					<tr>
						<td>Nama Barang</td>
						<td>: <input type="text" id="barang_name" name="barang_name" placeholder="Nama Barang"></td>
					</tr>
					<tr>
						<td>Satuan</td>
						<td>: <input type="text" id="satuan_code" name="satuan_code" placeholder="Satuan"></td>
					</tr>
					<tr>
						<td>Jumlah</td>
						<td>: <input type="text" id="jumlah_barang" name="jumlah_barang" placeholder="Jumlah"></td>
					</tr>
					
					<tr>
						<td colspan="3"></td>
						<td colspan="2"><input type="submit" id="excel" name="excel" value="Export to Excel"></td>
					</tr>
					<tr>
						<td colspan="3"></td>
						<td colspan="2"><input type="submit" id="pdf" name="pdf" value="Export to PDF"></td>
					</tr>
				</table>
			</fieldset>
		</div>
	</form>
	<br/>
	<table id="example" class="table table-hover" border="1px solid black">
		<thead>
			<tr>
				<th>Kode Barang</th>
				<th>Nama Barang</th>
				<th>Satuan</th>
				<th>Jumlah</th>
				<th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($laporan as $laporan) { ?>
			<tr>
				<td><?php echo $laporan->barang_kode;?></td>
				<td><?php echo $laporan->barang_name;?></td>
				<td><?php echo $laporan->satuan_code;?></td>
				<td><?php echo $laporan->jumlah_barang;?></td>
				<td>-</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>	
	<a href="<?php echo base_url()?>index.php/blog">Back to Menu</a>
</body>
</html>