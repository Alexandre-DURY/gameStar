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
                    <a class="nav-link" href="../views/index.php">Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../views/contact.php">Contact</a>
                    <span class="sr-only">(current)</span>
                </li>
                <?php
                if (isset($_SESSION['pseudo'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/addPicture.php">Ajout jeu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/ourGames.php">Mes jeux</a>
                    </li>
                    <li class="nav-item active">
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
    </nav>

    <!-- Page Content -->

    <?php
    if (isset($_POST['modifPseudo'])) { ?>
        <div class="container">
            <h1 class="my-4">Données personnelles</h1>
            <h2 class="my-4">Modification du pseudo</h2>
            <form action='validationPost.php' method='POST' class="form-example">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputPseudo">Nouveau pseudo</label>
                        <input required type="text" name="newpseudo" class="form-control" id="inputPseudo" placeholder="Pseudo">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputMdp">Confirmation du nouveau pseudo</label>
                        <input required type="text" name="newpseudo2" class="form-control" id="inputPseudo2" placeholder="Pseudo">
                    </div>
                </div>
                <button type="submit" name="modificationPseudo" class="btn btn-primary">Valider</button>
            </form>
            </br>
            <a href="../views/donneesPerso.php"><button class="btn btn-secondary">Retour</button></a>
        </div>
    <?php
    }
    if (isset($_POST['modifMdp'])) { ?>
        <div class="container">
            <h1 class="my-4">Données Personnelles</h1>
            <h2 class="my-4">Modification du mot de passe</h2>
            <form action='validationPost.php' method='POST' class="form-example">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputPseudo">Nouveau mot de passe</label>
                        <input required type="password" name="newmdp" class="form-control" id="inputMdp" placeholder="Mot de passe">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputMdp">Confirmation du nouveau mot de passe</label>
                        <input required type="password" name="newmdp2" class="form-control" id="inputMdp2" placeholder="Mot de passe">
                    </div>
                </div>
                <button type="submit" name="modificationMdp" class="btn btn-primary">Valider</button>
            </form>
            </br>
            <a href="../views/donneesPerso.php"><button class="btn btn-secondary">Retour</button></a>

        </div>
    <?php
    }
    ?>


</body>

</html>