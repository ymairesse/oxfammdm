<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$idContexte = isset($_POST['idContexte']) ? $_POST['idContexte'] : Null;

// si pas encore défini, on prend le contexte de la période actuelle
if ($idContexte == Null) {
    $date = date('Y-m-d');
    $idContexte = $Planning->getContexte4date($date);
    $_COOKIE['idContexte'] = $idContexte;
}

$listeContextes = $Planning->getListeContextes();
$listeDouble = $Planning->getListeDoubleContextes($listeContextes);

$datesLimites = $listeDouble[$idContexte];

$smarty->assign('datesLimites', $datesLimites);
$smarty->assign('idContexte', $idContexte);
$smarty->assign('listeContextes', $listeContextes);

$smarty->display('conges/modal/modalAddFerie.tpl');