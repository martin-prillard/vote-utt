<?
//On prépare l'utilisation des variables de fonctions (variable qui sont stockées sur le serveur pour chaque session ouverte)
session_start();
// Fichier auth.php
// On intègre les informations de connexion à la base de données ainsi que le fichier (ou librairie fonctions.php)
include("conf.site");
include("fonctions.php");


//securimage
//
include_once 'securimage/securimage.php';
$securimage = new Securimage();

if ($securimage->check(htmlspecialchars($_POST['captcha_code'])) == false) {
	// the code was incorrect
	// you should handle the error so that the form processor doesn't continue

	// or you can use the following code if there is no validation or you do not know how
	echo "The security code entered was incorrect.<br /><br />";
	echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
	exit;
}




// On intialise la connexion à la base de données
$bdd = new PDO('mysql:host='.$BDD_hote.';dbname='.$BDD_nmDB, $BDD_user, $BDD_pass);
// On récupère ce que l'utilisateur à saisi, si il n'a rien saisi (login ou mot de passe) on le renvoi sur la page de création de compte

if(isset($_POST['login']) && isset($_POST['password']))
{
	// Si l'utilisateur à rempli tous les champs on vérifie ce qu'il à saisit
	// En recherchant dans la base de donner, un login et un mot de passe crypté correspondant à ce qu'il à saisi.
	// Si on a pas de réponse, alors il y a une erreur d'authentification
	// Sinon l'utilisateur a réussi à s'authentifier
				
	//Recuperer le password chiffré associé
	//
	$stmt = $bdd->prepare("SELECT user_password FROM user WHERE user_email=:user_login AND `user_admin`='1'");
	$stmt->bindParam(':user_login', htmlspecialchars($_POST['login']));
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_OBJ);

	$res_password = $row->user_password;
	//recuperer le sel
	//
	$user_salt = substr($res_password, -4); //On extrait le grain de sel du mot de passe
	$pass_final = md5(sha1(htmlspecialchars($_POST['password']).$user_salt).$user_salt).$user_salt;


	$stmt = $bdd->prepare("SELECT * FROM user WHERE user_email=:user_login AND user_password = :user_password AND `user_admin`='1'");
	$stmt->bindParam(':user_login', htmlspecialchars($_POST['login']));
	$stmt->bindParam(':user_password', $pass_final);
	$stmt->execute();

	$row = $stmt->fetch(PDO::FETCH_OBJ);

	$requete = $row->user_email;

	if($requete)
	{
		// Nous avons bien le bon utilisateur
		// Nous créons la variable de session
		$_SESSION['auth_admin']="AUTH : OK";
		header("location: admin.php");
	}
	else
	{
		// Nous n'avons pas les bonnes informations
		// On renvoi vers la page d'authentification
		header("location: index.php");
	}
}

else
{
	// Formulaire incomplet
	// On renvoit vers la page précédente
	header("location: index.php");
}
?>