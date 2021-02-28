<?php
require_once 'securite.php';
require_once '../database/db.php';

$pseudo = isset($_GET['pseudo']) ? $_GET['pseudo'] :"";

$size = isset($_GET['size']) ? $_GET['size'] : 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1 ) * $size;

$request = "SELECT * FROM users WHERE pseudo LIKE '%$pseudo%'";
$requst_count = "SELECT COUNT(*) countU FROM users ";
$users = $db->query($request);

$resultat_count = $db->query($requst_count);
$tabCount = $resultat_count->fetch();
$nbu = $tabCount['countU'];
$reste = $nbu % $size;

if($reste === 0) 
    $nbpage = $nbu / $size;
else 
    $nbpage = floor($nbu / $size) + 1;

?>

<?php require '../includes/header.php';?>

    <?php require 'menu.php'?>
    <div class="container">
        <div class="card mt-3">
             <div class="card-header text-white bg-success">
                 <h5>Rechercher des utilisateurs ...</h5>
            </div>
            <div class="card-body bg-light">
              <form method="GET" class="form-inline">
                    <div class="form-group mr-2">
                         <input type="text" name="pseudo" placeholder="Saisir le pseudo du user" value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Rechercher <i class="fas fa-search"></i></button>
                    </div>
              </form>
            </div>
        </div>
        <div class="card mt-5">
             <div class="card-header text-white bg-info">
                 <h5>Liste des utilisateurs (<?= $nbu ?> Utilisateurs)</h5>
            </div>
            <div class="card-body bg-light">
                 <table class="table table-bordered">
                     <thead>
                         <tr>
                             <th>ID</th>
                             <th>Pseudo</th>
                             <th>Email</th>
                             <th>Role</th>
                             <th>Etat du compte</th>
                             <th>Actions</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php while($user = $users->fetch()) :?>
                         <tr>
                            <td><?= $user['id_u'] ?></td>
                            <td><?= $user['pseudo']?></td>
                            <td><?= $user['email']?></td>
                            <td><?= $user['role_u']?></td>
                            <td>
                                <a href="activer_compte.php?id_u=<?= $user['id_u']?>&etat=<?= $user['etat']?>">
                                    <?php
                                        if($user['etat'] == 1)
                                            echo '<button class="btn btn-success btn-block">Actif</button>';
                                        else
                                            echo '<button class="btn btn-danger btn-block">Inactif</button>';
                                    ?>
                                </a>
                            </td>
                            <td>
                                <a href="edit_u.php?id_u=<?= $user['id_u']?>" class="btn btn-info">Editer <i class="fas fa-edit"></i></a>
                                <a  onclick="return confirm('Etes vous sur de  vouloir supprimer ce user ?')"
                                    href="delete_u.php?id_u=<?= $user['id_u']?>" class="btn btn-danger">
                                    Supprimer <i class="fas fa-trash"></i>
                                </a>
                            </td>
                         </tr>
                         <?php endwhile ?>
                     </tbody>
                 </table>
                 <div>
                      <ul class="pagination">
                        <?php for($i = 1; $i <= $nbpage; $i++) :?>
                            <li class="<?php if($i == $page) echo 'page-item active'?>">
                                <a href="users.php?page=<?= $i ?>&pseudo=<?= $pseudo ?>" class="page-link">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor ?>
                      </ul>
                   </div>
            </div>
        </div>
    </div>
    <?php require '../includes/footer.php';?>