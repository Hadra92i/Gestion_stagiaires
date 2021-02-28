<?php

require_once '../database/db.php';

$id_u = $_GET['id_u'];
$etat = $_GET['etat'];

if($etat == 1)  
    $newEtat = 0 ;
else 
    $newEtat = 1;

$requette = "UPDATE users SET etat = ? WHERE id_u = ?";
$params = [$newEtat,$id_u];

$resultat = $db->prepare($requette);
if($resultat->execute($params)){
    header('location:users.php');
}