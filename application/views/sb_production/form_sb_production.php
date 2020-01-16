<!doctype html>
<html lang="en">
	<head>
		<title>Form Export</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/ui/themes/smoothness/jquery-ui.css">
		<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
		<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
		<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
		<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
		<script src="<?php echo base_url()?>template_lala/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
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
			
			/*$(function() {
				$('#tgl_request').datepicker();
			});*/

			$(document).ready(function(){
				$('#tgl_request').datepicker();
				
				$("#tgl_request").inputmask("yyyy-mm-dd");
				
				//Money Euro
				$("[data-mask]").inputmask();
				
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
				
				$('#b-add').click(function(){
					
					if($("#request_id").val() == ''){
						alert('request_id Request masih kosong');
						$("#barang_code").focus();
					} else if ($("#tgl_request").val() == ''){
						alert('Tanggal Request masih kosong');
						$("#tgl_request").focus();
					} else if ($("#barang_code").val() == ''){
						alert('Kode Barang masih kosong');
						$("#barang_code").focus();
					} else if($("#barang_name").val() == ''){
						alert('Nama Barang masih kosong');
						$("#barang_name").focus();
					} else if($("#jumlah_barang").val() == ''){
						alert('Jumlah masih kosong');
						$("#jumlah_barang").focus();
					} else {
						$('#table-1 tbody').append(
						'<tr>'
							+'<td><input type="hidden" name="request_id2[]"  value="'+$('#request_id').val()+'"/> '+$('#request_id').val()+'</td>'
							+'<td><input type="hidden" name="tgl_request2[]" value="'+$('#tgl_request').val()+'"/> '+$('#tgl_request').val()+'</td>'
							+'<td><input type="hidden" name="barang_kode2[]" value="'+$('#barang_code').val()+'"/> '+$('#barang_codes').val()+'</td>'
							+'<td><input type="hidden" name="barang_name[]" value="'+$('#barang_name').val()+'"/> '+$('#barang_name').val()+'</td>'
							+'<td><input type="hidden" name="jumlah_barang2[]" value="'+$('#jumlah_barang').val()+'"/> '+$('#jumlah_barang').val()+'</td>'
						+'</tr>');
						
						$("#barang_code").val('');
						$("#barang_name").val('');
						$("#jumlah_barang").val('');
					}
				});
				
				$('#b-edit').click( function () {	
					if(confirm("Apakah anda akan mengedit ?") == true){
						$("#request_id").val($.trim($('#table-1 tbody .selected').find('td:eq(0)').text()));
						$("#tgl_request").val($.trim($('#table-1 tbody .selected').find('td:eq(1)').text()));
						$("#barang_code").val($.trim($('#table-1 tbody .selected').find('td:eq(2)').text()));
						$("#barang_name").val($.trim($('#table-1 tbody .selected').find('td:eq(3)').text()));
						$("#jumlah_barang").val($.trim($('#table-1 tbody .selected').find('td:eq(4)').text()));
						
						$('#table-1 tbody .selected').remove();
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
				
				$('#request_id').on( 'change', function () {
					$("#message").html(" checking...");             
					var request_id = $("#request_id").val();
			 
					$.ajax({
						type:"post",
						url:"<?php echo base_url()?>index.php/Sb_production/search_request_id",
						data:"request_id="+request_id,
							success:function(data){
							if(data==0){
								$("#message").html("Kode Request Bisa Di Gunakan");
							} else {
								$("#message").html("Kode Request Sudah di Gunakan");
							}
						}
					});
				} );
				
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
				
				
			});	
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
			
			if(isset($count_request)){
				$jumlah = $count_request->jumlah;
			}
		?>	
		
		<form method="post" action="<?php echo base_url()?>index.php/Sb_production/save" class="form-horizontal" name="form1" id="form1">
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
									<input type="hidden" name="prod_id" id="prod_id" value="<?php echo $prod_id?>"/>
									<!--<td id="message1"></td>-->
									<input type="hidden" name="tgl_prod" id="tgl_prod" value="<?php echo $tgl_prod?>"/>
								<tr>
									<td><label for="barang_code">Barang jadi</label></td>
									<td> &nbsp : &nbsp <input type="text" name="barang_codes" id="barang_codes" value="<?php echo $kd_brg?>"
									<?php if ($prod_id != ""){?>
									readonly style="background:#eae9e9;"
									
									<?php } ?> />
									<?php if ($prod_id == ""){?>
									<td>
										<input type="button" value="Search" class="btn btn-primary btn-small" style="height:27px; font-size:11px;" onclick="openWinBarangJadi('<?php echo base_url()?>index.php/Sb_production/get_barang_jadi','popupBarang','600','550')"/>
									</td>
									<?php } ?>
									</td>
								</tr>
								<?php if($prod_id == ""){?>
									<tr>
										<td></td>
										<td> &nbsp &nbsp &nbsp 
											<input type="submit" value="Save" name="save_prod" class="btn btn-primary btn-small" style="height:27px; font-size:11px;"/>
										</td>
									</tr>
								<?php } ?>
								<tr>
									<td><label for="no_bukti">No Request</label></td>
									<td> &nbsp : &nbsp <input type="text" name="request_id" id="request_id" value=""></td>
									<!--
									<?php if ($prod_id != "" && $jumlah != 0){?>
										<td> &nbsp &nbsp 
										<input type="submit" class="btn btn-primary btn-small" style="height:27px; font-size:11px;" name="finish_request" id="finish_request" value="Finish">
										</td>
									<?php } ?>
									!-->
									<td id="message"></td>
								</tr>
								<tr>
									<td><label for="tgl_bukti">Tanggal Request</label></td>
									<td> &nbsp : &nbsp <input type="text" name="tgl_request" id="tgl_request" data-inputmask="'alias':'yyyy-mm-dd'" data-mask value=""></td>
								</tr>
								<!--
								<?php if ($prod_id != "" && $jumlah !=0 ){?>
								<tr>
									<td><label for="no_bukti">List Request</label></td>
									<td> &nbsp : &nbsp 
										<select name="list_request" id="list_request">
											<option value="">-- Choose Request --</option>
											<?php foreach ($prod_request_id as $request) { ?>
												<option value="<?php echo $request->request_id?>"><?php echo $request->request_id;?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
								<?php } ?>
								!-->
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
						<!--<a href="javascript:0">!-->
							<input type="button" value="Search" class="btn btn-primary btn-small" style="height:27px; font-size:11px;" onclick="openWinBarangJadi('<?php echo base_url()?>index.php/Sb_production/get_barang_material','popupBarang','600','550')"/>
						<!--</a>!-->
						<input type="text" name="barang_name" id="barang_name" value="" placeholder="nama barang"  />
						<input type="text" name="jumlah_barang" id="jumlah_barang" value="" placeholder="jumlah" size="10">
						<a href="javascript:0">
							<input type="button" value="add" class="btn btn-primary btn-small" style="height:27px; font-size:11px;" id="b-add"/>
						</a>
						<a href="javascript:0">
							<input type="button" value="edit" class="btn btn-primary btn-small" style="height:27px; font-size:11px;" id="b-edit"/>
						</a>
						<a href="javascript:0">
							<input type="button" value="delete" class="btn btn-primary btn-small" style="height:27px; font-size:11px;" id="b-delete"/>
						</a>
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
							<td><?php echo $prod_request_dt->jumlah_barang?></td>
							<input type="hidden" name="jumlah_barang2[]" value="<?php echo $prod_request_dt->jumlah_barang?>">
							
						<?php } ?>
						</tr>
					</tbody>
					<?php } else {?>
						<tbody>
					
						</tbody>
					<?php }?>
				</table>
			</div>
			<div>
				<input type="submit" name="submit" value="Save" class="btn btn-primary btn-small">
				<input type="reset" value="Reset" class="btn btn-primary btn-small">
			</div>
			<?php
				if($prod_id != ""){
					echo "<input type='hidden' value='$prod_id' name='prod_ids'>";
				}
			?>
		</form>
	</body>
</html>	