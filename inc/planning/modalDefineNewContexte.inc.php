<?php

// Édition du profil utilisateur oXFAM

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$listeContextes = $Planning->getListeContextes();

$lastContexte = end($listeContextes);

$smarty->assign('lastContexte', $lastContexte);

$smarty->display('planning/modal/modalNewContexte.tpl');
