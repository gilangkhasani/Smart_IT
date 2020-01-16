<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>List Supplier</title>
		<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>
		<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">	
		<link rel="icon" type="image/ico" href="<?php echo base_url()?>template_lala/img/smart.jpg">
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
					$('#supplier_code').val(rowData[0]);
					$('#supplier_name').val(rowData[1]);
					$('#supplier_address').val(rowData[2]);
				} );
				
				
				$(".dataTables_empty").css('display','none');
				$(".dataTables_info").css('display','none');
				$(".dataTables_length").css('display','none');
			} );
			
			function closeWin() {
				var supplier_code = document.form3.supplier_code.value;
				var supplier_name = document.form3.supplier_name.value;
				var supplier_address = document.form3.supplier_address.value;
				
				window.opener.document.form1.supplier_code.value = supplier_code; 
				window.opener.document.form1.supplier_name.value = supplier_name; 
				window.opener.document.form1.supplier_address.value = supplier_address; 
				self.close();
			}
			
			function closeWindow() {
				window.close();
			}
			
		</script>
	</head>
	<body>	
		<!-- <h3>List Barang</h3> !-->
		<br>
		<form action="" method="post" name="form3" id="form3">
			<input type="hidden" id="supplier_code" name="supplier_code">
			<input type="hidden" id="supplier_name" name="supplier_name">
			<input type="hidden" id="supplier_address" name="supplier_address">
			<table id="example" class="table table-hover" style="font-size:small">
				<thead>
					<tr>
						<th>Supplier Code</th>
						<th>Supplier Name</th>
						<th>Supplier Address</th>
						<th>Negara Code</th>
						<!--<th>NPWP</th>
						<th>No Izin TPB</th>!-->
					</tr>
				</thead>
				<tbody>
					<?php foreach($supplier as $supplier) { ?>
					<tr>
						<td><?php echo $supplier->supplier_code?></td>
						<td><?php echo $supplier->supplier_name?></td>
						<td><?php echo $supplier->supplier_address?></td>
						<td><?php echo $supplier->negara_code?></td>
						<!--<td><?php echo $supplier->npwp?></td>
						<td><?php echo $supplier->no_izin_tpb?></td>!-->
						<?php } ?>
					</tr>
				</tbody>
			</table>
			<div class="form-group">
			<div class="col-sm-2"></div>
			<div class="col-sm-3" align="right">	
				<button type="button" class="btn btn-default" style="height:27px; width:75px;" onclick="closeWindow();">Close</button>
				<input type="submit" value="Submit" class="btn btn-primary btn-small" style="height:27px; width:75px;" onclick="closeWin();">
			</div>
		</div>
		</form>	
	</body>
</html>