<html>
	<form action="index.php" method="post">
		<input type="submit" value="Index">
	</form>
</html>
<?php

require_once('./connection.php');

/*
	Récupération du nombre de candidat et de buletins de vote
*/
$query = "SELECT COUNT(id) FROM candidat;";
$res = $pdo->query($query)->fetch();
$nbCandidats = $res[0];			// gère le nombre de candidats par vote accepté
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
	$t_candidats[$i] = $res['nom'];
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

// créer un tableau t_votants[votant][votes] (par ordre de préférence)
$t_votants = array(); // initialisation tableau
for( $i = 0; $i < $nbVotants; $i++){	// pour chaque votant
	for ($j = 0; $j < $nbCandidats; $j++){ // et pour chaque candidat
		$query = 'SELECT '.$nomColonnes[$j][0].' FROM Vote WHERE id = '.$i.';'; // récupérer à la colone du candidat le vote du votant (ordre de pref)
		$res = $pdo->query($query)->fetch();
		$vote = $res[0];
		$t_votants[$i][$j] = $vote;
	}
}

// créer un tableau t_votants[votant][votes] (par ordre de préférence)
$t_votants = array();
for( $i = 0; $i < $nbVotants; $i++){
	for ($j = 0; $j < $nbCandidats; $j++){
		$query = 'SELECT '.$nomColonnes[$j][0].' FROM Vote WHERE id = '.$i.';';
		$res = $pdo->query($query)->fetch();
		$vote = $res[0];
		$t_votants[$i][$j] = $vote;
	}
}

// Algorythmie
$VainqueurDeCondorcet = NULL;
var_dump($t_votants); // DEBOGAGE
for( $candidat = 0; $candidat < $nbCandidats; $candidat++){
	for( $challengeur = 0; $challengeur < $nbCandidats ; $challengeur++){
	
	
		
		$candidat_nbVoix = 0; // remise à zéro pour un nouveau duel
		$challengeur_nbVoix = 0; // remise à zéro pour un nouveau duel
		
		if( $candidat != $challengeur)	// dans le cas où le candidat et le challengeur ne sont pas identiques (pour éviter duel contre soi-même)
		{
		
			for( $i = 0; $i < $nbVotants; $i++){
				for( $j = 0; $j < $nbCandidats; $j++){
					if( $t_votants[$i][$j] == $t_candidats[$candidat]){ 		// si le vote à l'emplacement [$j] du votant [$i] est le nom du candidat [$candidat]
						$candidat_nbVoix ++; // alors $candidat gagne une voix
						$j = $nbCandidats; // on passe au votant suivant
					}
					else if( $t_votants[$i][$j] == $t_candidats[$challengeur]){	// si le vote à l'emplacement [$j] du votant [$i] est le nom du candidat [$candidat]
						$challengeur_nbVoix ++; // alors $challengeur gagne une voix
						$j = $nbCandidats; // on passe au votant suivant
					}
				}
			}
		}
		
		echo "<br>Candidat ".$t_candidats[$candidat]." : ".$candidat_nbVoix." Challengeur ".$t_candidats[$challengeur]." : ".$challengeur_nbVoix.""; // DEBOGAGE
		
		if(($candidat_nbVoix <= $challengeur_nbVoix) 	// dans le cas où l'opposant qu'on teste échoue (une égalité est un échec)
			&& ($candidat != $challengeur))				// et que nous ne sommes pas dans un cas contre soi-même (où les valeurs sont de 0)
		{
			$challengeur = $nbCandidats; // on passe au suivant
		}
		else if(($candidat_nbVoix > $challengeur_nbVoix 	// dans le cas où le candidat remporte son duel
			&& $challengeur == ($nbCandidats -1))			// et est arrivé au dernier challengeur (sans échouer) [le dernier étant nb -1 car commençant à 0]
			|| ($candidat == $challengeur && $challengeur == ($nbCandidats -1)))  // ou si nous sommes dans le cas où le dernier challengeur est le candidat (et a donc vaincu tous les autres) [! CAS COMPLEXE]
		{
			$VainqueurDeCondorcet = $t_candidats[$candidat]; // le vainqueur de condorcet est ce candidat
			$candidat = $nbCandidats; // on arrête les duels
		}
	}
}

if($VainqueurDeCondorcet != NULL)
{
	echo "<br>$VainqueurDeCondorcet est le vainqueur de Condorcet."; // DEBOGAGE
}
else
	echo "<br>Aucun vainqueur de Condorcet n'existe. Utilisation d'une méthode complémentaire recommandée." // DEBOGAGE
?>