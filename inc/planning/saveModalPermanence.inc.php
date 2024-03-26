<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : Null;

$form = array();
parse_str($formulaire, $form);

$idContexte = isset($form['idContexte']) ? $form['idContexte'] : Null;
$numeroPermanence = isset($form['numeroPermanence']) ? $form['numeroPermanence'] : Null;
$heureDebut = isset($form['heureDebut']) ? $form['heureDebut'] : Null;
$heureFin = isset($form['heureFin']) ? $form['heureFin'] : Null;

$nb = $Planning->savePeriodePermanence($idContexte, $numeroPermanence, $heureDebut, $heureFin);

echo $nb >= 1;
