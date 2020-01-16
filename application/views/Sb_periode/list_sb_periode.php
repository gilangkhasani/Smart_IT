<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List Periode</title>
	<link rel="stylesheet" href="<?php echo base_url()?>template_lala/css/datatables/dataTables.bootstrap.css">
	<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
	<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
	<script src="<?php echo base_url()?>template_lala/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
	<link rel="stylesheet" href="<?php echo base_url()?>template_lala/css/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url()?>template_lala/css/jquery.ui.theme.css">
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
				var search1=document.getElementById('search');
				var jenis=document.getElementById('jenis');
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
				url: "<?php echo base_url();?>index.php/Sb_Periode/search",
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
			});
		});
	</script>
</head>
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
?>
<body>
	<div class="col-lg-16">
		<div class="box box-info">
			<div class="box-header">
				<div class="box-title">
					<h2 style="font-size:23px;"> List Periode</h2>
					<?php if ($today1 == $to2 || $today1 == $to1 || $today1 == $to){?>
					&nbsp <a class="btn btn-primary" data-toggle="modal" data-target="#myModal" href=""><i class="fa fa-plus"></i> &nbsp New Periode</a>
					<?php } else { ?>
						<h2 style="font-size:23px;">Periode Tidak Aktif</h2>
					<?php } ?>
				</div>
				<form id="formsearch" style="margin-left:700px; margin-top:70px;" method="post" onsubmit="return false">
					<input type="text" id="search" name="search" value="" />
					<select name="jenis" id="jenis">
						<option value="all">All</option>
						<option value="periode_id">Periode Id</option>
						<option value="start_date">Start Date</option>
						<option value="end_date">End Date</option>
					</select>	
					<input type="submit" value="Search" />
				</form></br>
			</div>
			<div class="box-body">
				<table class="table table-hover" id="table-1" style="border-bottom:1px solid;border-top:1px solid;">
				<div id="message-loading"></div>
					<thead>
						<tr>
							<th>Periode Id</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Create Date</th>
							<th>Create By</th>
							<th>Modify Date</th>
							<th>Modify By</th>
							<!--
							<th>Edit</th>
								<th>Delete</th>
							!-->
						</tr>
					</thead>
					<tbody>
						<?php $i=0; ?>
						<?php foreach($periode as $periode) { ?>
						<tr>
							<td><?php echo $periode->periode_id?></td>
							<td><?php echo $periode->start_date?></td>
							<td><?php echo $periode->end_date?></td>
							<td><?php echo $periode->create_date;?></td>
							<td><?php echo $periode->create_by;?></td>
							<td><?php echo $periode->modify_date;?></td>
							<td><?php echo $periode->modify_by;?></td>
							<!--
							<td><a href="" data-toggle="modal" data-target="#myModal<?php echo $periode->periode_id;?>" class="btn btn-primary btn-small" style="height:27px; font-size:11px;">Edit</a></td>
							<td><a class="btn btn-danger btn-small" style="height:27px; font-size:11px;" onclick="return confirm('Are you sure ?')" href="<?php echo base_url()?>index.php/Sb_periode/delete/<?php echo $periode->periode_id?>">Delete</a></td>
							!-->
							<div class="modal fade" id="myModal<?php echo $periode->periode_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog" style="width: 500px;">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title" id="myModalLabel"><i class="fa fa-calendar"></i> Form Edit Periode</h4>
										</div>

										<div class="modal-body">
											<div class="box-body">
												<form method="post" action="<?php echo base_url()?>index.php/Sb_periode/save">
												<div>
													<label for="start_date">Start Date</label>
													<div>
														<input type="date" name="start_date" value="<?php echo $periode->start_date?>" required />
													</div>
												</div>
												<div>
													<label for="end_date">End Date</label>
													<div>
														<input type="date"  name="end_date" value="<?php echo $periode->end_date?>" required />
													</div>
												</div></br>
												<!--<div>
													<input type="submit" value="Save">
													<input type="reset" value="Reset">
												</div>-->
												</br>
											</div>
										</div>

										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
											<input type="submit" class="btn btn-primary" value="Save" name="save_edit"/>
											<input type="hidden" value="<?php echo $periode->periode_id;?>" name="periode_id"/>
										</div>
									</form>
									</div>
								</div>
							</div>
							<?php $i++;
							} ?>
						</tr>
						<?php if ($i==0){?>
								<tr>
									<td colspan="9"><center>No Rows</center></td>
								</tr>
						<?php } ?>
					</tbody>
				</table>
				</br></br>
				<div id="paginati" style="margin-top:-30px;"><?php echo $this->pagination->create_links();?></div>
			</div>
		</div>
	</div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 500px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Add New Periode</h4>
          </div>

          <div class="modal-body">
            <div class="box-body">
				<form method="post" action="<?php echo base_url()?>index.php/Sb_periode/save">
					<div>
						<label for="start_date">Start Date</label>
						<div>
							<input type="date" name="start_date" value="" required />
						</div>
					</div>
					<div>
						<label for="end_date">End Date</label>
						<div>
							<input type="date"  name="end_date" value="" required />
						</div>
					</div></br>
			</div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <input type="submit" class="btn btn-primary" value="Save"/>
          </div>
		  </form>
        </div>
      </div>
    </div>
</body>
</html>