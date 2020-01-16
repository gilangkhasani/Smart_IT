<!doctype html>
<html lang="en">
	<head>
		<title>Form Barang</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
		<script>
			  $(function() {
				$( "#satuan_code" ).autocomplete({
				  source: "<?php echo base_url()?>index.php/Sb_satuan/get_Sb_satuan"
				});
			  });
		</script>
	</head>
	<body>
		<?php
			if(isset($barang)){
				$barang_code = $barang->barang_code;
				$barang_name = $barang->barang_name;
				$hs_code = $barang->hs_code;
				$barang_category = $barang->barang_category;
				$barang_status = $barang->barang_status;
			} else {
				$barang_code = "";
				$barang_name = "";
				$hs_code = "";
				$barang_category = "";
				$barang_status = "";
			}
			
			if(isset($saldo_awal)){
				$saldo_awal = $saldo_awal->saldo_awal;
			} else {
				$saldo_awal = "";
			}
			
			if(isset($satuan)){
				$satuan_code = $satuan->satuan_code;
				$satuan_name = $satuan->satuan_name;
			} else {
				$satuan_code = "";
				$satuan_name = "";
			}
			
			$today = date('Y-m-d');
			$today=date('Y-m-d', strtotime($today)).'<br/>';;
			
			$from = date('Y-m-d', strtotime("01/01/".date("Y")));
			$to = date('Y-m-d', strtotime("05/01/".date("Y")));
			
			$from1 = date('Y-m-d', strtotime("05/01/".date("Y")));
			$to1 = date('Y-m-d', strtotime("09/01/".date("Y")));
			
			if (($today >= $from) && ($today <= $to)) {
				$per = '1';
			}
			else if (($today >= $from1) && ($today <= $to1)) {
				$per = '2';
			}
			else {
				$per = '3';
			}
			$periode = 'PR-'.date('Y').'-'.$per;
		?>	
		<form method="post" action="<?php echo base_url()?>index.php/Sb_barang/save">
			<div>
				<label for="barang_name">Barang Name</label>
				<div>
					<input type="text" name="barang_name" id="barang_name" value="<?php echo $barang_name?>">
				</div>
			</div>
			<div>
				<label for="hs_code">HS Code</label>
				<div>
					<input type="text" name="hs_code" id="hs_code" value="<?php echo $hs_code?>">
				</div>
			</div>
			<div>
				<label for="satuan_code">Satuan Code</label>
				<div>
					<input type="text" name="satuan_code" id="satuan_code" value="<?php echo $satuan_name?>">
				</div>
			</div>
			<div>
				<label for="satuan_code">Barang Category</label>
				<div>
				<?php
					$str = str_replace("_", " ", $this->uri->segment(3));
					if($str == 'Mesin Sparepart'){
						$str = 'Mesin/Sparepart';
					} else {
						$str;
					}
				?>
					<input type="text" name="barang_category" id="barang_category" value="<?php echo ($barang_code == "") ? $str: $barang_category ?>" readonly>
					
				</div>
			</div>
			<div>
				<label for="saldo_awal">Saldo Awal</label>
				<div>
					<input type="text" name="saldo_awal" id="saldo_awal" value="<?php echo $saldo_awal;?>">
				</div>
			</div>
			<div>
				<label for="saldo_awal">Periode Id</label>
				<div>
					<input type="text" name="periode_id" id="periode_id" value="<?php echo $periode?>">
				</div>
			</div>
			<div>
				<input type="submit" value="Save">
				<input type="reset" value="Reset">
			</div>
			<?php
				if($barang_code != ""){
					echo "<input type='hidden' value='$barang_code' name='barang_code'>";
				}
			?>
		</form>
	</body>
</html>	