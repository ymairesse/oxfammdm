<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$idContexte = isset($_POST['idContexte']) ? $_POST['idContexte'] : Null;
$periode = isset($_POST['periode']) ? $_POST['periode'] : Null;
$jour = isset($_POST['jour']) ? $_POST['jour'] : Null;

$nb = $Conges->toggleCongeHebdo($idContexte, $periode, $jour);

echo $nb;
