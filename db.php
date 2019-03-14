<?php 
try{
		$host ='localhost'; 
		$dbname = 'cctLibrary';
		$user = 'root';
		$pass = '';
		$DBH = new PDO("mysql:host=$host;dbname=$dbname",$user,$pass); 
	}catch (PDOException $e) {echo $e->getMessage();}
	
?>