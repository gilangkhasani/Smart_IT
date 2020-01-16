<!doctype html>
<html lang="en">
	<head>
		<title>Detail Barang Keluar</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/ui/themes/smoothness/jquery-ui.css">
		<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
		<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
		<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
		<link rel="icon" type="image/ico" href="<?php echo base_url()?>template_lala/img/smart.jpg">
		<script type="text/javascript">
            $(document).ready(function() {
				var table = $('#table-1').DataTable();
				
				$(".dataTables_filter").css('display','none');
				$(".dataTables_empty").css('display','none');
				$(".dataTables_info").css('display','none');
				$(".dataTables_length").css('display','none');
				
				$("#startdate").datepicker({
				showOn: "both", buttonImage: "<?php echo base_url()?>/bootstrap/calendar/images/calendar.gif", 
				buttonImageOnly: true, 
				nextText: "", 
				prevText: "", 
				changeMonth: true, 
				changeYear: true, 
				dateFormat: "yy-mm-dd"
				});
				
				$("#enddate").datepicker({
				showOn: "both", buttonImage: "<?php echo base_url()?>/bootstrap/calendar/images/calendar.gif", 
				buttonImageOnly: true, 
				nextText: "", 
				prevText: "", 
				changeMonth: true, 
				changeYear: true, 
				dateFormat: "yy-mm-dd"
				});
			} );
	</script>
	</head>
	<body>	
		<div class="box box-info">
			<div class="col-lg-16">
				<div class="box-body">
				<h3 align="center">Detail Barang Export</h3>
				<table id="table-1" class="table-bordered" style="font-size:small;">
					<thead>
					<tr>
						<td>Kode Barang</td>
						<td>Nama Barang</td>
						<td style="display:none;">Satuan Barang</td>
						<td>Satuan</td>
						<td>Jumlah</td>
						<td style="display:none;">Nilai Konversi</td>
						<td>Nilai</td>
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
							<td style="display:none;"><?php echo $export_dt->nilai_konversi?>
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