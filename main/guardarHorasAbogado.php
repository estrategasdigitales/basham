<?php
	require_once "../HTML/Template/ITX.php";
	include("../_cnfgF/cfgLocation.php");
	include("../_cnfgF/configuration.php");
	
	date_default_timezone_set('America/Mexico_City');
	Conectar();
    
	$idAbogado = $_POST['idAbogado'];
    $horasFacturadas = $_POST['horasFacturadas'];
	
    $error = 0;
    
    if(count(explode("'",$idAbogado))>1 || count(explode('"',$idAbogado))>1){
        $error = 1;
    }
    if(count(explode("'",$horasFacturadas))>1 || count(explode('"',$horasFacturadas))>1){
        $error = 1;
    }
    
    $fechaHoy = date("Y-m-d H:i:00");
    
    if($error == 0)
    {
        $query = "UPDATE Abogados SET
				horasFacturadas = $horasFacturadas
				WHERE idAbogado = $idAbogado";
			
		$result = mysql_query($query) or die("1");
        
        print "OK";
        die();
    }
    else
    {
        print 0;
        die();
    }
?>