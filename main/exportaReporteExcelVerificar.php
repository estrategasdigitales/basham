<?php
    require_once "HTML/Template/ITX.php";
    include("../_cnfgF/configuration.php");
    
    date_default_timezone_set('America/Mexico_City');
    
    Conectar();
    
    $idAbogado = $_GET['idAbogado'];
    //$nombreArchivo = $_GET['nombreArchivo'];

    $error = 0;
    if(count(explode("'",$idAbogado))>1 || count(explode('"',$idAbogado))>1){
        $error = 1;
    }
    //if(count(explode("'",$nombreArchivo))>1 || count(explode('"',$nombreArchivo))>1){
    //    $error = 1;
    //}
    
	$queryEvaluaciones = "SELECT * FROM Resultado WHERE idAbogado = $idAbogado ORDER BY fecha DESC";
	$resultEvaluaciones = mysql_query($queryEvaluaciones);
	$numFilasEvaluaciones = mysql_num_rows($resultEvaluaciones);
	Desconectar();
    
	if($error == 1)
	{
		print 0;
		die();
	}
    if($numFilasEvaluaciones == 0)
	{
		print 1;
		die();
	}
    else
    {
        print "OK";
		die();
    }
    
?>