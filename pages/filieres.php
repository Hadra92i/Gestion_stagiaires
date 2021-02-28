<?php
require_once 'securite.php';

//$message = isset($_SESSION['msg_addf']) ? $_SESSION['msg_addf'] : "";

require_once '../database/db.php';

$nom_filiere = isset($_GET['nom_f']) ? $_GET['nom_f'] : "";
$niveau      = isset($_GET['niveau']) ? $_GET['niveau'] : "all";

$size = isset($_GET['size']) ? $_GET['size'] : 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1 ) * $size;

if($niveau === "all"){
    $request = "SELECT * FROM filieres WHERE nom_f LIKE '%$nom_filiere%' LIMIT $size OFFSET $offset";
    $request_count = "SELECT count(*) countF FROM  filieres  WHERE nom_f LIKE '%$nom_filiere%'";
} else{
    $request = "SELECT * FROM filieres WHERE nom_f LIKE '%$nom_filiere%' AND niveau = '$niveau' LIMIT $size OFFSET $offset";
    $request_count = "SELECT count(*) countF FROM  filieres WHERE nom_f LIKE '%$nom_filiere%' AND niveau = '$niveau'";
}

$filieres = $db->query($request);

$resultat_count = $db->query($request_count);
$tabCount = $resultat_count->fetch();
$nbf = $tabCount['countF'];
$reste = $nbf % $size;

if($reste === 0) 
    $nbpage = $nbf / $size;
else 
    $nbpage = floor($nbf / $size) + 1;

?>

<?php require '../includes/header.php';?>

    <?php require 'menu.php'?>
    <div class="container">
        <div class="card mt-3">
            <div class="card-header text-white bg-success">
                 <h5>Rechercher des filières ...</h5>
            </div>
            <div class="card-body bg-light">
                <form method="GET" class="form-inline">
                    <div class="form-group mr-2">
                         <input type="text" name="nom_f" placeholder="Saisir le nom de la filière" value="<?= $nom_filiere ?>" class="form-control">
                    </div>
                    <label for="niveau" class="mr-2">Niveau :</label> 
                    <select name="niveau" class="form-control mr-2" id="niveau" onchange="this.form.submit()">
                        <option value="all" <?php if ($niveau === "all") echo "selected"?>>Tous les niveaux</option>
                        <option value="m"   <?php if ($niveau === "m")   echo "selected"?>>Master</option>
                        <option value="l"   <?php if ($niveau === "l")   echo "selected"?>>Licence</option>
                        <option value="ts"  <?php if ($niveau === "ts")  echo "selected"?>>Technicien spécialisé</option>
                        <option value="t"   <?php if ($niveau === "t")   echo "selected"?>>Technicien</option>
                        <option value="q"   <?php if ($niveau === "q")   echo "selected"?>>Qualification</option>
                    </select>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Rechercher <i class="fas fa-search"></i></button>
                    </div>
                    &nbsp &nbsp;
                    <?php if($_SESSION['PROFILE']['role_u'] == 'ADMIN') : ?>
                        <a href="add_f.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nouvelle filière
                        </a>
                    <?php endif?>
                </form>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header text-white bg-info">
                 <h5>Liste des filières (<?= $nbf; ?> Filières)</h5>
            </div>
            <div class="card-body bg-light">
                <?php  if(!empty($message)) : ?>
                   <div class="alert alert-danger">
                       <?= $message ?>
                   </div>
                <?php endif?>
                   <table class="table table-bordered">
                       <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom de la filière</th>
                                <th>Niveau</th>
                                <?php if($_SESSION['PROFILE']['role_u'] == 'ADMIN') : ?>
                                    <th>Actions</th>
                                <?php endif?>
                            </tr>
                       </thead>
                       <tbody>
                           <?php while($filiere = $filieres->fetch()): ?>
                            <tr>
                                <td><?= $filiere['id_f'] ?></td>
                                <td><?= $filiere['nom_f'] ?></td>
                                <td><?= $filiere['niveau'] ?></td>
                                <?php if($_SESSION['PROFILE']['role_u'] == 'ADMIN') : ?>
                                    <td>
                                        <a href="edit.php?id_f=<?= $filiere['id_f'] ;?>" class="btn btn-info">Editer <i class="fas fa-edit"></i></a>
                                        <a 
                                        onclick="return confirm('Etes vous sur de  vouloir supprimer cette filière ?')"
                                        href="delete.php?id_f=<?= $filiere['id_f']; ?>" class="btn btn-danger">
                                        Supprimer <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                <?php endif?>
                            </tr>
                           <?php endwhile ?>
                       </tbody>
                   </table>
                   <div>
                      <ul class="pagination">
                        <?php for($i = 1; $i <= $nbpage; $i++) :?>
                            <li class="<?php if($i == $page) echo 'page-item active'?>">
                                <a href="filieres.php?page=<?= $i ?>&nom_f=<?= $nom_filiere?>&niveau=<?= $niveau ?>" class="page-link">
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