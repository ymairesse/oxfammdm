<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$idContexte = isset($_POST['idContexte']) ? $_POST['idContexte'] : Null;
$date = $Planning->getDate4idContexte($idContexte);

// liste des permanences pour la période $idContexte
$permanences = $Planning->getPermanences4Contexte($idContexte);

$smarty->assign('permanences', $permanences);
$smarty->assign('idContexte', $idContexte);
$smarty->assign('date', $date);

$smarty->display('planning/inc/detailsPermanences.tpl');