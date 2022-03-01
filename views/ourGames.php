<!doctype html>
<?php
session_start();
include("../models/bd.php"); // nécessaire pour executé les requête sur sql
include("../models/photo.php"); // nécessaire pour executé les requête des photos
include("../models/utilisateur.php"); // nécessaire pour executé les requête d'utilisateur
$link = getConnexion($dbHost, $dbUser, $dbPwd, $dbName);
$tabPictures = retiriveAllPicturesFromUser($_SESSION['pseudo'], $link);
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
                    <li class="nav-item active">
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

        <div class="row">

            <div class="col-lg-3">

                <h1 class="my-4">Mes jeux video</h1>

                <label>Sélectionner la catégorie que vous souhaitez visualiser :</label>
                <form action='ourGames.php' method='POST' class="form-example">
                    <div class="form-group">
                        <select multiple class="form-control" name="categorie">
                            <?php
                            foreach ($tabCategorie as $oneCat) {
                                echo "<option value='" . $oneCat['catId'] . "'>" . $oneCat['nomCat'] . "</option>";
                            }
                            ?>
                        </select></br>
                        <button type="submit" name="envoi" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
            <!-- /.col-lg-3 -->
            <div class="col-lg-9">
                <div class="row">


                    <?php
                    if (isset($_POST['categorie'])) {
                        $tabFromCat = PicturesFromCategorieUser($_POST['categorie'], $_SESSION['pseudo'], $link);
                        if (isset($tabFromCat)) {
                            foreach ($tabFromCat as $PictureCat) { ?>
                                <div class='col-lg-4 col-md-6 mb-4'>
                                    <div class='card h-100'>
                                        <?php echo "<a href='detail.php?id=" . $PictureCat['photoId'] . "'><img class='card-img-top' src='../" . $PictureCat['nomFich'] . "' alt='photo'></a>";
                                        ?><div class='card-body'>
                                            <h4 class='card-title'>
                                                <?php echo "<a href='detail.php?id=" . $PictureCat['photoId'] . "'> " . $PictureCat['nom'] . "</a>";
                                                ?>
                                            </h4>
                                            <?php echo '<h5>' . $PictureCat['prix'] . ' €</h5>' ?>
                                            <p class='card-text'><?php echo $PictureCat['description'] ?></p>
                                            <div class='card-text'>
                                                <?php echo "<a href='editGame.php?id=" . $PictureCat['photoId'] . "' >" ?>
                                                <button class="btn btn-primary">Modifier</button>
                                                </a>
                                                <?php echo "<a href='../controllers/deleteGame.php?id=" . $PictureCat['photoId'] . "' >" ?>
                                                <button class="btn btn-danger">Supprimer</button>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='card-footer'>
                                            <?php if ($PictureCat['etoile'] == '3') { ?>
                                                <small class='text-muted'>&#9733; &#9733; &#9733; &#9734; &#9734;</small>
                                            <?php }
                                            if ($PictureCat['etoile'] == '4') { ?>
                                                <small class='text-muted'>&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                                            <?php }
                                            if ($PictureCat['etoile'] == '5') { ?>
                                                <small class='text-muted'>&#9733; &#9733; &#9733; &#9733; &#9733;</small>
                                            <?php } ?>
                                        </div>

                                    </div>
                                </div>
                            <?php
                            }
                        }
                    } else {
                        foreach ($tabPictures as $onePicture) {
                            ?>
                            <div class='col-lg-4 col-md-6 mb-4'>
                                <div class='card h-100'>
                                    <?php echo "<a href='detail.php?id=" . $onePicture['photoId'] . "'><img class='card-img-top' src='../" . $onePicture['nomFich'] . "' alt='photo'></a>";
                                    ?><div class='card-body'>
                                        <h4 class='card-title'>
                                            <?php echo "<a href='detail.php?id=" . $onePicture['photoId'] . "'> " . $onePicture['nom'] . "</a>";
                                            ?>
                                        </h4>
                                        <?php echo '<h5>' . $onePicture['prix'] . ' €</h5>' ?>
                                        <p class='card-text'><?php echo $onePicture['description'] ?></p>
                                        <div class='card-text'>
                                            <?php echo "<a href='editGame.php?id=" . $onePicture['photoId'] . "' >" ?>
                                            <button class="btn btn-primary">Modifier</button>
                                            </a>
                                            <?php echo "<a href='../controllers/deleteGame.php?id=" . $onePicture['photoId'] . "' >" ?>
                                            <button class="btn btn-danger">Supprimer</button>
                                            </a>
                                        </div>
                                    </div>
                                    <div class='card-footer'>
                                        <?php if ($onePicture['etoile'] == '3') { ?>
                                            <small class='text-muted'>&#9733; &#9733; &#9733; &#9734; &#9734;</small>
                                        <?php }
                                        if ($onePicture['etoile'] == '4') { ?>
                                            <small class='text-muted'>&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                                        <?php }
                                        if ($onePicture['etoile'] == '5') { ?>
                                            <small class='text-muted'>&#9733; &#9733; &#9733; &#9733; &#9733;</small>
                                        <?php } ?>
                                    </div>

                                </div>
                            </div>
                    <?php
                        }
                    } ?>

</body>

</html>