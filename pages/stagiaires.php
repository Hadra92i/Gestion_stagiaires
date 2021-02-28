<?php
require_once 'securite.php';
$message = isset($_GET['message']) ? $_GET['message'] : "";

require_once '../database/db.php';

$nomPrenom = isset($_GET['nomPrenom']) ? $_GET['nomPrenom'] :"";
$idfiliere = isset($_GET['idfiliere']) ? $_GET['idfiliere'] : 0;

$size = isset($_GET['size']) ? $_GET['size'] : 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1 ) * $size;

$requette_f = "SELECT * FROM filieres";

if($idfiliere == 0){
     $requette_s ="SELECT id_s,nom_s,prenom_s,civilite,photo,nom_f FROM filieres AS f,stagiaires AS s WHERE
     f.id_f = s.idF AND (nom_s LIKE '%$nomPrenom%' OR prenom_s LIKE '%$nomPrenom%') ORDER BY id_s LIMIT $size OFFSET $offset";
    $requette_s_count = "SELECT count(*) countS FROM  stagiaires WHERE nom_s LIKE '%$nomPrenom%' OR prenom_s LIKE '%$nomPrenom%'";
} else{
    $requette_s ="SELECT id_s,nom_s,prenom_s,civilite,photo,nom_f FROM filieres AS f,stagiaires AS s WHERE
    f.id_f = s.idF AND (nom_s LIKE '%$nomPrenom%' OR prenom_s LIKE '%$nomPrenom%') AND f.id_f = $idfiliere
    ORDER BY id_s LIMIT $size OFFSET $offset";
    $requette_s_count = "SELECT count(*) countS FROM stagiaires WHERE idF = $idfiliere AND (
    nom_s LIKE '%$nomPrenom%' OR prenom_s LIKE '%$nomPrenom%')";
}

$resultat_f = $db->query($requette_f);
$resultatStagiaire = $db->query($requette_s);

$resultat_count = $db->query($requette_s_count);
$tabCount = $resultat_count->fetch();
$nbs = $tabCount['countS'];
$reste = $nbs % $size;

if($reste === 0) 
    $nbpage = $nbs / $size;
else 
    $nbpage = floor($nbs / $size) + 1;

?>
<?php require '../includes/header.php';?>

    <?php require 'menu.php'?>
    <div class="container">
        <div class="card mt-3">
            <div class="card-header text-white bg-success">
                 <h5>Rechercher des Stagiaires ...</h5>
            </div>
            <div class="card-body bg-light">
                <form method="GET" class="form-inline">
                    <div class="form-group mr-2">
                         <input type="text" name="nomPrenom" placeholder="Nom et Prénom"
                          value="<?= $nomPrenom ?>" class="form-control">
                    </div>
                    <label for="idfiliere" class="mr-2">Filière :</label> 
                    <select name="idfiliere" class="form-control mr-2" id="idfiliere" onchange="this.form.submit()">
                            <option value=0>Toutes les filières</option>
                            <?php while($f = $resultat_f->fetch()): ?>
                                <option value="<?= $f['id_f']?>"
                                   <?php if($f['id_f'] === $idfiliere) echo "selected"?>>
                                      <?= $f['nom_f']?>
                                </option>
                            <?php endwhile ?>
                    </select>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Rechercher <i class="fas fa-search"></i></button>
                    </div>
                    &nbsp &nbsp;
                    <?php if($_SESSION['PROFILE']['role_u'] == 'ADMIN') : ?>
                        <a href="add_s.php" class="btn btn-primary"><i class="fas fa-plus"></i> Nouveau Stagiaire
                        </a>
                    <?php endif?>
                </form>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header text-white bg-info">
                 <h5>Liste des Stagiaires (<?= $nbs; ?> Stagiaires)</h5>
            </div>
            <div class="card-body bg-light">
                <?php if(!empty($message)):?>
                    <div class="alert alert-info">
                        <?= $message ?>
                    </div>
                <?php endif ?>
                   <table class="table table-bordered">
                       <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Civilité</th>
                                <th>Photo</th>
                                <th>Filière</th>
                                <?php if($_SESSION['PROFILE']['role_u'] == 'ADMIN') : ?>
                                     <th>Actions</th>
                                <?php endif ?>
                            </tr>
                       </thead>
                       <tbody>
                           <?php while($stagiaire = $resultatStagiaire->fetch()): ?>
                            <tr>
                                <td><?= $stagiaire['id_s'] ?></td>
                                <td><?= $stagiaire['nom_s'] ?></td>
                                <td><?= $stagiaire['prenom_s'] ?></td>
                                <td><?= $stagiaire['civilite'] ?></td>
                                <td>
                                    <center><img src="../images/<?= $stagiaire['photo'] ?>" width="60" height="60"></center>
                                </td>
                                <td><?= $stagiaire['nom_f'] ?></td>
                                <?php if($_SESSION['PROFILE']['role_u'] == 'ADMIN') : ?>
                                    <td>
                                        <a href="edit_s.php?id_s=<?= $stagiaire['id_s'] ;?>" class="btn btn-info">Editer <i class="fas fa-edit"></i></a>
                                        <a 
                                        onclick="return confirm('Etes vous sur de  vouloir supprimer ce stagiaire ?')"
                                        href="delete_s.php?id_s=<?= $stagiaire['id_s']; ?>" class="btn btn-danger">
                                        Supprimer <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                <?php endif ?>
                            </tr>
                           <?php endwhile ?>
                       </tbody>
                   </table>
                   <div>
                      <ul class="pagination">
                        <?php for($i = 1; $i <= $nbpage; $i++) :?>
                            <li class="<?php if($i == $page) echo 'page-item active'?>">
                                <a href="stagiaires.php?page=<?= $i ?>&nomPrenom=<?= $nomPrenom ?>&idfiliere=<?= $idfiliere ?>" class="page-link">
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