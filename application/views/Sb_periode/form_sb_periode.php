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
			if(isset($periode)){
				$periode_id = $periode->periode_id;
				$start_date = $periode->start_date;
				$end_date = $periode->end_date;
			} else {
				$periode_id = "";
				$start_date = "";
				$end_date = "";
			}
		?>	
		<form method="post" action="<?php echo base_url()?>index.php/Sb_periode/save">
			<div class="box box-info">
				<div class="box-header">
							<h3 class="box-title">
								Input Periode
							</h3>
				</div>
				<div class="box-body">
					<div>
						<label for="start_date">Start Date</label>
						<div>
							<input type="date" name="start_date" id="start_date" value="<?php echo $start_date?>">
						</div>
					</div>
					<div>
						<label for="end_date">End Date</label>
						<div>
							<input type="date" name="end_date" id="end_date" value="<?php echo $end_date?>">
						</div>
					</div></br>
					<div>
						<input type="submit" value="Save">
						<input type="reset" value="Reset">
					</div>
					<?php
						if($periode_id != ""){
							echo "<input type='hidden' value='$periode_id' name='periode_id'>";
						}
					?>
				</div>
			</div>
		</form>
	</body>
</html>	