<link rel="icon" type="image/ico" href="<?php echo base_url()?>template_lala/img/smart.jpg">
<style>	
	h4{
		margin-left:30px;
		text-align:center;
	}
	p{
		text-align:center;
		margin-top:5px;
	}
	
	.bordered tbody  
{
    background-color:#FFF;
}
table {
*border-collapse: collapse; /* IE7 and lower */
border-spacing: 0; 
}


.bordered {
    border: solid #ccc 1px;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    border-radius: 6px;
    -webkit-box-shadow: 0 1px 1px #ccc; 
    -moz-box-shadow: 0 1px 1px #ccc; 
    box-shadow: 0 1px 1px #ccc;         
}

.bordered tr:hover {
    background: #fbf8e9;
    -o-transition: all 0.1s ease-in-out;
    -webkit-transition: all 0.1s ease-in-out;
    -moz-transition: all 0.1s ease-in-out;
    -ms-transition: all 0.1s ease-in-out;
    transition: all 0.1s ease-in-out;     
}    
    
.bordered td, .bordered th {
    border-left: 1px solid #ccc;
    border-top: 1px solid #ccc;
    padding: 5px;
}

.bordered th {
    background-color: #FF8A8A;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#FF4848), to(FF8A8A));
    background-image: -webkit-linear-gradient(top, #FF4848, #FF8A8A);
    background-image:    -moz-linear-gradient(top, #FF4848, #FF8A8A);
    background-image:     -ms-linear-gradient(top, #FF4848, #FF8A8A);
    background-image:      -o-linear-gradient(top, #FF4848, #FF8A8A);
    background-image:         linear-gradient(top, #FF4848, #FF8A8A);
    -webkit-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset; 
    -moz-box-shadow:0 1px 0 rgba(255,255,255,.8) inset;  
    box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;        
    border-top: none;
    text-shadow: 0 1px 0 rgba(255,255,255,.5); 
}
thead   {display: table-header-group;   }

</style>
<script type="text/javascript">
	setTimeout(function(){
		window.print();
	}, 1000);
</script>
	
	<h4>LAPORAN POSISI BARANG DALAM PROSES</h4>
	<?php foreach($profil as $tas){?>
			<p><?php echo $tas->company_name;?>
			<br><?php echo $tas->company_address;?>
			<br>Telp : <?php echo $tas->phone;?> Fax : <?php echo $tas->fax;?></p>
	<?php } ?>
	
	<table class="bordered" style="font-size:11px; width:100%;">
		<thead>
			<tr>
				<td><center>No</center></td>
				<td><center>Kode Barang</center></td>
				<td><center>Nama Barang</center></td>
				<td><center>Satuan</center></td>
				<td><center>Jumlah</center></td>
				<td><center>Keterangan</center></td>
			</tr>
		</thead>
		<?php $i=1;
			$jumlah_jumlah_barang=0;
		?>
		<?php foreach($wip as $data_wip){ ?>
		<tr>
			<td><center><?php echo $i;?></center></td>
			<td><?php echo $data_wip->barang_kode?></td>
			<td><?php echo $data_wip->barang_name?></td>
			<td><?php echo $data_wip->satuan_code?></td>
			<td align="right"><?php echo number_format($data_wip->jumlah_barang,2)?></td>
			<td><?php echo $data_wip->keterangan?></td>
		</tr>
		<?php $i++; 
			$jumlah_jumlah_barang = $jumlah_jumlah_barang + $data_wip->jumlah_barang;
		?>
		<?php }?>
		<tr>
			<td colspan="4">GRAND TOTAL :</td>
			<td align="right"><?php echo number_format($jumlah_jumlah_barang,2)?></td>
			<td></td>
		</tr>
	</table>
	
	