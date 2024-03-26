<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

// liste des différentes ères des permanences
$listeContextes = $Planning->getListeContextes();

$idContexte = isset($_COOKIE['idContexte']) ? $_COOKIE['idContexte'] : Null;

// s'il n'y a pas de contexte sélectionné, prendre le premier de la liste
if (!(in_array($idContexte, array_keys($listeContextes)))) {
    reset($listeContextes);
    $idContexte = key($listeContextes);
}

// recherche la date de début de l'époque
$date = $Planning->getDate4idContexte($idContexte);

// liste des permanences pour la période $idContexte
$permanences = $Planning->getPermanences4Contexte($idContexte);

$smarty->assign('idContexte', $idContexte);
$smarty->assign('date', $date);
$smarty->assign('listeContextes', $listeContextes);
$smarty->assign('permanences', $permanences);

$smarty->display('planning/gestPeriodes.tpl');