<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List Negara</title>
	<script>
			$(document).ready(function(){
			
			if(test.innerHTML !=""){
				alert('Kode Negara Sudah Ada Silahkan Input Data Kembali..');
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
					window.location.replace("<?php echo base_url()?>index.php/Sb_negara/listing");
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
					url: "<?php echo base_url();?>index.php/Sb_negara/search",
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
			
			$('.negara_code').on( 'change', function () {
				$("#message").html(" checking...");             
				var negara_code = $(".negara_code").val();
		 
				$.ajax({
					type:"post",
					url:"<?php echo base_url()?>index.php/Sb_negara/search_negara",
					data:"negara_code="+negara_code,
						success:function(data){
						if(data==0){
							$("#message").html(" Kode Negara Bisa Di Gunakan");
						} else {
							$("#message").html("Kode Negara Sudah di Gunakan");
						}
					}
				});
			} );
			
		});
		
		function modalEdit(negara_code,negara_name){
			$(function(){
				$("#negara_code1").val(negara_code);
				$("#negara_codes").val(negara_code);
				$("#negara_name1").val(negara_name);
				
			});
		}
	</script>
</head>
<body>
	<div class="col-lg-16">
	<div class="box box-info">
		<div class="box-header">
			<div class="box-title">
				<h2 style="font-size:23px;">&nbsp List Negara</h2>
				&nbsp <a class="btn btn-primary" data-toggle="modal" data-target="#myModal" href=""><i class="fa fa-plus"></i> &nbsp New Negara</a><div id="test" style="display:none;"><?php echo $this->session->flashdata('negara');?></div>
				<div id="notif" style="display:none;"><?php echo $this->session->flashdata('berhasil');?></div>
			</div>
			<form id="formsearch" style="margin-left:700px; margin-top:70px;" method="post" onsubmit="return false">
				<input type="text" id="search" name="search" value="" />
				<select name="jenis" id="jenis">
					<option value="all">All</option>
					<option value="negara_code">Negara Code</option>
					<option value="negara_name">Negara Name</option>
				</select>
				<input type="submit" value="Search" />
			</form></br>
		</div>
	<div class="box-body">
	<table class="table table-hover" id="table-1" style="border-bottom:1px solid;border-top:1px solid;">
	<div id="message-loading"></div>
		<thead>
			<tr>
				<th>Negara Code</th>
				<th>Negara Name</th>
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
			<?php foreach($negara as $negara) { ?>
			<tr>
				<td><?php echo $negara->negara_code?></td>
				<td><?php echo $negara->negara_name?></td>
				<td><?php echo $negara->create_date;?></td>
				<td><?php echo $negara->create_by;?></td>
				<td><?php echo $negara->modify_date;?></td>
				<td><?php echo $negara->modify_by;?></td>
				
				<td><a onclick="modalEdit('<?php echo $negara->negara_code?>','<?php echo $negara->negara_name;?>');" class="btn btn-primary btn-small" style="height:23px; font-size:10px;" data-toggle="modal" data-target="#myModal1" href="">Edit</a></td>
				
				<td><a class="btn btn-danger btn-small" style="height:23px; font-size:10px;" onclick="return confirm('Are you sure ?')" href="<?php echo base_url()?>index.php/Sb_negara/delete/<?php echo $negara->negara_code?>">Delete</a></td>
				<?php $i++; 
			} ?>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
	<div id="paginati" style="margin-top:-30px;"><?php echo $this->pagination->create_links();?></div>
	</div>
	<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog" style="width: 500px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title" id="myModalLabel">Edit Negara</h4>
		  </div>

		  <div class="modal-body">
			<div class="box-body">
				<form method="post" class="form-tes" action="<?php echo base_url()?>index.php/Sb_negara/save">
					<div>
						<label for="negara_code">Negara Code</label>
						<div>
							<input type="text" name="negara_code" id="negara_code1" value="" readonly style="background:#eae9e9;" required />
							<input type="hidden" name="negara_codes" id="negara_codes" value="" readonly style="background:#eae9e9;" required />
						</div>
					</div>
					<div>
						<label for="negara_name">Negara Name</label>
						<div id="isUpdating">
							<input type="text" name="negara_name" id="negara_name1" value="" required />
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
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 500px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Add New Negara</h4>
          </div>

          <div class="modal-body">
            <div class="box-body">
				<form method="post" class="form-tes" action="<?php echo base_url()?>index.php/Sb_negara/save">
					<div>
						<label for="negara_code">Negara Code</label>
						<div>
							<input type="text" name="negara_code" id="negara_code" value="" class="negara_code" required />
							<div id="message"></div>
						</div>
					</div>
					<div>
						<label for="negara_name">Negara Name</label>
						<div>
							<input type="text" name="negara_name" id="negara_name" value="" required />
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
</body>
</html>