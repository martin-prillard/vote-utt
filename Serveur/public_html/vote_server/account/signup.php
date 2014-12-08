<?php

/**
 * Création du compte de l'utilisateur
 *
 * @author Vot'UTT
 */
include '../util.php';

//ELEMENTS JSON
$error = true;
$error_msg = "";

if ($_GET["user_password"] AND $_GET["user_password_bis"] AND $_GET["user_email"]) {

    $user_email = htmlspecialchars($_GET["user_email"]);
    $user_password = htmlspecialchars($_GET["user_password"]);
    $user_password_bis = htmlspecialchars($_GET["user_password_bis"]);

    //On vérifie que l'email est valide
    if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {

        //Connection à la bdd
        $db = connexionBDD();

        //On vérifie que l'utilisateur n'existe pas déja avant de lui créer un nouveau compte
        if (!isAccountExist($db, $user_email)) {

            //On vérifie que le mot de passe entré est bien sécurisé (12 caractères ou plus avec 1 lettre minuscule, 1 lettre majuscule, 1 chiffre)
            if (check_strength($user_password) == 100) {

                //On vérifie que l'utilisateur a bien tapé un mot de passe identique dans les deux champs
                if (strcmp($user_password, $user_password_bis) == 0) {

                    //On cree une cle de validation
                    $user_key_validation = md5(time() . rand());
  
                    //On cree un compte pour l'utilisateur
                    createAccount($db, $user_email, $user_password, $user_key_validation);

                    //On envoie le mail de validation du compte avec la clé de validation
                    sendValidationEmail($user_email, $user_key_validation);

                    $error = false;
                } else {
                    $error_msg = "Veuillez entrer le même mot de passe dans les deux champs.";
                }
            } else {
                $error_msg = "Mot de passe sécurisé à " . check_strength($user_password) . "% (il faut 12 caractères ou plus sans espaces, avec 1 lettre minuscule, 1 lettre majuscule et 1 chiffre).";
            }
        } else {
            $error_msg = "Un compte existe déja pour l'adresse email : " . $user_email;
        }

        //Fermeture de la connexion a la base
        if ($db) {
            $db = NULL;
        }
    } else {
        $error_msg = "Veuillez entrer une adresse email valide.";
    }
} else {
    $error_msg = "Veuillez entrer un mot de passe correct et une adresse email valide.";
}

//JSON
$json = array(
    'error' => $error,
    'error_msg' => $error_msg
);

sendResponse(200, json_encode($json));

/**
 * Creation du compte utilisateur
 */
function createAccount($db, $user_email, $user_password, $user_key_validation) {
    $CREATE_ACCOUNT = "INSERT INTO user (user_email, user_password, user_key_validation) VALUES (?, ?, ?)";

    //On génere un grain de sel aléatoire 
    $user_salt = genererStr(4);
    //On chiffre et sale deux fois
    $password = encodeSalt($user_password, $user_salt);

    //On créer son compte
    $resultats = $db->prepare($CREATE_ACCOUNT);
    $resultats->execute(array( $user_email, $password,  $user_key_validation ));
    $resultats->closeCursor();
}

?>
