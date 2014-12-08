<?php

/**
 * Me permet de voter pour un candidat pour une election
 *
 * @author Vot'UTT
 */
include '../util.php';
require_once('../model/vote.php');

//ELEMENTS JSONF
$error = true;
$error_msg = "";

//Connection à la BDD
$db = connexionBDD();

//On verifie que l'election est toujours d'actualité
if (testCurrentElection($db, $_GET["election_id"])) {

    //On verifie que c'est bon le token
    if (testToken($db, $_GET["user_id"], $_GET["user_token"])
            AND $_GET["election_id"]
            AND $_GET["candidate_id"]) {

        //On recupere l'id de l'election et du candidat prefere
        $election_id = htmlspecialchars($_GET["election_id"]);
        $candidate_id = htmlspecialchars($_GET["candidate_id"]);
        $user_id = htmlspecialchars($_GET["user_id"]);

        //On verifie que l'utilisateur n'a pas deja vote pour cette election, il peut voter
        if (canVote($db, $user_id, $election_id)) {
            doVote($db, $user_id, $candidate_id, $election_id); //On vote
            $error = false;
        } else {
            $error_msg = "Vous avez déja voté pour cette élection !";
        }
    } else {
        $error_msg = "Authentifiez vous pour voter !";
    }

    //Fermeture de la connexion a la base
    if ($db) {
        $db = NULL;
    }
} else {
    $error_msg = "L'election est terminée, vous ne pouvez plus vote !";
}

//JSON
$json = array(
    'error' => $error,
    'error_msg' => $error_msg
);

sendResponse(200, json_encode($json));

/**
 * Test si l'utilisateur n'a pas deja vote pour une election
 */
function canVote($db, $user_id, $election_id) {
    $TEST_CAN_VOTED = "SELECT user_id FROM vote WHERE user_id = ? AND election_id = ?";
    $canVote = false; //Par defaut, il a deja vote


    if (!is_null($user_id) AND !is_null($election_id)) {
        $resultats = $db->prepare($TEST_CAN_VOTED);
        $resultats->execute(array($user_id, $election_id));
        $resultats->setFetchMode(PDO::FETCH_OBJ);

        //L'utilisateur peut voter
        if ($resultats->rowCount() == 0) {
            $canVote = true;
        }
        $resultats->closeCursor();
    }

    return $canVote;
}

/**
 * Fonction pour voter
 */
function doVote($db, $user_id, $candidate_id, $election_id) {
    $INSERT_VOTE = "INSERT INTO vote (user_id, candidate_id, election_id) VALUES (?, ?, ?)";

    $resultats = $db->prepare($INSERT_VOTE);
    $resultats->execute(array($user_id, $candidate_id, $election_id));
    $resultats->closeCursor();
}

?>
