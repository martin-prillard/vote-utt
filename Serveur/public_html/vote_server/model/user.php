<?php

/**
 * Classe utilisateur
 *
 * @author Vot'UTT
 */
class User {

    public $user_id,
            $user_email,
            $user_password,
            $user_time_sign_up;

    public function toDB() {
        $object = get_object_vars($this);
        return $object;
    }

}

?>
