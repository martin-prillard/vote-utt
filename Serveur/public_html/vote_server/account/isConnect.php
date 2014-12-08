<?php

/**
 * Verification que l'utilisateur est connecté
 *
 * @author Vot'UTT
 */
include '../util.php';

//ELEMENTS JSON
$is_connect = false;

//Connection à la BDD
$db = connexionBDD();

if (testToken($db, $_GET["user_id"], $_GET["user_token"])) {
    $is_connect = true;
}

//Fermeture de la connexion a la base
if ($db) {
    $db = NULL;
}

//JSON
$json = array(
    'is_connect' => $is_connect
);

sendResponse(200, json_encode($json));
?>
