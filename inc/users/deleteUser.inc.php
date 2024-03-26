<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty,
include '../entetes.inc.php';

$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : null;

$n = $User->delUser($pseudo);

echo $n;