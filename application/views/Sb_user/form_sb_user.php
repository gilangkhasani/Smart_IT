<!doctype html>
<html lang="en">
	<head>
		<title>Form Supplier</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
	</head>
	<body>
		<?php
			if(isset($user)){
				$usernames = $user->username;
				$password = $user->password;
				$first_name = $user->first_name;
				$last_name = $user->last_name;
			} else {
				$usernames = "";
				$password = "";
				$first_name = "";
				$last_name = "";
			}
		?>	
		<form method="post" action="<?php echo base_url()?>index.php/Sb_users/save">
			<div>
				<label for="username">Username</label>
				<div>
					<input type="text" name="username" id="username" value="<?php echo $usernames?>">
				</div>
			</div>
			<div>
				<label for="password">Password</label>
				<div>
					<input type="password" name="password" id="password" value="<?php echo $password?>">
				</div>
			</div>
			<div>
				<label for="first_name">First Name</label>
				<div>
					<input type="text" name="first_name" id="first_name" value="<?php echo $first_name?>">
				</div>
			</div>
			<div>
				<label for="last_name">Last Name</label>
				<div>
					<input type="text" name="last_name" id="last_name" value="<?php echo $last_name?>">
				</div>
			</div>
			<div>
				<input type="submit" value="Save">
				<input type="reset" value="Reset">
			</div>
			<?php
				if($usernames != ""){
					echo "<input type='hidden' value='$usernames' name='usernames'>";
				}
			?>
		</form>
	</body>
</html>	