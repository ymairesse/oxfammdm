<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$month = isset($_COOKiE['month']) ? $_COOKIE['month'] : date('m');
$year = isset($_COOKIE['year']) ? $_COOKIE['year'] : date('Y');
$idContexte = isset($_COOKIE['idContexte']) ? $_COOKIE['idContexte'] : Null;

$listeContextes = $Planning->getListeContextes();

// si $idContexte n'avait pas été sélectionné encore ($_COOKIE)
// on prend l'époque correspondant à aujourd'hui
if ($idContexte == Null) {
    $date = date('Y-m-d');
    $listeContextes = $Planning->getListeContextes();
    // quel est le contexte pour cette date?
    $idContexte = $Planning->getContexte4date($date);
    $_COOKIE['idContexte'] = $idContexte;
}

$daysOfWeek = $Application->getDaysName ();
$smarty->assign('daysOfWeek', $daysOfWeek);

// récupère les périodes de permanence pour le contexte donné
$listePeriodes = $Planning->getPeriodes4Contexte($idContexte);
$smarty->assign('listePeriodes', $listePeriodes);

$smarty->assign('year', $year);
$smarty->assign('month', $month);
$smarty->assign('idContexte', $idContexte);


// lecture de toute la liste des congés hebodmadaires
$listeCongesHebdo = $Conges->getListeCongesHebdo();
// dont on extrait les congés liés au contexte présent
$smarty->assign('listeCongesHebdo', $listeCongesHebdo[$idContexte]);

$listeCongesFeries = $Conges->getListeCongesFeries();
$smarty->assign('listeCongesFeries', $listeCongesFeries[$idContexte]);

$smarty->assign('listeContextes', $listeContextes);

$listeDoubleContextes = $Planning->getListeDoubleContextes($listeContextes);
$smarty->assign('listeDoubleContextes', $listeDoubleContextes);

$smarty->display('conges/conges.tpl');