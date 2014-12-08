<?php

/**
 * Classe Candidate
 *
 * @author Vot'UTT
 */
class Candidate {

    //Champs de la BDD
            public $candidate_id,
            $candidate_name,
            $candidate_desc,
            $candidate_url_picture;
    //Champs calculés
            public $nbvote,
            $percent;

    public function toDB() {
        $object = get_object_vars($this);
        return $object;
    }

}

?>
