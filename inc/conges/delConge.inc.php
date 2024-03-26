<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$idContexte = isset($_POST['idContexte']) ? $_POST['idContexte'] : Null;
$date = isset($_POST['date']) ? $_POST['date'] : Null;

$nb = $Conges->delConge($date, $idContexte);

echo $nb;

