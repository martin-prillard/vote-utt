<?php

/**
 * Connexion au compte de l'utilisateur
 *
 * @author Vot'UTT
 */
include '../util.php';
require_once('../model/user.php');

//ELEMENTS JSON
$error_code = 1;
$token = "";


if ($_GET["user_email"] AND $_GET["user_password"]) {

    $user_email = htmlspecialchars($_GET["user_email"]);
    $user_password = htmlspecialchars($_GET["user_password"]);

    //Connexion à la bdd
    $db = connexionBDD();

    //Verification si l'email de l'utilisateur correspond à un compte
    if (isAccountExist($db, $user_email)) {
        //On recupere son id 
        $user_id = getIdFromEmailUser($db, $user_email);
        //Verification du nombre de tentatives de connexion pour savoir si l'utilisateur peut se connecter
        if (canAttemptSignin($db, $user_id)) {
			//Verification que c'est le bon email et mot de passe
			if (canSignin($db, $user_id, $user_password)) {
				//Verification que le compte est valide
				if (isValidedAccount($db, $user_id)) {
                    //Connexion au compte de l'utilisateur
                    $token = md5(time() . rand()); //On genere un token aleatoirement
                    connection($db, $user_id, $token);
                    $error_code = 0;
                } else {
                    $error_code = 5;
                }
            } else {
                $error_code = 4;
            }
        } else {
            $error_code = 3;
        }
    } else {
        $error_code = 2;
    }

    //Fermeture de la connexion a la base
    if ($db) {
        $db = NULL;
    }
} else {
    $error_code = 1;
}

//JSON
$json = array(
	'error_code' => $error_code,
    'user_id' => $user_id,
    'token' => $token
);

sendResponse(200, json_encode($json));

/**
 * Test si le compte a ete active
 */
function canAttemptSignin($db, $user_id) {
    $TEST_ATTEMPT_SIGNIN_MAX = "SELECT COUNT(attempt_signin_id) AS nb_attempt FROM attempt_signin WHERE user_id = ? AND attempt_signin_state = 0 AND attempt_signin_time >= ?";
    $canAttemptSignin = false; //Par defaut, il ne peut pas se connecter
    $attempt_fail_max = 3;

    if (!is_null($user_id)) {
        $resultats = $db->prepare($TEST_ATTEMPT_SIGNIN_MAX);
        $resultats->execute(array($user_id, date('Y-m-j h:i:s', strtotime("-30 minutes")))); //Droit à trois tentatives d'échec de connexion toute les 30minutes
        $row = $resultats->fetch(PDO::FETCH_OBJ);

        //l'utilisateur peut tenter de se connecter
        if ($resultats->rowCount() == 1 AND $row->nb_attempt <= $attempt_fail_max) {
            $canAttemptSignin = true;
        }
        $resultats->closeCursor();
    }

    return $canAttemptSignin;
}

/**
 * Test si le compte a ete active
 */
function canSignin($db, $user_id, $user_password) {
    $SELECT_PASSWORD = "SELECT user_password FROM user WHERE user_id = ?";
    $TEST_ATTEMPT_SIGNIN = "SELECT user_id FROM user WHERE user_id = ? AND user_password = ?";
    $canSignin = false; //Par defaut, la connexion échoue

    if (!is_null($user_id)) {
        //On récupère les grains de sels
        $resultats = $db->prepare($SELECT_PASSWORD);
        $resultats->execute(array($user_id));
        $row = $resultats->fetch(PDO::FETCH_OBJ);
        $user_salt = substr($row->user_password, -4); //On extrait le grain de sel du mot de passe
        $resultats->closeCursor();

        $resultats = $db->prepare($TEST_ATTEMPT_SIGNIN);
        $resultats->execute(array($user_id, encodeSalt($user_password, $user_salt)));
        $resultats->setFetchMode(PDO::FETCH_OBJ);

        //L'utilisateur se connecte
        if ($resultats->rowCount() == 1) {
            $canSignin = true;
        }
        $resultats->closeCursor();
    }

    if ($canSignin) {
        $signinState = 1;
    } else {
        $signinState = 0;
    }

    //On rajoute la tentative de connexion en base
    addAttemptSignin($db, $user_id, $signinState);

    return $canSignin;
}

/**
 * Rajoute une tentative de connexion en base
 */
function addAttemptSignin($db, $user_id, $signinState) {
    $INSERT_ATTEMPT_SIGNIN = "INSERT INTO attempt_signin (user_id, attempt_signin_hostname, attempt_signin_remote_addr, attempt_signin_http_x_forwarded_for, attempt_signin_browser, attempt_signin_state) VALUES (?, ?, ?, ?, ?, ?)";

    //Rajout dans les tentatives de connexion
    $ua = getBrowser(); //Récupération du navigateur
    $browser = $ua['name'] . "_" . $ua['version'] . "_" . $ua['platform'] . "_" . $ua['userAgent'];
    $resultats = $db->prepare($INSERT_ATTEMPT_SIGNIN);
    $resultats->execute(array($user_id, gethostname(), $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_X_FORWARDED_FOR'], $browser, $signinState));
    $resultats->closeCursor();
}

/**
 * Connexion au compte utilisateur
 */
function connection($db, $user_id, $token) {
    $UPDATE_TOKEN = "UPDATE user SET user_token = ?, user_token_dead = ? WHERE user_id = ?";

    $resultats = $db->prepare($UPDATE_TOKEN);
    $resultats->execute(array($token, date('Y-m-j h:i:s', strtotime("+1 day")), $user_id)); //Durée de vie du token de 24 heures
    $resultats->closeCursor();
}

?>
