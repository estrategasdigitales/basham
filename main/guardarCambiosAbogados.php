<?php
	require_once "../HTML/Template/ITX.php";
	include("../_cnfgF/cfgLocation.php");
	include("../_cnfgF/configuration.php");
	
	date_default_timezone_set('America/Mexico_City');
	Conectar();
        
	$idAbogado = $_POST['idAbogado'];
    $idUsuario = $_POST['idUsuario'];
	
    $nombre = utf8_decode($_POST['nombre']);
    $aPaterno = utf8_decode($_POST['aPaterno']);
    $aMaterno = utf8_decode($_POST['aMaterno']);
    $clave = utf8_decode($_POST['clave']);
    $practica = $_POST['practica'];
    $nivel = $_POST['nivel'];
	$horasCargadas = $_POST['horasCargadas'];
    $sueldo  = $_POST['sueldo'];
    
    $error = 0;
    
    if(count(explode("'",$nombre))>1 || count(explode('"',$nombre))>1){
        $error = 1;
    }
    if(count(explode("'",$aPaterno))>1 || count(explode('"',$aPaterno))>1){
        $error = 1;
    }
    if(count(explode("'",$aMaterno))>1 || count(explode('"',$aMaterno))>1){
        $error = 1;
    }
    if(count(explode("'",$clave))>1 || count(explode('"',$clave))>1){
        $error = 1;
    }
    if(count(explode("'",$practica))>1 || count(explode('"',$practica))>1){
        $error = 1;
    }
    if(count(explode("'",$nivel))>1 || count(explode('"',$nivel))>1){
        $error = 1;
    }
	if(count(explode("'",$horasCargadas))>1 || count(explode('"',$horasCargadas))>1){
        $error = 1;
    }
    if(count(explode("'",$sueldo))>1 || count(explode('"',$sueldo))>1){
        $error = 1;
    }
    
    $fechaHoy = date("Y-m-d H:i:00");
    
    if($error == 0)
    {
        if($idAbogado == 0)
		{
			//Validar que el nombre del abogado en la misma institucion no exista
			$query = "SELECT * FROM Abogados WHERE nombre = '$nombre' AND apPaterno = '$aPaterno'
					AND apMaterno = '$aMaterno'";
			$result = mysql_query($query);
			$numFilas = mysql_num_rows($result);
			if($numFilas > 0)
			{
				die("2");
			}
			
			//Validar que la clave del abogado no exista
			$query = "SELECT * FROM Abogados WHERE claveIdentificacion = '$clave'";
			$result = mysql_query($query);
			$numFilas = mysql_num_rows($result);
			if($numFilas > 0)
			{
				die("3");
			}
			
			$query = "INSERT INTO Abogados(claveIdentificacion,nombre,apPaterno,apMaterno,idNivel,horasCargadas,sueldo,idUsuario,idPractica)
									VALUES('$clave','$nombre','$aMaterno','$aPaterno',$nivel,$horasCargadas,$sueldo,$idUsuario,$practica)";
			
			$result = mysql_query($query) or die("1");
			
			$nombreCompletoAbogado = $nombre . " " . $aPaterno . " " . $aMaterno;
            
			$fecha = date("Y-m-d H:i:s");
	    
            Desconectar();
            

		}
		else
		{
			//Validar que el nombre del usuario en la misma institucion no exista
			$query = "SELECT * FROM Abogados WHERE nombre = '$nombre' AND apPaterno = '$aPaterno'
					AND apMaterno = '$aMaterno' AND idAbogado != $idAbogado";
			$result = mysql_query($query);
			$numFilas = mysql_num_rows($result);
			if($numFilas > 0)
			{
				die("2");
			}
			
			//Validar que el correo del usuario no exista
			$query = "SELECT * FROM Abogados WHERE claveIdentificacion = '$clave' AND idAbogado != $idAbogado";
			$result = mysql_query($query);
			$numFilas = mysql_num_rows($result);
			if($numFilas > 0)
			{
				die("4");
			}
			
			$query = "UPDATE Abogados SET
				nombre = '$nombre',
				apPaterno = '$aPaterno',
				apMaterno = '$aMaterno',
				idNivel = $nivel,
				idPractica = '$practica',
				claveIdentificacion = '$clave',
				horasCargadas = $horasCargadas,
				sueldo = $sueldo
				WHERE idAbogado = $idAbogado";
			
			$result = mysql_query($query) or die("1");
			
			
			
		}
        print "OK";
        die();
    }
    else
    {
        print 0;
        die();
    }
?>