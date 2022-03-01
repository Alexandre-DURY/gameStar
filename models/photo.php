<?php

/*Cette fonction prend en entrée un pseudo à ajouter à la relation utilisateur et une connexion et 
retourne vrai si le pseudo est disponible (pas d'occurence dans les données existantes), faux sinon*/
function retiriveAllPictures($link)
{
	$query = "SELECT * FROM `Photo`;";
    $tab = executeQuery($link, $query);
    return $tab;
}

function retiriveAllPicturesFromUser($pseudo,$link)
{
    $query = "SELECT * FROM `Photo` WHERE pseudoUser = '$pseudo';";
    $tab = executeQuery($link, $query);
    return $tab;
}

function PicturesFromCategorie($Idcategorie,$link)
{
	$query = "SELECT * FROM `Photo` WHERE catId =$Idcategorie; ";
    $tab = executeQuery($link, $query);
    return $tab;
}

function PicturesFromCategorieUser($Idcategorie,$pseudo,$link)
{
	$query = "SELECT * FROM `Photo` WHERE catId =$Idcategorie AND pseudoUser = '$pseudo';";
    $tab = executeQuery($link, $query);
    return $tab;
}

function AllCategories($link)
{
	$query = "SELECT * FROM `Categorie`; ";
    $tab = executeQuery($link, $query);
    return $tab;
}

function AllInformations($photoId,$link)
{
	$query = "SELECT * FROM `Photo` P join `Categorie` C ON P.catId=C.CatId WHERE P.photoId = $photoId; ";
    $tab = executeLine($link, $query);
    return $tab;
}

function InfoPicture($idPhoto,$link)
{
    $query = "SELECT * FROM `Photo` WHERE photoId = $idPhoto;";
    $tab = executeQuery($link, $query);
    return $tab;
}


function AddPicture($lienImg,$descriptif,$catId,$nom,$prix,$etoile,$user,$cache,$link)
{
    $query = "INSERT INTO `Photo` (nomFich,description,catId,nom,prix,etoile,pseudoUser,cache) VALUES ('$lienImg', '$descriptif', $catId,'$nom',$prix,$etoile,'$user',$cache) ";
    $tab = executeUpdate($link,$query);
    return $tab;
}

function deleteGameFromUser($pseudo,$idPhoto,$link)
{
    $query = "DELETE FROM `Photo` WHERE `photoId` = $idPhoto AND pseudoUser = '$pseudo';";
    $tab = executeUpdate($link, $query);
    return $tab;
}

function EditLienPhoto($photoId,$lienPhoto,$link)
{
    $query = "UPDATE `Photo` SET nomFich = '$lienPhoto' WHERE photoId = $photoId; ";
    $tab = executeUpdate($link, $query);
    return $tab;
}

function EditDescriptif($photoId,$descriptif,$link)
{
    //attention guillmets
    $query = "UPDATE `Photo` SET description = '$descriptif' WHERE photoId = $photoId;";
    $tab = executeUpdate($link, $query);
    return $tab;
}

function EditCategorie($photoId,$categorie,$link)
{
    $query = "UPDATE `Photo` SET catId = $categorie WHERE photoId = $photoId; ";
    $tab = executeUpdate($link, $query);
    return $tab;
}
function EditNomImg($photoId,$nomImg,$link)
{
    $query = "UPDATE `Photo` SET nom = '$nomImg' WHERE photoId = $photoId; ";
    $tab = executeUpdate($link, $query);
    return $tab;
}
function EditPrix($photoId,$prix,$link)
{
    $query = "UPDATE `Photo` SET prix = $prix WHERE photoId = $photoId; ";
    $tab = executeUpdate($link, $query);
    return $tab;
}
function EditEtoile($photoId,$etoile,$link)
{
    $query = "UPDATE `Photo` SET etoile = $etoile WHERE photoId = $photoId; ";
    $tab = executeUpdate($link, $query);
    return $tab;
}

function EditCache($photoId,$cache, $link)
{
    $query = "UPDATE `Photo` SET cache = $cache WHERE photoId = $photoId; ";
    $tab = executeUpdate($link, $query);
    return $tab;
}
?>