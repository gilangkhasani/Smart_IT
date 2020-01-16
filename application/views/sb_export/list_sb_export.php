<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List Export</title>
	<link rel="stylesheet" href="<?php echo base_url()?>template_lala/css/datatables/dataTables.bootstrap.css">
	<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
    <script src="<?php echo base_url()?>template_lala/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
	<script type="text/javascript">
        $(document).ready(function() {
			//var table = $('#table-1').DataTable();
		} );
		
		function openWin(url, title, w, h)
		{
			var left = (screen.width/2)-(w/2);
			var top = (screen.height/2)-(h/2);
			return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);	
		}
	</script>
	<script>
			$(document).ready(function(){
			
			$("#tgl_bukti").datepicker();
			
			$("#tgl_bukti").inputmask("yyyy-mm-dd");
				
            //Money Euro
            $("[data-mask]").inputmask();
			
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
			
			$("#formsearch").submit(function(){
				if($("#jenis").val() == 'all'){
					window.location.replace("<?php echo base_url()?>index.php/Sb_export/listing/<?php echo $this->uri->segment(3);?>");
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
					url: "<?php echo base_url();?>index.php/Sb_export/search/<?php echo $this->uri->segment(3);?>",
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
		
		function modalEdit(doc_id){
			$(function(){
				$("#doc_id").val(doc_id);
				
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
				<h2 style="font-size:23px;">List of Export <?php echo str_replace('_', ' ', $this->uri->segment(3));?></h2>
				<a class="btn btn-primary" href="<?php echo base_url()?>index.php/Sb_export/add/<?php echo $this->uri->segment(3)?>">
				<i class="fa fa-plus"></i> &nbsp New Export</a>
				<div id="notif" style="display:none;"><?php echo $this->session->flashdata('berhasil');?></div>
			</div>
			<form id="formsearch" style="margin-left:700px; margin-top:70px;" method="post" onsubmit="return false">
					<input type="text" id="search" name="search" value="" />
					<select name="jenis" id="jenis">
						<option value="all">All</option>
						<option value="no_doc">No. Dokumen</option>
						<option value="no_bukti">No. Pengeluaran</option>
						<option value="supplier_id">Supplier</option>
					</select>
				<input type="submit" value="Search" />
			</form></br>
		</div>
		<div class="box-body">
			<table class="table table-hover" id="table-1" style="border-bottom:1px solid;border-top:1px solid;">
				<div id="message-loading"></div>
				<thead>
					<tr>
						<th>No. Dokumen</th>
						<th>Tgl. Dokumen</th>
						<th>No. Pengeluaran</th>
						<th>Tgl. Pengeluaran</th>
						<th>Supplier</th>
						<th>Valas</th>
						<th>Detail Barang</th>
						<th>Status</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php $tes=0 ?>
					<?php foreach($export as $export) { ?>
					<tr>
						<td><?php echo $export->no_doc?></td>
						<td><?php echo $export->tgl_doc?></td>
						<td><?php echo $export->no_bukti?></td>
						<td><?php echo $export->tgl_bukti?></td>
						<td><?php echo $export->supplier_name?></td>
						<td><?php echo $export->valas?></td>
						
						<td><a href="javascript:0" onClick="openWin('<?php echo base_url()?>index.php/Sb_export/lihat_detail/<?php echo $export->doc_id?>','popupdetail','600','500')"><?php echo $export->jumlah?></a></td>
						
						<!--
						<td><a class="btn btn-success btn-small" style="height:27px; font-size:11px;" onclick="return confirm('Are you sure ?')" href="<?php echo base_url()?>index.php/Sb_export/ubah_status/<?php echo $export->doc_id?>/<?php echo str_replace(' ', '_', $export->jenis_doc)?>">Finish</a></td>
						!-->
						<td><a onclick="modalEdit('<?php echo $export->doc_id?>');" class="btn btn-success btn-small" style="height:27px; font-size:10px;" data-toggle="modal" data-target="#myModal1">Finish</a></td>
						
						<td><a class="btn btn-primary btn-small" style="height:27px; font-size:11px;" href="<?php echo base_url()?>index.php/Sb_export/edit/<?php echo $this->uri->segment(3)?>/<?php echo $export->doc_id?>">Edit</a></td>
						
						<td><a class="btn btn-danger btn-small" style="height:27px; font-size:11px;" onclick="return confirm('Are you sure ?')" href="<?php echo base_url()?>index.php/Sb_export/delete/<?php echo $export->doc_id?>/<?php echo $this->uri->segment(3)?>">Delete</a></td>
						
					</tr>
					<?php $tes++;
					} ?>
						<?php if ($tes==0){?>
							<tr>
								<td colspan="10"><center>No data available in table</center></td>
							</tr>
						<?php } ?>
				</tbody>
			</table>
			</br></br>
			<div id="paginati" style="margin-top:-30px;"><?php echo $this->pagination->create_links();?></div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog" style="width: 500px; margin-top:120px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title" id="myModalLabel"><i class="fa fa-hdd-o"></i> &nbsp Bukti Pengeluaran Barang</h4>
		  </div>

		  <div class="modal-body">
			<div class="box-body">
				<form method="post" class="form-tes" action="<?php echo base_url()?>index.php/Sb_export/finish">
					<div>
						<label for="no_bukti">No. Pengeluaran</label>
						<div id="isUpdating">
							<input type="text" name="no_bukti" id="no_bukti" value="" required/>
							<input type="hidden" name="doc_id" id="doc_id" value="" required/>
						</div>
					</div>
					<div>
						<label for="tgl_bukti">Tgl. Pengeluaran</label>
						<div>
							<input type="text" id="tgl_bukti" name="tgl_bukti" data-inputmask="'alias':'yyyy-mm-dd'" data-mask  value=""/>
						</div>
					</div>
					
					<?php
						$jenis_doc = str_replace(' ', '_', $export->jenis_doc);
						echo "<input type='hidden' value='$jenis_doc' name='jenis_doc'>";	
					?>
				</div>
			</div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="submit" class="btn btn-primary" value="Finish"/>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
</body>
</html>