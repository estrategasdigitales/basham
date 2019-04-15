<?php
	require_once "../HTML/Template/ITX.php";
	include("../_cnfgF/cfgLocation.php");
	include("../_cnfgF/configuration.php");
	
	date_default_timezone_set('America/Mexico_City');
	Conectar();
    
    /*
    
    var params = "idAbodago="+idAbodago+"&idUsuario="+idUsuario+"&idPreguntaArray="+idPreguntaArray+"&respuestaArray="+respuestaArray;
    
    */
        
	$idAbogado = $_POST['idAbogado'];
    $idUsuario = $_POST['idUsuario'];
	
    $idPreguntaArray = $_POST['idPreguntaArray'];
    $respuestaArray = $_POST['respuestaArray'];
    
    $error = 0;
    
    if(count(explode("'",$idAbogado))>1 || count(explode('"',$idAbogado))>1){
        $error = 1;
    }
    if(count(explode("'",$idUsuario))>1 || count(explode('"',$idUsuario))>1){
        $error = 1;
    }
    if(count(explode("'",$idPreguntaArray))>1 || count(explode('"',$idPreguntaArray))>1){
        $error = 1;
    }
    if(count(explode("'",$respuestaArray))>1 || count(explode('"',$respuestaArray))>1){
        $error = 1;
    }
    
    $fechaHoy = date("Y-m-d H:i:00");
    
    if($error == 0)
    {
        if($idPreguntaArray != "")
        {
            $idPreguntaArray2 = explode(",",$idPreguntaArray);
            $respuestaArray2 = explode(",",$respuestaArray);
        }
        
        $queryResultado = "INSERT INTO Resultado(idAbogado, idUsuario) VALUES($idAbogado, $idUsuario)";
        $resultResultado = mysql_query($queryResultado) or die(mysql_error());
        
        $idResultado = mysql_insert_id();
        
        $j = 0;
        $sumaPuntos = 0;
        $seccion = 1;
        for($i = 0; $i < sizeof($idPreguntaArray2); $i++)
        {
            $idPregunta = $idPreguntaArray2[$i];
            $respuesta = $respuestaArray2[$i];
            
            $queryResultadoPreguntas = "INSERT INTO ResultadosPreguntas(idPregunta, idResultado, respuesta)
                                        VALUES($idPregunta, $idResultado, $respuesta)";
            $resultResultadoPreguntas = mysql_query($queryResultadoPreguntas) or die("1");
            
            $sumaPuntos += $respuesta;
            
            $j++;
            if($j == 5)
            {
                $queryPorcentajeCompetencia = "SELECT * FROM Competencias WHERE seccion = $seccion";
                $resultProcentajeCompetencia = mysql_query($queryPorcentajeCompetencia);
                $linePorcentajeCompetencia = mysql_fetch_assoc($resultProcentajeCompetencia);
                $idCompetencia = $linePorcentajeCompetencia['idCompetencia'];
                $valor = $linePorcentajeCompetencia['valor'];
                
                $porcentajeObtenido = ($sumaPuntos * 100) / 25;
                $porcentajePonderado = ($porcentajeObtenido * $valor) / 100;
                
                $queryResultadoCompetencias = "INSERT INTO ResultadosCompetencias(idResultado, idCompetencia,
                                                porcentajeObtenido, porcentajePonderado)
                                                VALUES($idResultado, $idCompetencia,
                                                '$porcentajeObtenido', '$porcentajePonderado')";
                $resultResultadoCompetencias = mysql_query($queryResultadoCompetencias) or die("1");
                
                
                $j = 0;
                $sumaPuntos = 0;
                $seccion++;
            }
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