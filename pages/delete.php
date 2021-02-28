<?php
require_once 'securite.php';
require_once 'controle_acces.php';
require_once '../database/db.php';
$message = '';

$id_f = $_GET['id_f'];
$requette_stag = "SELECT COUNT(*) count_nbs FROM stagiaires WHERE idF = $id_f";
$resultat = $db->query($requette_stag);
$tab_nbs  = $resultat->fetch();
$nb_s = $tab_nbs['count_nbs'];

if($nb_s == 0){

    $sql_delete = "DELETE FROM filieres WHERE id_f =:id_f";
    $statement = $db->prepare($sql_delete);
    $statement->execute([':id_f' => $id_f]);
    header('location:filieres.php');
} else{
    $message = "Impossible d'effectuer la suppréssion !.Supprimer d'abord les stagiaire de cette filière !";
    header("location:filieres.php?message=$message");
}


