<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php
		$barang1 = $this->uri->segment(3);
		$barang2 = $this->uri->segment(4);
		if($barang1 == 'Mesin_Sparepart'){
			$barang1 = 'Mesin';
		} else
		if($barang1 == 'Reject'){
			$barang1 = 'Barang Sisa';
		} else  {
			$barang1=str_replace('_', ' ', $barang1);
		}
		$barang2=str_replace('_', ' ', $barang2);
	?>
	<title> Laporan Mutasi <?php echo  $barang1?> <?php echo $barang2 ?></title>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/ui/themes/smoothness/jquery-ui.css">
	<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
	<script src="<?php echo base_url()?>template/js/ui/1.11.1/jquery-ui.js"></script>
	<script src="<?php echo base_url()?>template/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>template/css/jquery.dataTables.css">
	<script>
		$(document).ready(function() {
			table = $('#example').DataTable();
			
				$('#example tbody').on( 'click', 'tr', function () {
					if ( table.$('tr.selected').removeClass('selected') ) {
						$(this).addClass('selected');
					}
				} );
				
			// Event listener to the two range filtering inputs to redraw on input
			
			$('#barang_category').on( 'change', function () {
				table
					.columns( 12 )
					.search( this.value )
					.draw();
			} );
			
			$('#barang_code').on( 'keyup', function () {
				table
					.columns( 1 )
					.search( this.value )
					.draw();
			} );
		} );
	</script>
</head>
<body>
	<?php if ($barang1 != 'Barang Jadi'){?>
	<h3> Laporan Mutasi <?php echo $barang1?> dan <?php echo $barang2 ?></h3>
	<?php } else {?>
	<h3> Laporan Mutasi <?php echo $barang1?> </h3>
	<?php } ?>
	<form action="<?php echo base_url()?>Mutasiexcel/report_mutasi_bb_bp" method="post" target="_blank">
		<div>
			<fieldset>
				<legend style="color:blue;font-weight:bold;">Filter</legend>
				<table>
					<tr>
						<td>Kategori Barang</td>
						<td> &nbsp : &nbsp
							<?php if($barang1 == 'Bahan Baku' && $barang2 == 'Bahan Penolong'){?>
								<select name="barang_category" id="barang_category" style="width:150px;">
									<option value="">All</option>
									<option value="Bahan Baku">Bahan Baku</option>
									<option value="Bahan Penolong">Bahan Penolong</option>
								</select>
							<?php } else if($barang1 == 'Barang Jadi' ){?>	
								<select name="barang_category" id="barang_category" style="width:150px;">
									<option value="">All</option>
									<option value="Barang Jadi">Barang Jadi</option>
								</select>
							<?php } else if($barang1 == 'Reject' && $barang2 == 'Scrap' ){?>	
								<select name="barang_category" id="barang_category" style="width:150px;">
									<option value="">All</option>
									<option value="Reject">Barang Sisa</option>
									<option value="Scrap">Scrap</option>
								</select>
							<?php } else {?>
								<select name="barang_category" id="barang_category" style="width:150px;">
									<option value="">All</option>
									<option value="Mesin/Sparepart">Mesin/Peralatan</option>
									<option value="Peralatan Pabrik">Peralatan Pabrik</option>
								</select>
							<?php }?>
						</td>
						<td> &nbsp &nbsp &nbsp &nbsp &nbsp <input class="btn-primary" type="submit" id="pdf" name="pdf" style="width:100px;" value="Export to PDF"></td>
					</tr>
					<tr>
						<td>Kode Barang</td>
						<td> &nbsp : &nbsp <input type="text" name="barang_code" style="width:150px;" id="barang_code" class="barang_code"/></td>
						<td> &nbsp &nbsp &nbsp &nbsp &nbsp <input class="btn-primary" type="submit" id="excel" name="excel" style="width:100px;" value="Export to Excel"></td>
					</tr>
					<input type="hidden" name="periode_id" value="<?php echo $this->uri->segment(5);?>">
					<input type="hidden" name="barang1" value="<?php echo $this->uri->segment(3);?>">
					<input type="hidden" name="barang2" value="<?php echo $this->uri->segment(4);?>">
				</table>
				<br>
			</fieldset>
		</div>
	</form>
	<br/>
	<table id="example" class="table table-hover" border="1px solid black" style="font-size:small;">
		<thead>
			<tr>
				<th>No</th>
				<th>Kode Barang</th>
				<th>Nama Barang</th>
				<th>Satuan</th>
				<th>Saldo Awal</th>
				<th>Pemasukan</th>
				<th>Pengeluaran</th>
				<th>Penyesuaian</th>
				<th>Saldo Akhir</th>
				<th>Stock Opname</th>
				<th>Selisih</th>
				<th>Keterangan</th>
				<th style="display:none;">Kategory</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($laporan as $laporan) { ?>
			<tr>
				<td><?php echo $laporan->no;?></td>
				<td><?php echo $laporan->barang_code;?></td>
				<td><?php echo $laporan->barang_name;?></td>
				<td><?php echo $laporan->satuan_code;?></td>
				<td align="right"><?php echo number_format($laporan->stock_awal,2);?></td>
				<td align="right"><?php echo number_format($laporan->pemasukan,2);?></td>
				<td align="right"><?php echo number_format($laporan->pengeluaran,2);?></td>
				<td align="right"><?php echo number_format($laporan->penyesuaian,2);?></td>
				<td align="right"><?php echo number_format($laporan->saldo_akhir,2);?></td>
				<td align="right"><?php echo number_format($laporan->stock_opname,2);?></td>
				<td align="right"><?php echo number_format($laporan->selisih,2);?></td>
				<td><?php echo $laporan->keterangan;?></td>
				<td style="display:none;"><?php echo $laporan->barang_category;?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<a href="<?php echo base_url()?>index.php/Sb_mutasi/listing/<?php echo $this->uri->segment(3)?>/<?php echo $this->uri->segment(4)?>">Back to Menu</a>
	<div class="modal fade" id="myModalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 500px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-key"></i> Change Password</h4>
          </div>

          <div class="modal-body">
            <div class="box-body">
				<form method="post" action="<?php echo base_url()?>index.php/Sb_users/changePassword1">
					<div>
						<label for="old_password">Old Password lala</label>
						<div>
							<input type="password" class="form-control" name="old_password" value=""/>
						</div>
					</div>
					<div>
						<label for="new_password">New Password</label>
						<div>
							<input type="password" class="form-control" name="new_password" value=""/>
						</div>
					</div>
					<div>
						<label for="re_type_password">Re-type Password</label>
						<div>
							<input type="password" class="form-control" name="re_type_password" value=""/>
						</div>
					</div></br>
			</div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <input type="submit" class="btn btn-primary" value="Save"></button>
          </div>
		  </form>
        </div>
      </div>
    </div>
</body>
</html>