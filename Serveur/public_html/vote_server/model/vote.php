<?php

/**
 * Classe de vote
 *
 * @author Vot'UTT
 */
class Vote {

    public $user_id,
            $candidate_id,
            $election_id,
            $vote_time_voted;

    public function toDB() {
        $object = get_object_vars($this);
        return $object;
    }

}

?>
