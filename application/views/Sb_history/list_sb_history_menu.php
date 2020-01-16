<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List Satuan</title>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/ui/themes/smoothness/jquery-ui.css">
		<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
		<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
		<script src="<?php echo base_url()?>template_lala/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
		<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
		<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
	<!--
	<link rel="stylesheet" href="<?php echo base_url()?>template_lala/css/datatables/dataTables.bootstrap.css">
	<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
	<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
	<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">-->
</head>
	<script>
		$(document).ready(function(){
			$('#create_date').datepicker();
			$('#modify_date').datepicker();
			
			$("#create_date").inputmask("yyyy-mm-dd");
			$("#modify_date").inputmask("yyyy-mm-dd");
				
			//Money Euro
			$("[data-mask]").inputmask();
			
			$("#formsearch").submit(function(){
				if($("#menu").val() == 'awal'){
					window.location.replace("<?php echo base_url()?>index.php/Sb_history/history_menu");
				} else {
					var x = $("#formsearch").serialize();
					//$("#message").html(" checking...");  
					$("#message-loading").html(' <div class="progress sm progress-striped active"> <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div>');  
					$.ajax({
						type: "POST", //ganti "POST" untuk request POST
						url: "<?php echo base_url();?>index.php/Sb_history/search_history_menu",
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
		});
	</script>
<body>	
	<div class="col-lg-16">
		<div class="box box-info">
			<div class="box-header">
				<div class="box-title">
					<h3>List History</h3>
				</div>
				<form id="formsearch" style="margin-left:-50px; margin-top:70px;" method="post" onsubmit="return false" action="<?php echo base_url()?>index.php/Sb_history/search_history_satuan">
					<table>
						<tr>
							<td>Pilih Menu</td>
							<td>
								<select name="menu" id="menu">
									<option value="0">-- Pilih Menu --</option>
									<option value="sb_barang">Barang</option>
									<option value="sb_satuan">Satuan</option>
									<option value="sb_negara">Negara</option>
									<option value="sb_supplier">Supplier</option>
									<option value="sb_doc_export_hd">Export</option>
									<option value="sb_doc_import_hd">Import</option>
									<option value="sb_production">Production</option>
									<option value="awal">kembali ke awal</option>
								</select>	
							</td>
						</tr>
						<tr>
							<td>Create Date</td>
							<td><input type="text" id="create_date" name="create_date" value="" /></td>
						</tr>
						<tr>
							<td>Create By</td>
							<td><input type="text" id="create_by" name="create_by" value="" /></td>
						</tr>
						<tr>
							<td>Modify Date</td>
							<td><input type="text" id="modify_date" name="modify_date" value="" /></td>
						</tr>
						<tr>
							<td>Modify By</td>
							<td><input type="text" id="modify_by" name="modify_by" value="" /></td>
						</tr>
						<tr>
							<td><input type="submit" value="Search" /></td>
						</tr>
					</table>
				</form></br>
			</div>
			<div class="box-body">
				<table class="table table-bordered table-hover" id="table-1" >
					<div id="message-loading">
					<thead>
						<tr>
							<th>Kode</th>
							<th>Input Data</th>
							<th>Create Date</th>
							<th>Create By</th>
							<th>Modify Date</th>
							<th>Modify By</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
					</div>
				</table>
			</div>
		</div>
	<div id="paginati" style="margin-top:-30px;"></div>
	</div>
	
</body>
</html>