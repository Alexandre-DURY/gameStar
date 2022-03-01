<!doctype html>
<?php
session_start();
include("../models/bd.php"); // nécessaire pour executé les requête
include("../models/photo.php"); // nécessaire pour executé les requête
$link = getConnexion($dbHost, $dbUser, $dbPwd, $dbName);
$idPhoto = $_GET['id'];
$oneGame = AllInformations($idPhoto, $link);
?>
<html lang="fr">

<head>
    <meta charset="UTF-8" content-type='text/html'>
    <title>Accueil</title>
    <!--===============================================================================================-->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="../../bootstrap/css/monstyle.css">
</head>

<body>
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
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
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

    <!-- Page Content -->


    <div class="container">
        <h1 class="my-4">Détails du jeu</h1>
        <div class="card">
            <div class="card-header">
                Nom du jeu :
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <?php echo "<p>" . $oneGame['nom'] . " </p>";  ?>
                    <footer class="blockquote-footer">Avec une note de <cite title="Source Title"><?php echo $oneGame['etoile'] . "/5"; ?></cite>
                    </footer>
                </blockquote>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Description du jeu :
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <div class="row">
                        <div class="col-md-5">
                            <?php echo "<img src='../" . $oneGame['nomFich'] . "' class='img-thumbnail' alt='image-jeu'>"; ?>
                        </div>
                        <div class="col-md-5">
                            <?php echo "<p>" . $oneGame['description'] . " </p>"; ?>
                            <form action="index.php" method="POST" class="form-example">
                                <div class="form-group">
                                    <p>Voir les jeux de la catégorie : <button type="submit" name="categorie" value="<?php echo $oneGame['catId'] ?>" class="btn btn-info"><?php echo $oneGame['nomCat']; ?></button></p>
                                </div>
                            </form>
                        </div>
                    </div>
                    <footer class="blockquote-footer">Au prix de <cite title="Source Title"><?php echo $oneGame['prix']; ?></cite></footer>
                </blockquote>


            </div>
        </div>


    </div>

</body>

</html>