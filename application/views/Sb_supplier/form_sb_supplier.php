<!doctype html>
<html lang="en">
	<head>
		<title>Form Supplier</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
		<script>
			  $(function() {
				$( "#negara_code" ).autocomplete({
				  source: "<?php echo base_url()?>index.php/Sb_supplier/get_Sb_supplier"
				});
			  });
		</script>
	</head>
	<body>
		<?php
			if(isset($supplier)){
				$supplier_code = $supplier->supplier_code;
				$supplier_name = $supplier->supplier_name;
				$supplier_address = $supplier->supplier_address;
				$negara_code = $supplier->negara_code;
				$npwp = $supplier->npwp;
				$no_izin_tpb = $supplier->no_izin_tpb;
			} else {
				$supplier_code = "";
				$supplier_name = "";
				$supplier_address = "";
				$negara_code = "";
				$npwp = "";
				$no_izin_tpb = "";
			}
		?>	
		<form method="post" action="<?php echo base_url()?>index.php/Sb_supplier/save">
			<div>
				<label for="supplier_name">Supplier Name</label>
				<div>
					<input type="text" name="supplier_name" id="supplier_name" value="<?php echo $supplier_name?>">
				</div>
			</div>
			<div>
				<label for="supplier_address">Supplier Address</label>
				<div>
					<textarea name="supplier_address" id="supplier_address" cols="30" rows="10"><?php echo $supplier_address;?></textarea>
				</div>
			</div>
			<div>
				<label for="negara_code">Negara Code</label>
				<div>
					<input type="text" name="negara_code" id="negara_code" value="<?php echo $negara_code?>">
				</div>
			</div>
			<div>
				<label for="npwp">NPWP</label>
				<div>
					<input type="text" name="npwp" id="npwp" value="<?php echo $npwp?>">
				</div>
			</div>
			<div>
				<label for="no_izin_tpb">No Izin TPB</label>
				<div>
					<input type="text" name="no_izin_tpb" id="no_izin_tpb" value="<?php echo $no_izin_tpb?>">
				</div>
			</div>
			<div>
				<input type="submit" value="Save">
				<input type="reset" value="Reset">
			</div>
			<?php
				if($supplier_code != ""){
					echo "<input type='hidden' value='$supplier_code' name='supplier_code'>";
				}
			?>
		</form>
	</body>
</html>	