<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List Barang</title>
	<link rel="stylesheet" href="<?php echo base_url()?>template_lala/css/datatables/dataTables.bootstrap.css">
	<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
	<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
	<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
	
</head>
	<script>
			$(document).ready(function(){
			
			$("#formsearch").submit(function(){
				if($("#jenis").val() == 'all'){
					window.location.replace("<?php echo base_url()?>index.php/Sb_history/history_barang");
				} else {
					var create_date=document.getElementById('create_date');
					var modify_date=document.getElementById('modify_date');
					var pagi=document.getElementById('paginati');
					var x = $("#formsearch").serialize();
					if(create_date.value==""){
						alert("Gagal Mencari, field search harus diisi");
						create_date.focus();
						return false;
					}
					
					$.ajax({
						type: "POST", //ganti "POST" untuk request POST
						url: "<?php echo base_url();?>index.php/Sb_history/search_history_barang",
						data: x,
						success: function(rsp) {
							$("#table-1").html(rsp);
							$("#formsearch")[0].reset();
							$("#paginati").css('display', 'none');
						},
						error: function(rsp) {
							alert(rsp);
						}
					});
				}	
			});
		});
	</script>
<body>
	<div class="col-lg-16">
		<div class="box box-info">
			<div class="box-header">
				<div class="box-title">
				<h3>History Barang</h3>
				<a class="btn btn-primary" href="<?php echo base_url()?>index.php/Sb_history/history_barang">History Barang</a>
				<a class="btn btn-primary" href="<?php echo base_url()?>index.php/Sb_history/history_satuan"> History Satuan</a><br/>
				</div>
				<form id="formsearch" style="margin-left:700px; margin-top:70px;" method="post" onsubmit="return false">
					<table>
						<tr>
							<td>Create Date</td>
							<td><input type="date" id="create_date" name="create_date" value="" /></td>
						</tr>
						<tr>
							<td>Create By</td>
							<td><input type="text" id="create_by" name="create_by" value="" /></td>
						</tr>
						<tr>
							<td>Create By</td>
							<td><input type="text" id="modify_by" name="modify_by" value="" /></td>
						</tr>
						<tr>
							<td>Modify Date</td>
							<td><input type="date" id="modify_date" name="modify_date" value="" /></td>
						</tr>
					</table>
					<!--<select name="jenis" id="jenis">
						<option value="0">-- Pilih Berdasarkan --</option>
						<option value="barang_code">Kode Barang</option>
						<option value="barang_name">Nama Barang</option>
						<option value="all">All</option>
					</select>!-->
				<input type="submit" value="Search" />
				</form></br>
			</div>
			<div class="box-body">
				<table class="table table-hover" id="table-1" style="border-bottom:1px solid;border-top:1px solid;">
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Kode Satuan</th>
							<th>Kode Hs</th>
							<th>Barang Category</th>
							<th>Barang Status</th>
							<th>Create Date</th>
							<th>Create By</th>
							<th>Modify Date</th>
							<th>Modify By</th>
						</tr>
					</thead>		
					<tbody>
						<?php $i=0;?>
						<?php foreach($barang as $barang) { ?>
						<tr>
							<td><?php echo $barang->barang_code?></td>
							<td><?php echo $barang->barang_name?></td>
							<td><?php echo $barang->satuan_code?></td>
							<td><?php echo $barang->hs_code;?></td>
							<td><?php echo $barang->barang_category;?></td>
							<td><?php echo $barang->barang_status;?></td>
							<td><?php echo $barang->create_date;?></td>
							<td><?php echo $barang->create_by;?></td>
							<td><?php echo $barang->modify_date;?></td>
							<td><?php echo $barang->modify_by;?></td>
						<?php $i++;?>
						<?php } ?>
						</tr>
						<?php if ($i==0){?>
							<tr>
								<td colspan="8"><center>No Rows</center></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				</br>
				</br>
				<div id="paginati" style="margin-top:-30px;"><?php echo $this->pagination->create_links();?></div>
			</div>
		</div>
	</div>
</body>
</html>