<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

// lecture des noms des jours en français
$daysOfWeek = $Application->getDaysName();

// fixation de la date "année" et "mois". Par défaut, année et mois actuels
$year = isset ($_POST['year']) ? $_POST['year'] : date('Y');
$month = isset ($_POST['month']) ? $_POST['month'] : date('m');

// nombre de jours dans ce mois
$nbJours = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// ---------------------------------------------------------------------------------
// établir une grille vide des périodes de permanences pour le mois sélectionné
// la fonction recherche automatiquement à quelle époque cela correspond

$monthGrid = $Planning->getMonthGrid($month, $year);

// ---------------------------------------------------------------------------------
// recherche des inscriptions au planning dans cette période $month / $year
$inscriptions = $Planning->getInscriptions($month, $year);

// rattachement des inscriptions aux jours et périodes dans la grille générale
foreach ($inscriptions as $jourDuMois => $lesPeriodes) {
    foreach ($lesPeriodes as $numeroPeriode => $lesBenevoles) {
        foreach ($lesBenevoles as $pseudo => $unBenevole)
            $monthGrid[$jourDuMois]['periodes'][$numeroPeriode]['benevoles'][$pseudo] = $unBenevole;
    }
}

// --------------------------------------------------------------------------------
// tous les jours de congé, hebdomadaires et fériés
$listeCongesFeries = $Conges->getListeCongesFeries();
$listeCongesHebdo = $Conges->getListeCongesHebdo();


// marquage des jours et périodes de fermetures dans la grille générale
foreach ($monthGrid as $jourDuMois => $detailsJour) {
    $idContexte = $detailsJour['idContexte'];
    $date = $detailsJour['date'];
    $noJourSemaine = $detailsJour['noJourSemaine'];

    foreach ($detailsJour['periodes'] as $noPeriode => $detailsPeriode) {
        if (
            ($listeCongesFeries[$idContexte][$date][$noPeriode] == 1)
            || ($listeCongesHebdo[$idContexte][$noJourSemaine][$noPeriode] == 1)
        )
            $monthGrid[$jourDuMois]['periodes'][$noPeriode]['closed'] = 1;
    }
}

$smarty->assign('monthGrid', $monthGrid);

$pseudo = $User->getPseudo();
$smarty->assign('pseudo', $pseudo);

$identite = $User->getIdentiteUser($pseudo);
$smarty->assign('identite', $identite);

$monthName = $Application->monthName($month);
$smarty->assign('monthName', $monthName);



$smarty->assign('year', $year);
$smarty->assign('month', $month);


// $ym = sprintf('%d-%02d', $year, $month);
// $freezeStatus = isset ($Application->getFreezings4month(array($ym))[$ym]) ? $Application->getFreezings4month(array($ym))[$ym] : 0;
// $smarty->assign('freezeStatus', $freezeStatus);

// $smarty->assign('inscriptions', $inscriptions);

$smarty->display('inscriptions/calendar.tpl');