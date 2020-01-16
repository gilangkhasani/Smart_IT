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
	</head>
	<body>	
		<div class="box box-info">
			<div class="col-lg-16">
				<div class="box-body">
				<table id="table-1" class="table-bordered">
					<thead>
					<tr>
						<td>Code Barang</td>
						<td>Nama Barang</td>
						<td style="display:none;">Satuan Barang</td>
						<td>Satuan Doc</td>
						<td>Jumlah Doc</td>
						<td>Nilai Konversi</td>
						<td>Nilai Barang</td>
					</tr>
					</thead>
					<tbody>
						<?php foreach($export_dt as $export_dt){ ?>
						<tr>
							<td><?php echo $export_dt->barang_code?>
							<input type="hidden" name="barang_code[]" id="barang_code" value="<?php echo $export_dt->barang_code?>"/>
							</td>
							<td><?php echo $export_dt->barang_name?>
							<input type="hidden" name="barang_name[]" id="barang_name" value="<?php echo $export_dt->barang_name?>"/>
							</td>
							<td style="display:none;"><?php echo $export_dt->satuan_code?>
							<input type="hidden" name="satuan_code[]" id="satuan_code" value="<?php echo $export_dt->satuan_code?>"/>
							</td>
							<td><?php echo $export_dt->satuan_doc?>
							<input type="hidden" name="satuan_doc[]" id="satuan_doc" value="<?php echo $export_dt->satuan_doc?>"/>
							</td>
							<td><?php echo $export_dt->jumlah_doc?>
							<input type="hidden" name="jumlah_doc[]" id="jumlah_doc" value="<?php echo $export_dt->jumlah_doc?>"/>
							</td>
							<td><?php echo $export_dt->nilai_konversi?>
							<input type="hidden" name="nilai_konversi[]" id="nilai_konversi" value="<?php echo $export_dt->nilai_konversi?>"/>
							</td>
							<td><?php echo $export_dt->nilai_barang?>
							<input type="hidden" name="nilai_barang[]" id="nilai_barang" value="<?php echo $export_dt->nilai_barang?>"/>
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