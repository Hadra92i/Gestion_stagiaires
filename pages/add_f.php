<?php
require_once 'securite.php';
require_once 'controle_acces.php';
require_once '../database/db.php';


if(!empty($_POST)){
  if(!empty($_POST['nom_f']) && !empty($_POST['niveau'])){
    $sql_insert = $db->prepare("INSERT INTO filieres SET nom_f = ?, niveau = ?");
    if($statement = $sql_insert->execute([$_POST['nom_f'],strtoupper($_POST['niveau'])])){
        $_SESSION['msg_addf'] = 'Filière ajoutée avec succès !';
        header('location:filieres.php');
    }
  }
}
?>
<?php require '../includes/header.php'?>

    <?php require 'menu.php'?>
    <div class="container">
            <div class="card mt-3">
                <div class="card-header text-white bg-info">
                    <h5>Nouvelle Filière</h5>
                </div>
                <div class="card-body bg-light">
                <form method="POST" class="form">
                    <div class="form-group mr-2">
                         <label for="nom_filiere">Nom de la filière</label>
                         <input type="text" name="nom_f" placeholder="Saisir le nom de la filière" class="form-control">
                    </div>
                    <label for="nveau" class="mr-2">Niveau de la filière :</label> 
                    <select name="niveau" class="form-control mr-2" id="niveau">
                        <option value="" selected></option>
                        <option value="m"  >Master</option>
                        <option value="l"  >Licence</option>
                        <option value="ts" >Technicien spécialisé</option>
                        <option value="t"  >Technicien</option>
                        <option value="q"  >Qualification</option>
                    </select>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success mt-2 mr-2"><i class="fas fa-save"></i> Valider</button>
                        <a href="filieres.php" class="btn btn-info mt-2"> Retour </a>
                    </div>
                    
                </form>
                </div>
            </div>
    </div>
    <?php require '../includes/footer.php';?>