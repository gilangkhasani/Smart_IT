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
<style>

.ui-menu .ui-menu-item a {
  font-size: 12px;
}
.ui-autocomplete {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1510 !important;
  float: left;
  display: none;
  min-width: 160px;
  width: 160px;
  padding: 4px 0;
  margin: 2px 0 0 0;
  list-style: none;
  background-color: #ffffff;
  border-color: #ccc;
  border-color: rgba(0, 0, 0, 0.2);
  border-style: solid;
  border-width: 1px;
  -webkit-border-radius: 2px;
  -moz-border-radius: 2px;
  border-radius: 2px;
  -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  -webkit-background-clip: padding-box;
  -moz-background-clip: padding;
  background-clip: padding-box;
  *border-right-width: 2px;
  *border-bottom-width: 2px;
}
.ui-menu-item > a.ui-corner-all {
    display: block;
    padding: 3px 15px;
    clear: both;
    font-weight: normal;
    line-height: 18px;
    color: #555555;
    white-space: nowrap;
    text-decoration: none;
}
.ui-state-hover, .ui-state-active {
      color: #ffffff;
      text-decoration: none;
      background-color: #0088cc;
      border-radius: 0px;
      -webkit-border-radius: 0px;
      -moz-border-radius: 0px;
      background-image: none;
}
</style>
<script>
	  $(function() {
		$( "#satuan_code" ).autocomplete({
		  source: "<?php echo base_url()?>index.php/Sb_satuan/get_Sb_satuan"
		});
		
		$( "#satuan_codes" ).autocomplete({
		  source: "<?php echo base_url()?>index.php/Sb_satuan/get_Sb_satuan"
		});
		
		$( ".satuan_code" ).autocomplete( "option", "appendTo", ".form-tes" );
	  });
</script>
	<script>
			$(document).ready(function(){
			
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
					window.location.replace("<?php echo base_url()?>index.php/Sb_stock_opname");
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
						url: "<?php echo base_url();?>index.php/Sb_stock_opname/search_stock_opname",
						data: x,
						success: function(rsp) {
							$("#table-1").html(rsp);
							$("#formsearch")[0].reset();
							$("#paginati").css('display', 'none');
							$("#message-loading").html('')
						},
						error: function(rsp) {
							alert(rsp);
						}
						});
				}	
			});
			
			$('.barang_code').on( 'change', function () {
				$("#message").html(" checking...");             
				var barang_code = $(".barang_code").val();
		 
				$.ajax({
					type:"post",
					url:"<?php echo base_url()?>index.php/Sb_stock_opname/search_barang",
					data:"barang_code="+barang_code,
						success:function(data){
						if(data==0){
							$("#message").html(" Kode Barang Bisa Di Gunakan");
						} else {
							$("#message").html("Kode Barang Sudah di Gunakan");
						}
					}
				});
			} );
			
		});
	</script>
<?php
	$today = date('Y-m-d');
	$today=date('Y-m-d', strtotime($today)).'<br/>';;
		
	$from = date('Y-m-d', strtotime("01/01/".date("Y")));
	$to = date('Y-m-d', strtotime("05/01/".date("Y")));
			
	$from1 = date('Y-m-d', strtotime("05/01/".date("Y")));
	$to1 = date('Y-m-d', strtotime("09/01/".date("Y")));
	
	$today1 = date('Y-m-d');
	$to2 = date('Y-m-d', strtotime("12/31/".(date("Y"))));
			
	if (($today >= $from) && ($today <= $to)) {
		$per = '01';
	}
	else if (($today >= $from1) && ($today <= $to1)) {
		$per = '02';
	}
	else {
		$per = '03';
	}
	$periode = 'PR-'.date('Y').'-'.$per;
	
?>
<body>
	<div class="col-lg-16">
		<div class="box box-info">
			<div class="box-header">
				<div class="box-title">
				<?php if ($today1 == $to2 || $today1 == $to1 || $today1 == $to){?>
					<h3 style="font-size:23px;">List Stock Opname </h3>
					<a href="<?php echo base_url()?>index.php/Sb_stock_opname/insert" class="btn btn-primary"><i class="fa fa-plus"></i> &nbsp New Stock Opname</a>
				<?php } else { ?>
					<h3 style="font-size:23px;">Belum Akhir Periode</h3>
				<?php } ?>
				</div>
				<form id="formsearch" style="margin-left:700px; margin-top:70px;" method="post" onsubmit="return false">
					<input type="text" id="search" name="search" value="" />
					<select name="jenis" id="jenis">
						<option value="all">All</option>
						<option value="barang_code">Kode Barang</option>
						<option value="barang_name">Nama Barang</option>
					</select>
				<input type="submit" value="Search" />
				</form></br>
			</div>
			<div class="box-body">
				<table class="table table-hover" id="table-1" style="border-bottom:1px solid;border-top:1px solid;">
					<div id="message-loading"></div>
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Stock Opname</th>
							<th>Periode Id</th>
							<th>Keterangan</th>
							<th>Penyesuaian</th>
						</tr>
					</thead>		
					<tbody>
						<?php $i=0;?>
						<?php foreach($barang as $barang) { ?>
						<tr>
							<td><?php echo $barang->barang_code?></td>
							<td><?php echo $barang->stock_opname?></td>
							<td><?php echo $barang->periode_id?></td>
							<td><?php echo $barang->keterangan;?></td>
							<td><a class="btn btn-primary btn-small" data-toggle="modal" data-target="#myModal<?php echo $barang->barang_code;?>" style="height:27px; font-size:11px;" href="">Penyesuaian</a></td>
							
							<div class="modal fade" id="myModal<?php echo $barang->barang_code;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							  <div class="modal-dialog" style="width: 500px;">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myModalLabel">Penyesuaian Barang</h4>
								  </div>

								  <div class="modal-body">
									<div class="box-body">
										<form method="post" class="form-tes" action="<?php echo base_url()?>index.php/Sb_stock_opname/save">
											<div>
												<label for="barang_code">Barang Code</label>
												<div>
													<input type="text" name="barang_code" id="barang_code" value="<?php echo $barang->barang_code?>" readonly style="background:#eae9e9;" required />
												</div>
											</div>
											<div>
												<label for="stock_opname">Stock Opname</label>
												<div>
													<input type="text" name="stock_opname" id="stock_opname" value="<?php echo $barang->stock_opname;?>" readonly style="background:#eae9e9;">
												</div>
											</div>
											<div>
												<label for="penyesuaian">Penyesuaian</label>
												<div>
													<input type="text" name="penyesuaian" id="penyesuaian" value="">
												</div>
											</div>
											<div>
												<label for="periode_id">Periode Id</label>
												<div>
													<input type="text" name="periode_id" id="periode_id" value="<?php echo $barang->periode_id;?>" readonly style="background:#eae9e9;">
												</div>
											</div>
											<div>
												<label for="keterangan">Keterangan</label>
												<div>
													<input type="text" name="keterangan" id="keterangan" value="<?php echo $barang->keterangan?>" required />
												</div>
											</div>
										</div>
									</div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
									<input type="submit" class="btn btn-primary" value="Save"/>
								  </div>
								  <?php
										if($barang->barang_code != ""){
											echo "<input type='hidden' value='$barang->barang_code' name='barang_codes'>";
										}
									?>
								  </form>
								</div>
							  </div>
							</div>
							<?php $i++;?>
							<?php } ?>
						</tr>
						<?php if ($i==0){?>
							<tr>
								<td colspan="8"><center>No data available in table</center></td>
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