<?php

$dbHost = "localhost";// à compléter
$dbUser = "p1919722";// à compléter
$dbPwd = "0d4c4c";// à compléter
$dbName = "p1919722";

/*Cette fonction prend en entrée l'identifiant de la machine hôte de la base de données, les identifiants (login, mot de passe) d'un utilisateur autorisé 
sur la base de données contenant les tables pour le chat et renvoie une connexion active sur cette base de donnée. Sinon, un message d'erreur est affiché.*/
function getConnexion($dbHost, $dbUser, $dbPwd, $dbName)
{
	try {
		$cnx = new PDO("mysql:host=$dbHost;dbname=$dbName", "$dbUser", "$dbPwd"); // on créer la connexion
		$cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$cnx->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		// Connexion module PDO
	} catch (PDOException $e) {
		// en cas d'erreur
		$erreur = $e->getMessage();
		echo "vous n'êtes pas connecté" . $e->getMessage();
	}
	return $cnx;
}

/*Cette fonction prend en entrée une connexion vers la base de données du chat ainsi 
qu'une requête SQL SELECT et renvoie les résultats de la requête dans un tableau à 2 dimensions . Si le résultat est faux, un message d'erreur est affiché*/
function executeQuery($link, $query)
{
	try {

		$sth = $link->prepare($query);

        $sth->execute(array());

        $res = $sth->fetchAll();

        return $res;
		
	} catch (PDOException $e) {
		$erreur = $e->getMessage();
		echo"Erreur requête !";
	}
}

/*Cette fonction prend en entrée une connexion vers la base de données du chat ainsi 
qu'une requête SQL SELECT et renvoie le résultats de la requête dans un tableau à 1 dimensions. Si le résultat est faux, un message d'erreur est affiché*/
function executeLine($link, $query)
{
	try {

		$sth = $link->prepare($query);

        $sth->execute(array());

        $res = $sth->fetch();

        return $res;
		
	} catch (PDOException $e) {
		$erreur = $e->getMessage();
		echo"Erreur requête !";
	}
}

/*Cette fonction prend en entrée une connexion vers la base de données du chat ainsi 
qu'une requête SQL INSERT/UPDATE/DELETE et ne renvoie rien si la mise à jour a fonctionné, sinon un 
message d'erreur est affiché.*/
function executeUpdate($link, $query)
{
	try {
		$sth = $link->prepare($query);
		
		$sth->execute();

        return $sth;
		
	} catch (PDOException $e) {
		$erreur = $e->getMessage();
		echo"Erreur requête !";
	}
}

/*Cette fonction ferme la connexion active $link passée en entrée*/
function closeConnexion($link)
{
	try {
		$link = null;
	} catch (PDOException $e) {

		$erreur = $e->getMessage();
	}
}
?>