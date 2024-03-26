<?php

// Édition du profil personnel de l'utilisateur

session_start();

require_once '../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include 'entetes.inc.php';

$benevole = $User->getUser();
$smarty->assign('benevole', $benevole);

$idUser = $benevole['idUser'];

$profil = $User->getDataUser($idUser);
$smarty->assign('profil', $profil);

// fiche personnelle

$smarty->display('ficheProfil.tpl');