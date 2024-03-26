<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty, 
include '../entetes.inc.php';

$formulaire = isset($_POST['formulaire']) ? $_POST['formulaire'] : Null;

$form = array();
parse_str($formulaire, $form);

// enregistrer les données utilisateur
$nb = User::saveNewUser($form);

// si tout s'est bien passé, envoyer un mail de confirmation au nouveau bénévole
// et aux administrateurs
if ($nb == 1) {

    // Créer une nouvelle instance de PHPMailer
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';

    $mailExp = MAILADMIN;
    $nomExp = NOMADMIN;
    $mail->setFrom (MAILADMIN, NOMADMIN);
    
    $mail->Subject = 'Plateforme "plannings" Oxfam MDM';

    $email = $form['mail'];
    $nom = $form['nom'];
    $prenom = $form['prenom'];

    $texteMail = file_get_contents(INSTALL_DIR.'/templates/users/inc/mailInscription.tpl'); 

    $texteMail = str_replace('{nom}', $nom, $texteMail);
    $texteMail = str_replace('{prenom}', $prenom, $texteMail);
    $texteMail = str_replace('{email}', $email, $texteMail);

    $mail->addAddress($email, $prenom . ' '.$nom);

    // ajouter les admins en BCC
    $listeAdmins = $Application->getListeAdmins();
    foreach ($listeAdmins as $pseudo => $unAdmin) {
        $mail->addBCC($unAdmin['mail'], NOMADMIN);
    }

    $mail->Body = $texteMail;

    if (!$mail->send())
        $nb = -1;
}

$resultat = array(
    'nb' => $nb, 
    'form' => $form,
);
$resultatJSON = json_encode($resultat);

echo $resultatJSON;