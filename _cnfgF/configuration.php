<?php
	
	function Conectar(){
		
		//Conectar a la base de datos
		$host = "localhost";
		
		
		$user = "basham";
		$pass = "CN5WPamKTLhpi2lj";
		$db = "basham"; 
		
		
		$link = mysql_connect($host, $user, $pass) or die('Could not connect: ' . mysql_error());
		mysql_select_db($db) or die('Could not select database.');
		
	}

	function Desconectar(){
		//Cerrar la conexion a la base de datos
		mysql_close();
	}
	
?>
