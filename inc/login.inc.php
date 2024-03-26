<?php

session_start();

require_once '../config.inc.php';

require_once 'entetes.inc.php';

require_once INSTALL_DIR . '/inc/classes/class.User.php';


$identifiant = isset($_POST['identifiant']) ? $_POST['identifiant'] : Null;
$passwd = isset($_POST['passwd']) ? $_POST['passwd'] : Null;

$md5passwd = md5($passwd);

$User = new User($identifiant, $md5passwd);

// $user = l'utilisateur sous forme de array
// $User = l'utilisateur sous forme d'objet
$pseudo = $User->getPseudo();
$user = $User->getIdentiteUser($pseudo);

if ($user['approuve'] == 0)
    die('unapproved');
if ($user == false)
    die('ko');

$_SESSION[APPLICATION] = serialize($User);

$smarty->assign('user', $user);
$smarty->display('navbar.tpl');


