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
<script type="text/javascript">
	$(document).ready(function() {
		
		
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
					window.location.replace("<?php echo base_url()?>index.php/Sb_barang/listing_void/<?php echo $this->uri->segment(3);?>");
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
					url: "<?php echo base_url();?>index.php/Sb_barang/searchVoid/<?php echo $this->uri->segment(3)?>",
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
	*/
	});
</script>
<body>
	<?php
		$barang_category = str_replace('_',' ',$this->uri->segment(3));
		
		if($barang_category == 'Mesin Sparepart'){
			$barang_category = 'Mesin/Sparepart';
		} else {
			$barang_category;
		}
		
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
	<div class="col-lg-16">
		<div class="box box-info">
			<div class="box-header">
				<div class="box-title">
				<h3 style="font-size:23px;">List Of <?php echo $barang_category?> Void</h3>
				<!--<a class="btn btn-primary" data-toggle="modal" data-target="#myModal" href=""><i class="fa fa-plus"></i> &nbsp New Barang</a><div id="test" style="display:none;"><?php echo $this->session->flashdata('barang');?></div>--!>
				<a class="btn btn-default" href="<?php echo base_url()?>index.php/Sb_barang/listing/<?php echo $this->uri->segment(3)?>"> &nbsp Barang Active</a><br/>
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
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Kode Satuan</th>
							<th>Kode Hs</th>
							<th>Saldo</th>
							<th>Active</th>
							<!--
							<th>Edit</th>
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
							
							<td><a class="btn btn-success btn-small" style="height:27px; font-size:11px;" href="<?php echo base_url()?>index.php/Sb_barang/updateActive/<?php echo $barang->barang_code?>/<?php echo $this->uri->segment(3);?>">Active</a></td>
							<!--
							<td><a onclick="modalEdit('<?php echo $barang->barang_code?>','<?php echo $barang->barang_name?>','<?php echo $barang->satuan_code?>','<?php echo $barang->hs_code?>');" class="btn btn-primary btn-small" data-toggle="modal" data-target="#myModal1" style="height:27px; font-size:11px;" href="">Edit</a></td>
							
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
				<form method="post" action="<?php echo base_url()?>index.php/Sb_barang/save">
					<div>
						<label for="barang_code">Kode Barang</label>
						<div>
							<input type="text" name="barang_code" id="barang_code" value="" required>
						</div>
					</div>
					<div>
						<label for="barang_name">Nama Barang</label>
						<div>
							<input type="text" name="barang_name" id="barang_name" value="">
						</div>
					</div>
					<div>
						<label for="hs_code">Kode HS</label>
						<div>
							<input type="text" name="hs_code" id="hs_code" value="">
						</div>
					</div>
					<div>
						<label for="satuan_code">Satuan Barang</label>
						<div>
							<input type="text" name="satuan_code" id="satuan_code" value="" required>
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
					<input type="hidden" name="barang_category" id="barang_category" value="<?php echo $str; ?>" readonly>
					<div>
						<label for="saldo_awal">Saldo Awal</label>
						<div>
							<input type="text" name="saldo_awal" id="saldo_awal" value="">
						</div>
					</div>
					<input type="hidden" name="periode_id" id="periode_id" value="<?php echo $periode?>" readonly>
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