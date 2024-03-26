<?php

// définition de la class Application, y compris la lecture de config.ini
require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();

require_once INSTALL_DIR.'/inc/classes/class.User.php';

require_once INSTALL_DIR.'/inc/classes/class.Planning.php';
$Planning = new Planning();

require_once INSTALL_DIR.'/inc/classes/class.Conges.php';
$Conges = new Conges();


$User = isset($_SESSION[APPLICATION]) ? unserialize($_SESSION[APPLICATION]) : null;

// -------------------------------------------------------------
require_once INSTALL_DIR.'/vendor/autoload.php';

$smarty = new Smarty();
$smarty->template_dir = INSTALL_DIR."/templates";
$smarty->compile_dir = INSTALL_DIR."/templates_c";
// -------------------------------------------------------------
