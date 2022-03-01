<?php

/*Cette fonction prend en entrée un pseudo à ajouter à la relation utilisateur et une connexion et 
retourne vrai si le pseudo est disponible (pas d'occurence dans les données existantes), faux sinon*/
function checkAvailability($pseudo, $link)
{
	$valide = FALSE;
	$query = "SELECT * FROM `utilisateur` WHERE pseudo ='$pseudo'";
	if (executeQuery($link, $query) == NULL) {
		$valide = TRUE;
	}

	return $valide;
}

/*Cette fonction prend en entrée un pseudo et un mot de passe, associe une couleur aléatoire dans le tableau de taille fixe  
array('red', 'green', 'blue', 'black', 'yellow', 'orange') et enregistre le nouvel utilisateur dans la relation utilisateur via la connexion*/
function register($pseudo, $hashPwd, $link)
{
	if (checkAvailability($pseudo, $link)) {

		$couleur = array('red', 'green', 'blue', 'black', 'yellow', 'orange');
		$Aleat = $couleur[rand(0, 5)];
		$query = "INSERT INTO utilisateur (pseudo,mdp,couleur,etat) VALUES ('$pseudo','$hashPwd','$Aleat','inactif')";
		executeUpdate($link, $query);
	} else {
		echo "Impossible d'enregistrer l'utilisateur avec un pseudo déjà utilisé";
	}
}

/*Cette fonction prend en entrée un pseudo d'utilisateur et change son état en 'connected' dans la relation 
utilisateur via la connexion*/
function setConnected($pseudo, $link)
{
	$query = "UPDATE utilisateur SET  etat = 'connected' WHERE pseudo = '$pseudo';";
	executeUpdate($link, $query);
}

/*Cette fonction prend en entrée un pseudo et mot de passe et renvoie vrai si l'utilisateur existe (au moins un tuple dans le résultat), faux sinon*/
function getUser($pseudo, $hashPwd, $link)
{
	$existe = FALSE;
	$query = "SELECT * from utilisateur WHERE pseudo ='$pseudo' and mdp ='$hashPwd';";
	if (executeQuery($link, $query) != NULL) {
		$existe = TRUE;
	}
	return $existe;
}

/*Cette fonction renvoie un tableau (array) contenant tous les pseudos d'utilisateurs dont l'état est 'connected'*/
function getConnectedUsers($link)
{
	$query = "SELECT pseudo from utilisateur WHERE etat='connected' ;";
	$res = executeQuery($link, $query);
	return $res;
}

/*Cette fonction prend en entrée un pseudo d'utilisateur et change son état en 'disconnected' dans la relation 
utilisateur via la connexion*/
function setDisconnected($pseudo, $link)
{
	$query = "UPDATE utilisateur SET etat='disconnected' WHERE pseudo = '$pseudo';";
	$res = executeQuery($link, $query);
	return $res;
}

function AllUser($link)
{
	$query = "SELECT pseudo FROM `utilisateur`; ";
	$res = executeQuery($link, $query);
	return $res;
}

/*Cette fonction prend en entrée deux pseudo d'utilisateur et change le premier pseudo par le second pseudo*/
function changementPseudo($pseudo, $pseudo2, $link)
{
	$query = "UPDATE utilisateur SET pseudo='$pseudo2' WHERE pseudo = '$pseudo';";
	$res = executeQuery($link, $query);
	return $res;
}

/*Cette fonction prend en entrée deux pseudo d'utilisateur et 1 mot de passe, et change la valeur du pseudo du couple
pseudo-mot de passe par le second pseudo*/
function changementPseudoPhoto($pseudo, $pseudo2, $link)
{
	$query = "UPDATE Photo SET pseudoUser='$pseudo2' WHERE pseudoUser = '$pseudo';";
	$res = executeQuery($link, $query);
	return $res;
}

/*Cette fonction prend en entrée deux mots de passe d'utilisateur et 1 pseudo, et change la valeur du mot de passe du couple
pseudo-mot de passe par le second mot de passe*/
function changementMdp($mdp, $mdp2, $pseudo,  $link)
{
	$query = "UPDATE utilisateur SET mdp='$mdp2' WHERE mdp = '$mdp' AND pseudo = '$pseudo';";
	$res = executeQuery($link, $query);
	return $res;
}

/*Cette fonction prend en entrée deux mots de passe d'utilisateur et 1 pseudo, et change la valeur du mot de passe du couple
pseudo-mot de passe par le second mot de passe*/
function nbUtilisateur($link)
{
	$query = "SELECT COUNT(*) FROM utilisateur;";
	$res = executeLine($link, $query);
	return $res;
}


/*Cette fonction prend en entrée deux mots de passe d'utilisateur et 1 pseudo, et change la valeur du mot de passe du couple
pseudo-mot de passe par le second mot de passe*/
function nbUtilisateurConnecte($link)
{
	$query = "SELECT COUNT(*) FROM `utilisateur` WHERE `etat` ='connected';";
	$res = executeLine($link, $query);
	return $res;
}

/*Cette fonction prend en entrée deux mots de passe d'utilisateur et 1 pseudo, et change la valeur du mot de passe du couple
pseudo-mot de passe par le second mot de passe*/
function nbPhotoCategorie($Id, $link)
{
	$query = "SELECT COUNT(*) FROM `Photo` WHERE `catId` = $Id;";
	$res = executeLine($link, $query);
	return $res;
}

/*Cette fonction prend en entrée deux mots de passe d'utilisateur et 1 pseudo, et change la valeur du mot de passe du couple
pseudo-mot de passe par le second mot de passe*/
function nbPhotoUtilisateur($user, $link)
{
	$query = "SELECT COUNT(*) FROM `Photo` WHERE `pseudoUser` = '$user';";
	$res = executeLine($link, $query);
	return $res;
}
