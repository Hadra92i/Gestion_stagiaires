<?php
require_once 'securite.php';
require_once 'controle_acces.php';
require_once '../database/db.php';

$message = '';

$id_u = $_GET['id_u'];
$requette = "DELETE FROM users WHERE id_u = ?";
$statement = $db->prepare($requette);
if($statement->execute([$id_u])){
    header("location:users.php");
}

