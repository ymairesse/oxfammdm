<?php

// Édition du profil personnel de l'utilisateur

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

// utilisateur actif en session
$pseudo = $User->getPseudo();
$dataUser = $User->getIdentiteUser($pseudo);

$smarty->assign('dataUser', $dataUser);
$smarty->assign('self', $dataUser);


// fiche personnelle uniquement
$smarty->display('users/modal/modalEditUser.tpl');
