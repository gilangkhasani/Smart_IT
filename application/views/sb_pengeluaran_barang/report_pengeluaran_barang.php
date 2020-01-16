<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Laporan Pemasukan Barang per Dokumen</title>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/ui/themes/smoothness/jquery-ui.css">
		<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
		<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
		<script src="<?php echo base_url()?>template_lala/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
		<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
		<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
	<script>
		$.fn.dataTable.ext.search.push(
			
			function( settings, data, dataIndex ) {
				var min_tgl = $('#min_tgl_doc').val();
				var max_tgl = $('#max_tgl_doc').val();
				var data = data[3]; // use data for the age column
		 
				if 	(( min_tgl == ""  &&  max_tgl == "" ) ||
					(  min_tgl == "" && data <= max_tgl ) ||
					( min_tgl <= data   && max_tgl == "" ) ||
					( min_tgl <= data   && data <= max_tgl ))
				{
					return true;
				}
				return false;
			}
			
			,function( settings, data, dataIndex ) {
				var min_tgl = $('#min_tgl_bukti').val();
				var max_tgl = $('#max_tgl_bukti').val();
				var data = data[5]; // use data for the age column
		 
				if 	(( min_tgl == ""  &&  max_tgl == "" ) ||
					(  min_tgl == "" && data <= max_tgl ) ||
					( min_tgl <= data   && max_tgl == "" ) ||
					( min_tgl <= data   && data <= max_tgl ))
				{
					return true;
				}
				return false;
			}
		);
		 
		$(document).ready(function() {
			$('#min_tgl_doc').datepicker();
			$('#max_tgl_doc').datepicker();
			$('#min_tgl_bukti').datepicker();
			$('#max_tgl_bukti').datepicker();
			
			$("#min_tgl_doc").inputmask("yyyy-mm-dd");
			$("#max_tgl_doc").inputmask("yyyy-mm-dd");
			$("#min_tgl_bukti").inputmask("yyyy-mm-dd");
			$("#max_tgl_bukti").inputmask("yyyy-mm-dd");
				
			//Money Euro
			$("[data-mask]").inputmask();
			
			table = $('#example').DataTable();
			table1 = $('#example').dataTable();
			
				$('#example tbody').on( 'click', 'tr', function () {
					if ( table.$('tr.selected').removeClass('selected') ) {
						$(this).addClass('selected');
					}
				} );
				
			// Event listener to the two range filtering inputs to redraw on input
			
			$('#jenis_doc').on( 'change', function () {
				table
					.columns( 1 )
					.search( this.value )
					.draw();
			} );
			
			$('#no_doc').on( 'keyup', function () {
				table
					.columns( 2 )
					.search( this.value )
					.draw();
			} );
			
			$('#no_bukti').on( 'keyup', function () {
				table
					.columns( 4 )
					.search( this.value )
					.draw();
			} );
			
			$('#tgl_doc').on( 'change', function () {
				table
					.columns( 3 )
					.search( this.value )
					.draw();
			} );
			
			$('#tgl_bukti').on( 'change', function () {
				table
					.columns( 5 )
					.search( this.value )
					.draw();
			} );
			
			$('#supplier_code').on( 'keyup', function () {
				table
					.columns( 6 )
					.search( this.value )
					.draw();
			} );
			
			$('#barang_code').on( 'keyup', function () {
				table
					.columns( 7 )
					.search( this.value )
					.draw();
			} );
			
			$('#barang_name').on( 'keyup', function () {
				table
					.columns( 8 )
					.search( this.value )
					.draw();
			} );
			
			$('#satuan_doc').on( 'keyup', function () {
				table
					.columns( 9 )
					.search( this.value )
					.draw();
			} );
			
					
			$('#min_tgl_doc, #max_tgl_doc').change( function() {
				table.draw();
			} );
			
			$('#min_tgl_bukti, #max_tgl_bukti').change( function() {
				table.draw();
			} );
		} );
	</script>
