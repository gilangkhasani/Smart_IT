<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List Periode</title>
	<link rel="stylesheet" href="<?php echo base_url()?>template_lala/css/datatables/dataTables.bootstrap.css">
	<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
	<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
	<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
</head>
<script type="text/javascript">
	$(document).ready(function() {
		var table = $('#table-1').DataTable();
		$(".dataTables_filter").css('display','none');
		$(".dataTables_empty").css('display','none');
		$(".dataTables_info").css('display','none');
		$(".dataTables_length").css('display','none');
	});
</script>
<body>	
	<div class="col-lg-16">
		<div class="box box-info">
			<div class="box-header">
				<div class="box-title">
					<h3>List Periode</h3>
				</div>
			</div>
			<div class="box-body">
				<table class="table table-hover" id="table-1">
					<thead>
						<tr>
							<th>Periode Id</th>
							<th>Star and End Date</th>
							<th>Detail</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($periode as $periode) { ?>
						<tr>
							<td><?php echo $periode->periode_id;?></td>
							<td><?php echo $periode->start_date; echo ' - '.$periode->end_date;?></td>
							<td><a href="<?php echo base_url()?>index.php/Sb_mutasi/detail/<?php echo $this->uri->segment(3)?>/<?php echo ($this->uri->segment(3) == 'Barang_Jadi')? '_' : $this->uri->segment(4)?>/<?php echo $periode->periode_id?>" class="btn btn-primary btn-small" style="height:27px; font-size:11px;">Detail</a>
							</td>
							<?php } ?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>