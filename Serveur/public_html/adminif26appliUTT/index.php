<?
session_start();
if(isset($_SESSION['auth_admin']))
{
header("location:admin.php");
}
?>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Administration du site</title>
	<link href="css/global.css" rel="stylesheet" type="text/css" />
</head>
	
<body>
	<div id="page">
		<div id="top">
			<center>
			<h1>Administration des données de l'appli VOTE-UTT</h1>
			</center>
		</div>

		<div id="form">
			<center>
			<form action="auth.php" method="post">
				<div id="form_bg">
					<p class="label_form">Identifiant Admin</p>
					<input class="input_form" type="text" name="login"/>

					<p class="label_form2">Mot de passe Admin</p>
					<input class="input_form" type="password" name="password" />
					<br />
				</div>
				
				<div id="captcha_div">
				<img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" /><br/>
				<a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
				<p class="label_form_captcha">Entrez le code ci-dessus</p>
				<input class="input_form" type="text" name="captcha_code" size="10" maxlength="6" />
				</div>
				
				<input id="btn_login" type="submit" value="Se connecter" />
			</form>
			</center>
		</div>
	</div>
</body>
<html>