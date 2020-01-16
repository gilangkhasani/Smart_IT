<!doctype html>
<html lang="en">
	<head>
		<title>Form Scrap</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/ui/themes/smoothness/jquery-ui.css">
		<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
		<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
		<script src="<?php echo base_url()?>template_lala/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
		<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
		<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
		<script type="text/javascript">
			
			function openWinBarangMaterial(url, title, w, h)
			{
				var left = (screen.width/2)-(w/2);
				var top = (screen.height/2)-(h/2);
				return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
				
				//window.open("<?php echo base_url()?>index.php/Sb_export/get_barang", "popup_form", "toolbar=yes, scrollbars=yes, resizable=yes");
			}
			
			function openWinScrap(url, title, w, h)
			{
				var left = (screen.width/2)-(w/2);
				var top = (screen.height/2)-(h/2);
				return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
				//window.open("<?php echo base_url()?>index.php/Sb_export/get_supplier", "popup_form", "toolbar=yes, scrollbars=yes, resizable=yes");
			}

			$(document).ready(function(){
			
				$('#tgl_penerimaan').datepicker();
				
				$("#tgl_penerimaan").inputmask("yyyy-mm-dd");
				
				//Money Euro
				$("[data-mask]").inputmask();
				
				table = $('#table-1').DataTable();
				
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
					
					if($("#request_id").val() == ''){
						alert('Kode Request masih kosong');
					} else if ($("#tgl_request").val() == ''){
						alert('Tanggal Request masih kosong');
					} else if ($("#barang_code").val() == ''){
						alert('Kode Barang masih kosong');
					} else if($("#barang_name").val() == ''){
						alert('Nama Barang masih kosong');
					} else if($("#jumlah_barang").val() == ''){
						alert('Jumlah masih kosong');
					} else {
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
					}
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
		
		<form method="post" action="<?php echo base_url()?>index.php/Sb_inventory/save_scrap" class="form-horizontal" name="form1" id="form1">
			<div class="row">
			<div class="col-lg-12">
					<div class="box box-info">
						<div class="box-header">
							<h3 class="box-title">
								Scrap
							</h3>
						</div>
						<div class="box-body">
							<table>
								<tr>
									<td>Kode Produksi / Kode Barang</td>
									<td> &nbsp : &nbsp <input type="text" name="prod_id" id="prod_id" style="width:175px; background:#eae9e9;" value="<?php echo $prod_id?>" 
									<?php if ($prod_id != ""){?>
									readonly 
									<?php } ?>/></td>
									<td> &nbsp &nbsp <input type="text" name="barang_codes" id="barang_codes" style="width:175px; background:#eae9e9;" value="<?php echo $kd_brg?>"
									<?php if ($prod_id != ""){?>
									readonly 
									<?php } ?> />
									</td>
								</tr>
								<tr>
									<td>Nomor / Tgl. Penerimaan</td>
									<td> &nbsp : &nbsp <input type="text" name="no_penerimaan" id="no_penerimaan" style="width:175px;" value=""/></td>
									<td> &nbsp &nbsp <input type="text" name="tgl_penerimaan" id="tgl_penerimaan"  data-inputmask="'alias':'yyyy-mm-dd'" data-mask style="width:175px;" value=""/></td>
								</tr>
								<tr>
									<td>Jenis Scrap</td>
									<td> &nbsp : &nbsp <input type="hidden" name="barang_codess" id="barang_codess" style="width:175px;" value=""/>
									<input type="text" name="barang_namess" id="barang_namess" style="width:175px;" value=""/>
									</td>
									<td> &nbsp &nbsp <input type="button" value="Search" class="btn btn-primary btn-small" style="height:27px; width:75px; font-size:11px;" onclick="openWinScrap('<?php echo base_url()?>index.php/Sb_inventory/get_scrap','popupBarang','600','500')"/>
									</td>
								</tr>
								<tr>
									<td>Jumlah Barang</td>
									<td>&nbsp : &nbsp <input type="text" name="jumlah" id="jumlah" style="width:175px;" value=""/></td>
								</tr>
								<tr>
									<td></td>
									<td> &nbsp &nbsp &nbsp
										<input type="submit" value="Save" name="save_prod" class="btn btn-primary btn-small" style="height:27px; width:75px; font-size:11px;"/>
									</td>
								</tr>
								<input type="hidden" name="request_id" id="request_id" value="">
							</table>
						</div>
					</div>
			</div>
			</div>
			<div>
				<label for="status">
				<div>
				</div>
			</div>
			<div>
				<table id="table-1" class="table table-hover" border="1px solid black" frame="box">
					<thead>
					<tr>
						<td>No Penerimaan</td>
						<td>Tanggal Penerimaan</td>
						<td>Kode Barang</td>
						<td>Jumlah</td>
					</tr>
					</thead>
					<?php if ($prod_id != "") { ?>
					<tbody>
						<?php foreach($prod_request_dt as $prod_request_dt){ ?>
						<tr>
							<td><?php echo $prod_request_dt->no_penerimaan?></td>
							<td><?php echo $prod_request_dt->tgl_penerimaan?></td>
							<td><?php echo $prod_request_dt->barang_code?></td>
							<td><?php echo $prod_request_dt->jumlah?></td>
						<?php } ?>
						</tr>
					</tbody>
					<?php } else {?>
						<tbody>
					
						</tbody>
					<?php }?>
				</table>
			</div>
			<a href="<?php echo base_url()?>index.php/Sb_inventory/listing_scrap">Back to Menu</a>
			<!--<a href="<?php echo base_url()?>index.php/blog">Back to Menu</a>!-->
			<?php
				if($prod_id != ""){
					echo "<input type='hidden' value='$prod_id' name='prod_ids'>";
				}
			?>
		</form>
	</body>
</html>	