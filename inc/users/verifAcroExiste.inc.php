<?php

require_once '../config.inc.php';

// définition de la class APPLICATION
require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();

// définition de la class USER
require_once INSTALL_DIR.'/inc/classes/class.User.php';

$nom = isset($_POST['nom']) ? $_POST['nom'] : Null;
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : Null;
$acronyme = $Application->acronyme4nomPrenom($nom, $prenom);

$User = new User();
$test = $User->userExists($acronyme, Null);

echo ($test == true) ? 1 : 0;