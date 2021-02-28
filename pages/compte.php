<?php
require_once 'securite.php';

require_once '../database/db.php';

$id_u = $_SESSION['PROFILE']['id_u'];

$sql_select = "SELECT * FROM users WHERE id_u = $id_u";
$statement = $db->query($sql_select);
$UnUser = $statement->fetch();
$pseudo   = $UnUser['pseudo'];
$email = $UnUser['email'];

if(!empty($_POST)){
    if(!empty($_POST['pseudo']) && !empty($_POST['email'])){
        
        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        
        $requette = "UPDATE users SET pseudo = ?,email = ? WHERE id_u = ?";
        $params = [$pseudo,$email,$id_u];
        
        $resultat = $db->prepare($requette);
        $resultat->execute($params);
        $_SESSION['message_reconnexion'] = "Votre compte à été modifier.Veillez vous connecter s'il vous plait";
        header('location:login.php');
        
    }
}
?>
<?php require '../includes/header.php'?>

<?php require 'menu.php'?>

    <div class="container">
        <div class="row my-4">
            <div class="col-md-9 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3>Les informations de mon compte</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                             <label for="pseudo"><b>Pseudo : </b></label>
                             <div class="form-group">
                                 <input type="text" name="pseudo" value="<?= $pseudo ?>" class="form-control">
                             </div>
                             <label for="email"><b>Email : </b></label>
                             <div class="form-group">
                                 <input type="email" name="email" value="<?= $email ?>" class="form-control">
                             </div>
                             <div class="form-group">
                                 <button type="submit" class="btn btn-success mt-2 mr-2"><i class="fas fa-save"></i> Valider</button>
                                 <a href="../index.php" class="btn btn-info mt-2"> Retour </a>
                             </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <a href="change_pwd.php">Changer le mot de passe </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require '../includes/footer.php';?>