<!doctype html>
<?php
session_start();
include("../models/bd.php"); // nécessaire pour executé les requête
include("../models/photo.php"); // nécessaire pour executé les requête
$link = getConnexion($dbHost, $dbUser, $dbPwd, $dbName);
$tabCategorie = AllCategories($link);
$InfoJeu = InfoPicture($_GET['id'], $link);
foreach ($InfoJeu as $uneInfo) {
    $nomImg = $uneInfo['nom'];
    $descriptif = $uneInfo['description'];
    $prix = $uneInfo['prix'];
    $etoile = $uneInfo['etoile'];
    $catID = $uneInfo['catId'];
    $fileName = $uneInfo['nomFich'];
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
                <li class="nav-item ">
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
            <form action='../controllers/editGamePost.php' method='POST' enctype="multipart/form-data">
                <h1 class="my-4">Modification d'un jeu </h1>
                <div class="form-group">
                    <label for="descriptif">Descriptif du jeu</label>
                    <textarea class="form-control" id="descriptif" name="descriptif" rows="3"><?php echo $descriptif ?></textarea>
                </div></br>

                <div class="form-group">
                    <label for="NomImage">Nom du jeu</label>
                    <input type="text" class="form-control" name="nomImg" value="<?php echo $nomImg ?>">
                </div></br>


                <div class="form-group">
                    <label for="prix">Prix du jeu</label>
                    <input required type="number" step="any" min="0.00" max="100.00" class="form-control" name="prix" value="<?php echo $prix ?>">
                </div></br>

                <div class="form-group">
                    <label for="etoile">Nombre d'étoiles du jeu (entre 1 et 5)</label>
                    <input type="number" min="1" max="5" class="form-control" name="etoile" value="<?php echo $etoile ?>">
                </div></br>

                <div class="form-group">
                    <label for="Catégorie">Categorie du jeu</label>
                    <select class="form-control" name="categorie">
                        <?php
                        foreach ($tabCategorie as $oneCat) {
                            if ($oneCat['catId'] == $catID) {
                                echo "<option selected value='" . $oneCat['catId'] . "'>" . $oneCat['nomCat'] . "</option>";
                            } else {
                                echo "<option value='" . $oneCat['catId'] . "'>" . $oneCat['nomCat'] . "</option>";
                            }
                        }
                        ?>
                    </select></br>
                </div>

                <div class="form-group">
                    <label for="photo">Photo actuelle :</label>
                    <?php echo "<img src='../" . $fileName . "' class='img-thumbnail' alt='image-jeu'>"; ?>
                    <label for="inputSujet">modifier la photo :</label>
                    <input type="file" id="picture" name="picture" accept="image/png, image/jpeg, image/gif">
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="cache" value="1" id="defaultCheck">
                        <label class="form-check-label" for="defaultCheck">
                            Je souhaite cacher mon jeu aux autres
                        </label>
                    </div>
                </div>

                <?php echo "<input type='hidden' name='idPhoto' value='" . $_GET['id'] . "'>"; ?>

                <button type="submit" name="FormEdit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>

</body>

</html>