<html>
<?php
require_once('./connection.php');
?>
	<form action="condorcet.php" method="post">
		<input type="submit" value="Condorcet">
	</form>

	<form action="vmu1.php" method="post">
		<input type="submit" value="Vote majoritaire uninominal à 1 tour">
	</form>
	
	<form method="POST">
		<button name="matrice1()">Configuration 1 :</button>
	<form>
	<form method="POST">
		<button name="matrice2()">Configuration 2 :</button>
	<form>
	<form method="POST">
		<button name="matrice3()">Configuration 3 :</button>
	<form>
	<form method="POST">
		<button name="matrice4()">Configuration 4 :</button>
	<form>
	<form method="POST">
		<button name="matrice5()">Configuration 5 :</button>
	<form>
	<br /><br />
	<form method="POST">
		<button name="matrice6()">Configuration 6 :</button>
	<form>
	
	<?php
	
	$Candidats1 = "	DROP TABLE if exists candidat;
						CREATE TABLE candidat
						( id int PRIMARY KEY,
						 nom varchar(50));
					 
					INSERT INTO candidat
						 VALUES (0, 'A'),
						 (1, 'B'),
						 (2, 'C'),
						 (3, 'D'),
						 (4, 'E');
					DROP TABLE if exists vote;
					CREATE TABLE vote
						( id int PRIMARY KEY,
						 choix1 varchar(50),
						 choix2 varchar(50),
						 choix3 varchar(50),
						 choix4 varchar(50),
						 choix5 varchar(50));";
						 
	$Candidats2 = " DROP TABLE if exists candidat;
					CREATE TABLE candidat
					( id int PRIMARY KEY,
					 nom varchar(50));
					 
					INSERT INTO candidat
					VALUES (0, 'Chocolat'),
					 (1, 'Fraise'),
					 (2, 'Vanille'),
					 (3, 'Pistache');
					 
					DROP TABLE if exists vote;
					CREATE TABLE vote
					( id int PRIMARY KEY,
					 choix1 varchar(50),
					 choix2 varchar(50),
					 choix3 varchar(50),
					 choix4 varchar(50));
					 
					INSERT INTO vote
					VALUES (0, 'Fraise','Vanille','Chocolat','Pistache'),
					 (1, 'Chocolat','Fraise','Vanille','Pistache'),
					 (2, 'Vanille','Chocola','Fraise','Pistache'),
					 (3, 'Pistache','Vanille','Chocolat','Fraise'),
					 (4, 'Pistache','Vanille','Fraise','Chocolat');";
					 
		if(isset($_POST['matrice1()'])){
			$query = $Candidats1." 
					 INSERT INTO vote 
						 VALUES (0, 'A','B','C','D','E'),
						 (1, 'A','B','C','D','E'),
						 (2, 'A','B','C','D','E'),
						 (3, 'A','B','C','D','E'),
						 (4, 'A','B','C','D','E'),
						 (5, 'A','B','C','D','E'),
						 (6, 'A','B','C','D','E');
			";
			$pdo->exec($query);
		}
		if(isset($_POST['matrice2()'])){
			$query = $Candidats1." 
					  INSERT INTO vote
						 VALUES (0, 'A','B','C','D','E'),
						 (1, 'A','B','C','D','E'),
						 (2, 'B','A','C','D','E'),
						 (3, 'B','A','C','D','E'),
						 (4, 'B','A','C','D','E'),
						 (5, 'A','B','C','D','E');
			";
			$pdo->exec($query);
		}
		if(isset($_POST['matrice3()'])){
			$query = $Candidats1." 
					 INSERT INTO vote 
						 VALUES (0, 'C','B','A','D','E'),
						 (1, 'C','B','A','D','E'),
						 (2, 'B','C','A','D','E'),
						 (3, 'B','C','A','D','E'),
						 (4, 'B','C','A','D','E'),
						 (5, 'C','B','A','D','E');
			";
			$pdo->exec($query);
		}
		if(isset($_POST['matrice4()'])){
			$query = $Candidats1." 
					  INSERT INTO vote
						 VALUES (0, 'A','B','C','D','E'),
						 (1, 'B','C','A','D','E'),
						 (2, 'C','B','A','D','E');
			";
			$pdo->exec($query);
		}
		if(isset($_POST['matrice5()'])){
			$query = $Candidats1." 
					  INSERT INTO vote
						 VALUES (0, 'A','B','C','D','E'),
						 (1, 'E','C','A','D','B'),
						 (2, 'E','B','A','D','C');
			";
			$pdo->exec($query);
		}
		if(isset($_POST['matrice6()'])){
			$query = $Candidats2." 
					  INSERT INTO vote
						 VALUES (0, 'Fraise','Vanille','Chocolat','Pistache'),
						 (1, 'Chocolat','Fraise','Vanille','Pistache'),
						 (2, 'Vanille','Chocola','Fraise','Pistache'),
						 (3, 'Pistache','Vanille','Chocolat','Fraise'),
						 (4, 'Pistache','Vanille','Fraise','Chocolat');
			";
			$pdo->exec($query);
		}
	?>
<html>