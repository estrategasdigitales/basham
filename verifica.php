<?php
	include("_cnfgF/configuration.php");
	include("_cnfgF/cfgLocation.php");
	
	date_default_timezone_set('America/Mexico_City');

	$location = $cfgLocation['location'];
	
	// ========================================================================
	//
	// 	INICIO DE LA SESION
	// 
	// ========================================================================
	session_start();
	
	if(!isset($_SESSION["start"])){
		$_SESSION["start"] = time();
	}
	if(!(isset($_GET['token']))){
		
		if(isset($_POST['usuario']) && isset($_POST['passwd'])){
			
			$usuario = $_POST['usuario'];
			$passwd = $_POST['passwd'];
		
			if(count(explode("'",$usuario))>1 || count(explode('"',$usuario))>1){
				header("location: $location");
				//print "chale 1";
			}
		
			if(count(explode("'",$passwd))>1 || count(explode('"',$passwd))>1){
				header("location: $location");
				//print "chale 2";
			}
		
			$passwd = sha1($passwd);
			
			Conectar();
			
			$query = mysql_query("SELECT idUsuario, userName FROM usuarios WHERE userName = '$usuario' AND password = '$passwd'") OR DIE ("Error en el query");
			
			// La contrasenia esta mal o el usuario no existe
			if(($row = mysql_fetch_assoc($query)) == null){
				
				header("location: $location");
				
				Desconectar();
				//print "chale 3";
			
			}// if
			else{
				
				// El usuario si existe
				$ip = $_SERVER['REMOTE_ADDR'];
				$idUsuario = $row['idUsuario'];
				$usuarioBD = $row['userName'];
				
				if($usuario != $usuarioBD)
				{
					
					header("location: $location");
				
					Desconectar();
				}
			
				// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				// +
				// + Inicia registro de pistas de auditoria
				// +
				// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				$query = mysql_query("INSERT INTO Entradas(idUsuario, ip) VALUES($idUsuario,'$ip')");
				
				// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				// +
				// + Termina registro de pistas de auditoria
				// +
				// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				
				mysql_query("DELETE FROM Sesion WHERE idUsuario = $idUsuario");
				
				do{
					$token = sha1(microtime(true));
					$query = "SELECT token FROM Sesion WHERE token = '$token'";
				}while((mysql_num_rows(mysql_query($query))) > 0);
				
				$query = "INSERT INTO Sesion (token,idUsuario) VALUES ('$token',$idUsuario)";
				mysql_query($query) or die ("Query fallo");
				
				header("location: ./main/principal.php?token=$token");
				
			}// else
		
		}// if(isset($_POST['usuario']) && isset($_POST['passwd']))
		else{
			header("location: $location");
			//print "chale 5";
		}
	}// if(!(isset($_GET['token']))){
	else{
		$token = $_GET['token'];
		
		Conectar();
		
		$query = mysql_query("SELECT HoraFecha FROM sesion WHERE Token = '$token'");
		
		if(($row = mysql_fetch_assoc($query)) == null){
			Desconectar();
			header("location: $location");
			//print "chale 6";
		}// if
		
		if(count(explode("'",$token))>1 || count(explode('"',$token))>1){
			header("location: $location");
			//print "chale 7";
		}
		
		$token = $_GET['token'];
		mysql_query("DELETE FROM sesion WHERE Token = '$token'");
			
		session_destroy();
				
		header("location: $location");
		//print "chale 8";
	
		Desconectar();
	}// else
?>
