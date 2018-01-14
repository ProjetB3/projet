<?php
	 try {
		$host = 'mysql:host=localhost;dbname=projet';   
		$login = 'root';   
		$password = '';   
		$pdo = new PDO( $host, $login, $password );
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
	}   
		catch (Exception $e)
	{      
		die ($e->getMessage()) ;   
	}
?>