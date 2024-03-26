<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

// ----------------------------------------------------------------------------------
// liste latérale de sélection des utilisateurs -------------------------------------
// ----------------------------------------------------------------------------------

$sortUsers = isset($_COOKIE['sortUsers']) ? $_COOKIE['sortUsers'] : 'parNom';
$pseudo = isset($_COOKIE['pseudo']) ? $_COOKIE['pseudo'] : Null;

$usersList = $User->getListeUsers($sortUsers);

// s'il n'y a pas d'utilisateur désigné, prendre le premier de la liste
if ($pseudo == Null) {
    reset($listeUsers);
    $pseudo = key($listeUsers);
}
// ----------------------------------------------------------------------------------
// liste latérale de sélection des utilisateurs -------------------------------------
// ----------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------
// tableau planning pour un admin ---------------------------------------------------
// ----------------------------------------------------------------------------------

// fixation de la date "année" et "mois". Par défaut, année et mois actuels
$year = isset ($_COOKIE['year']) ? $_COOKIE['year'] : date('Y');
$month = isset ($_COOKIE['month']) ? $_COOKIE['month'] : date('n');

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
        foreach ($lesBenevoles as $unPseudo => $unBenevole)
            $monthGrid[$jourDuMois]['periodes'][$numeroPeriode]['benevoles'][$unPseudo] = $unBenevole;
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
// ----------------------------------------------------------------------------------
// tableau planning pour un admin ---------------------------------------------------
// ----------------------------------------------------------------------------------

$identite = $User->getIdentiteUser($pseudo);
$smarty->assign('identite', $identite);

$smarty->assign('monthGrid', $monthGrid);

$monthName = $Application->monthName($month);
$smarty->assign('monthName', $monthName);

$smarty->assign('year', $year);
$smarty->assign('month', $month);


// $ym = sprintf('%d-%02d', $year, $month);
// $freezeStatus = isset ($Application->getFreezings4month(array($ym))[$ym]) ? $Application->getFreezings4month(array($ym))[$ym] : 0;
// $smarty->assign('freezeStatus', $freezeStatus);


$smarty->assign('listeUsers', $usersList);
$smarty->assign('sortUsers', $sortUsers);
$smarty->assign('pseudo', $pseudo);

$smarty->display('gestion/gestionInscriptions.tpl');

