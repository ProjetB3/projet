<?php
// connexion à la BDD
$host='localhost';
$bd='projet_vote';
$login='root';
$password='';
try {
	$pdo = new PDO('mysql:host='.$host.';dbname='.$bd, $login, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e) {
	die($e->getMessage());
}
// déclaration pdo
global $pdo;
// truncate
	$requete = 'TRUNCATE `Votants`';
	$prep = $pdo->prepare($requete);
	$prep->execute();
	

$n = 0; // variable remise a 0 (condition)

// variables nombre d'insertions
$i = 2; // pour id 1
$j = 4; // pour id 2
$k = 6; // pour id 3




 for($n = 0; $n < $i; $n++)
 {
	$requete = 'INSERT INTO `Votants` VALUES(NULL,1)';
	$prep = $pdo->prepare($requete);
	$prep->execute();
 }
 
 for($n = 0; $n < $j; $n++)
 {
	$requete = 'INSERT INTO `Votants` VALUES(NULL,2)';
	$prep = $pdo->prepare($requete);
	$prep->execute();
 }

 for($n = 0; $n < $k; $n++)
 {
	$requete = 'INSERT INTO `Votants` VALUES(NULL,3)';
	$prep = $pdo->prepare($requete);
	$prep->execute();
 }
 
?>




