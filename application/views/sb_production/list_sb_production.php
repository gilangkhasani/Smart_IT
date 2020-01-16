<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List Production</title>
	<link rel="stylesheet" href="<?php echo base_url()?>template_lala/css/datatables/dataTables.bootstrap.css">
	<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
    <script src="<?php echo base_url()?>template_lala/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
	<script type="text/javascript">		
		function openWinBarangJadi(url, title, w, h)
		{
			var left = (screen.width/2)-(w/2);
			var top = (screen.height/2)-(h/2);
			return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
			//window.open("<?php echo base_url()?>index.php/Sb_export/get_supplier", "popup_form", "toolbar=yes, scrollbars=yes, resizable=yes");
		}

		$(document).ready(function(){
		
			$('#tgl_prod').datepicker();
			
			$("#tgl_prod").inputmask("yyyy-mm-dd");
				
			//Money Euro
			$("[data-mask]").inputmask();
		
			if(test.innerHTML !=""){
				alert('Kode Produksi Sudah Ada Silahkan Input Data Kembali..');
			}
			
			if(notif.innerHTML !=""){
				alert(notif.innerHTML);
			}
			
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
			
			$('#prod_id').on( 'change', function () {
				$("#message1").html(" checking...");             
				var prod_id = $("#prod_id").val();
		 
				$.ajax({
					type:"post",
					url:"<?php echo base_url()?>index.php/Sb_production/search_prod_id",
					data:"prod_id="+prod_id,
						success:function(data){
						if(data==0){
							$("#message1").html(" Kode Produksi Bisa Di Gunakan");
						} else {
							$("#message1").html("Kode Produksi Sudah di Gunakan");
						}
					}
				});
			} );
			
			$("#formsearch").submit(function(){
				if($("#jenis").val() == 'all'){
					window.location.replace("<?php echo base_url()?>index.php/Sb_production/listing");
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
						url: "<?php echo base_url();?>index.php/Sb_production/searchProduction/",
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
			/*
			$('#cek').click(function(){
				if($(".jumlah_on_production").val() > 0){
					alert('Jumlah On Production Lebih dari 0');
					return false;
				} 
			});	
			*/
		});
		function cek(jumlah){
			$(function(){
				if(jumlah > 0){
					alert('Jumlah On Production Lebih dari 0');
					event.preventDefault();
				} 
			});
		}
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
					<h3>List Production <?php echo $this->uri->segment(3)?></h3>
					<a class="btn btn-primary" data-toggle="modal" data-target="#myModal" href="">
					<!--<a class="btn btn-primary"  href="<?php echo base_url()?>index.php/Sb_production/add">!-->
					<i class="fa fa-plus"></i> &nbsp New Production</a>
					<div id="test" style="display:none;"><?php echo $this->session->flashdata('production');?></div>
					<div id="notif" style="display:none;"><?php echo $this->session->flashdata('berhasil');?></div>
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
							<th>Status</th>
							<th>Request</th>
							<!--
							<th>Delete</th>
							!-->
						</tr>
					</thead>
					<tbody>
						<?php $i=0;?>
						<?php foreach($production as $production) { ?>
						<tr>
							<td><?php echo $production->prod_id?></td>
							<td><?php echo $production->tgl_prod?></td>
							<td><?php echo $production->barang_code?></td>
							
							<td><a href="javascript:0" onClick="openWinBarangJadi('<?php echo base_url()?>index.php/Sb_production/lihat_detail/<?php echo $production->prod_id?>','popupdetail','600','500')"><?php echo $production->jumlah_barang;?></a></td>
							
							<input type="hidden" name="jumlah_on_production" id="jumlah_on_production" class="jumlah_on_production" value="<?php echo $production->jumlah_on_production;?>">
							
							<td><a id="cek" onclick="cek('<?php echo $production->jumlah_on_production?>');" class="btn btn-success btn-small" style="height:27px; font-size:11px;" href="<?php echo base_url()?>index.php/Sb_production/update_status/<?php echo $production->prod_id?>">Finish</a></td>
							
							<td><a class="btn btn-primary btn-small" style="height:27px; font-size:11px;" href="<?php echo base_url()?>index.php/Sb_production/edit/<?php echo $production->prod_id?>">Request</a></td>
							<!--
							<td><a class="btn btn-danger btn-small" style="height:27px; font-size:11px;" onclick="return confirm('Are you sure ?')" href="<?php echo base_url()?>index.php/Sb_production/delete/<?php echo $production->prod_id?>">Delete</a></td>
							!-->
							<?php $i++;
							} ?>
						</tr>
						<?php if ($i==0){?>
								<tr>
									<td colspan="7"><center>No Rows</center></td>
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
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 500px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Production Plan</h4>
          </div>

          <div class="modal-body">
            <div class="box-body">
				<form method="post" action="<?php echo base_url()?>index.php/Sb_production/save" class="form-horizontal" name="form1" id="form1">
					<table>
						<tr>
							<td><label for="prod_id">Kode Produksi</label></td>
							<td> &nbsp : &nbsp <input type="text" name="prod_id" id="prod_id" value="" required/></td>
							<td id="message1"></td>
						</tr>
						<tr>
							<td><label for="tgl_prod">Tanggal Produksi</label></td>
							<td> &nbsp : &nbsp <input type="text" name="tgl_prod" id="tgl_prod" data-inputmask="'alias':'yyyy-mm-dd'" data-mask value="" required /></td>
						</tr>
						<tr>
							<td><label for="barang_code">Barang jadi</label></td>
							<td> &nbsp : &nbsp <input type="text" name="barang_codes" id="barang_codes" value=""readonly />

							<td>
								<input type="button" value="Search" class="btn btn-primary btn-small" style="height:27px; font-size:11px;" onclick="openWinBarangJadi('<?php echo base_url()?>index.php/Sb_production/get_barang_jadi','popupBarang','600','550')"/>
							</td>
									
							</td>
						</tr>
					</table>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
				<input type="submit" class="btn btn-primary" value="Save" name="save_prod"/>
			</div>
		  </form>
        </div>
      </div>
    </div>
</body>
</html>