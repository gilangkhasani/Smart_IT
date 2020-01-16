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
	
	<h4>LAPORAN PEMASUKAN BARANG PER DOKUMEN PABEAN</h4>
	<?php foreach($profil as $tas){?>
			<p><?php echo $tas->company_name;?>
			<br><?php echo $tas->company_address;?>
			<br>Telp : <?php echo $tas->phone;?> Fax : <?php echo $tas->fax;?></p>
	<?php } ?>
	
	<table class="bordered" style="font-size:11px; width:100%;">
		<thead>
			<tr>
				<td><center>No</center></td>
				<td><center>Jenis Dokumen</center></td>
				<td><center>No. Dokumen</center></td>
				<td><center>Tgl. Dokumen</center></td>
				<td><center>No. Penerimaan</center></td>
				<td><center>Tgl. Penerimaan</center></td>
				<td><center>Supplier</center></td>
				<td><center>Kode Barang</center></td>
				<td><center>Nama Barang</center></td>
				<td><center>Satuan</center></td>
				<td><center>Jumlah</center></td>
				<td><center>Valas</center></td>
				<td><center>Nilai</center></td>
			</tr>
		</thead>
		<?php $i=1; ?>
		<?php foreach($import as $data_import){ ?>
		<tr>
			<td><center><?php echo $i;?></center></td>
			<td><?php echo $data_import->jenis_doc?></td>
			<td><?php echo $data_import->no_doc?></td>
			<td><?php echo $data_import->tgl_doc?></td>
			<td><?php echo $data_import->no_bukti?></td>
			<td><?php echo $data_import->tgl_bukti?></td>
			<td><?php echo $data_import->supplier_name?></td>
			<td><?php echo $data_import->barang_code?></td>
			<td><?php echo $data_import->barang_name?></td>
			<td><?php echo $data_import->satuan_doc?></td>
			<td align="right"><?php echo number_format($data_import->jumlah_doc,2)?></td>
			<td><?php echo $data_import->valas?></td>
			<td align="right"><?php echo number_format($data_import->nilai_barang,2)?></td>
		</tr>
		<?php $i++; ?>
		<?php } 
		?>
	</table>
	
	</br>	
	<p style="margin-left:-530px;">Total Dokumen : <?php  echo $i-1; ?></p>
	<p></p>
	
	<p style="margin-left:400px;"><?php echo $tas->city;?>, <?php echo date('d M Y');?></p>
			<br><br><p style="margin-left:400px;"><?php echo $nama->first_name;?>&nbsp <?php echo $nama->last_name;?></p>