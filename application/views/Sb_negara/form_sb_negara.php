<!doctype html>
<html lang="en">
	<head>
		<title>Form Benang</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="<?php echo base_url()?>template_lala/css/datatables/dataTables.bootstrap.css">
	<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
	<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
	<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
	</head>
<script type="text/javascript">
	$(document).ready(function(){		
		$("#negara_code").change(function(){
            var negara_code = $("#negara_code").val();
            $.ajax({
               type : "POST",
               url  : "<?php echo base_url(); ?>index.php/Sb_negara/cek_negara_code",
               data : "negara_code=" + negara_code,
               success: function(data){
					if(data==1){
						$("#hasil_negara_code").html('Maaf username telah digunakan');
						$("#negara_code").focus();
						return false;
					}else{
						$("#hasil_negara_code").html('Username valid');
					}
			   }
            });
        });
	});
</script>
	<body>
		<?php
			if(isset($negara)){
				$negara_codes = $negara->negara_code;
				$negara_name = $negara->negara_name;
			} else {
				$negara_codes = "";
				$negara_name = "";
			}
		?>	
		<form method="post" action="<?php echo base_url()?>index.php/Sb_negara/save">
			<div>
				<label for="negara_code">Negara Code</label>
				<div>
					<input type="text" name="negara_code" id="negara_code" value="<?php echo $negara_codes?>" maxlength="3">
				</div>
				<div id="hasil_negara_code">
						</div>
			</div>
			<div>
				<label for="negara_name">Negara Name</label>
				<div>
					<input type="text" name="negara_name" id="negara_name" value="<?php echo $negara_name?>">
				</div>
			</div>
			<div>
				<input type="submit" value="Save">
				<input type="reset" value="Reset">
			</div>
			<?php
				if($negara_codes != ""){
					echo "<input type='hidden' value='$negara_codes' name='negara_codes'>";
				}
			?>
		</form>
	</body>
</html>	