<?php

/**
 * Fonctions generiques
 *
 * @author Vot'UTT
 */

/**
 * Helper method to get a string description for an HTTP status code
 * From http://www.gen-x-design.com/archives/create-a-rest-api-with-php/ 
 */
function getStatusCodeMessage($status) {
    // these could be stored in a .ini file and loaded
    // via parse_ini_file()... however, this will suffice
    // for an example
    $codes = Array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => '(Unused)',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported'
    );

    return (isset($codes[$status])) ? $codes[$status] : '';
}

/**
 * Helper method to send a HTTP response code/message
 */
function sendResponse($status = 200, $body = '', $content_type = 'text/html') {
    $status_header = 'HTTP/1.1 ' . $status . ' ' . getStatusCodeMessage($status);
    header($status_header);
    header('Content-type: ' . $content_type);
    echo $body;
}

/**
 * calcul un pourcentage
 */
function GetPercentage($a, $b) {
    return (($b / $a) * 100);
}

/**
 * Retourne un pourcentage du niveau de robustesse du mot de passe
 */
function check_strength($user_password) {
    $characters = 0;
    $capitalletters = 0;
    $loweletters = 0;
    $number = 0;

    if (strlen ($user_password) > 11) {
        $characters = 1;
    } else {
        $characters = 0;
    };
    if (preg_match('/[A-Z]/', $user_password)) {
        $capitalletters = 1;
    } else {
        $capitalletters = 0;
    };
    if (preg_match('/[a-z]/', $user_password)) {
        $loweletters = 1;
    } else {
        $loweletters = 0;
    };
    if (preg_match('/[0-9]/', $user_password)) {
        $number = 1;
    } else {
        $number = 0;
    };

    $total = $characters + $capitalletters + $loweletters + $number;

    return GetPercentage(4, $total);
}

/**
 * Envoi un mail de validation du compte à l'utilisateur
 */
function sendValidationEmail($user_email, $user_key_validation) {
    if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $user_email)) { // On filtre les serveurs qui rencontrent des bogues.
        $passage_ligne = "\r\n";
    } else {
        $passage_ligne = "\n";
    }
    //=====Déclaration des messages au format texte et au format HTML.
    $message_html = '<html><head></head><body><b>bonjour</b>, <br /><br />Merci d\'avoir créé votre compte client sur Vot\'UTT. <br /><br />Pour activer votre compte, veuillez copier/coller le lien suivant dans votre navigateur internet :<br />  <br />
	
	<a href="http://www.vote-utt.url.ph/vote_server/account/validation.php?user_email=' . $user_email . '&user_key_validation=' . $user_key_validation . '">http://www.vote-utt.url.ph/vote_server/account/validation.php?user_email=' . $user_email . '&user_key_validation=' . $user_key_validation . '</a>

	<br /><br /> ---------------<br />Si vous n\'avez pas créé de compte sur Vot\'UTT, ignorez cet email.<br />Ceci est un mail automatique, merci de ne pas y répondre.</body></html>';
    //==========
    //=====Création de la boundary
    $boundary = "-----=" . md5(rand());
    //==========
    //=====Définition du sujet.
    $sujet = "Validation compte Vot'UTT";
    //=========
    //=====Création du header de l'e-mail.
    $header = "From: \"votutt.noreplay\" <votutt.noreplay@gmail.com>" . $passage_ligne;
    $header.= "Reply-to: \"Vot'UTT\" <votutt.noreplay@gmail.com>" . $passage_ligne;
    $header.= "MIME-Version: 1.0" . $passage_ligne;
    $header.= "Content-Type: multipart/alternative;" . $passage_ligne . " boundary=\"$boundary\"" . $passage_ligne;
    //==========
    //=====Création du message.
    $message = $passage_ligne . "--" . $boundary . $passage_ligne;
    //=====Ajout du message au format HTML
    $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"" . $passage_ligne;
    $message.= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
    $message.= $passage_ligne . $message_html . $passage_ligne;
    //==========
    $message.= $passage_ligne . "--" . $boundary . "--" . $passage_ligne;
    $message.= $passage_ligne . "--" . $boundary . "--" . $passage_ligne;
    //==========
    //=====Envoi de l'e-mail.
    mail($user_email, $sujet, $message, $header);
    //==========
}

/**
 * Genere une chaine aleatoire
 */
function genererStr($longueur) {
    // initialiser la variable $mdp
    $mdp = "";

    // Définir tout les caractères possibles dans le mot de passe, 
    // Il est possible de rajouter des voyelles ou bien des caractères spéciaux
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

    // obtenir le nombre de caractères dans la chaîne précédente
    // cette valeur sera utilisé plus tard
    $longueurMax = strlen($possible);

    if ($longueur > $longueurMax) {
        $longueur = $longueurMax;
    }

    // initialiser le compteur
    $i = 0;

    // ajouter un caractère aléatoire à $mdp jusqu'à ce que $longueur soit atteint
    while ($i < $longueur) {
        // prendre un caractère aléatoire
        $caractere = substr($possible, mt_rand(0, $longueurMax - 1), 1);

        // vérifier si le caractère est déjà utilisé dans $mdp
        if (!strstr($mdp, $caractere)) {
            // Si non, ajouter le caractère à $mdp et augmenter le compteur
            $mdp .= $caractere;
            $i++;
        }
    }

    // retourner le résultat final
    return $mdp;
}

