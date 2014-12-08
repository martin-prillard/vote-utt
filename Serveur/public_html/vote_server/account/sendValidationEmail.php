<?php

/**
 * Envoie du mail de validation du compte à l'utilisateur
 *
 * @author Vot'UTT
 */
include '../util.php';
require_once('../model/user.php');

//REQUETES SQL
$UPDATE_KEY_VALIDATION = "UPDATE user SET user_key_validation = ? WHERE user_email = ?";

if ($_GET["user_email"]) {

	//Connection à la BDD
	$db = connexionBDD();

	$user_email = htmlspecialchars($_GET["user_email"]);

	//On cree une cle de validation
	$user_key_validation = md5(time() . rand());
	//Qu'on ajoute en base
	$resultats = $db->prepare($UPDATE_KEY_VALIDATION);
    $resultats->execute(array($user_key_validation, $user_email));
    $resultats->closeCursor();
	
	//Fermeture de la connexion a la base
	if ($db) {
		$db = NULL;
	}

	//On envoie le mail de validation du compte avec la clé de validation
	sendValidationEmail($user_email, $user_key_validation);
}
?>
