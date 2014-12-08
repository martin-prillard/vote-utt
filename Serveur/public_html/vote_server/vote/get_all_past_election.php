<?php

/**
 * Recupere toutes les elections actuelles
 *
 * @author Vot'UTT
 */
include '../util.php';
require_once('../model/election.php');

//REQUETES SQL
$SELECT_ALL_PAST_ELECTION = "SELECT election_id, election_label, election_time_start, election_time_end FROM election WHERE election_time_end < ? ORDER BY election_time_end";
$COUNT_ELECTION_VOTE = "SELECT COUNT(candidate_id) AS total FROM vote WHERE election_id = ?";

//Connection à la BDD
$db = connexionBDD();

//On recupere toutes les elections courrantes 
$resultats = $db->prepare($SELECT_ALL_PAST_ELECTION);
$resultats->execute(array(date('Y-m-j h:i:s')));
$resultats->setFetchMode(PDO::FETCH_OBJ);

$elections = array();

while ($row = $resultats->fetch()) {
    $election = new Election();
    $election->election_id = $row->election_id;
    $election->election_label = $row->election_label;
    $election->election_time_start = $row->election_time_start;
    $election->election_time_end = $row->election_time_end;

    //On recupere le nombre de vote total pour cette election
    $res = $db->prepare($COUNT_ELECTION_VOTE);
    $res->execute(array($election->election_id));
    $r = $res->fetch(PDO::FETCH_OBJ);
    $election->election_total_vote = $r->total;
    $res->closeCursor();

    $elections[] = $election;
}

$resultats->closeCursor();
if ($db) {
    $db = NULL;
}

$json = array(
    'elections' => $elections
);

sendResponse(200, json_encode($json));
?>