<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List Users</title>
	<link rel="stylesheet" href="<?php echo base_url()?>template_lala/css/datatables/dataTables.bootstrap.css">
	<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
	<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
	<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
	<!--<script type="text/javascript">
            $(document).ready(function() {
				var table = $('#table-1').DataTable();
			} );
	</script>-->
</head>
	<script>
			$(document).ready(function(){
			
			if(test.innerHTML !=""){
				alert('Username Sudah Ada Silahkan Input Data Kembali..');
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
					window.location.replace("<?php echo base_url()?>index.php/Sb_users/listing");
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
					url: "<?php echo base_url();?>index.php/Sb_users/search",
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
			
			$('.username').on( 'change', function () {
				$("#message").html(" checking...");             
				var username = $(".username").val();
		 
				$.ajax({
					type:"post",
					url:"<?php echo base_url()?>index.php/Sb_users/search_users",
					data:"username="+username,
						success:function(data){
						if(data==0){
							$("#message").html(" Username Bisa Di Gunakan");
						} else {
							$("#message").html("Username Sudah di Gunakan");
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
				<h2 style="font-size:23px;">&nbsp List User</h2>
				&nbsp <a class="btn btn-primary" data-toggle="modal" data-target="#myModal" href=""><i class="fa fa-plus"></i> &nbsp New User</a><div id="test" style="display:none;"><?php echo $this->session->flashdata('users');?></div>
				<div id="notif" style="display:none;"><?php echo $this->session->flashdata('berhasil');?></div>
			</div>
			<form id="formsearch" style="margin-left:700px; margin-top:70px;" method="post" onsubmit="return false">
				<input type="text" id="search" name="search" value="" />
				<select name="jenis" id="jenis">
					<option value="all">All</option>
					<option value="username">Username</option>
					<option value="first_name">First Name</option>
					<option value="last_name">Last Name</option>
				</select>
				<input type="submit" value="Search" />
			</form></br>
		</div>
	<div class="box-body">
	<table class="table table-hover" id="table-1" style="border-bottom:1px solid;border-top:1px solid;">
	<div id="message-loading"></div>
		<thead>
			<tr>
				<th>User Name</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>User Type</th>
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
			<?php foreach($user as $user) { ?>
			<tr>
				<td><?php echo $user->username?></td>
				<td><?php echo $user->first_name?></td>
				<td><?php echo $user->last_name?></td>
				<td><?php echo $user->usertype?></td>
				<td><?php echo $user->create_date?></td>
				<td><?php echo $user->create_by;?></td>
				<td><?php echo $user->modify_date;?></td>
				<td><?php echo $user->modify_by;?></td>
				<td><a class="btn btn-primary btn-small" data-toggle="modal" data-target="#myModal<?php echo $user->username;?>" style="height:27px; font-size:11px;" href="">Edit</a></td>
				<td><a class="btn btn-danger btn-small" style="height:27px; font-size:11px;" onclick="return confirm('Are you sure ?')" href="<?php echo base_url()?>index.php/Sb_users/delete/<?php echo $user->username?>">Delete</a></td>
				
				<div class="modal fade" id="myModal<?php echo $user->username;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog" style="width: 500px;">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Edit User</h4>
					  </div>

					  <div class="modal-body">
						<div class="box-body">
							<form method="post" action="<?php echo base_url()?>index.php/Sb_users/save">
								<div>
									<label for="username">Username</label>
									<div>
										<input type="text" name="username" id="username" value="<?php echo $user->username?>" required >
									</div>
								<div>
									<label for="first_name">First Name</label>
									<div>
										<input type="text" name="first_name" id="first_name" value="<?php echo $user->first_name?>" required >
									</div>
								</div>
								<div>
									<label for="last_name">Last Name</label>
									<div>
										<input type="text" name="last_name" id="last_name" value="<?php echo $user->last_name?>" required >
									</div>
								</div>
								<?php
									if($user->username != ""){
										echo "<input type='hidden' value='$user->username' name='usernames'>";
									}
								?>
							</div>
						</div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-primary" value="Save"/>
					  </div>
					  </form>
					</div>
				  </div>
				</div>
				
				<?php $i++;
				} ?>
			</tr>
		</tbody>
	</table></br></br>
	<div id="paginati" style="margin-top:-30px;"><?php echo $this->pagination->create_links();?></div>
	</div>
	</div>
	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 500px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Add New User</h4>
          </div>

          <div class="modal-body">
            <div class="box-body">
				<form method="post" action="<?php echo base_url()?>index.php/Sb_users/save">
					<div>
						<label for="username">Username</label>
						<div>
							<input type="text" name="username" id="username" class="username" value="" required />
							<div id="message"></div>
						</div>
					</div>
					<div>
						<label for="password">Password</label>
						<div>
							<input type="password" name="password" id="password" value="" required/>
						</div>
					</div>
					<div>
						<label for="first_name">First Name</label>
						<div>
							<input type="text" name="first_name" id="first_name" value="" required />
						</div>
					</div>
					<div>
						<label for="last_name">Last Name</label>
						<div>
							<input type="text" name="last_name" id="last_name" value="" required/>
						</div>
					</div>
					<div>
						<label for="usertype">UserType</label>
						<div>
							<select name="usertype" id="usertype" required>
								<option value="User">User</option>
								<option value="Guest">Guest</option>
								<option value="Exim">Exim</option>
								<option value="Production">Production</option>
								<option value="Inventory">Inventory</option>
							</select>
						</div>
					</div>
				</div>
			</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" value="Save"/>
          </div>
		  </form>
        </div>
      </div>
    </div>
</body>
</html>