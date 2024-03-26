<?php

session_start();

require_once '../config.inc.php';

// définition de la class APPLICATION
require_once INSTALL_DIR.'/inc/classes/class.Application.php';
$Application = new Application();

// définition de la class USER
require_once INSTALL_DIR.'/inc/classes/class.User.php';

$User = isset($_SESSION[APPLICATION]) ? unserialize($_SESSION[APPLICATION]) : Null;
$expediteur = $User->getIdentite();

$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : null;
$form = array();
parse_str($formulaire, $form);

$sujet = isset($form['sujet']) ? $form['sujet'] : Null;
$texteMail = isset($form['texteMail']) ? $form['texteMail'] : Null;

// Inclure l'autoloader de Composer
require 'vendor/autoload.php';

// Créer une nouvelle instance de PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();



if (($sujet != Null) && ($texteMail != Null)) { 

    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';

    $mailExp = $expediteur['mail'];
    $nomExp = sprintf('%s %s', $expediteur['prenom'], $expediteur['nom']);
    $mail->setFrom ($mailExp, $nomExp);

    $mail->Subject = $sujet;

    $mail->AddAddress($mailExp, $nomExp);

    foreach ($listeMails as $wtf => $pseudo) {
        $identite = $User->getIdentiteUser($pseudo);
        $prenomNom = sprintf('%s %s', $identite['prenom'], $identite['nom']);
        $mail->AddCC($identite['mail'], $prenomNom);
    }

    $texteMail .= '<br><br><hr>Mail envoyé depuis l\'application <a href="https://sio2.be/mdm">https://sio2.be/mdm</a>';
    $mail->Body = $texteMail;

    if ($mail->send())
        echo "Le mail a été envoyé";
        else echo "Problème lors de l'envoi de ce mail";
}

else echo "Il nous manque une ou plusieurs informations. Veuillez vérifier.";