<!doctype html>
<html lang="en">
	<head>
		<title>Form Finish Good</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/ui/themes/smoothness/jquery-ui.css">
		<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
		<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
		<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
		<script type="text/javascript">
			
			function openWinBarangMaterial(url, title, w, h)
			{
				var left = (screen.width/2)-(w/2);
				var top = (screen.height/2)-(h/2);
				return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
				
				//window.open("<?php echo base_url()?>index.php/Sb_export/get_barang", "popup_form", "toolbar=yes, scrollbars=yes, resizable=yes");
			}
			
			function openWinBarangJadi(url, title, w, h)
			{
				var left = (screen.width/2)-(w/2);
				var top = (screen.height/2)-(h/2);
				return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
				//window.open("<?php echo base_url()?>index.php/Sb_export/get_supplier", "popup_form", "toolbar=yes, scrollbars=yes, resizable=yes");
			}

			$(document).ready(function(){
				
				table = $('#table-1').DataTable( {
					"scrollY": "310px",
					"paging": false
				} );
				
				$('#table-1 tbody').on( 'click', 'tr', function () {
					if ( $('#table-1 tbody tr.selected').removeClass('selected') ) {
						$(this).addClass('selected');
					}
				} );
				
				$( "#satuan_doc" ).autocomplete({
					source: "<?php echo base_url()?>index.php/Sb_satuan/get_Sb_satuan"
				});
				
				$('#satuan_doc').on( 'blur', function () {
					if($('#satuan_doc').val() == $('#satuan_code').val()){
						$('#nilai_konversi').val(1);
					} 				
					else {
						$('#nilai_konversi').val('');
					}
				} );
				
				$('#jumlah_doc,#nilai_konversi').on( 'blur', function () {
					if($('#jumlah_doc').val() && $('#nilai_konversi').val()){
						$('#jumlah_barang').val(parseFloat($('#nilai_konversi').val()) * parseFloat($('#jumlah_doc').val()));
					}
				} );
				
				$('#b-add').click(function(){
					
					
						$('#table-1 tbody').append(
						'<tr>'
							+'<td><input type="hidden" name="request_id2[]"  value="'+$('#request_id').val()+'"/> '+$('#request_id').val()+'</td>'
							+'<td><input type="hidden" name="tgl_request2[]" value="'+$('#tgl_request').val()+'"/> '+$('#tgl_request').val()+'</td>'
							+'<td><input type="hidden" name="barang_kode2[]" value="'+$('#barang_codes').val()+'"/> '+$('#barang_codes').val()+'</td>'
							+'<td><input type="hidden" name="barang_name[]" value="'+$('#barang_name').val()+'"/> '+$('#barang_name').val()+'</td>'
							+'<td><input type="hidden" name="jumlah_barang2[]" value="'+$('#jumlah_barang').val()+'"/> '+$('#jumlah_barang').val()+'</td>'
						+'</tr>');
						
						$("#barang_code").val('');
						$("#barang_name").val('');
						$("#jumlah_doc").val('');
					
				});
				
				$('#b-edit').click( function () {	
					if(confirm("Apakah anda akan mengedit ?") == true){
						$("#request_id").val($.trim($('#table-1 tbody .selected').find('td:eq(0)').text()));
						$("#tgl_request").val($('#table-1 tbody .selected').find('td:eq(1)').text());
						$("#barang_code").val($('#table-1 tbody .selected').find('td:eq(2)').text());
						$("#barang_name").val($('#table-1 tbody .selected').find('td:eq(3)').text());
						$("#jumlah_barang").val($('#table-1 tbody .selected').find('td:eq(4)').text());
						
						$('#table-1 tbody .selected').remove();
						$('#b-edit').css('display','none');
						$('#b-selesai').css('display','inline');
					}
				} );
				
				$('#b-delete').click( function () {
					if(confirm("Apakah anda akan menghapus ?") == true){
						$('#table-1 tbody .selected').remove();
					}
				} );
				
				$(".dataTables_filter").css('display','none');
				$(".dataTables_empty").css('display','none');
				$(".dataTables_info").css('display','none');
				$(".dataTables_length").css('display','none');
				$(".dataTables_paginate").css('display','none');
				
				$('#list_request').on( 'change', function () {
					table
						.columns( 0 )
						.search( this.value )
						.draw();
					$('#request_id').val($('#list_request').val());
				} );
			});
			/*
			$(function() {
				$( "#supplier_code" ).autocomplete({
				  source: "<?php echo base_url()?>index.php/Sb_export/get_Sb_supplier"
				});
			});	
			*/	
			
		</script>
	</head>
	<body>	
		<?php
			if(isset($prod)){
				$prod_id = $prod->prod_id;
				$tgl_prod = $prod->tgl_prod;
				$kd_brg = $prod->barang_code;
			} else {
				$prod_id = "";
				$tgl_prod = "";
				$kd_brg = "";
			}
		?>	
		
		<form method="post" action="<?php echo base_url()?>index.php/Sb_inventory/save_wip" class="form-horizontal" name="form1" id="form1">
			<div class="row">
			<div class="col-lg-12">
					<div class="box box-info">
						<div class="box-header">
							<h3 class="box-title">
								Production Request
							</h3>
						</div>
						<div class="box-body">
							<table>
									<input type="hidden" name="request_id" id="request_id" value="">
								<?php if ($prod_id != ""){?>
								<tr>
									<td><label for="no_bukti">List Request</label></td>
									<td> &nbsp : &nbsp 
										<select name="list_request" id="list_request">
											<option value="">-- All Request --</option>
											<?php foreach ($prod_request_dt as $request) { ?>
												<option value="<?php echo $request->request_id?>"><?php echo $request->request_id;?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
								<?php } ?>
								<?php if ($prod_id == ""){?>
								<tr>
									<td></td>
									<td> &nbsp  &nbsp </td>
								</tr>
								<tr>
									<td></td>
									<td> &nbsp  &nbsp </td>
								</tr>
								<tr>
									<td></td>
									<td> &nbsp  &nbsp </td>
								</tr>
								<?php } ?>
							</table>
						</div>
					</div>
			</div>
			</div>
			<div>
				<label for="status"></label>
				<div>
				</div>
			</div>
			<div class="col-lg-16" style="margin-top:-20px;">
				<div class="box box-info">
					<div class="box-header">
						<label class="box-title" for="">Detail Barang</label>
					</div>
					<div class="box-body" style="margin-top:-20px;">
						<input type="text" name="barang_code" id="barang_code" value="" placeholder="kode barang" size="15" />
						<input type="text" name="barang_name" id="barang_name" value="" placeholder="nama barang"  />
						<input type="text" name="jumlah_barang" id="jumlah_barang" value="" placeholder="jumlah" size="10">
						<a href="javascript:0">
							<input type="button" value="edit" class="btn btn-primary btn-small" style="height:27px; font-size:11px;" id="b-edit"/>
						</a>
						<input type="submit" id="b-selesai" name="selesai" value="selesai" class="btn btn-primary btn-small" style="height:27px; font-size:11px; display:none;"  />
					</div>
				</div>
			</div>
			<div>
				<table id="table-1" class="display" frame="box">
					<thead>
					<tr>
						<td>Kode Request</td>
						<td>Tanggal Request</td>
						<td>Kode Barang</td>
						<td>Nama Barang</td>
						<td>Jumlah</td>
					</tr>
					</thead>
					<?php if ($prod_id != "") { ?>
					<tbody>
					
						<?php foreach($prod_request_dt as $prod_request_dt){ ?>
						<tr>
							<td><?php echo $prod_request_dt->request_id?>
							<input  type="hidden" name="request_id2[]" value="<?php echo $prod_request_dt->request_id?>">
							</td>
							<td><?php echo $prod_request_dt->tgl_request?></td>
							<input type="hidden" name="tgl_request2[]" value="<?php echo $prod_request_dt->tgl_request?>">
							<td><?php echo $prod_request_dt->barang_kode?></td>
							<input type="hidden" name="barang_kode2[]" value="<?php echo $prod_request_dt->barang_kode?>">
							<td><?php echo $prod_request_dt->barang_name?></td>
							<td><?php echo $prod_request_dt->jumlah_on_production?></td>
							<input type="hidden" name="jumlah_barang2[]" value="<?php echo $prod_request_dt->jumlah_on_production?>">
						<?php } ?>
						</tr>
					</tbody>
					<?php } else {?>
						<tbody>
					
						</tbody>
					<?php }?>
				</table>
			</div>
			<a href="<?php echo base_url()?>index.php/blog">Back to Menu</a>
			<?php
				if($prod_id != ""){
					echo "<input type='hidden' value='$prod_id' name='prod_ids'>";
				}
			?>
		</form>
	</body>
</html>	