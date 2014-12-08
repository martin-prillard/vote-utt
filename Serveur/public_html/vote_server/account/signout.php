<?php

/**
 * Déconnexion du compte de l'utilisateur
 *
 * @author Vot'UTT
 */
include '../util.php';
require_once('../model/user.php');

//REQUETES SQL
$DELETE_TOKEN = "UPDATE user SET user_token = NULL, user_token_dead = NULL WHERE user_id = ?";

//Connection à la BDD
$db = connexionBDD();

if (testToken($db, $_GET["user_id"], $_GET["user_token"])) {

    //On recupere l'id de l'utilisateur
    $user_id = htmlspecialchars($_GET["user_id"]);

    //On supprime le token
    $resultats = $db->prepare($DELETE_TOKEN);
    $resultats->execute(array($user_id));
    $resultats->closeCursor();
}

//Fermeture de la connexion a la base
if ($db) {
    $db = NULL;
}
?>
