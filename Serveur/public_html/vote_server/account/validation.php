<?php

/**
 * Validation compte de l'utilisateur
 *
 * @author Vot'UTT
 */
include '../util.php';
require_once('../model/user.php');

$SELECT_USER_KEY_VALIDATION = "SELECT user_valided_account, user_key_validation FROM user WHERE user_email = ?";

if ($_GET["user_email"] AND $_GET["user_key_validation"]) {

    $user_email = htmlspecialchars($_GET["user_email"]);
    $user_key_validation = htmlspecialchars($_GET["user_key_validation"]);

    //Connexion &agrave; la bdd
    $db = connexionBDD();

    $resultats = $db->prepare($SELECT_USER_KEY_VALIDATION);
    $resultats->execute(array($user_email));
    $row = $resultats->fetch(PDO::FETCH_OBJ);

    //On recupere l'etat du compte et la cle en base
    $user_valided_account = $row->user_valided_account;
    $user_key_validation_db = $row->user_key_validation;

    $resultats->closeCursor();

    // On teste la valeur de la variable $actif recupere dans la BDD
    if ($user_valided_account == '1') { // Si le compte est deja actif on pr&eacute;vient
		echo '<html><head><meta http-equiv="Content-type" content="text/html; charset=utf-8" /><title>Compte activ&eacute; !</title></head><body><p>Votre compte est d&eacute;j&agrave; actif !</p></body></html>';
    } else { // Si ce n'est pas le cas on passe aux comparaisons
        if ($user_key_validation == $user_key_validation_db) { // On compare nos deux cles	
            // La requête qui va passer notre champ actif de 0 &agrave; 1
            validateAccount($db, $user_email);
            
            // Si elles correspondent on active le compte !	
            echo '<html><head><meta http-equiv="Content-type" content="text/html; charset=utf-8" /><title>Compte activ&eacute; !</title></head><body><p>Votre compte a bien &eacute;t&eacute; activ&eacute; !</p></body></html>';
        } else { // Si les deux cl&eacute;s sont differentes on provoque une erreur...
            echo '<html><head><meta http-equiv="Content-type" content="text/html; charset=utf-8" /><title>Compte activ&eacute; !</title></head><body><p>Erreur ! Votre compte ne peut être activ&eacute;... veuillez vous addresser &agrave; votutt.noreplay@gmail.com</p></body></html>';
        }
    }

    //Fermeture de la connexion a la base
    if ($db) {
        $db = NULL;
    }
} else { 
    echo '<html><head><meta http-equiv="Content-type" content="text/html; charset=utf-8" /><title>Compte activ&eacute; !</title></head><body><p>Erreur ! Votre compte ne peut être activ&eacute;... veuillez vous addresser &agrave; votutt.noreplay@gmail.com</p></body></html>';
}

/**
 * Validatation du compte
 */
function validateAccount($db, $user_email) {
    $VALIDATE_ACCOUNT = "UPDATE user SET user_valided_account = 1 WHERE user_email = ?";

    $resultats = $db->prepare($VALIDATE_ACCOUNT);
    $resultats->execute(array($user_email));
    $resultats->closeCursor();
}

?>
