<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$year = isset($_POST['year']) ? $_POST['year'] : Null;
$month = isset($_POST['month']) ? $_POST['month'] : Null;
// on récupère le pseudo de l'utilisateur courant
$pseudo = $User->getPseudo();

// -----------------------------------------------------------------------
// ensemble des inscriptions figurant dans la BD
$oldInscriptions = $Planning->getInscriptionsArray($month, $year, $pseudo);

// -----------------------------------------------------------------------
// le formulaire revient avec toutes les cases cochées pour les anciennes
// et les nouvelles inscriptions
$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : null;
$form = array();
parse_str($formulaire, $form);

// toutes les cases cochées dans le formulaire (comprenant donc d'anciennes
// et de nouvelles inscriptions)
$dataNew = array();
if (isset($form['inscriptions']))
    foreach ($form['inscriptions'] as $wtf => $datePeriode) {
        $data = explode('_', $datePeriode);
        $key = sprintf('%s_%d', $data[0], $data[1]);
        $dataNew[$key] = array('date' => $data[0], 'periode' => $data[1]);
    }
$dataNew = array_keys($dataNew);

$toDelete = array_diff($oldInscriptions, $dataNew);
$toAdd = array_diff($dataNew, $oldInscriptions);

// -----------------------------------------------------------------------
// on passe à l'enregistrement
// -----------------------------------------------------------------------

$nbDeleted = 0;
foreach ($toDelete as $wtf => $permanence) {
    $laPermanence = explode ('_', $permanence);
    $date = $laPermanence[0];
    $periode = $laPermanence[1];
    $nbDeleted += $Planning->deletePermanence($date, $periode, $pseudo);
}

$nbAdded = 0;
foreach ($toAdd as $wtf => $permanence) {
    $laPermanence = explode ('_', $permanence);
    $date = $laPermanence[0];
    $periode = $laPermanence[1];
    $idContexte = $Planning->getContexte4date($date);
    $nbAdded += $Planning->savePermanence($idContexte, $date, $periode, $pseudo);
}


$message = sprintf('%d inscriptions annulée(s) et %d inscriptions ajoutée(s)', $nbDeleted, $nbAdded);

echo $message;