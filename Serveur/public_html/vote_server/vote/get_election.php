<?php

/**
 * Recupere toutes les elections
 *
 * @author Vot'UTT
 */
include '../util.php';
require_once('../model/election.php');
require_once('../model/candidate.php');
require_once('../model/vote.php');

//ELEMENTS JSON
$error = true;
$error_msg = "";
$candidates = array();

$SELECT_CANDIDATES_ELECTION = "SELECT DISTINCT c.*, IFNULL(count(v.candidate_id),0) AS nbvote FROM candidate c LEFT JOIN election_candidate ec ON c.candidate_id=ec.candidate_id LEFT JOIN vote v ON c.candidate_id=v.candidate_id AND v.election_id = ec.election_id AND ec.election_id = ? WHERE c.candidate_id IN (SELECT candidate_id FROM election_candidate WHERE election_id = ?)GROUP BY c.candidate_id ORDER BY nbvote";
$COUNT_ELECTION_VOTE = "SELECT COUNT(candidate_id) AS total FROM vote WHERE election_id = ?";
$COUNT_CANDIDATE_VOTE = "SELECT COUNT(candidate_id) AS nbvote FROM vote WHERE election_id = ? AND candidate_id = ?";



if (isset($_GET["election_id"])) {

    //Connection à la BDD
    $db = connexionBDD();

    //On recupere l'id de l'election
    $election_id = htmlspecialchars($_GET["election_id"]);

    //On recupere les candidats pour cette election
    $resultats = $db->prepare($SELECT_CANDIDATES_ELECTION);
    $resultats->execute(array($election_id, $election_id));
    $resultats->setFetchMode(PDO::FETCH_OBJ);

    while ($row = $resultats->fetch()) {
        $candidate = new Candidate();
        $candidate->candidate_id = $row->candidate_id;
        $candidate->candidate_name = $row->candidate_name;
        $candidate->candidate_desc = $row->candidate_desc;
        $candidate->candidate_url_picture = $row->candidate_url_picture;
        array_push($candidates, $candidate);
    }

    $resultats->closeCursor();

    //On recupere le nombre de vote total pour cette election
    $resultats = $db->prepare($COUNT_ELECTION_VOTE);
    $resultats->execute(array($election_id));
    $row = $resultats->fetch(PDO::FETCH_OBJ);

    $total = $row->total;
    $resultats->closeCursor();

    //On recupere leurs nombre de vote respectifs
    foreach ($candidates as $candidate) {
        $resultats = $db->prepare($COUNT_CANDIDATE_VOTE);
        $resultats->execute(array($election_id, $candidate->candidate_id));
        $row = $resultats->fetch(PDO::FETCH_OBJ);
        $candidate->nbvote = $row->nbvote;
        if ($total == 0)
            $candidate->percent = 0;
        else
            $candidate->percent = round(($candidate->nbvote / $total) * 100, 2);
        $resultats->closeCursor();
    }

    $error = false;

    if ($db) {
        $db = NULL;
    }
} else {
    $error_msg = "Election invalide";
}

//JSON
$json = array(
    'error' => $error,
    'error_msg' => $error_msg,
    'candidates' => $candidates
);

sendResponse(200, json_encode($json));
?>
