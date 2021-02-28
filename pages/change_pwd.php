<?php

require 'securite.php';
require_once '../database/db.php';

$id_u = $_SESSION['PROFILE']['id_u'];
$password = $_SESSION['PROFILE']['pwd'];

if(!empty($_POST)){
   
    $erreurs = [];
    
    $pass_hash = sha1($_POST['anc_pwd']) ;

    if(empty($_POST['anc_pwd']) || $pass_hash != $password){
         
        $erreurs['erreur_anc_pwd'] = "L'ancien mot de passe est incorrect !";
    }
    
    if(empty($_POST['new_pwd']) || $_POST['new_pwd'] != $_POST['pass_confirm']){
        $erreurs['erreur_nw_pwd'] = "Les deux mot de passe ne correspondent pas !";
    }
  
    if(empty($erreurs)){
       $requette = $db->prepare("UPDATE users SET pwd = ? WHERE id_u = ?"); 
       $params = [sha1($_POST['new_pwd']),$id_u];
       if($statement = $requette->execute($params)){
         session_destroy();
         $message = "Vous avez changé de mot de passe.Veillez vous connecter à nouveau ";
         header('location:login.php');
       }
    }
}
?>
<?php require '../includes/header.php';?>

    <?php require 'menu.php'?>
    <div class="container">
            <div class="card mt-3">
                <div class="card-header text-white bg-info">
                    <h5>Mise à jour du mot de passe </h5>
                </div>
                <div class="card-body bg-light">
                     <?php if(!empty($erreurs)) :?>
                        <div class="alert alert-danger">
                          <p>Vous n'avez pas rempli correctement le formmulaire</p>
                          <ul>
                              <?php foreach($erreurs as $erreur) :?>
                                <li><?= $erreur;?></li>
                              <?php endforeach; ?>
                          </ul>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($message)) : ?>
                        <div class="alert alert-success">
                            <?= $message ?>
                        </div>
                    <?php endif ;?>
                    <form method="POST" class="form">
                        <div class="form-group mr-2">
                            <label for="anc_pwd">Ancien mot de passe :</label>
                            <input type="password" name="anc_pwd" placeholder="Saisir votre ancien mot de passe" required class="form-control">
                        </div>
                        <div class="form-group mr-2">
                            <label for="new_pwd">Nouveau mot de passe :</label>
                            <input type="password" name="new_pwd" placeholder="Saisir votre nouveau mot de passe " required class="form-control">
                        </div>
                        <div class="form-group mr-2">
                            <label for="pass_confirm">Confirmer le mot de passe :</label>
                            <input type="password" name="pass_confirm" placeholder="confirmer le nouveau mot de passe " required class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success mt-2"><i class="fas fa-save"></i> Valider</button>
                            <a href="compte.php" class="btn btn-info mt-2"> Retour </a>
                        </div>
                    </form>
                </div>
            
            </div>
    </div>


<?php require '../includes/footer.php';?>