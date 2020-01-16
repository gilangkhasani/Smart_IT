<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>IT Inventory | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url()?>template_lala/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url()?>template_lala/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo base_url()?>template_lala/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?php echo base_url()?>template_lala/css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?php echo base_url()?>template_lala/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="<?php echo base_url()?>template_lala/css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php echo base_url()?>template_lala/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
		<!-- Date Picker -->
        <link href="<?php echo base_url()?>template_lala/css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo base_url()?>template_lala/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url()?>template_lala/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
		
		<meta http-equiv="PRAGMA" content="NO-CACHE">
		<meta http-equiv="Expires" content="-1">
		<meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
		<link rel="icon" type="image/ico" href="<?php echo base_url()?>template_lala/img/smart.jpg">
		<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>
		
		<style>
			.no-print{
				display:none;
			}
		</style>
	  <style>
		#load{
			width:100%;
			height:100%;
			position:fixed;
			z-index:9999;
			background:url("https://www.creditmutuel.fr/cmne/fr/banques/webservices/nswr/images/loading.gif") no-repeat center center rgba(0,0,0,0.25)
		}
	  </style>
	  <script>
		document.onreadystatechange = function () {
		  var state = document.readyState
		  if (state == 'interactive') {
			   document.getElementById('contents').style.visibility="hidden";
		  } else if (state == 'complete') {
			  setTimeout(function(){
				 document.getElementById('interactive');
				 document.getElementById('load').style.visibility="hidden";
				 document.getElementById('contents').style.visibility="visible";
			  },1000);
		  }
		}
	  </script>
		<script src="<?php echo base_url()?>template/js/jquery-1.11.1.min.js"></script>	
		<!--<script type="text/javascript">
        $(function() {
            $(this).bind("contextmenu", function(e) {
                e.preventDefault();
            });
        }); 
		
    </script>-->
    </head>
    <body class="skin-blue">
		<div id="load"></div>
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo base_url()?>Blog" class="logo" style="position:fixed;">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                IT Inventory
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav style="width:84%; position:fixed; " class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
				<div class="navbar-left">
                    <h3 style="color:white; margin-top:10px;"> &nbsp &nbsp
						<?php foreach($profil as $tes){
							echo $tes->company_name;
						} ?>
                    </h3>
				</div>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
   
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <!--<a href="<?php echo base_url()?>Sb_login/doLogout">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>Log Out<span>
                            </a>-->
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $this->session->userdata('first_name');?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" data-toggle="modal" data-target="#myModallogin" class="btn btn-primary btn-flat"><i class="fa fa-key"></i> Change Password</a>
                                        <!--<a href="<?php echo base_url()?>index.php/Sb_users/add" class="btn btn-primary btn-flat"><i class="fa fa-key"></i> Change Password</a>-->
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url()?>Sb_login/doLogout" class="btn btn-primary btn-flat"><i class="fa fa-power-off"></i> Log out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar" id="sidebar" style="font-size:small">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
					<div id="MainMenu" style="position:fixed; width:16%;">
					  <div class="list-group panel">
						<?php if($this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Exim') {?>
						<a href="#demo3" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#MainMenu">
								<i class="fa fa-bar-chart-o"></i>
                                <span>Export-Import</span>
                                <i class="fa fa-angle-left pull-right"></i>
						</a>
						<div class="collapse" id="demo3">
						  <a href="#SubMenu1" style="padding : 7px 15px;" class="list-group-item list-group-item-success" data-toggle="collapse" >Export </a>
						  
							<a href="<?php echo base_url()?>index.php/Sb_export/listing/BC_2.5" style="padding : 7px 15px;" class="list-group-item list-group-item-success" data-parent="#SubMenu1">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Exp 2.5</a>
							<a href="<?php echo base_url()?>index.php/Sb_export/listing/BC_2.6.1" style="padding : 7px 15px;" class="list-group-item list-group-item-success" data-parent="#SubMenu1">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Exp 2.6.1</a>
							<a href="<?php echo base_url()?>index.php/Sb_export/listing/BC_2.7" style="padding : 7px 15px;" class="list-group-item list-group-item-success" data-parent="#SubMenu1">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Exp 2.7</a>
							<a href="<?php echo base_url()?>index.php/Sb_export/listing/BC_3.0" style="padding : 7px 15px;" class="list-group-item list-group-item-success" data-parent="#SubMenu1">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Exp 3.0</a>
							<a href="<?php echo base_url()?>index.php/Sb_export/listing/BC_4.1" style="padding : 7px 15px;" class="list-group-item list-group-item-success" data-parent="#SubMenu1">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Exp 4.1</a>
						  
						  <a href="#SubMenu2" class="list-group-item list-group-item-success" data-toggle="collapse" >Import</a>
						  
							<a href="<?php echo base_url()?>index.php/Sb_import/listing/BC_2.3" style="padding : 7px 15px;" class="list-group-item list-group-item-success" data-parent="#SubMenu2">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Imp 2.3</a>
							<a href="<?php echo base_url()?>index.php/Sb_import/listing/BC_2.6.2" style="padding : 7px 15px;" class="list-group-item list-group-item-success" data-parent="#SubMenu2">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Imp 2.6.2</a>
							<a href="<?php echo base_url()?>index.php/Sb_import/listing/BC_2.7" style="padding : 7px 15px;" class="list-group-item list-group-item-success" data-parent="#SubMenu2">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Imp 2.7</a>
							<a href="<?php echo base_url()?>index.php/Sb_import/listing/BC_4.0" style="padding : 7px 15px;" class="list-group-item list-group-item-success" data-parent="#SubMenu2">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Imp 4.0</a>
						  
						</div>
						
						<?php } if($this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Inventory') {?>
						<a href="#demo4" style="padding : 7px 15px;" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#MainMenu">
							<i class="fa fa-bar-chart-o"></i>
                            <span>Inventory</span>
                            <i class="fa fa-angle-left pull-right"></i>
						</a>
						<div class="collapse" id="demo4">
						  <a href="<?php echo base_url()?>index.php/Sb_inventory" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Finish Good</a>
						  <a href="<?php echo base_url()?>index.php/Sb_inventory/listing_scrap" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Scrap</a>
						  <!--<a href="<?php echo base_url()?>index.php/Sb_inventory/listing_reject" style="padding : 7px 15px;" class="list-group-item">Reject</a>-->
						  <a href="<?php echo base_url()?>index.php/Sb_inventory/listing_material_return" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Material Return</a>
						  <a href="<?php echo base_url()?>index.php/Sb_stock_opname" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Stock Opname</a>
						</div>
						
						<?php } ?>
						<?php if($this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Production') {?>
						<a href="#demo5" style="padding : 7px 15px;" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#MainMenu">
							<i class="fa fa-bar-chart-o"></i>
                            <span>Production</span>
                            <i class="fa fa-angle-left pull-right"></i>
						</a>
						<div class="collapse" id="demo5">
						  <a href="<?php echo base_url()?>index.php/Sb_production/listing" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Production Plan</a>
						  <a href="<?php echo base_url()?>index.php/Sb_inventory/listing_wip" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Work In Process</a>
						</div>
						<?php } ?>
						<?php if($this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Guest') {?>
						<a href="#demo6" style="padding : 7px 15px;" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#MainMenu">
							<i class="fa fa-bar-chart-o"></i>
                            <span>Report</span>
                            <i class="fa fa-angle-left pull-right"></i>
						</a>
						<div class="collapse" id="demo6">
						  <a href="<?php echo base_url()?>index.php/Sb_pemasukan_barang/detail" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Pemasukan Barang Per Dokumen</a>
						  <a href="<?php echo base_url()?>index.php/Sb_pengeluaran_barang/detail" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Pengeluaran Barang Per Dokumen</a>
						  <a href="<?php echo base_url()?>index.php/Sb_production/get_wip" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Work In Process</a>
						  <a href="<?php echo base_url()?>index.php/Sb_mutasi/listing/Bahan_Baku/Bahan_Penolong" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Mutasi Bahan Baku dan Penolong</a>
						  <a href="<?php echo base_url()?>index.php/Sb_mutasi/listing/Barang_Jadi/_" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Mutasi Barang Jadi</a>
						  <a href="<?php echo base_url()?>index.php/Sb_mutasi/listing/Reject/Scrap" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Mutasi Barang Sisa dan Scrap</a>
						  <a href="<?php echo base_url()?>index.php/Sb_mutasi/listing/Mesin_Sparepart/Peralatan_Pabrik" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Mutasi Mesin dan Peralatan</a>
						  <a href="<?php echo base_url()?>index.php/Sb_history/history_menu" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp History</a>
						</div>
						<?php } ?>
						<?php if($this->session->userdata('usertype') == 'Admin') {?>
						<a href="#demo7" style="padding : 7px 15px;" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#MainMenu">
							<i class="fa fa-bar-chart-o"></i>
                            <span>Setting</span>
                            <i class="fa fa-angle-left pull-right"></i>
						</a>
						<div class="collapse" id="demo7">
						  <a href="#SubMenu3" style="padding : 7px 15px;" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#demo3">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Barang <i class="fa fa-caret-down"></i></a>
						  <div class="collapse list-group-submenu" data-parent="#SubMenu2" id="SubMenu3">
							<a href="<?php echo base_url()?>index.php/Sb_barang/listing/Bahan_Baku" style="padding : 7px 15px;" class="list-group-item" data-parent="#SubMenu2">&nbsp &nbsp &nbsp &nbsp &nbsp Bahan Baku</a>
							<a href="<?php echo base_url()?>index.php/Sb_barang/listing/Bahan_Penolong" style="padding : 7px 15px;" class="list-group-item" data-parent="#SubMenu2">&nbsp &nbsp &nbsp &nbsp &nbsp Bahan Penolong</a>
							<a href="<?php echo base_url()?>index.php/Sb_barang/listing/Bahan_Setengah_Jadi" style="padding : 7px 15px;" class="list-group-item" data-parent="#SubMenu2">&nbsp &nbsp &nbsp &nbsp &nbsp Bahan Setengah Jadi</a>
							<a href="<?php echo base_url()?>index.php/Sb_barang/listing/Barang_Jadi" style="padding : 7px 15px;" class="list-group-item" data-parent="#SubMenu2">&nbsp &nbsp &nbsp &nbsp &nbsp Barang Jadi</a>
							<a href="<?php echo base_url()?>index.php/Sb_barang/listing/Scrap" style="padding : 7px 15px;" class="list-group-item" data-parent="#SubMenu2">&nbsp &nbsp &nbsp &nbsp &nbsp Scrap</a>
							<a href="<?php echo base_url()?>index.php/Sb_barang/listing/Mesin_Sparepart" style="padding : 7px 15px;" class="list-group-item" data-parent="#SubMenu2">&nbsp &nbsp &nbsp &nbsp &nbsp Mesin/Sparepart</a>
							<a href="<?php echo base_url()?>index.php/Sb_barang/listing/Peralatan_Pabrik" style="padding : 7px 15px;" class="list-group-item" data-parent="#SubMenu2">&nbsp &nbsp &nbsp &nbsp &nbsp Peralatan Pabrik</a>
						  </div>
						  <a href="<?php echo base_url()?>index.php/Sb_periode" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Periode</a>
						  <a href="<?php echo base_url()?>index.php/Sb_users" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp User Management</a>
						  <a href="<?php echo base_url()?>index.php/Sb_satuan" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Satuan</a>
						  <a href="<?php echo base_url()?>index.php/Sb_supplier" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Supplier</a>
						  <a href="<?php echo base_url()?>index.php/Sb_negara" style="padding : 7px 15px;" class="list-group-item">&nbsp &nbsp  <i class="fa fa-plus"></i>&nbsp Negara</a>
						</div>
						<?php } ?>
						</div>
					  </div>
					</div>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Main content -->
                <section class="content">
					<div style="font-size:small; margin-top:50px;" class="dataTables_wrapper form-inline" role="grid">
							<?php echo $this->load->view($content)?>
					</div>
					
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
		<div class="modal fade" id="myModallogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 500px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-key"></i> Change Password</h4>
          </div>

          <div class="modal-body">
            <div class="box-body">
				<form method="post" action="<?php echo base_url()?>index.php/Sb_users/changePassword">
					<div>
						<label for="old_password">Old Password</label>
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

        <!-- Bootstrap -->
        <script src="<?php echo base_url()?>template_lala/js/bootstrap.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="<?php echo base_url()?>template_lala/js/AdminLTE/app.js" type="text/javascript"></script>
        
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url()?>template_lala/js/AdminLTE/demo.js" type="text/javascript"></script>
    </body>
</html>