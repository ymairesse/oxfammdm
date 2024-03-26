<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

// pseudo sélectionné à l'écran précédent
$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : Null;
$dataUser = ($pseudo != Null) ? $User->getDataUser($pseudo) : Null;

// l'utilisateur actif dans l'application
$adminPseudo = $User->getPseudo();
$self = $User->getIdentiteUser($adminPseudo);


$smarty->assign('pseudo', $pseudo);
$smarty->assign('dataUser', $dataUser);
$smarty->assign('self', $self);

$smarty->display('users/modal/modalEditUser.tpl');