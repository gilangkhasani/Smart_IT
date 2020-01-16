<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List Of Scrap</title>
	<link rel="stylesheet" href="<?php echo base_url()?>template_lala/css/datatables/dataTables.bootstrap.css">
	<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
	<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
	<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
	<script type="text/javascript">
        $(document).ready(function() {
			//var table = $('#table-1').DataTable();
			
			$("#jenis").change(function(){
				if($("#jenis").val() == 'all'){
					$("#search").attr('readonly', true);
					$("#search").addClass('input-disabled');
					$("#search").css('background-color' , '#DEDEDE');
				}else{
					$("#search").attr('readonly', false);
					$("#search").css('background-color' , '#FFF');
				}
			});
			
			$("#formsearch").submit(function(){
				if($("#jenis").val() == 'all'){
					window.location.replace("<?php echo base_url()?>index.php/Sb_inventory/<?php echo $this->uri->segment(2);?>");
				} else {
					var search1=document.getElementById('search');
					var pagi=document.getElementById('paginati');
					var x = $("#formsearch").serialize();
					if(search1.value==""){
						alert("Gagal Mencari, field search harus diisi");
						search1.focus();
						return false;
					}
					if(jenis.selectedIndex ==""){
						alert("Gagal Mencari, field jenis harus diisi");
						jenis.focus();
						return false;
					}
					$("#message-loading").html(' <div class="progress sm progress-striped active"> <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div>'); 
					
					$.ajax({
						type: "POST", //ganti "POST" untuk request POST
						url: "<?php echo base_url();?>index.php/Sb_inventory/searchProductionPlan/<?php echo $this->uri->segment(2);?>",
						data: x,
						success: function(rsp) {
							$("#table-1").html(rsp);
							$("#formsearch")[0].reset();
							$("#paginati").css('display', 'none');
							$("#message-loading").html('');
						},
						error: function(rsp) {
							alert(rsp);
						}
						});
				}	
			});
		} );
	</script>	
	<meta http-equiv="PRAGMA" content="NO-CACHE">
	<meta http-equiv="Expires" content="-1">
	<meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
</head>

<body>	
	<div class="col-lg-16">
		<div class="box box-info">
			<div class="box-header">
				<div class="box-title">	
					<h3>List of Scrap <?php echo $this->uri->segment(3)?></h3>
				</div>
				<form id="formsearch" style="margin-left:700px; margin-top:70px;" method="post" onsubmit="return false">
					<input type="text" id="search" name="search" value="" />
					<select name="jenis" id="jenis">
						<option value="all">All</option>
						<option value="prod_id">Kode Produksi</option>
						<option value="barang_code">Kode Barang</option>
					</select>
					<input type="submit" value="Search" />
					</form></br>
			</div>
			<div class="box-body">	
				<table class="table table-hover" id="table-1" style="border-bottom:1px solid;border-top:1px solid;">
				<div id="message-loading"></div>
					<thead>
						<tr>
							<th>Kode Produksi</th>
							<th>Tanggal Produksi</th>
							<th>Kode Barang</th>
							<th>Jumlah Barang</th>
							<th>Pemasukan</th>
						</tr>
					</thead>
					<tbody>
						<?php $tes=0 ?>
						<?php foreach($inventory as $inventory) { ?>
						<tr>
							<td><?php echo $inventory->prod_id?></td>
							<td><?php echo $inventory->tgl_prod?></td>
							<td><?php echo $inventory->barang_code?></td>
							<td><?php echo $inventory->jumlah_finish?></td>
							<td><a class="btn btn-success btn-small" style="height:27px; font-size:11px;" href="<?php echo base_url()?>index.php/Sb_inventory/change_scrap/<?php echo $inventory->prod_id?>">Scrap</a></td>
							<?php $tes++; } 
							?>
						</tr>
						<?php if ($tes==0){?>
								<tr>
									<td colspan="5"><center>No data available in table</center></td>
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