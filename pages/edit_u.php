<?php
require_once 'securite.php';
require_once '../database/db.php';

$id_u = $_GET['id_u'];

$sql_select = "SELECT * FROM users WHERE id_u = $id_u";
$statement = $db->query($sql_select);
$UnUser = $statement->fetch();
$pseudo   = $UnUser['pseudo'];
$email = $UnUser['email'];
$role = strtoupper($UnUser['role_u']);

if(!empty($_POST)){
    if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['role'])){
        
        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $role = strtoupper($_POST['role']);
        
        $requette = "UPDATE users SET pseudo = ?,email = ?,role_u = ? WHERE id_u = ?";
        $params = [$pseudo,$email,$role,$id_u];
        
        $resultat = $db->prepare($requette);
        if($resultat->execute($params)){
            header('location:users.php');
        }
    }
}
?>
<?php require '../includes/header.php';?>

    <?php require 'menu.php'?>
    <div class="container">
            <div class="card mt-3">
                <div class="card-header text-white bg-info">
                    <h5>Mise à jour du user </h5>
                </div>
                <div class="card-body bg-light">
                    <form method="POST" class="form">
                        <div class="form-group mr-2">
                            <label for="pseudo">Pseudo :</label>
                            <input type="text" name="pseudo" value="<?= $pseudo ?>" class="form-control">
                        </div>
                        <div class="form-group mr-2">
                            <label for="email">Email :</label>
                            <input type="email" name="email" value="<?= $email ?>" class="form-control">
                        </div>
                        <label for="role" class="mr-2">Role  :</label> 
                        <select name="role" class="form-control mr-2" id="role">
                            <option value="ADMIN" <?php if($role == "ADMIN") echo "selected" ?>>Administrateur</option>
                            <option value="VISITEUR"<?php if($role == "VISITEUR") echo "selected" ?>>Visiteur</option>
                        </select>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success mt-2"><i class="fas fa-save"></i> Valider</button>
                            <a href="users.php" class="btn btn-info mt-2"> Retour </a>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                     <a href="modifier_pass.php?id_u=<?= $id_u?>">Changer le mot de passe</a>
                </div>
            </div>
    </div>

    
<?php require '../includes/footer.php';?>