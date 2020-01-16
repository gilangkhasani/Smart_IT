<!doctype html>
<html lang="en">
	<head>
		<title>Form Import</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/ui/themes/smoothness/jquery-ui.css">
		<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
		<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
		<script src="<?php echo base_url()?>template_lala/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
		<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
		<script src="<?php echo base_url()?>template_lala/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
		<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
		<?php
			if(isset($import_hd)){
				$doc_id = $import_hd->doc_id;
				$jenis_doc = $import_hd->jenis_doc;
				$no_doc = $import_hd->no_doc;
				$tgl_doc = substr($import_hd->tgl_doc, 0, 10);
				$no_bukti = $import_hd->no_bukti;
				$tgl_bukti = $import_hd->tgl_bukti;
				$supplier_code = $import_hd->supplier_code;
				$valas = $import_hd->valas;
				$status = $import_hd->status;
			} else {
				$doc_id = "";
				$jenis_doc = "";
				$no_doc = "";
				$tgl_doc = "";
				$no_bukti = "";
				$tgl_bukti = "";
				$supplier_code = "";
				$valas = "";
				$status = "";
			}
			
			if(isset($supplier)){
				$supllier_name = $supplier->supplier_name;
				$supplier_address = $supplier->supplier_address;
			} else {
				$supplier_address = '';
				$supllier_name = '';
			}
		?>	
		<script type="text/javascript">
			
			function openWin(url, title, w, h)
			{
				var left = (screen.width/2)-(w/2);
				var top = (screen.height/2)-(h/2);
				return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
				
				//window.open("<?php echo base_url()?>index.php/Sb_import/get_barang", "popup_form", "toolbar=yes, scrollbars=yes, resizable=yes");
			}
			
			function openWinSupplier(url, title, w, h)
			{
				var left = (screen.width/2)-(w/2);
				var top = (screen.height/2)-(h/2);
				return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
				//window.open("<?php echo base_url()?>index.php/Sb_import/get_supplier", "popup_form", "toolbar=yes, scrollbars=yes, resizable=yes");
			}

			$(document).ready(function(){
				
				$('#tgl_doc').datepicker();
				
				$("#tgl_doc").inputmask("yyyy-mm-dd");
				
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
				
				var tbody = $("#table-1 tbody");

				$("#form1").submit(function(){
					if (tbody.children().length == 0) {
						alert('Detail Barang Masih Kosong');
						return false;
					}
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
					
					if ($("#barang_code").val() == ''){
						alert('Kode Barang masih kosong');
						$("#barang_code").focus();
					} else if($("#barang_name").val() == ''){
						alert('Nama Barang masih kosong');
						$("#barang_name").focus();
					} else if($("#satuan_code").val() == ''){
						alert('Kode satuan masih kosong');
						$("#satuan_code").focus();
					} else if($("#satuan_doc").val() == ''){
						alert('Dokumen Satuan masih kosong');
						$("#satuan_doc").focus();
					} else if($("#jumlah_doc").val() == ''){
						alert('Jumlah Dokumen masih kosong');
						$("#jumlah_doc").focus();
					} else if($("#nilai_konversi").val() == ''){
						alert('Nilai Konversi masih kosong');
						$("#Nilai").focus();
					} else if($("#jumlah_barang").val() == ''){
						alert('Jumlah Barang masih kosong');
						$("#jumlah_barang").focus();
					} else if($("#nilai_barang").val() == ''){
						alert('Nilai Barang masih kosong');
						$("#nilai_barang").focus();
					} else {
							$('#table-1 tbody').append(
							'<tr>'
								+'<td><input type="hidden" name="barang_code[]" value="'+$('#barang_code').val()+'"/> '+$('#barang_code').val()+'</td>'
								+'<td><input type="hidden" name="barang_name[]" value="'+$('#barang_name').val()+'"/> '+$('#barang_name').val()+'</td>'
								+'<td style="display:none;"><input type="hidden" name="satuan_code[]" value="'+$('#satuan_code').val()+'"/> '+$('#satuan_code').val()+'</td>'
								+'<td><input type="hidden" name="satuan_doc[]" value="'+$('#satuan_doc').val()+'"/> '+$('#satuan_doc').val()+'</td>'
								+'<td><input type="hidden" name="jumlah_doc[]" value="'+$('#jumlah_doc').val()+'"/> '+$('#jumlah_doc').val()+'</td>'
								+'<td style="display:none;"><input type="hidden" name="nilai_konversi[]" value="'+$('#nilai_konversi').val()+'"/>'+$('#nilai_konversi').val()+'</td>'
								+'<td   style="display:none;"><input type="hidden" name="jumlah_barang[]" value="'+$('#jumlah_barang').val()+'"/>'+$('#jumlah_barang').val()+'</td>'
								+'<td><input type="hidden" name="nilai_barang[]" value="'+$('#nilai_barang').val()+'"/> '+$('#nilai_barang').val()+'</td>'
								+'<td  style="display:none;"><input type="hidden" name="saldo_awal[]" value="'+$('#saldo_awal').val()+'"/>'+$('#saldo_awal').val()+'</td>'
							+'</tr>');
							
							$("#barang_code").val('');
							$("#barang_name").val('');
							$("#satuan_code").val('');
							$("#satuan_doc").val('');
							$("#saldo_awal").val('');
							$("#jumlah_doc").val('');
							$("#jumlah_barang").val('');
							$("#nilai_konversi").val('');
							$("#nilai_barang").val('');
						
					}
				});
				
				$('#b-edit').click( function () {	
					if ( confirm("Apakah Anda akan mengedit ?") == true) {
						$("#barang_code").val($.trim($('#table-1 tbody .selected').find('td:eq(0)').text()));
						$("#barang_name").val($.trim($('#table-1 tbody .selected').find('td:eq(1)').text()));
						$("#satuan_code").val($.trim($('#table-1 tbody .selected').find('td:eq(2)').text()));
						$("#satuan_doc").val($.trim($('#table-1 tbody .selected').find('td:eq(3)').text()));
						$("#jumlah_doc").val($.trim($('#table-1 tbody .selected').find('td:eq(4)').text()));
						$("#nilai_konversi").val($.trim($('#table-1 tbody .selected').find('td:eq(5)').text()));
						$('#jumlah_barang').val($.trim($('#table-1 tbody .selected').find('td:eq(6)').text()));
						$("#nilai_barang").val($.trim($('#table-1 tbody .selected').find('td:eq(7)').text()));
						$("#saldo_awal").val($.trim($('#table-1 tbody .selected').find('td:eq(8)').text()));
						
						$('#table-1 tbody .selected').remove();
					}
				} );
				
				$('#b-delete').click( function () {
					if ( confirm("Anda Mau edit ?") == true) {
						$('#table-1 tbody .selected').remove();
					}
				} );
				
				$(".dataTables_filter").css('display','none');
				$(".dataTables_empty").css('display','none');
				$(".dataTables_info").css('display','none');
				$(".dataTables_length").css('display','none');
				$(".dataTables_paginate").css('display','none');
				/*
				if(<?php echo $doc_id == ""?>){
					$(".dataTables_empty, .odd").remove();
				}
				*/
			});
			/*
			$(function() {
				$( "#supplier_code" ).autocomplete({
				  source: "<?php echo base_url()?>index.php/Sb_import/get_Sb_supplier"
				});
			});	
			*/	
			
		</script>
	</head>
	<body>	
		
		<form method="post" action="<?php echo base_url()?>index.php/Sb_import/save" class="form-horizontal" name="form1" id="form1">
			<div>
				<div class="col-lg-4 col-xs-8">
						<div class="box box-info">
							<div class="box-header">
								<h3 class="box-title">
									Dokumen Pabean <?php echo str_replace("_", " ", $this->uri->segment(3));?>
								</h3>
							</div>
							<div class="box-body">
								<table>
									<input type="hidden" name="jenis_doc" id="jenis_doc" value="<?php echo $test = ($doc_id != "") ? $jenis_doc : str_replace("_", " ", $this->uri->segment(3));?>" readonly style="background:#eae9e9;" required />
									<tr>
										<td><label for="no_doc">No. Dokumen</label></td>
										<td>&nbsp:&nbsp<input type="text" name="no_doc" id="no_doc" style="width:150px;" value="<?php echo $no_doc;?>" required /></td>
									</tr>
									<tr>
										<td><label for="tgl_doc">Tgl. Dokumen</label></td>
										<td>&nbsp:&nbsp<input type="text" name="tgl_doc" id="tgl_doc" data-inputmask="'alias':'yyyy-mm-dd'" data-mask style="width:150px;" value="<?php echo $tgl_doc;?>" required /></td>
									</tr>
									<tr>
										<td><label for="valas">Valas</label></td>
										<td>&nbsp:&nbsp<input type="text" name="valas" id="valas" style="width:50px;"  value="<?php echo $valas?>" required /></td>
									</tr>
								</table>
							</div>
						</div>
				</div>
				<div class="col-lg-4 col-xs-8">
						<!--
						<div class="box box-info">
							<div class="box-header">
								<h3 class="box-title">
									Bukti
								</h3>
							</div>
							<div class="box-body">
								<table>
									<tr>
										<td>No Bukti</td>
										<td><input type="text" name="no_bukti" id="no_bukti" value="<?php echo $no_bukti;?>" required /></td>
									</tr>
									<tr>
										<td>Tanggal Bukti</td>
										<td><input type="date" name="tgl_bukti" id="tgl_bukti" value="<?php echo $tgl_bukti?>" required /></td>
									</tr>
								</table>
							</div>
						</div>
					!-->
					<div class="box box-info">
							<div class="box-header">
								<h3 class="box-title">
									Supplier
								</h3>
							</div>
							<div class="box-body">
								<?php if($doc_id == '') {?>
								<table>
									<tr>
										<td><label for="supplier_code">Kode Supplier</label></td>
										<td>&nbsp:&nbsp<input type="text" name="supplier_code" id="supplier_code" style="width:150px;" value="<?php echo $supplier_code?>" readonly required />
											<!--<a href="javascript:0">!-->
												<input type="button" value="Search" class="btn btn-primary btn-small" style="height:27px; font-size:11px;" onclick="openWinSupplier('<?php echo base_url()?>index.php/Sb_import/get_supplier','popupBarang','600','500')"/>
											<!--</a>!--></td>
									</tr>
									<tr>
										<td><label for="supplier_name">Nama Supplier</label></td>
										<td>&nbsp:&nbsp<input type="text" name="supplier_name" id="supplier_name" style="width:150px;" value="<?php echo $supllier_name?>" readonly></td>
									</tr>
										<input type="hidden" name="supplier_address" id="supplier_address" value="<?php echo $supplier_address?>" readonly style="background:#eae9e9;" />
									<tr>
										<td> &nbsp </td>
									</tr>
								</table>
							<?php } else {?>	
								<table>
									<tr>
										<td><label for="supplier_code">Kode Supplier</label></td>
										<td>&nbsp:&nbsp<input type="text" name="supplier_code" id="supplier_code" style="width:150px;" value="<?php echo $supplier_code?>" readonly required />
											<!--<a href="javascript:0">!-->
												<input type="button" value="Search" class="btn btn-primary btn-small" style="height:27px; font-size:11px;" onclick="openWinSupplier('<?php echo base_url()?>index.php/Sb_import/get_supplier','popupBarang','600','550')"/>
											<!--</a></td>!-->
									</tr>
									<tr>
										<td><label for="supplier_name">Nama Supplier</label></td>
										<td>&nbsp:&nbsp<input type="text" name="supplier_name" id="supplier_name" style="width:150px;" value="<?php echo $supllier_name?>" readonly /></td>
									</tr>
									<!--
									<tr>
										<td><label for="supplier_address">Supplier Address</label></td>
										<td><input type="text" name="supplier_address" id="supplier_address" value="<?php echo $supplier_address?>" readonly style="background:#eae9e9;" /></td>
									</tr>
									!-->
										<input type="hidden" name="supplier_address" id="supplier_address" value="<?php echo $supplier_address?>" readonly style="background:#eae9e9;" />
									<tr>
										<td> &nbsp </td>
									</tr>
								</table>
							<?php }?>
							</div>
						</div>
				</div>
				<div class="col-lg-4 col-xs-8">
						<div class="box box-info">
							<div class="box-header">
								<h3 class="box-title">
									Action
								</h3>
							</div>
							<div class="box-body">
								<table>
									<div style="padding:22px;"></div>
									<tr>
										<td></td>
										<td>
											<input type="submit" class="btn btn-primary btn-small" style="height:27px; width:75px; font-size:11px;" value="Save">
											<input type="reset" class="btn btn-primary btn-small" style="height:27px; width:75px; font-size:11px;" value="Reset">
										</td>
									</tr>
								</table>
							</div>
						</div>
				</div>
				<div>
					<label for="status"></label>
					<div></div>
				</div>
			</div>
			<div class="col-lg-12" style="margin-top:-20px;">
				<div class="box box-info">
					<div class="box-header">
						<label class="box-title" for="">Detail Barang</label>
					</div>
					<div class="box-body" style="margin-top:-20px;">
						<input type="text" name="barang_code" id="barang_code" value="" placeholder="Kode Barang" size="15" readonly>
						<!--<a href="javascript:0">!-->
							<input type="button" value="Search" class="btn btn-primary btn-small" style="height:27px; font-size:11px;" onclick="openWin('<?php echo base_url()?>index.php/Sb_import/get_barang','popupBarang','600','550')"/>
						<!--</a>!-->
						<input type="text" name="barang_name" id="barang_name" value="" placeholder="Nama Barang"style="width:150px;" readonly>
						<input type="text" name="satuan_code" id="satuan_code" value="" placeholder="Satuan Barang" style="width:80px;" readonly>
						<input type="text" name="satuan_doc" id="satuan_doc" value="" placeholder="Satuan Masuk" style="width:80px;" >
						<input type="hidden" name="saldo_awal" id="saldo_awal" value="">
						<input type="text" name="jumlah_doc" id="jumlah_doc" value="" placeholder="Jumlah" size="10">
						<input type="text" name="nilai_konversi" id="nilai_konversi" value="" placeholder="Nilai Konversi" size="10">
						<input type="text" name="jumlah_barang" id="jumlah_barang" value="" placeholder="Jumlah Barang" size="10" readonly>
						<input type="text" name="nilai_barang" id="nilai_barang" value="" placeholder="Nilai Barang" size="10">
						<a href="javascript:0">
							<input type="button" value="Add" class="btn btn-primary btn-small" style="height:27px; width:60px; font-size:11px;" id="b-add"/>
						</a>
						<a href="javascript:0">
							<input type="button" value="Edit" class="btn btn-primary btn-small" style="height:27px; width:60px; font-size:11px;" id="b-edit"/>
						</a>
						<a href="javascript:0">
							<input type="button" value="Delete" class="btn btn-primary btn-small" style="height:27px; width:60px; font-size:11px;" id="b-delete"/>
						</a>
					</div>
				</div>
			</div>
			<div>
				<table id="table-1" class="display" frame="box">
					<thead>
					<tr>
						<td>Kode Barang</td>
						<td>Nama Barang</td>
						<td style="display:none;">Satuan Barang</td>
						<td>Satuan Masuk</td>
						<td>Jumlah Barang</td>
						<td style="display:none;">Nilai Konversi</td>
						<td>Nilai Barang</td>
						<td style="display:none;">Jumlah Barang</td>
						<td style="display:none;">Saldo Barang</td>
					</tr>
					</thead>
					<?php if ($doc_id != "") { ?>
					<tbody>
						<?php foreach($import_dt as $import_dt){ ?>
						<tr>
							<td><?php echo $import_dt->barang_code?>
							<input type="hidden" name="barang_code[]" value="<?php echo $import_dt->barang_code?>">
							</td>
							<td><?php echo $import_dt->barang_name?></td>
							<td style="display:none;"><?php echo $import_dt->satuan_code?></td>
							<td><?php echo $import_dt->satuan_doc?>
							<input type="hidden" name="satuan_doc[]" value="<?php echo $import_dt->satuan_doc?>">
							</td>
							<td><?php echo $import_dt->jumlah_doc?>
							<input type="hidden" name="jumlah_doc[]" value="<?php echo $import_dt->jumlah_doc?>">
							</td>
							<td style="display:none;"><?php echo $import_dt->nilai_konversi?>
							<input type="hidden" name="nilai_konversi[]" value="<?php echo $import_dt->nilai_konversi?>">
							</td>
							<td style="display:none;">
							<input type="hidden" name="jumlah_barang[]" value="<?php echo $import_dt->jumlah_barang?>"><?php echo $import_dt->jumlah_barang?>
							</td>
							<td><?php echo $import_dt->nilai_barang?>
							<input type="hidden" name="nilai_barang[]" value="<?php echo $import_dt->nilai_barang?>">
							</td>
							<td style="display:none"><?php echo $import_dt->saldo_akhir?></td>
						<?php } ?>
						</tr>
					</tbody>
					<?php } else {?>
						<tbody>
					
						</tbody>
					<?php }?>
				</table>
			</div></br>
			<div>
			</div>
			<?php
				if($doc_id != ""){
					echo "<input type='hidden' value='$doc_id' name='doc_id'>";
				}
			?>
		</form>
		<a href="<?php echo base_url()?>index.php/Sb_import/listing/<?php echo $this->uri->segment(3);?>">Back To Menu</a>
	</body>
</html>	