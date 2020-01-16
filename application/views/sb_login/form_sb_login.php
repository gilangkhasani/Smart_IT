<!doctype html>
<html lang="en" class="bg-black">
<head>
	<meta charset="UTF-8">
    <title>IT Inventory | Log in</title>
	<script type="text/javascript">
	
		function validasi()
		{
			var email = document.getElementById('email');
			var pass = document.getElementById('password');
			if(email.value == ""){
				alert('email kosong');
				return false
			}
			if(pass.value == ""){
				alert('password kosong');
				return false
			}
			return true;
		}
	</script>
	<meta http-equiv="PRAGMA" content="NO-CACHE">
	<meta http-equiv="Expires" content="-1">
	<meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
		<link rel="icon" type="image/ico" href="<?php echo base_url()?>template_lala/img/smart.jpg">
	<!-- Bootstrap -->
        <script src="<?php echo base_url()?>template_lala/js/bootstrap.min.js" type="text/javascript"></script>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url()?>template_lala/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url()?>template_lala/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url()?>template_lala/css/AdminLTE.css" rel="stylesheet" type="text/css" />
		
        <link href="<?php echo base_url()?>template_lala/css/font-ajax.css" rel="stylesheet" type="text/css" />
		
		<link href="<?php echo base_url()?>template_lala/css/Kaushan_Script.css" rel="stylesheet" type="text/css" />
</head>
	<body class="bg-black" oncontextmenu='return false;'  ondragstart='return false' onselectstart='return false' style='-moz-user-select: none; cursor: default;'>
        <div class="form-box" id="login-box">
            <div class="header">Smart IT Inventory
				<h5><?php echo $this->session->flashdata('message');?></h5>
			</div>
            <form action="<?php echo base_url();?>index.php/Sb_login/doLogin" method="post">
                <div class="body bg-gray"></br>
                    <div class="input-group">
                        <span class="input-group-addon">​<i class="fa fa-user"></i></span><input type="text" name="username" id="username" class="form-control" placeholder="Username"/>
                    </div></br>
                    <div class="input-group">
                        <span class="input-group-addon">​<i class="fa fa-key"></i>​</span>​<input type="password" name="password" id="password" class="form-control" placeholder="Password"/>
                    </div></br>   
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Login</button>  
                    <button type="reset" class="btn bg-olive btn-block">Reset</button>  
                </div>
            </form>

            <div class="margin text-center">
                <span>IT Inventory Kawasan Berikat (v1.50b)</span></br></br>
                <span style="font-size:30px;">
					<?php foreach($profil as $tes){
						echo $tes->company_name;
					} ?>
				</span></br></br></br>
				<span>(c) bEE Computer System</span>
            </div>
        </div>     

    </body>
</html>