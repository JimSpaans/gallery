<?php
	session_start();

	if(isset($_SESSION['session_user'])){
		echo "";
	}else{
		header("Location: index.php");
	}


	include 'layout_inc/header.php';
?>

<div id="login-form"><br/>
	<div class="login_form_title">
		Login
	</div>
	<form action="" method="post">
		<input type="text" name="username" id="login_form_username" placeholder="Username"/><br/>
			<input type="password" name="password" id="login_form_username" placeholder="*******"/><br/>
			<input type="submit" name="login_button" id="login_form_button" value="Send"/>
		</form>	
	</div>

<?php
	include 'layout_inc/footer.php';
?>