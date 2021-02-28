
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="../index.php">Gestion des Stagiaires</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item ">
          <a class="nav-link" href="stagiaires.php">Les stagiaires</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="filieres.php">Les filières</a>
        </li>
        <?php if($_SESSION['PROFILE']['role_u'] == 'ADMIN') : ?>
          <li class="nav-item">
            <a class="nav-link" href="users.php">Les utilisateurs</a>
          </li>
        <?php endif ?>
      </ul>
      <ul class="nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link" href="compte.php"><i class="fas fa-user"></i> <?= $_SESSION['PROFILE']['pseudo'] ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="logout.php"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a>
        </li>
      </ul>
    </div>
  </nav>

