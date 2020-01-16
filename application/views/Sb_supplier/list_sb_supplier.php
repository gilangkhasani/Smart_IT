<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List Supplier</title>
	<link rel="stylesheet" href="<?php echo base_url()?>template_lala/css/datatables/dataTables.bootstrap.css">
	<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
	<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
	<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
	<script>
		$(document).ready(function(){
			
			if(test.innerHTML !=""){
				alert('Kode Supplier Sudah Ada Silahkan Input Data Kembali..');
			}
			if(notif.innerHTML !=""){
				alert(notif.innerHTML);
			}
							
			$( "#negara_code, #negara_code1" ).autocomplete({
			  source: "<?php echo base_url()?>index.php/Sb_supplier/get_Sb_supplier"
			});
			
			$( ".negara_code" ).autocomplete( "option", "appendTo", ".form-tes" );
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
					window.location.replace("<?php echo base_url()?>index.php/Sb_supplier/listing");
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
					url: "<?php echo base_url();?>index.php/Sb_supplier/search",
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
			
			$('.supplier_code').on( 'change', function () {
				$("#message").html(" checking...");             
				var supplier_code = $(".supplier_code").val();
		 
				$.ajax({
					type:"post",
					url:"<?php echo base_url()?>index.php/Sb_supplier/search_supplier",
					data:"supplier_code="+supplier_code,
						success:function(data){
						if(data==0){
							$("#message").html(" Kode Supplier Bisa Di Gunakan");
						} else {
							$("#message").html("Kode Supplier Sudah di Gunakan");
						}
					}
				});
			});
		});
		
		function modalEdit(supplier_code, supplier_name, supplier_address, negara_code, npwp, no_izin_tpb){
			$(function(){
				$("#negara_code1").val(negara_code);
				$("#supplier_code1").val(supplier_code);
				$("#supplier_codes").val(supplier_code);
				$("#supplier_name1").val(supplier_name);
				$("#supplier_address1").val(supplier_address);
				$("#npwp1").val(npwp);
				$("#no_izin_tpb1").val(no_izin_tpb);
				
			});
		}
	</script>
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
</head>
<body>	
	<div class="box">
		<div class="box-header">
			<div class="box-title">
				<h2 style="font-size:23px;">&nbsp List Supplier</h2>
				&nbsp <a class="btn btn-primary" data-toggle="modal" data-target="#myModal" href=""><i class="fa fa-plus"></i> &nbsp New Supplier</a>
				<div id="test" style="display:none;"><?php echo $this->session->flashdata('supplier');?></div>
				<div id="notif" style="display:none;"><?php echo $this->session->flashdata('berhasil');?></div>
			</div>
			<form id="formsearch" style="margin-left:700px; margin-top:70px;" method="post" onsubmit="return false">
				<input type="text" id="search" name="search" value="" />
				<select name="jenis" id="jenis">
					<option value="all">All</option>
					<option value="supplier_code">Supplier Code</option>
					<option value="supplier_name">Supplier Name</option>
					<option value="supplier">Supplier Address</option>
					<option value="negara_code">Negara Code</option>
				</select>
				<input type="submit" value="Search" />
			</form></br>
		</div>
	<div class="box-body">
		<table class="table table-hover" id="table-1" style="border-bottom:1px solid;border-top:1px solid;">
		<div id="message-loading"></div>
			<thead>
				<tr>
					<th>Supplier Code</th>
					<th>Supplier Name</th>
					<th>Supplier Address</th>
					<th>Negara Code</th>
					<th>NPWP</th>
					<th>No Izin TPB</th>
					<th>Modify Date</th>
					<th>Modify By</th>
					<th>Edit</th>
					<!--
					<th>Delete</th>
					!-->
				</tr>
			</thead>
			<tbody>
				<?php $i=0;?>
				<?php foreach($supplier as $supplier) { ?>
				<tr>
					<td><?php echo $supplier->supplier_code?></td>
					<td><?php echo $supplier->supplier_name?></td>
					<td><?php echo $supplier->supplier_address?></td>
					<td><?php echo $supplier->negara_code?></td>
					<td><?php echo $supplier->npwp?></td>
					<td><?php echo $supplier->no_izin_tpb?></td>
					<td><?php echo $supplier->modify_date;?></td>
					<td><?php echo $supplier->modify_by;?></td>
					<td><a onclick="modalEdit('<?php echo $supplier->supplier_code?>','<?php echo $supplier->supplier_name?>','<?php echo $supplier->supplier_address?>','<?php echo $supplier->negara_code?>','<?php echo $supplier->npwp?>','<?php echo $supplier->no_izin_tpb?>');" class="btn btn-primary btn-small" style="height:27px; font-size:11px;" data-toggle="modal" data-target="#myModal1" href="">Edit</a></td>
					<!--
					<td><a class="btn btn-danger btn-small" style="height:27px; font-size:11px;" onclick="return confirm('Are you sure ?')" href="<?php echo base_url()?>index.php/Sb_supplier/delete/<?php echo $supplier->supplier_code?>">Delete</a></td>
					!-->
					<?php $i++;
					} ?>
				</tr>
			</tbody>
		</table></br></br>
		<div id="paginati" style="margin-top:-30px;"><?php echo $this->pagination->create_links();?></div>
	</div>
	
	<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog" style="width: 500px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Edit Supplier</h4>
		  </div>

		  <div class="modal-body">
			<div class="box-body">
				<form method="post" class="form-tes" action="<?php echo base_url()?>index.php/Sb_supplier/save">
					<div>
						<label for="supplier_code">Supplier Code</label>
						<div id="isUpdating">
							<input type="text" name="supplier_code" id="supplier_code1" value="" readonly style="background:#eae9e9;" required />
							<input type="hidden" name="supplier_codes" id="supplier_codes" value="" readonly style="background:#eae9e9;" required />
						</div>
					</div>
					<div>
						<label for="supplier_name">Supplier Name</label>
						<div>
							<input type="text" name="supplier_name" id="supplier_name1" value="" required />
						</div>
					</div>
					<div>
						<label for="supplier_address">Supplier Address</label>
						<div>
							<textarea name="supplier_address" id="supplier_address1" cols="30" rows="5" required ></textarea>
						</div>
					</div>
					<div>
						<label for="negara_code">Negara</label>
						<div>
							<input type="text" name="negara_code" id="negara_code1" value="" required readonly style="background:#eae9e9;"/>
						</div>
					</div>
					<div>
						<label for="npwp">NPWP</label>
						<div>
							<input type="text" name="npwp" id="npwp1" value="">
						</div>
					</div>
					<div>
						<label for="no_izin_tpb">No Izin TPB</label>
						<div>
							<input type="text" name="no_izin_tpb" id="no_izin_tpb1" value="">
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
            <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Add New Supplier</h4>
          </div>

          <div class="modal-body">
            <div class="box-body">
				<form method="post" class="form-tes" action="<?php echo base_url()?>index.php/Sb_supplier/save">
					<div>
						<label for="supplier_code">Supplier Code</label>
							<div>
								<input type="text" name="supplier_code" id="supplier_code" value="" class="supplier_code" required />
								<div id="message"></div>
							</div>
					</div>
					<div>
						<label for="supplier_name">Supplier Name</label>
						<div>
							<input type="text" name="supplier_name" id="supplier_name" value="" required />
						</div>
					</div>
					<div>
						<label for="supplier_address">Supplier Address</label>
						<div>
							<textarea name="supplier_address" id="supplier_address" cols="30" rows="5" required /></textarea>
						</div>
					</div>
					<div>
						<label for="negara_code">Negara</label>
						<div>
							<input type="text" name="negara_code" id="negara_code" value="" required />
						</div>
					</div>
					<div>
						<label for="npwp">NPWP</label>
						<div>
							<input type="text" name="npwp" id="npwp" value="">
						</div>
					</div>
					<div>
						<label for="no_izin_tpb">No Izin TPB</label>
						<div>
							<input type="text" name="no_izin_tpb" id="no_izin_tpb" value="">
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