<?php

session_start();

require_once '../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
// valeur de $action
include 'entetes.inc.php';

$identifiant = isset($_POST['identifiant']) ? strtolower(trim($_POST['identifiant'])) : Null;

// est-ce une adresse mail?

$qui = false;
if (filter_var($identifiant, FILTER_VALIDATE_EMAIL)) {
    // vérifions que l'adresse mail existe dans la table des users en retournant
    // le couple pseudo/adresse mail
    $qui = User::getIdentite4mail($identifiant);
} else {
    // vérifions que l'adresse mail existe dans la table des users en retournant
    // le couple pseudo/adresse mail
    $qui = User::getIdentite4pseudo($identifiant);
}

if ($qui != false) {
    $date = date('d/m/Y');
    $heure = date('H:i');

    $pseudo = $qui['pseudo'];
    // reset d'un éventuel Token précédent
    $nb = User::clearToken($pseudo);
    // création d'un nouveau Token
    $link = User::createPasswdLink($pseudo);

    $identite = User::getIdentiteUser($pseudo);
    $identiteReseau = User::identiteReseau();

    $smarty->assign('expediteur', MAILADMIN);
    $smarty->assign('URL', URL);
    $smarty->assign('link', $link);
    $smarty->assign('identite', $identite);
    $smarty->assign('identiteReseau', $identiteReseau);
    $smarty->assign('date', $date);
    $smarty->assign('heure', $heure);

    $texte = $smarty->fetch('texteMailmdp.tpl');

    $Application->mailPasswd($identite['mail'], $texte);

    $texte = sprintf('Nous venons d\'envoyer un mail à l\'adresse <a href="mailto:%s">%s</a>.<br>', $identite['mail'], $identite['mail']);
    $texte .= 'Il contient un lien qui vous permettra de changer votre mot de passe ';
    echo $texte;
} else
    die("L'utilisateur <strong>" . $identifiant . "</strong> n'existe pas dans notre base de données.");
