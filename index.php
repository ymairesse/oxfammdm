<?php

session_start();

require_once 'config.inc.php';

// initialisation des classes Application et User (y compris la définition du $User)
// initialisation de Smarty
require_once 'inc/entetes.inc.php';

if ($User != Null) {
    $pseudo = $User->getPseudo();
    $user = $User->getIdentiteUser($pseudo);
} else
    $user = Null;


// cas de la demande de renouvellement du mot de passe
$action = isset($_GET['action']) ? $_GET['action'] : Null;

if ($action == 'renewPasswd') {
    $pseudo = isset($_GET['pseudo']) ? $_GET['pseudo'] : Null;
    $token = isset($_GET['token']) ? $_GET['token'] : Null;
    $valid = $Application->checkValidPseudoToken($pseudo, $token);
    if ($valid) {
        $distrait = User::getIdentiteUser($pseudo);
        $smarty->assign('pseudo', $pseudo);
        $smarty->assign('action', $action);
        $smarty->assign('token', $token);
        $smarty->assign('distrait', $distrait);
    }

} else {
    $smarty->assign('user', $user);
}

$smarty->display('index.tpl');