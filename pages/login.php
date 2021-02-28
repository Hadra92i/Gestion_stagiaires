<?php
session_start();
require_once '../database/db.php';
$message = "";

if(!empty($_POST)){
    if(!empty($_POST['pseudo']) && !empty($_POST['pwd'])){

        $pseudo = $_POST['pseudo'];
        $pwd    = sha1($_POST['pwd']);
         
        $requette = "SELECT * FROM users WHERE pseudo = ? AND pwd = ?";
        $resultat = $db->prepare($requette);
        $resultat->execute([$pseudo,$pwd]);
        if($user = $resultat->fetch()){
            if($user['etat'] == 1){
                $_SESSION['PROFILE'] = $user;
                header('location:../index.php');
            } else{
                $_SESSION['erreur'] = "Votre Compte est suspendu .Veillez contacter l'administrateur";
                header('location:login.php');
            }
        }else{
                $_SESSION['erreur'] = 'Pseudo ou mot de passe incorrect !';
                header('location:login.php');
        }
    }
}
if(isset($_SESSION['erreur'])){
    $message = $_SESSION['erreur'];
}else{
    $message = "";
}
if(isset($_SESSION['message_reconnexion'])){
    session_destroy();
    $message = $_SESSION['message_reconnexion'];
  }
?>
<?php require '../includes/header.php';?>

      <div class="container">
         <div class="row my-4">
             <div class="col-md-6 mx-auto">
                 <div class="card mt-5">
                        <div class="card-header bg-info">
                            <h3 class="text-center">Connexion</h3>
                         </div>
                         <div class="card-body">
                             <?php if(!empty($message)) :?>
                                <div class="alert alert-danger">
                                    <?= $message ?>
                                </div>
                             <?php endif?>
                            <form method="POST" class="form">
                                <label for="pseudo">Pseudo </label>
                                <div class="form-group">
                                    <input type="text" name="pseudo" placeholder="Saisir le pseudo" class="form-control" autocomplete="off">
                                </div>
                                <label for="password">Password</label>
                                <div class="form-group">
                                    <input type="password" name="pwd" placeholder="Saisir le mot de passe" class="form-control" autocomplete="off">
                                </div>
                                <div class="container">
                                    <div class="col text-center">
                                        <div class="form-group">
                                              <button type="submit" class="btn btn-success">Se connecter </button>
                                        </div> 
                                    </div>
                                </div> 
                            </form>
                        </div>
                        <div class="card-footer">
                            <a href="register.php"> S'Inscrire</a>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
<?php require '../includes/footer.php'?>