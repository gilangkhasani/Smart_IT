<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List Satuan</title>
	<link rel="stylesheet" href="<?php echo base_url()?>template_lala/css/datatables/dataTables.bootstrap.css">
	<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
	<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
	<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
</head>
	<script>
			$(document).ready(function(){
			
			if(test.innerHTML !=""){
				alert('Kode Satuan Sudah Ada Silahkan Input Data Kembali..');
			}
			
			$("#formsearch").submit(function(){
				if($("#jenis").val() == 'all'){
					window.location.replace("<?php echo base_url()?>index.php/Sb_satuan/listing");
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
				$.ajax({
					type: "POST", //ganti "POST" untuk request POST
					url: "<?php echo base_url();?>index.php/Sb_satuan/search",
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
			
			$('.satuan_code').on( 'change', function () {
				$("#message").html(" checking...");             
				var satuan_code = $(".satuan_code").val();
		 
				$.ajax({
					type:"post",
					url:"<?php echo base_url()?>index.php/Sb_satuan/search_satuan",
					data:"satuan_code="+satuan_code,
						success:function(data){
						if(data==0){
							$("#message").html(" Kode Satuan Bisa Di Gunakan");
						} else {
							$("#message").html("Kode Satuan Sudah di Gunakan");
						}
					}
				});
			} );
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
				<table class="table table-bordered table-hover" id="table-1" >
					<thead>
						<tr>
							<th>Satuan Code</th>
							<th>Satuan Name</th>
							<th>Create Date</th>
							<th>Create By</th>
							<th>Modify Date</th>
							<th>Modify By</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($satuan as $satuan) { ?>
						<tr>
							<td><?php echo $satuan->satuan_code?></td>
							<td><?php echo $satuan->satuan_name?></td>
							<td><?php echo $satuan->create_date;?></td>
							<td><?php echo $satuan->create_by;?></td>
							<td><?php echo $satuan->modify_date;?></td>
							<td><?php echo $satuan->modify_by;?></td>
							<?php 
							} ?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	<div id="paginati" style="margin-top:-30px;"><?php echo $this->pagination->create_links();?></div>
	</div>
	
</body>
</html>