<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : Null;

$form = array();
parse_str($formulaire, $form);

$dateDebutEpoque = isset($form['dateDebutEpoque']) ? $form['dateDebutEpoque'] : Null;
$idEpoque = isset($form['idEpoque']) ? $form['idEpoque'] : Null;

$id = $Planning->saveDateEpoque($dateDebutEpoque);

echo $id;
