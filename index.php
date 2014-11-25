<?php
session_start();
echo $_SESSION['session_user'];
include 'php/classes/classes.php';



if(isset($_POST['login_button'])){
	$user = new User();

	$username = $_POST['username'];
	$password = $_POST['password'];

	$errors = array();

	if(strlen($username) == ""){
		array_push($errors, "Please fill in your username.");
	}

	if(strlen($password) == ""){
		array_push($errors, "Please fill in your password.");
	}

	if(strlen($username) < 5){
		array_push($errors, "Your username has to be at least 5 characters long.");
	}

	if(strlen($password) < 6){
		array_push($errors, "Your password has to be at least 6 characters long.");
	}

	if(count($errors) == 0){
		$login = $user->Login($username, $password);
		if($user->Login($username, $password)!= false){
			$_SESSION['session_user'] = $username;
			header("Location: admin_panel.php");
		}else{
			echo "Ja nee";
		}
	}else{
		print_r($errors);
	}



	/*
	echo '<pre>';
	print_r($login);
	echo '</pre>';	

	if($login = false){
		
	}else{
		
	}*/
}

?>
<html>
	<head>
		<title>Gallery</title>
		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
		<link href="css/main.css" rel="stylesheet" type="text/css"/>
		<link href="css/mobile.css" rel="stylesheet" type="text/css"/>
		<link href="css/forms.css" rel="stylesheet" type="text/css"/>
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="js/background.js"></script>
	</head>
	<body>
		<div id="container">
			<div id="background" class="img_0"></div>
			<div id="fader" class="bg_div"></div>

			<div id="header">
				<div id="header-content">
					<div class="header-logo">Gallery</div>
				</div>
			</div><br/><br/><br/><br/>
			<!--<div id="content-div"><div id="content">-->
			
			<div id="login-form"><br/>
			<div class="login_form_title">
				Login
			</div>
				<form action="" method="post">
					<input type="text" name="username" class="form_input" id="login_form_username" placeholder="Username"/><br/>
					<input type="password" name="password" class="form_input" id="login_form_username" placeholder="*******"/><br/>
					<input type="submit" name="login_button" class="form_button" id="login_form_button" value="Send"/>
				</form>	
			</div>
			<!--</div></div>-->
			<br/><br/>
			<div id="footer">
				<div id="footer-content">
					<div class="footer-link-icons">
						<div class="copy-right">Copyrights &copy <?php echo date("Y"); ?></div>
						<table class="icon-tabel">
							<tr>
								<td class="td-footer-links"><img src="media/icons/facebook32-icon.png" style="width:75%;"/></td>
								<td class="td-footer-links"><img src="media/icons/email32-icon.png"/></td>
								<td class="td-footer-links"><img src="media/icons/twitter32-icon.png" style="width:80	%;"/></td>
							</tr>	
						</table>	
					</div>	
				</div>
			</div>
		</div>
	</body>
</html>	