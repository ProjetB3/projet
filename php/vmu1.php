<html>
	<form action="index.php" method="post">
		<input type="submit" value="Index">
	</form>
</html>
<?php

require_once('./connection.php');


/**

Ceci est une simulation de vote majoritaire unonimale à un tour.
	Autrement dit, celui qui obtient le plus de voix au premier tour remporte le vote. Un seul nom est possible par bulletin.

Pour un vote à multi tours, il est possible de reproduire celui-ci jusqu'à obtention du résultat final (comme lors d'une élection)
	ou utiliser un mode de scrutin demandant de trier par ordre de préférence chaque candidats (comme pour celui de Condorcet) puis utiliser le dépouillement unonimale

**/

/*
	Récupération du nombre de candidats, de bulletins de vote et déclaration du nombre de noms par votes
*/
$query = "SELECT COUNT(id) FROM candidat;";
$res = $pdo->query($query)->fetch();
$nbCandidats = $res[0];	

$nbNomsParSuffrage = 1;				// gère le nombre de candidats par vote accepté

$query = "SELECT COUNT(id) FROM vote;";
$res = $pdo->query($query)->fetch();
$nbVotants = $res[0];

/*
	Tableau des noms des candidats
*/
$t_candidats = array();
for( $i = 0; $i < $nbCandidats; $i++)
{
	$query = "SELECT nom FROM Candidat WHERE id = ".$i.";";
	$res = $pdo->query($query)->fetch();
	$t_candidats[$i] = $res['nom']; // on attribut son nom à chaque candidat
	$t_nbVoix[$i] = 0; // chaque candidat a un nombre de voix s'élevant à 0
}

/*
	Récupération des noms des colonnes (excepté id) de la table de vote. Puis stockage dans un tableau.
*/
$host = 'mysql:host=localhost;dbname=information_schema';   
$login = 'root';   
$password = '';   
$pdo_columns = new PDO( $host, $login, $password );

$query = "SELECT column_name FROM columns WHERE table_name = 'vote' AND column_name != 'id'";
$nomColonnes = $pdo_columns->query($query)->fetchAll();


// créer un tableau t_votants[votant][votes] s'arrêtant à la première colone (premier choix) -> choix unonimale à un tour
$t_votants = array(); // initialisation tableau
for( $i = 0; $i < $nbVotants; $i++){	// pour chaque votant
	for ($j = 0; $j < $nbNomsParSuffrage; $j++){ // et pour chaque candidat
		$query = 'SELECT '.$nomColonnes[$j][0].' FROM Vote WHERE id = '.$i.';'; // récupérer à la colone du candidat le vote du votant (ordre de pref)
		$res = $pdo->query($query)->fetch();
		$vote = $res[0];
		$t_votants[$i][$j] = $vote;
	}
}
var_dump($t_candidats);
var_dump($t_votants);

/*
	Comptabilise les voix pour chaque candidats
*/
for( $candidat = 0; $candidat < $nbCandidats; $candidat++){
	for( $j = 0; $j < $nbVotants; $j++){
		for( $h = 0; $h < $nbNomsParSuffrage; $h++){
			if( $t_votants[$j][$h] == $t_candidats[$candidat]){
				$t_nbVoix[$candidat]++;
			}
		}
	}
}

var_dump($t_nbVoix);
/*
	Trouve la valeur de celui ayant eu le plus de voix
*/
$max = 0;
$egalite = false; // valeur check dans le cas où plusieurs éléments seraient la plus haute
for( $candidat = 0; $candidat < $nbCandidats; $candidat++){
	if( $t_nbVoix[$candidat] > $t_nbVoix[$max]){ // dans le cas où le nombre de voix de candidat dépasse le maximum précédant
		$max = $candidat;
		$egalite = false; // un nouveau maximum est trouvé, il ne peut donc pas être égale à un précédant
	}
	else if($t_nbVoix[$candidat] == $t_nbVoix[$max]){ // dans le cas d'une égalité
		$egalite = true; // la valeur check est modifiée
	}
}

if($egalite == true) // si le gagnant est en égalité avec un autre
	echo "Deux candidats ou plus ayant le nombre maximale de voix enregistré, aucun n'a pu être élu. Veuillez procéder à de nouvelles élections."; // aucun ne gagne
else	// s'il n'y a pas d'égalité, il y a donc un gagnant
	echo "$t_candidats[$max] a rassemblé le plus de voix.";
	

?>