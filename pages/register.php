
<?php

if(!empty($_POST)){

    require_once '../database/db.php';

    $erreurs = [];

    if(empty($_POST['pseudo']) || !preg_match('/^[a-zA-Z0-9_]+$/',$_POST['pseudo'])){
        $erreurs['pseudo'] = 'Votre pseudo n\'est pas valide (alphanumérique) !';
    }else{
        $sql_select = $db->prepare("SELECT id_u FROM users WHERE pseudo = ?");
        $sql_select->execute([$_POST['pseudo']]);
        $user = $sql_select->fetch();
        if($user){
            $erreurs['pseudo'] = 'Ce pseudo est déja pris !';
        }
    }

    if(empty($_POST['email']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
       $erreurs['email'] = 'Votre email n\'est pas valide !';
    }else{
        $sql_select = $db->prepare("SELECT id_u FROM users WHERE email = ?");
        $sql_select->execute([$_POST['email']]);
        $user = $sql_select->fetch();
        if($user){
            $erreurs['email'] = 'Cet email est déja pris pour un autre compte !';
        }
    }

    if(empty($_POST['pass']) || $_POST['pass'] != $_POST['pass_confirm']){
        $erreurs['pass'] = 'Les deux mots de passe ne correspondent pas !';
    }

    if(empty($erreurs)){

        $sql_insert = $db->prepare("INSERT INTO users SET pseudo = ?,email = ?,pwd = ?");
        $password   = sha1($_POST['pass']);
        $sql_insert->execute([$_POST['pseudo'],$_POST['email'],$password]);
        header('Location:login.php');
        exit();
    }
}

?>

<?php require '../includes/header.php' ?>

<div class="container">
    <div class="row my-4">
        <div class="col-md-6 mx-auto">
            <div class="card mt-5">
                <div class="card-header bg-info">
                    <h3 class="text-center">S'inscrire</h3>
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
                    <form method="POST">
                        <div class="form-group">
                            <label for="pseudo">Pseudo</label>
                            <input type="text" name="pseudo" id="pseudo"  class="form-control" placeholder="Saisir votre Pseudo">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Saisir votre email">
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" name="pass" id="mot de passe"  class="form-control" placeholder="Saisir votre mot de passe">
                        </div>
                        <div class="form-group">
                            <label for="mot de passe">Confirmez votre mot de passe</label>
                            <input type="password" name="pass_confirm" id="mot de passe"  class="form-control" placeholder="Confirmer le mot de passe">
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" name="valider" class="btn btn-success">M'INSCRIRE</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                        <a href="login.php"> Login</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require '../includes/footer.php' ?>