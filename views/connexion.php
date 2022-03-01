<?php
include("../models/bd.php"); // nécessaire pour executé les requête
include("../models/utilisateur.php"); // nécessaire pour executé les requête
session_start();
?>

<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Stay at home to play</title>
  <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../bootstrap/css/monstyle.css">
</head>

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
          <a class="nav-link" href="../views/index.php">Accueil
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../views/contact.php">Contact</a>
        </li>
        <li class="nav-item">
          <a href="../views/connexion.php"><button class="btn btn-primary">Connexion</button></a>
        </li>
      </ul>
    </div>
  </nav></br></br></br>
  <?php
  $link = getConnexion($dbHost, $dbUser, $dbPwd, $dbName);

  ?>
  <div class="container">
    <div class="jumbotron">
      <h1>Page de connexion</h1>
      <form action="connexion.php" method="POST" class="form-example">

        <div class="form-group row">
          <label for="lbl_pseudo" class="col-sm-3 col-form-label">Pseudo</label>
          <div class="col-sm-3">
            <input required type="text" class="form-control" name="pseudo" id="pseudo" placeholder="pseudo" required>
          </div>
          <?php
          if (isset($_POST['envoi'])) { // si formulaire soumis
            $pseudo = $_POST['pseudo'];
            $pwd = $_POST['mdp'];
            $link = getConnexion($dbHost, $dbUser, $dbPwd, $dbName);
            $connexionValide = getUser($pseudo, $pwd, $link);
            if ($connexionValide) {
              $_SESSION["pseudo"] = $pseudo;
              $_SESSION["mdp"] = $pwd;
              $_SESSION['log_time'] = time();
              setConnected($pseudo, $link);
              echo  $_SESSION["pseudo"];
              header('Location: https://bdw1.univ-lyon1.fr/p1919722/projet/views/index.php');
              exit();
            }
          }

          ?>
        </div>

        <div class="form-group row">
          <label for="Password" class="col-sm-3 col-form-label">Mot de passe</label>
          <div class="col-sm-3">
            <input required type="password" class="form-control" name="mdp" id="mdp" placeholder="mot de passe sécurisé">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-3">
            <button type="submit" name="envoi" class="btn btn-primary">Se connecter</button>
          </div>
        </div>
        <?php
        if (isset($_POST['envoi'])) {
          if (!($connexionValide)) {
            echo "<div class='alert alert-danger' role='alert'>
        Le couple pseudo/mot de passe ne correspond à aucun utilisateur enregistré !
        </div>";
          }
        }
        ?>
      </form>
      </br>
      <a href="inscription.php">Vous n'avez pas de compte ? Cliquez-ici </a>
    </div>
  </div>

</body>

</html>