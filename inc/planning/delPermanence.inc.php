<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$idEpoque = isset($_POST['idEpoque']) ? $_POST['idEpoque'] : Null;
$numeroPermanence = isset($_POST['numeroPermanence']) ? $_POST['numeroPermanence'] : Null;

$nb = $Planning->delPermanence($idEpoque, $numeroPermanence);

echo $nb;