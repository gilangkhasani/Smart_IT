<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>List Of Barang</title>
		<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>
		<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">	
		<script>
			$(document).ready(function() {
			
				var table = $('#example').DataTable();
				$('#example tbody').on( 'click', 'tr', function () {
					if ( table.$('tr.selected').removeClass('selected') ) {
						$(this).addClass('selected');
					}
				} );
				
				$('#example tbody').on( 'click', 'tr', function () {
				  var rowData = table.row( this ).data();
					//alert(rowData);
					$('#barang_code').val(rowData[0]);
					$('#barang_name').val(rowData[1]);
				} );
				
				
				$(".dataTables_empty").css('display','none');
				$(".dataTables_info").css('display','none');
				$(".dataTables_length").css('display','none');
				/*$('#button').click( function () {
					alert($('#nama').val());
				} );*/
			} );
			
			function closeWin() {
				var barang_code = document.form2.barang_code.value;
				var barang_name = document.form2.barang_name.value;
				
				window.opener.document.form1.barang_codess.value = barang_code; 
				window.opener.document.form1.barang_namess.value = barang_name; 
				self.close();
				//window.opener.document.getElementById("tret").innerHTML = agen;
			}
			
			function closeWindow() {
				window.close();
			}
		</script>
	</head>
	<body>	
		<h3>List Of Barang</h3>
		<form action="" method="post" name="form2" id="form2">
			<input type="hidden" id="barang_code" name="barang_code">
			<input type="hidden" id="barang_name" name="barang_name">
			<input type="hidden" id="satuan_code" name="satuan_code">
			<table id="example" class="table table-hover" style="font-size:small;">
				<thead>
					<tr>
						<th>Kode Barang</th>
						<th>Nama Barang</th>
						<th>Satuan Kode</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($scrap as $barang) { ?>
					<tr>
						<td><?php echo $barang->barang_code?></td>
						<td><?php echo $barang->barang_name?></td>
						<td><?php echo $barang->satuan_code?></td>
						<?php } ?>
					</tr>
				</tbody>
			</table>
			<div class="form-group">
			<div class="col-sm-2"></div>
			<div class="col-sm-3" align="right">	
				<button type="button" class="btn btn-default" style="height:27px; width:75px;" onclick="closeWindow();">Close</button>
				<input type="submit" value="Submit" class="btn btn-primary" style="height:27px; width:75px;" onclick="closeWin();">
			</div>
		</div>
		</form>	
	</body>
</html>