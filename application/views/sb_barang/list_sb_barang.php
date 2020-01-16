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
		$( "#satuan_code, #satuan_code1" ).autocomplete({
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
			
			if(test.innerHTML !=""){
				alert('Kode Barang Sudah Ada Silahkan Input Data Kembali..');
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
					window.location.replace("<?php echo base_url()?>index.php/Sb_barang/listing/<?php echo $this->uri->segment(3);?>");
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
						url: "<?php echo base_url();?>index.php/Sb_barang/searchactive/<?php echo $this->uri->segment(3)?>",
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
			
			$('.barang_code').on( 'change', function () {
				$("#message").html(" checking...");             
				var barang_code = $(".barang_code").val();
		 
				$.ajax({
					type:"post",
					url:"<?php echo base_url()?>index.php/Sb_barang/search_barang",
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
			
		$(".ui-helper-hidden-accessible").css('display','none');
		});
		function modalEdit(barang_code,barang_name,satuan_code,hs_code){
			$(function(){
				$("#barang_code1").val(barang_code);
				$("#barang_codes").val(barang_code);
				$("#barang_name1").val(barang_name);
				$("#satuan_code1").val(satuan_code);
				$("#hs_code1").val(hs_code);
				
			});
		}
	</script>
<?php
	$today = date('Y-m-d');
	$today=date('Y-m-d', strtotime($today)).'<br/>';;
		
	$from = date('Y-m-d', strtotime("01/01/".date("Y")));
	$to = date('Y-m-d', strtotime("05/01/".date("Y")));
			
	$from1 = date('Y-m-d', strtotime("05/01/".date("Y")));
	$to1 = date('Y-m-d', strtotime("09/01/".date("Y")));
			
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
	<?php
		$barang_category = str_replace('_',' ',$this->uri->segment(3));
		
		if($barang_category == 'Mesin Sparepart'){
			$barang_category = 'Mesin/Sparepart';
		} else {
			$barang_category;
		}
	?>
	<div class="col-lg-16">
		<div class="box box-info">
			<div class="box-header">
				<div class="box-title">
				<h2 style="font-size:23px;">List Of <?php echo $barang_category?> Active</h2>
				<a class="btn btn-primary" data-toggle="modal" data-target="#myModal" href=""><i class="fa fa-plus"></i> &nbsp New Barang</a><div id="test" style="display:none;"><?php echo $this->session->flashdata('barang');?></div>
				<div id="notif" style="display:none;"><?php echo $this->session->flashdata('berhasil');?></div>
				<a class="btn btn-default" href="<?php echo base_url()?>index.php/Sb_barang/listing_void/<?php echo $this->uri->segment(3)?>"> &nbsp Barang Void</a><br/>
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
							<th>Nama Barang</th>
							<th>Satuan</th>
							<th>Kode HS</th>
							<th>Saldo Barang</th>
							<th>Void</th>
							<th>Edit</th>
							<!--
							<th>Delete</th>
							!-->
						</tr>
					</thead>		
					<tbody>
						<?php $i=0;?>
						<?php foreach($barang as $barang) { ?>
						<tr>
							<td><?php echo $barang->barang_code?></td>
							<td><?php echo $barang->barang_name?></td>
							<td><?php echo $barang->satuan_code?></td>
							<td><?php echo $barang->hs_code;?></td>
							<td><?php echo $barang->saldo_akhir;?></td>
							<td><a class="btn btn-success btn-small" style="height:27px; font-size:11px;" href="<?php echo base_url()?>index.php/Sb_barang/updateVoid/<?php echo $barang->barang_code?>/<?php echo $this->uri->segment(3);?>">Void</a></td>
							
							<td><a onclick="modalEdit('<?php echo $barang->barang_code?>','<?php echo $barang->barang_name?>','<?php echo $barang->satuan_code?>','<?php echo $barang->hs_code?>');" class="btn btn-primary btn-small" data-toggle="modal" data-target="#myModal1" style="height:27px; font-size:11px;" href="">Edit</a></td>
							<!--
							<td><a class="btn btn-danger btn-small" style="height:27px; font-size:11px;" onclick="return confirm('Are you sure ?')" href="<?php echo base_url()?>index.php/Sb_barang/delete/<?php echo $barang->barang_code?>/<?php echo $this->uri->segment(3);?>">Delete</a></td>
							!-->
							
							<?php $i++;?>
							<?php } ?>
						</tr>
						<?php if ($i==0){?>
							<tr>
								<td colspan="8"><center>No Rows</center></td>
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
            <h4 class="modal-title" id="myModalLabel">Tambah Data Barang</h4>
          </div>

          <div class="modal-body">
            <div class="box-body">
				<form method="post" class="form-tes" action="<?php echo base_url()?>index.php/Sb_barang/save">
					<div>
						<label for="barang_code">Kode Barang</label>
						<div>
							<input type="text" name="barang_code" id="barang_code" value="" class="barang_code" required />
							<div id="message"></div>
						</div>
					</div>
					<div>
						<label for="barang_name">Nama Barang</label>
						<div>
							<input type="text" name="barang_name" id="barang_name" value="" required />
						</div>
					</div>
					<div>
						<label for="hs_code">Kode HS</label>
						<div>
							<input type="text" name="hs_code" id="hs_code" value="" />
						</div>
					</div>
					<div>
						<label for="satuan_code">Satuan Barang</label>
						<div>
							<input type="text" name="satuan_code" id="satuan_code" value="" required />
						</div>
					</div>
					
						<?php
							$str = str_replace("_", " ", $this->uri->segment(3));
							if($str == 'Mesin Sparepart'){
								$str = 'Mesin/Sparepart';
							} else {
								$str;
							}
						?>
							<input type="hidden" name="barang_category" id="barang_category" value="<?php echo $str; ?>" readonly style="background:#eae9e9;">
						
					<div>
						<label for="saldo_awal">Saldo Awal</label>
						<div>
							<input type="text" name="saldo_awal" id="saldo_awal" value="" />
						</div>
					</div>
						<input type="hidden" name="periode_id" id="periode_id" value="<?php echo $periode;?>" readonly style="background:#eae9e9;">
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
	
	<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog" style="width: 500px;">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title" id="myModalLabel">Edit Data Barang</h4>
		  </div>

		  <div class="modal-body">
			<div class="box-body">
				<form method="post" class="form-tes" action="<?php echo base_url()?>index.php/Sb_barang/save">
					<div>
						<label for="barang_code">Kode Barang</label>
						<div>
							<input type="text" name="barang_code" id="barang_code1" value="" readonly style="background:#eae9e9;" required />
						</div>
					</div>
					<div>
						<label for="barang_name">Nama Barang</label>
						<div>
							<input type="text" name="barang_name" id="barang_name1" value="" required />
						</div>
					</div>
					<div>
						<label for="hs_code">Kode HS</label>
						<div>
							<input type="text" name="hs_code" id="hs_code1" value="" />
						</div>
					</div>
					<div>
						<label for="satuan_code">Satuan Barang</label>
						<div id="isUpdating">
							<input type="text" name="satuan_code" id="satuan_code1" value="" required />
						</div>
					</div>
						<?php
							$str = str_replace("_", " ", $this->uri->segment(3));
							if($str == 'Mesin Sparepart'){
								$str = 'Mesin/Sparepart';
							} else {
								$str;
							}
						?>
					<input type="hidden" name="barang_category" id="barang_category" value="<?php echo $str; ?>" readonly style="background:#eae9e9;">		
					<input type='hidden' value='' name='barang_codes' id="barang_codes">
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