<?php

// Édition du profil utilisateur oXFAM

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : Null;


$dataUser = $User->getDataUser($pseudo);

$smarty->assign('dataUser', $dataUser);

$smarty->display('users/ficheProfilUser.tpl');