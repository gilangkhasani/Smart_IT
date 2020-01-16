<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List Periode</title>
</head>
<body>	
	<h2>List Periode</h2>
	<table class="table table-hover" border="1px solid black">
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
				<td><a href="<?php echo base_url()?>index.php/Sb_pengeluaran_barang/detail">Detail</a></td>
				<?php } ?>
			</tr>
		</tbody>
	</table>
	<a href="<?php echo base_url()?>index.php/blog">Back to Menu</a>
</body>
</html>