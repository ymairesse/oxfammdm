<?php

// Édition des profils des utilisateurs par un user "root"

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

// utilisateur désigné par le click dans la colonne de gauche
$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : Null;
$sortUsers = isset($_COOKIE['sortUsers']) ? $_COOKIE['sortUsers'] : 'nom';

$listeUsers = $User->getListeUsers($sortUsers);

// s'il n'y a pas d'utilisateur désigné, prendre le premier de la liste
if ($pseudo == Null) {
    reset($listeUsers);
    $pseudo = key($listeUsers);
}

// data de l'utilisateur désigné dans la liste (ou le premier, par défaut)
$dataUser = $User->getDataUser($pseudo);

$smarty->assign('listeUsers', $listeUsers);

$smarty->assign('pseudo', $pseudo);
$smarty->assign('dataUser', $dataUser);
$smarty->assign('sortUsers', $sortUsers);

// ficheUser.tpl contiendra deux zones distinctes
// inc/listeUsers.tpl avec la liste des utilisateurs et
//  ficheProfilUser.tpl pour le détail du profil de l'utilisateur sélectionné

$smarty->display('users/ficheUser.tpl');