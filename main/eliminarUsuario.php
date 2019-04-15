<?php
	require_once "HTML/Template/ITX.php";
	include("../_cnfgF/cfgLocation.php");
	include("../_cnfgF/configuration.php");
	
	date_default_timezone_set('America/Mexico_City');
        
    Conectar();
    
    $idUsuario = $_POST['idUsuario'];

    //Eliminar usuario
    $queryDeleteUsuario = "DELETE FROM Usuarios WHERE idUsuario = $idUsuario";
    $resultDeleteUsuario = mysql_query($queryDeleteUsuario);
    if(!$resultDeleteUsuario)
    {
        die("1");
    }
    
    die("OK");
        
	//mysql_free_result($resultEntidad);
	Desconectar();
	
?>