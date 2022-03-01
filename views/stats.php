<?php session_start();
include("../models/bd.php"); // nécessaire pour executé les requête sur sql
include("../models/photo.php"); // nécessaire pour executé les requête des photos
include("../models/utilisateur.php"); // nécessaire pour executé les requête d'utilisateur
$link = getConnexion($dbHost, $dbUser, $dbPwd, $dbName);
$tabCategorie = AllCategories($link);
$tabUser = AllUser($link);

?>
<!doctype html>

<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Contact</title>
    <!--===============================================================================================-->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="../../bootstrap/css/monstyle.css">
</head>

<body>

    </br></br></br>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="index.php">Stay at home to play</a>
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
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                    <span class="sr-only">(current)</span>
                </li>
                <?php
                if (isset($_SESSION['pseudo'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="addPicture.php">Ajout jeu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ourGames.php">Mes jeux</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="donneesPerso.php">Données personnelles</a>
                    </li>
                    <?php if ($_SESSION['pseudo'] == 'admin') { ?>
                        <li class="nav-item active">
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
    </nav>

    <!-- Page Content -->
    <div class="container">
        <h1 class="my-4">Statistiques</h1>
        <div class="form-row">
            <div class="form-group col-md-6">
                <h2 class="my-4">Nombre d'utilisateurs</h2>
                <?php $nbUtilisateur = nbUtilisateur($link);
                echo $nbUtilisateur[0] ?>
            </div>
            <div class="form-group col-md-6">
                <h2 class="my-4">Nombre d'utilisateurs connectés</h2>
                <?php $nbUtilisateurConnecte = nbUtilisateurConnecte($link);
                echo $nbUtilisateurConnecte[0] ?></br>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <h2 class="my-4">Nombre de jeux par catégories</h2>
                <label>Selectionner une catégorie </label>
                <form action='stats.php' method='POST' class="form-example">
                    <div class="form-group">
                        <select multiple class="form-control" name="categorie">
                            <?php
                            foreach ($tabCategorie as $oneCat) {
                                echo "<option value='" . $oneCat['catId'] . "'>" . $oneCat['nomCat'] . "</option>";
                            }
                            ?>
                        </select></br>
                        <button type="submit" name="envoiCategorie" class="btn btn-primary">Valider</button>
                    </div>
                </form>
                <?php if (isset($_POST['envoiCategorie'])) {
                    if (isset($_POST['categorie'])) {
                        $nbPhotoCategorie = nbPhotoCategorie($_POST['categorie'], $link);
                        echo $nbPhotoCategorie[0];
                    } else {
                        echo "Veuillez sélectionner une catégorie";
                    }
                } ?>
            </div>
            <div class="form-group col-md-6">
                <h2 class="my-4">Nombre de jeux par utilisateur</h2>
                <label>Selectionner un utilisateur </label>
                <form action='stats.php' method='POST' class="form-example">
                    <div class="form-group">
                        <select multiple class="form-control" name="user">
                            <?php
                            foreach ($tabUser as $oneUser) {
                                echo '<option value="' . $oneUser['pseudo'] . '">' . $oneUser['pseudo'] . '</option>';
                            }
                            ?>
                        </select></br>
                        <button type="submit" name="envoiUtilisateur" class="btn btn-primary">Valider</button>
                    </div>
                </form>
                <?php if (isset($_POST['envoiUtilisateur'])) {
                    if (isset($_POST['user'])) {
                        $nbPhotoUtilisateur = nbPhotoUtilisateur($_POST['user'], $link);
                        echo $nbPhotoUtilisateur[0];
                    } else {
                        echo "Veuillez sélectionner un utilisateur";
                    }
                } ?>
            </div>
        </div>
    </div>

</body>

</html>