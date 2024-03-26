<?php

session_start();

require_once '../../config.inc.php';

// ressources principales toujours nécessaires: classes Application, User, Smarty,
include '../entetes.inc.php';

$nom = isset($_POST['nom']) ? $_POST['nom'] : Null;
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : Null;

$pseudo = $Application->pseudo4nomPrenom($nom, $prenom);

$pseudoExiste = $Application->pseudoExiste($pseudo);

echo json_encode(array('pseudo' => $pseudo, 'pseudoExiste' => $pseudoExiste));