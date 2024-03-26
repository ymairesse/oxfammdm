<?php

// Édition des profils des utilisateurs par un user "root"

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

// utilisateur désigné par le click dans la colonne de gauche
$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : Null;
$sortUsers = isset($_COOKIE['sortUsers']) ? $_COOKIE['sortUsers'] : 'parNom';

$listeUsers = $User->getListeUsers($sortUsers);

// s'il n'y a pas d'utilisateur désigné, prendre le premier de la liste
if ($pseudo == Null) {
    reset($listeUsers);
    $pseudo = key($listeUsers);
}

$smarty->assign('listeUsers', $listeUsers);
$smarty->assign('sortUsers', $sortUsers);

$smarty->assign('pseudo', $pseudo);

$smarty->display('users/inc/listeUsers.tpl');