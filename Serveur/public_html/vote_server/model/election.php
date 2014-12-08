<?php

/**
 * Classe Election
 *
 * @author Vot'UTT
 */
class Election {

    //Champs de la BDD
            public $election_id,
            $election_label,
            $election_time_start,
            $election_time_end;
    //Champs calculé
            public $election_total_vote;

    public function toDB() {
        $object = get_object_vars($this);
        return $object;
    }

}

?>
