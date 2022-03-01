<?php session_start();
include("../models/utilisateur.php"); // nécessaire pour executé les requête d'utilisateur
?>
<!doctype html>

<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Données Personelles</title>
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
                    <li class="nav-item active">
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
    </nav>

    <!-- Page Content -->

    <form action='../controllers/donneesPersoPost.php' method='POST'>
        <div class="container">
            <h1 class="my-4">Données personnelles</h1>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <h2 class="my-4">Pseudo actuel :</h2>
                    <?php echo $_SESSION['pseudo']; ?></Br></Br>
                    <button type="submit" name="modifPseudo" class="btn btn-primary">Modifier mon pseudo</button>
                </div>
                <div class="form-group col-md-6">
                    <h2 class="my-4">Mot de passe actuel :</h2>
                    <?php echo $_SESSION['mdp']; ?></Br></Br>
                    <button type="submit" name="modifMdp" class="btn btn-primary">Modifier mon mot de passe</button>
                </div>
            </div>

        </div>

    </form>

</body>

</html>