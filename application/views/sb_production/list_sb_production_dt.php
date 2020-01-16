<!doctype html>
<html lang="en">
	<head>
		<title>Form Export</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/ui/themes/smoothness/jquery-ui.css">
		<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
		<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
		<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
		<link rel="icon" type="image/ico" href="<?php echo base_url()?>template_lala/img/smart.jpg">
		<script>
			$(document).ready(function() {
				var table = $('#table-1').DataTable();
				
				$(".dataTables_filter").css('display','none');
				$(".dataTables_empty").css('display','none');
				$(".dataTables_info").css('display','none');
				$(".dataTables_length").css('display','none');
			} );	
		</script>
	</head>
	<body>	
		<div class="box box-info">
			<div class="col-lg-16">
				<div class="box-body">
				<table id="table-1" class="table table-hover" style="font-size:small;">
					<thead>
					<tr>
						<td>Code Barang</td>
						<td>Nama Barang</td>
						<td>Satuan Barang</td>
						<td>Jumlah Barang</td>
						<td>Jumlah On Production</td>
					</tr>
					</thead>
					<tbody>
						<?php foreach($prod_dt as $prod_dt){ ?>
						<tr>
							<td><?php echo $prod_dt->barang_code?>
							</td>
							<td><?php echo $prod_dt->barang_name?>
							</td>
							<td><?php echo $prod_dt->satuan_code?>
							</td>
							<td><?php echo $prod_dt->jumlah_barang?>
							</td>
							<td><?php echo $prod_dt->jumlah_on_production?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</body>
</html>	