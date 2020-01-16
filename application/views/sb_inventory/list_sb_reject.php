<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List Of Reject</title>
	<link rel="stylesheet" href="<?php echo base_url()?>template_lala/css/datatables/dataTables.bootstrap.css">
	<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
	<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
	<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
	<script type="text/javascript">
            $(document).ready(function() {
				var table = $('#table-1').DataTable();
			} );
	</script>
	<meta http-equiv="PRAGMA" content="NO-CACHE">
	<meta http-equiv="Expires" content="-1">
	<meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
</head>

<body>	
	<h2>List Of Reject <?php echo $this->uri->segment(3)?></h2><br/><br/>
	<table class="table table-hover" id="table-1">
		<thead>
			<tr>
				<th>Kode Produksi</th>
				<th>Tanggal Produksi</th>
				<th>Kode Barang</th>
				<th>Jumlah Barang</th>
				<th>Scrap</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($inventory as $inventory) { ?>
			<tr>
				<td><?php echo $inventory->prod_id?></td>
				<td><?php echo $inventory->tgl_prod?></td>
				<td><?php echo $inventory->barang_code?></td>
				<td><?php echo $inventory->jumlah_finish?></td>
				<td><a class="btn btn-success btn-small" style="height:27px; font-size:11px;" href="<?php echo base_url()?>index.php/Sb_inventory/change_reject/<?php echo $inventory->prod_id?>">Reject</a></td>
				<?php } ?>
			</tr>
		</tbody>
	</table>
	<a href="<?php echo base_url()?>index.php/blog">Back to Menu</a>
</body>
</html>