<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$idContexte = isset($_POST['idContexte']) ? $_POST['idContexte'] : Null;
$nbPermanences = isset($_POST['nbPermanences']) ? $_POST['nbPermanences'] : Null;

$listePermanences = $Planning->getPermanences4Contexte($idContexte);

$lastPermanence = end($listePermanences);

$numeroPermanence = $lastPermanence['numeroPermanence'];

$nb = $Planning->saveNewPermanences($idContexte, $nbPermanences, $numeroPermanence);

echo $nb;