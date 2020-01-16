
<h1>Welcome to <?php echo $this->session->userdata('username');?></h1>

<br/>
<a href="<?php echo base_url()?>Sb_login/doLogout">logout</a>
<ul>
	Export/Import
	<ul>
		Import
		<li><a href="<?php echo base_url()?>index.php/Sb_import/listing/BC_2.3">Import BC 2.3</a></li>
		<li><a href="<?php echo base_url()?>index.php/Sb_import/listing/BC_2.6.2">Import BC 2.6.2</a></li>
		<li><a href="<?php echo base_url()?>index.php/Sb_import/listing/BC_2.7">Import BC 2.7</a></li>
		<li><a href="<?php echo base_url()?>index.php/Sb_import/listing/BC_4.0">Import BC 4.0</a></li>
	</ul>
	<ul>
		Export
		<li><a href="<?php echo base_url()?>index.php/Sb_export/listing/BC_2.5">Export BC 2.5</a></li>
		<li><a href="<?php echo base_url()?>index.php/Sb_export/listing/BC_2.6.1">Export BC 2.6.1</a></li>
		<li><a href="<?php echo base_url()?>index.php/Sb_export/listing/BC_2.7">Export BC 2.7</a></li>
		<li><a href="<?php echo base_url()?>index.php/Sb_export/listing/BC_3.0">Export BC 3.0</a></li>
		<li><a href="<?php echo base_url()?>index.php/Sb_export/listing/BC_4.1">Export BC 4.1</a></li>
	</ul>
</ul>

<ul>
	Inventory
	<li><a href="">Stock Transfer</a></li>
	<li><a href="">Material Return</a></li>
	<li><a href="">Reject</a></li>
	<li><a href="">Finish Good</a></li>
	<li><a href="">Scrap</a></li>
	<li><a href="">Stock Opname</a></li>
</ul>
<ul>
	Production
	<li><a href="">Consumption</a></li>
	<li><a href="">Production Plan</a></li>
	<li><a href="">Work In Process</a></li>
</ul>
<ul>
	Report
	<li><a href="<?php echo base_url()?>index.php/Sb_pemasukan_barang">Pemasukan Barang Per Dokumen</a></li>
	<li><a href="<?php echo base_url()?>index.php/Sb_pengeluaran_barang">Pengeluaran Barang Per Dokumen</a></li>
	<li><a href="">Work In Process</a></li>
	<li><a href="">Mutasi Bahan Baku dan Penolong</a></li>
	<li><a href="">Mutasi Barang Jadi</a></li>
	<li><a href="">Mutasi Barang Sisa dan Scrap</a></li>
	<li><a href="">Mutasi Mesin dan Peralatan</a></li>
</ul>
<ul>
	Setting
	<li><a href="<?php echo base_url()?>index.php/Sb_periode">Periode</a></li>
	<li><a href="<?php echo base_url()?>index.php/Sb_users">User Management</a></li>
	<li><a href="<?php echo base_url()?>index.php/Sb_satuan">Satuan</a></li>
</ul>
<ul>
	Barang
	<li><a href="<?php echo base_url()?>index.php/Sb_barang/listing/Bahan_Baku">Bahan Baku</a></li>
	<li><a href="<?php echo base_url()?>index.php/Sb_barang/listing/Bahan_Penolong">Bahan Penolong</a></li>
	<li><a href="<?php echo base_url()?>index.php/Sb_barang/listing/Barang_Jadi">Barang Jadi</a></li>
	<li><a href="<?php echo base_url()?>index.php/Sb_barang/listing/Scrap">Scrap</a></li>
	<li><a href="<?php echo base_url()?>index.php/Sb_barang/listing/Mesin_Sparepart">Mesin/Sparepart</a></li>
	<li><a href="<?php echo base_url()?>index.php/Sb_barang/listing/Peralatan_Pabrik">Peralatan Pabrik</a></li>
</ul>
<ul>
	Satuan
	<li><a href="<?php echo base_url()?>index.php/Sb_supplier">Supplier</a></li>
	<li><a href="<?php echo base_url()?>index.php/Sb_negara">Negara</a></li>
</ul>
IP 
27.123.5.86:8484
--user--
phone
email
last_login
<?php

    $d = date('d-m-Y H:i:s'); //Returns IST 
	$date = new DateTime(date('d-m-Y H:i:s'));
	$result = $date->format('Y-m-d H:i:s');
	
	if ($result) {
	  echo $result;
	} else { // format failed
	  echo "Unknown Time";
	}
	
	$str = str_replace("_", " ", "Bahan_baku");
	echo $str;
	/*
	echo "<br/>";
	$today = date('Y-m-d');
    echo $today=date('Y-m-d', strtotime($today)).'<br/>';;
    //echo $today; // echos today! 
	$from = date('Y-m-d', strtotime("01/01/2014"));
    $to = date('Y-m-d', strtotime("05/01/2014"));
	
	$from1 = date('Y-m-d', strtotime("05/01/2014")).'<br/>';
    $to1 = date('Y-m-d', strtotime("09/01/2014"));
	
    if (($today >= $from) && ($today <= $to)) {
      $periode = '1';
    }
    else if (($today >= $from1) && ($today <= $to1)) {
      $periode = '2';
    }
	else {
		$periode = '3';
	}
	echo 'PR-'.date('Y').'-'.$periode;*/
?>
