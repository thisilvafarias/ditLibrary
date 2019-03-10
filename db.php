<?php 
try{
		$host ='localhost'; 
		$dbname = 'id4326553_dbname'; 
		$user = 'id4326553_dbuser'; 
		$pass = 'thiago';
		$DBH = new PDO("mysql:host=$host;dbname=$dbname",$user,$pass); 
	}catch (PDOException $e) {echo $e->getMessage();}
	
?>