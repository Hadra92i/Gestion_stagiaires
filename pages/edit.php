<?php
require_once 'securite.php';
require_once 'controle_acces.php';
require_once '../database/db.php';

$id_f = $_GET['id_f'];

$sql_select = "SELECT * FROM filieres WHERE id_f = $id_f";
$statement = $db->query($sql_select);
$Unefiliere = $statement->fetch();
$nom_f   = $Unefiliere['nom_f'];
$niveau  = strtolower($Unefiliere['niveau']);

if(!empty($_POST)){
    if(!empty($_POST['nom_f']) && !empty($_POST['niveau'])){
        $nom_f = $_POST['nom_f'];
        $niveau = $_POST['niveau'];
        $request = $db->prepare("UPDATE filieres SET nom_f =:nom_f,niveau =:niveau WHERE id_f =:id_f");
        if($statement = $request->execute([':nom_f'=>$_POST['nom_f'],':niveau'=>strtoupper($_POST['niveau']),':id_f'=>$id_f])){
            header('location:filieres.php');
        }
    }
}

?>
<?php require '../includes/header.php';?>

    <?php require 'menu.php'?>
    <div class="container">
            <div class="card mt-3">
                <div class="card-header text-white bg-info">
                    <h5>Mise à jour de la filière </h5>
                </div>
                <div class="card-body bg-light">
                <form method="POST" class="form">
                    <div class="form-group mr-2">
                         <label for="nom_filiere">Nom de la filière</label>
                         <input type="text" name="nom_f" value="<?= $nom_f ?>" class="form-control">
                    </div>
                    <label for="nveau" class="mr-2">Niveau de la filière :</label> 
                    <select name="niveau" class="form-control mr-2" id="niveau">
                        <option value="m"  <?php if($niveau == "m")  echo "selected" ?>>Master</option>
                        <option value="l"  <?php if($niveau == "l")  echo "selected" ?>>Licence</option>
                        <option value="ts" <?php if($niveau == "ts") echo "selected" ?>>Technicien spécialisé</option>
                        <option value="t"  <?php if($niveau == "t")  echo "selected" ?> >Technicien</option>
                        <option value="q"  <?php if($niveau == "q")  echo "selected" ?>>Qualification</option>
                    </select>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success mt-2"><i class="fas fa-save"></i> Valider</button>
                        <a href="filieres.php" class="btn btn-info mt-2"> Retour </a>
                    </div>
                </form>
                </div>
            </div>
    </div>
 <?php require '../includes/footer.php';?>