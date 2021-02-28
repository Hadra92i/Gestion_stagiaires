<?php
require_once 'securite.php';
require_once 'controle_acces.php';
require_once '../database/db.php';
$message = '';

$id_s = $_GET['id_s'];
$requette = "DELETE FROM stagiaires WHERE id_s = ?";
$statement = $db->prepare($requette);
if($statement->execute([$id_s])){
    $message = 'Stagiaire supprimé avec succès !';
    header("location:stagiaires.php?message=$message");
}

