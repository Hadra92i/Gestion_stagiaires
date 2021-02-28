<?php
require_once 'securite.php';
require_once 'controle_acces.php';
require_once '../database/db.php';

$sql_select_f = "SELECT * FROM filieres ";
$resultat_f = $db->query($sql_select_f);

if(!empty($_POST)){
    if(!empty($_POST['nom_s']) && !empty($_POST['prenom_s']) && !empty($_POST['civilite']) 
    && isset($_FILES['photo']['name']) && !empty($_POST['idfiliere'])){
        
        $nom_s = $_POST['nom_s'];
        $prenom_s = $_POST['prenom_s'];
        $civilite = $_POST['civilite'];
        $idfiliere = $_POST['idfiliere'];
        $photo = $_FILES['photo']['name'];
        $photo_tmp = $_FILES['photo']['tmp_name'];
        move_uploaded_file($photo_tmp,"../images/".$photo);
      
        $requette = "INSERT INTO stagiaires SET nom_s = ?,prenom_s = ?,civilite = ?, photo = ?,idF = ?";
        $params = [$nom_s,$prenom_s,$civilite,$photo,$idfiliere];
        $resultat = $db->prepare($requette);
        if($resultat->execute($params)){
            header('location:stagiaires.php');
        }
    }
}
?>
<?php require '../includes/header.php';?>

    <?php require 'menu.php'?>
    <div class="container">
            <div class="card mt-3">
                <div class="card-header text-white bg-info">
                    <h5>Ajout d'un stagiaire </h5>
                </div>
                <div class="card-body bg-light">
                <form method="POST" class="form" enctype="multipart/form-data">
                    <div class="form-group mr-2">
                         <label for="nom_s">Nom :</label>
                         <input type="text" name="nom_s" placeholder="Saisir le nom du stagiaire" class="form-control">
                    </div>
                    <div class="form-group mr-2">
                         <label for="prenom_s">Préom :</label>
                         <input type="text" name="prenom_s" placeholder="Saisir le prénom du stagiaire" class="form-control">
                    </div>
                    <div class="form-group mr-2">
                         <label for="civilite">Civilité :</label><br>
                         <input type="radio" name="civilite" value="F" > F<br>
                         <input type="radio" name="civilite" value="M" > M
                    </div>
                    <label for="idfiliere" class="mr-2">La filière :</label> 
                    <select name="idfiliere" class="form-control mr-2" id="idfiliere">
                        <option value=""></option>
                        <?php while($f = $resultat_f->fetch()) :?>
                              <option value="<?= $f['id_f']?>">
                                    <?= $f['nom_f']?>
                              </option>
                        <?php endwhile ?>
                    </select>
                    <div class="form-group mr-2">
                         <label for="photo">Photo :</label><br>
                         <input type="file" name="photo">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success mt-2"><i class="fas fa-save"></i> Valider</button>
                        <a href="stagiaires.php" class="btn btn-info mt-2"> Retour </a>
                    </div>
                </form>
                </div>
            </div>
    </div>
    <?php require '../includes/footer.php';?>