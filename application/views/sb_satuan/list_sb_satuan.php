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
					$("#message-loading").html(' <div class="progress sm progress-striped active"> <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div>'); 
				$.ajax({
					type: "POST", //ganti "POST" untuk request POST
					url: "<?php echo base_url();?>index.php/Sb_satuan/search",
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
		
		function modalEdit(satuan_code, satuan_name){
			$(function(){
				$("#satuan_code1").val(satuan_code);
				$("#satuan_codes").val(satuan_code);
				$("#satuan_name1").val(satuan_name);
				
			});
		}
	</script>
<body>	
	<div class="col-lg-16">
		<div class="box box-info">
			<div class="box-header">
				<div class="box-title">
					<h3>List Satuan</h3>
					<a class="btn btn-primary btn-small" data-toggle="modal" data-target="#myModal" href="" style="font-size:small;"><i class="fa fa-plus"></i> &nbsp New Satuan</a><div id="test" style="display:none;"><?php echo $this->session->flashdata('satuan');?></div>
					<div id="notif" style="display:none;"><?php echo $this->session->flashdata('berhasil');?></div>
				</div>
				<form id="formsearch" style="margin-left:700px; margin-top:70px;" method="post" onsubmit="return false">
					<input type="text" id="search" name="search" value="" />
					<select name="jenis" id="jenis">
						<option value="all">All</option>
						<option value="satuan_code">Satuan Code</option>
						<option value="satuan_name">Satuan Name</option>
					</select>
					<input type="submit" value="Search" />
				</form></br>
			</div>
			<div class="box-body">
				<table class="table table-hover" id="table-1" style="border-bottom:1px solid;border-top:1px solid;">
				<div id="message-loading"></div>
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
						<?php $i=0;?>
						<?php foreach($satuan as $satuan) { ?>
						<tr>
							<td><?php echo $satuan->satuan_code?></td>
							<td><?php echo $satuan->satuan_name?></td>
							<td><?php echo $satuan->create_date;?></td>
							<td><?php echo $satuan->create_by;?></td>
							<td><?php echo $satuan->modify_date;?></td>
							<td><?php echo $satuan->modify_by;?></td>
							<td><a onclick="modalEdit('<?php echo $satuan->satuan_code?>','<?php echo $satuan->satuan_name;?>');" class="btn btn-primary btn-small" style="height:23px; font-size:10px;" data-toggle="modal" data-target="#myModal1">Edit</a></td>
							<td><a class="btn btn-danger btn-small" style="height:23px; font-size:10px;"onclick="return confirm('Are you sure ?')" href="<?php echo base_url()?>index.php/Sb_satuan/delete/<?php echo $satuan->satuan_code?>">Delete</a></td>
							
							<?php $i++;
							} ?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	<div id="paginati" style="margin-top:-30px;"><?php echo $this->pagination->create_links();?></div>
	</div>
	<!-- Modal Add -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 500px; margin-top:120px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-hdd-o"></i> &nbsp Add New Satuan</h4>
          </div>

          <div class="modal-body">
            <div class="box-body">
				<form method="post" class="form-tes" action="<?php echo base_url()?>index.php/Sb_satuan/save">
					<div>
						<label for="satuan_code">Satuan Code</label>
						<div>
							<input type="text" name="satuan_code" id="satuan_code" value="" class="satuan_code" required />
							<div id="message"></div>
						</div>
					</div>
					<div>
						<label for="satuan_name">Satuan Name</label>
						<div>
							<input type="text" name="satuan_name" id="satuan_name" value="" required />
						</div>
					</div>
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
	<!-- Modal -->
	
	<!-- Modal Edit -->
	<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog" style="width: 500px; margin-top:120px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title" id="myModalLabel"><i class="fa fa-hdd-o"></i> &nbsp Edit Satuan</h4>
		  </div>

		  <div class="modal-body">
			<div class="box-body">
				<form method="post" class="form-tes" action="<?php echo base_url()?>index.php/Sb_satuan/save">
					<div>
						<label for="satuan_code">Satuan Code</label>
						<div>
							<input type="text" name="satuan_code" id="satuan_code1" value="" readonly style="background:#eae9e9;" required/>
							<input type="hidden" name="satuan_codes" id="satuan_codes" value="" readonly style="background:#eae9e9;" required/>
						</div>
					</div>
					<div>
						<label for="satuan_name">Satuan Name</label>
						<div id="isUpdating">
							<input type="text" name="satuan_name" id="satuan_name1" value=""/>
						</div>
					</div>
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
	<!-- Modal -->
</body>
</html>