<?php


session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : Null;

$form = array();
parse_str($formulaire, $form);

// qui est l'utilisateur Oxfam dont on enregistre la fiche?
$pseudoOxfam = $form['pseudo'];

// qui est l'utilisateur actif dans l'application?
$self = $User->getUser();
$pseudo = $self['pseudo'];

// enregistrement sans modification des droits et de l'activation
// si l'enregistrement concerne l'utilisateur actif
$partiel = ($pseudo == $pseudoOxfam);

// enregistrer les données utilisateur
$nb = $User->saveUser($form, $partiel);

if ($nb > 0) {
    $user = $User->getUser();
    $pseudo = $user['pseudo'];
    $User->identite = User::getIdentiteUser($pseudo);
}

echo $nb;