<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

//  la date d'aujourd'hui
$date = date('Y-m-d');

$listeContextes = $Planning->getListeContextes();
$idContexte = $Planning->getContexte4date($date, $listeContextes);

echo $idContexte;