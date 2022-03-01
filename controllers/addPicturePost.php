<!doctype html>
<?php
session_start();
include("../models/bd.php"); // nécessaire pour executé les requête
include("../models/photo.php"); // nécessaire pour executé les requête
$link = getConnexion($dbHost, $dbUser, $dbPwd, $dbName);
if ($_POST['cache'] == NULL) {
    $_POST['cache'] = 0;
}
?>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ajout</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="../views/index.php">Accueil
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../views/contact.php">Contact</a>
                </li>
                <?php
                if (isset($_SESSION['pseudo'])) { ?>
                    <li class="nav-item active">
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



    // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
    if (isset($_FILES['picture']) and $_FILES['picture']['error'] == 0) {
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['picture']['size'] <= 800000) // 100Ko = 800000 bit
        {
            // Testons si l'extension est autorisée
            $infosfichier = pathinfo($_FILES['picture']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
            if (in_array($extension_upload, $extensions_autorisees)) {
                // On peut valider le fichier et le stocker définitivement
                $envoie = move_uploaded_file($_FILES['picture']['tmp_name'], '../assets/images/' . basename($_FILES['picture']['name']));
    ?><div class='container'>
                    <div class='row'>
                        <div class='alert alert-success' role='alert'>
                            Opération réussie, nouveau jeu ajouté !
                        </div>
                    </div>
                </div>
            <?php

                $lienPhoto = 'assets/images/' . basename($_FILES['picture']['name']);
                AddPicture($lienPhoto, $_POST['descriptif'], $_POST['categorie'], $_POST['nomImg'], $_POST['prix'], $_POST['etoile'], $_SESSION['pseudo'], $_POST['cache'], $link);
            } else {
            ?><div class='container'>
                    <div class='row'>
                        <div class='alert alert-danger' role='alert'>
                            Opération échouée, extension non autorisée !
                        </div>
                    </div>
                </div>
            <?php
            }
        } else {
            ?><div class='container'>
                <div class='row'>
                    <div class='alert alert-danger' role='alert'>
                        Opération échouée, image trop grosse !
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        echo var_dump($_FILES);
    }
    ?>

</body>

</html>