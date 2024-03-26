<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : Null;

$identite = $User->getIdentiteUser($pseudo);

$smarty->assign('identite', $identite);
$smarty->display('gestion/inc/boutonInscription.tpl');