<!doctype html>
<?php
session_start();
include("../models/bd.php"); // nécessaire pour executé les requête sur sql
include("../models/photo.php"); // nécessaire pour executé les requête des photos
include("../models/utilisateur.php"); // nécessaire pour executé les requête d'utilisateur
$link = getConnexion($dbHost, $dbUser, $dbPwd, $dbName);
$tabPictures = retiriveAllPictures($link);
$tabCategorie = AllCategories($link);

if (isset($_POST['deco'])) { // si formulaire soumis
    setDisconnected($_SESSION['pseudo'], $link);
    unset($_SESSION['pseudo']);
    header('Location: https://bdw1.univ-lyon1.fr/p1919722/projet/views/index.php');
    exit();
}

?>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Accueil</title>
    <!--===============================================================================================-->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
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
                <li class="nav-item active">
                    <a class="nav-link" href="../views/index.php">Accueil
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../views/contact.php">Contact</a>
                </li>
                <?php
                if (isset($_SESSION['pseudo'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/addPicture.php">Ajout jeu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/ourGames.php">Mes jeux</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/donneesPerso.php">Données personnelles</a>
                    </li>
                    <?php if ($_SESSION['pseudo'] == 'admin' && $_SESSION['mdp'] == 'admin') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../views/stats.php">Statistiques</a>
                        </li>
                    <?php } ?>

                    <li class="nav-item">
                        <form action="../views/index.php" method="POST" class="form-example">
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
                        <a href="../views/connexion.php"><button class="btn btn-outline-primary">Connexion</button></a>
                    </li> <?php
                        } ?>

            </ul>
        </div>
    </nav></br></br></br>

    <!-- Page Content -->


    <?php

    if (deleteGameFromUser($_SESSION['pseudo'], $_GET['id'], $link)) {
    ?>
        <div class='row'>
            <div class='alert alert-success' role='alert'>
                Opération réussie, jeu supprimé !
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class='row'>
            <div class='alert alert-danger' role='alert'>
                Opération échouée, le jeu n'a pas pu être supprimé, contacter l'administrateur.
            </div>
        </div>
    <?php
    }