function connexionBDD() {
    //Connection à la bdd
    $config = require('config.php');
    return new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
}

/**
 * Chiffre et sale un mot de passe deux fois de suite
 */
function encodeSalt($passwordNatif, $salt) {

    //On concatene le mot de passe et le grain de sel
    $password = $passwordNatif . $salt;
    //On chiffre le mot de passe salé avec sha1
    $password = sha1($password);
    //On ajoute le grain de sel au mot de passe chiffré
    $password .= $salt;
    //On rechiffre le tout avec md5
    $password = md5($password);
    //On rajoute le grain de sel une dernière fois
    $password .= $salt;

    return $password;
}

/**
 * Test si l'election est bien une election courrante
 */
function testCurrentElection($db, $election_id) {

    $TEST_CURRENT_ELECTION = "SELECT election_time_end FROM election WHERE election_id = ? AND election_time_end > ?";
    $isCurrentElection = false; //Par defaut, l'election n'est pas courante

    if (!is_null($election_id)) {
        $resultats = $db->prepare($TEST_CURRENT_ELECTION);
        $resultats->execute(array($election_id, date('Y-m-j h:i:s')));
        $row = $resultats->fetch(PDO::FETCH_OBJ);
        $electionTimeEnd = $row->election_time_end;

        //L'election est courante
        if (!IS_NULL($electionTimeEnd)) {
            $isCurrentElection = true;
        }
        $resultats->closeCursor();
    }

    return $isCurrentElection;
}

/**
 * Retourne l'id de l'utilisateur en fonction de son email
 */
function getIdFromEmailUser($db, $user_email) {

    $SELECT_ID_USER = "SELECT user_id FROM user WHERE user_email = ?";

    $resultats = $db->prepare($SELECT_ID_USER);
    $resultats->execute(array($user_email));
    $row = $resultats->fetch(PDO::FETCH_OBJ);
    $user_id = $row->user_id;
    $resultats->closeCursor();

    return $user_id;
}

/**
 * Test si le compte a ete active
 */
function isValidedAccount($db, $user_id) {
    $TEST_VALIDED_ACCOUNT = "SELECT user_valided_account FROM user WHERE user_id = ?";
    $isValidedAccount = false; //Par defaut, il n'est pas valide

    if (!is_null($user_id)) {
        $resultats = $db->prepare($TEST_VALIDED_ACCOUNT);
        $resultats->execute(array($user_id));
        $row = $resultats->fetch(PDO::FETCH_OBJ);
        $user_valided_account = $row->user_valided_account;

        //Le compte est valide
        if ($user_valided_account == 1) {
            $isValidedAccount = true;
        }
        $resultats->closeCursor();
    }

    return $isValidedAccount;
}

/**
 * Test si le compte a ete active
 */
function isAccountExist($db, $user_email) {
    $TEST_ACCOUNT_EXIST = "SELECT user_id FROM user WHERE user_email = ?";
    $accountExist = false; //Par defaut, le compte n'existe pas

    if (!is_null($user_email)) {
        $resultats = $db->prepare($TEST_ACCOUNT_EXIST);
        $resultats->execute(array($user_email));

        //Le compte existe
        if ($resultats->rowCount() == 1) {
            $accountExist = true;
        }
        $resultats->closeCursor();
    }

    return $accountExist;
}

/**
 * Test si l'utilisateur est admin
 */
function testAdmin($db, $user_id) {

    $TEST_ADMIN = "SELECT user_admin FROM user WHERE user_id = ?";
    $isAdmin = false; //Par defaut, il n'est pas admin

    if (!is_null($user_id)) {
        $resultats = $db->prepare($TEST_ADMIN);
        $resultats->execute(array($user_id));
        $row = $resultats->fetch(PDO::FETCH_OBJ);
        $user_admin = $row->user_admin;

        if ($user_admin == 1) {
            $isAdmin = true;
        }
        $resultats->closeCursor();
    }

    return $isAdmin;
}

/**
 * Test si le token de l'utilisateur est bon
 */
function testToken($db, $user_id, $user_token) {

    $SELECT_TOKEN = "SELECT user_token FROM user WHERE user_id = ? AND user_token_dead >= ?";
    $canDoRequest = false; //Par defaut, il ne peut pas faire de requetes

    if (!is_null($user_id) AND !is_null($user_token)) {

        $resultats = $db->prepare($SELECT_TOKEN);
        $resultats->execute(array($user_id, date('Y-m-j h:i:s')));
        $row = $resultats->fetch(PDO::FETCH_OBJ);

        if (!is_null($row->user_token) AND $user_token == $row->user_token) {
            $canDoRequest = true;
        }
        $resultats->closeCursor();
    }

    return $canDoRequest;
}

/**
 * Retourne des infos sur le navigateur de l'utilisateur
 */
function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version $number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching $number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a $number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'version' => $version,
        'platform' => $platform,
        'pattern' => $pattern
    );
}

?>