</head>
<body>	
	<h3> Laporan Pengeluaran Barang per Dokumen</h3>
	<form action="<?php echo base_url()?>Eksportexcel/report_pengeluaran" method="post" target="_blank">
		<div>
			<fieldset>
				<legend style="color:blue;font-weight:bold;">Filter</legend>
				<table>
					<tr>
						<td>Jenis Dokumen</td>
						<td> &nbsp : &nbsp
							<select name="jenis_doc" id="jenis_doc" style="width:75px;">
								<option value="">All</option>
								<option value="BC 2.5">BC 2.5</option>
								<option value="BC 2.6.1">BC 2.6.1</option>
								<option value="BC 2.7">BC 2.7</option>
								<option value="BC 3.0">BC 3.0</option>
								<option value="BC 4.1">BC 4.1</option>
							</select>
						</td>
						<td></td>
						<td></td>
						<td>&nbsp &nbsp Supplier</td>
						<td> &nbsp : &nbsp <input type="text" id="supplier_code" name="supplier_code" style="width:150px;" placeholder="Nama Supplier"></td>
					</tr>
					<tr>
						<td>No. Dokumen</td>
						<td> &nbsp : &nbsp <input type="text" id="no_doc" name="no_doc" style="width:150px;" placeholder="Nomor Dokumen"></td>
						<td></td>
						<td></td>
						<td>&nbsp &nbsp Kode/Nama Barang</td>
						<td> &nbsp : &nbsp <input type="text" id="barang_code" name="barang_code" style="width:150px;" placeholder="Kode Barang"></td>
						<td> / <input type="text" id="barang_name" name="barang_name" style="width:150px;" placeholder="Nama Barang"></td>
					</tr>
					<tr>
						<td>No. Pengeluaran</td>
						<td> &nbsp : &nbsp <input type="text" id="no_bukti" name="no_bukti" style="width:150px;" placeholder="Nomor Bukti"></td>
						<td></td>
						<td></td>
						<td>&nbsp &nbsp Satuan</td>
						<td> &nbsp : &nbsp <input type="text" id="satuan_doc" name="satuan_doc" style="width:150px;" placeholder="Satuan"></td>
					</tr>
					<tr>
						<td>Tgl. Dokumen (Min-Max)</td>
						<td> &nbsp : &nbsp <input type="text" id="min_tgl_doc" style="width:150px;" name="min_tgl_doc" data-inputmask="'alias':'yyyy-mm-dd'" data-mask></td>
						<td></td>
						<td> - <input type="text" id="max_tgl_doc" style="width:150px;" name="max_tgl_doc" data-inputmask="'alias':'yyyy-mm-dd'" data-mask></td>
						<td></td>
						<td> &nbsp &nbsp &nbsp <input class="btn-primary" type="submit" id="pdf" style="width:100px;" name="pdf" value="Export to PDF"></td>
					<tr>
					<tr>
						<td>Tgl. Pengeluaran (Min-Max)</td>
						<td> &nbsp : &nbsp <input type="text" id="min_tgl_bukti" style="width:150px;" name="min_tgl_bukti" data-inputmask="'alias':'yyyy-mm-dd'" data-mask></td>
						<td></td>
						<td> - <input type="text" id="max_tgl_bukti" style="width:150px;" name="max_tgl_bukti" data-inputmask="'alias':'yyyy-mm-dd'" data-mask></td>
						<td></td>
						<td> &nbsp &nbsp &nbsp <input class="btn-primary" type="submit" id="excel" style="width:100px;" name="excel" value="Export to Excel"></td>
				</table>
			</fieldset>
		</div>
	</form>
	<br/>
	<table id="example" class="table table-hover" border="1px solid black" style="font-size:12px;">
		<thead>
			<tr>
				<th rowspan="2"><center>No</center></th>
				<th colspan="3"><center>Dokumen Pabean</center></th>
				<th colspan="2"><center>Bukti Pengeluaran</center></th>
				<th rowspan="2"><center>Supplier</center></th>
				<th rowspan="2"><center>Kode Barang</center></th>
				<th rowspan="2"><center>Nama Barang</center></th>
				<th rowspan="2"><center>Satuan</center></th>
				<th rowspan="2"><center>Jumlah</center></th>
				<th rowspan="2"><center>Valas</center></th>
				<th rowspan="2"><center>Nilai</center></th>
			</tr>
			<tr>
				<th><center>Jenis</center></th>
				<th><center>Nomor</center></th>
				<th><center>Tanggal</center></th>
				<th><center>Nomor</center></th>
				<th><center>Tanggal</center></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($laporan as $laporan) { ?>
			<tr>
				<td><?php echo $laporan->no;?></td>
				<td><?php echo $laporan->jenis_doc;?></td>
				<td><?php echo $laporan->no_doc;?></td>
				<td><?php echo $laporan->tgl_doc;?></td>
				<td><?php echo $laporan->no_bukti;?></td>
				<td><?php echo $laporan->tgl_bukti;?></td>
				<td><?php echo $laporan->supplier_name;?></td>
				<td><?php echo $laporan->barang_code;?></td>
				<td><?php echo $laporan->barang_name;?></td>
				<td><?php echo $laporan->satuan_doc;?></td>
				<td align="right"><?php echo number_format($laporan->jumlah_doc,2);?></td>
				<td><?php echo $laporan->valas;?></td>
				<td align="right"><?php echo number_format($laporan->nilai_barang,2);?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>	
	<a href="<?php echo base_url()?>index.php/blog">Back to Menu</a>
</body>
</html>