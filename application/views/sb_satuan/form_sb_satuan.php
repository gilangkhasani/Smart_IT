<!doctype html>
<html lang="en">
	<head>
		<title>Form Benang</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
	</head>
	<body>
		<?php
			if(isset($satuan)){
				$satuan_codes = $satuan->satuan_code;
				$satuan_name = $satuan->satuan_name;
			} else {
				$satuan_codes = "";
				$satuan_name = "";
			}
		?>	
		<form method="post" action="<?php echo base_url()?>index.php/Sb_satuan/save">
			<div>
				<label for="satuan_code">Satuan Code</label>
				<div>
					<input type="text" name="satuan_code" id="satuan_code" value="<?php echo $satuan_codes?>" maxlength="3">
				</div>
			</div>
			<div>
				<label for="satuan_name">Satuan Name</label>
				<div>
					<input type="text" name="satuan_name" id="satuan_name" value="<?php echo $satuan_name?>">
				</div>
			</div>
			<div>
				<input type="submit" value="Save">
				<input type="reset" value="Reset">
			</div>
			<?php
				if($satuan_codes != ""){
					echo "<input type='hidden' value='$satuan_codes' name='satuan_codes'>";
				}
			?>
		</form>
	</body>
</html>	