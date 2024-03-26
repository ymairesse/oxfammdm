<?php


session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : Null;

$form = array();
parse_str($formulaire, $form);

$pseudo = $form['pseudo'];
$token = $form['token'];
$passwd = $form['pwd'];

if ($Application->checkValidPseudoToken($pseudo, $token)) {
    $nb = User::savePasswd4pseudo($pseudo, $passwd);
    if ($nb > 0) {
        echo "Votre mot de passe a été changé";
        User::delToken4pseudo($pseudo);
    } else
        echo "Votre mot de passe n'a pas été changé";
} else {
    echo "Un problème inattendu s'est produit.";
}

