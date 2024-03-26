<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty,
include '../entetes.inc.php';

// Créer une nouvelle instance de PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();

$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : Null;
$email = isset($_POST['email']) ? $_POST['email'] : Null;

$mail->IsHTML(true);
$mail->CharSet = 'UTF-8';

// valeurs définies dans config.ini
$mail->setFrom (MAILADMIN, NOMADMIN);

$sujet = 'Magasin du Mond Oxfam: planning';

$texte = 'Ce mail pour confirmer la réception de votre demande de création de compte ';
$texte .= 'sur la plateforme de gestion du planning du Magasin Du Monde Oxfam. ';
$texte .= '\n Dès l\'acceptation de votre demande, vous recevrez un nouveau mail et vous pourrez vous connecter. ';
$texte .= '\n Bien cordialement.';

$mail->Subject = $sujet;


    $identite = $User->getIdentiteUser($pseudo);
    $prenomNom = sprintf('%s %s', $identite['prenom'], $identite['nom']);
    $mail->AddCC($identite['mail'], $prenomNom);


    $texteMail .= '<br><br><hr>Mail envoyé depuis l\'application <a href="https://sio2.be/mdm">https://sio2.be/mdm</a>';
    $mail->Body = $texteMail;

    if ($mail->send())
        echo "Le mail a été envoyé";
        else echo "Problème lors de l'envoi de ce mail";