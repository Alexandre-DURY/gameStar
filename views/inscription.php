<?php
require_once('../models/bd.php');
require_once('../models/utilisateur.php');
session_start();
?>

<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>inscription</title>
  <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../bootstrap/css/monstyle.css">
</head>
<?php
if (isset($_POST['envoi'])) { // si formulaire soumis
  $pseudo = $_POST['pseudo'];
  $pwd = $_POST['password'];
  $verifPwd = $_POST['verifPassword'];
  $link = getConnexion($dbHost, $dbUser, $dbPwd, $dbName);
  $pseudoValide = checkAvailability($pseudo, $link);
  if (isset($pseudoValide)  && $pwd == $verifPwd) {
    register($pseudo, $pwd, $link);
    header('Location: https://bdw1.univ-lyon1.fr/p1919722/projet/views/connexion.php');
    exit();
  }
}
?>

<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="../views/index.php">Stay at home to play</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <p class="text-warning"></br><?php if (isset($_SESSION['pseudo'])) {
                                    echo "Utilisateur : " . $_SESSION['pseudo'];
                                    $tempsDeConnexion = ((time() - $_SESSION['log_time']) / 60);
                                    $tempsDeConnexion = round($tempsDeConnexion);
                                    $tempsSec = fmod((time() - $_SESSION['log_time']), 60);
                                    echo " - Temps de connexion : " . $tempsDeConnexion . " minutes et " . $tempsSec . " secondes";
                                  } ?></p>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Accueil
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
        <?php
        if (isset($_SESSION['pseudo'])) { ?>
          <li class="nav-item active">
            <a class="nav-link" href="addPicture.php">Ajout jeu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ourGames.php">Mes jeux</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="donneesPerso.php">Données personnelles</a>
          </li>
          <?php if ($_SESSION['pseudo'] == 'admin' && $_SESSION['mdp'] == 'admin') { ?>
            <li class="nav-item">
              <a class="nav-link" href="stats.php">Statistiques</a>
            </li>
          <?php } ?>

          <li class="nav-item">
            <form action="index.php" method="POST" class="form-example">
              <div class="form-group">
                <div class='col-md-10'></div>
                <div class='col-md-2'>
                  <button type="submit" name="deco" class="btn btn-outline-danger">Déconnexion</button>
                </div>
              </div>
            </form>
          </li>
        <?php } else {
        ?> <li class="nav-item">
            <a href="connexion.php"><button class="btn btn-outline-primary">Connexion</button></a>
          </li> <?php
              } ?>
      </ul>
    </div>
  </nav></br></br></br>
  <div class="container">
    <div class="jumbotron">
      <h1>Page d'inscription</h1>
      <form action="inscription.php" method="POST" class="form-example">
        <div class="form-group row">
          <label for="lbl_pseudo" class="col-sm-3 col-form-label">Pseudo souhaité :</label>
          <div class="col-sm-3">
            <input required type="text" class="form-control" name="pseudo" id="pseudo" placeholder="pseudo" required>
          </div>
          <?php
          if (isset($_POST['envoi'])) {
            if ($pseudoValide == NULL) {
              echo "<div class='alert alert-danger' role='alert'>
        Pseudo déjà utilisé !
        </div>";
            }
          }
          ?>
        </div>
        <div class="form-group row">
          <label for="Password" class="col-sm-3 col-form-label">Mot de passe</label>
          <div class="col-sm-3">
            <input required type="password" class="form-control" name="password" id="password" placeholder="mot de passe sécurisé">
          </div>
        </div>
        <div class="form-group row">
          <label for="verifPassword" class="col-sm-3 col-form-label">Vérification mot de passe</label>
          <div class="col-sm-3">
            <input required type="password" class="form-control" name="verifPassword" id="verifPassword" placeholder="retaper votre mot de passe">
          </div>
          <?php
          if (isset($_POST['envoi'])) {
            if ($pwd != $verifPwd) {
              echo "<div class='alert alert-danger' role='alert'>
        Mot de passe pas identique !
        </div>";
            }
          }
          ?>
        </div>
        <div class="form-group row">
          <div class="col-sm-3">
            <button type="submit" name="envoi" class="btn btn-primary">S'inscrire</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>

</html>