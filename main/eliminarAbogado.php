<?php
	require_once "HTML/Template/ITX.php";
	include("../_cnfgF/cfgLocation.php");
	include("../_cnfgF/configuration.php");
	
	date_default_timezone_set('America/Mexico_City');
        
    Conectar();
    
    $idAbogado = $_POST['idAbogado'];
	
	//Eliminar evaluaciones
    $queryEvaluaciones = "SELECT * FROM Resultado WHERE idAbogado = $idAbogado";
    $resultEvaluaciones = mysql_query($queryEvaluaciones);
    $numFilasEvaluaciones = mysql_num_rows($resultEvaluaciones);
    if($numFilasEvaluaciones > 0)
    {
        while($lineEvaluaciones = mysql_fetch_assoc($resultEvaluaciones))
        {
            $idResultado = $lineEvaluaciones['idResultado'];
            
            //Eliminar resultados de evaluacion
            $queryDeleteResultados = "DELETE FROM ResultadosPreguntas WHERE idResultado = $idResultado";
            $resultDeleteResultados = mysql_query($queryDeleteResultados);
            if(!$resultDeleteResultados)
            {
                die("Error BD.");
            }
            
            $queryDeleteResultados = "DELETE FROM ResultadosCompetencias WHERE idResultado = $idResultado";
            $resultDeleteResultados = mysql_query($queryDeleteResultados);
            if(!$resultDeleteResultados)
            {
                die("Error BD.");
            }
			
			//Eliminar evaluacion
			$queryDeleteEvaluaciones = "DELETE FROM Resultado WHERE idResultado = $idResultado";
            $resultDeleteEvaluaciones = mysql_query($queryDeleteEvaluaciones);
            if(!$resultDeleteEvaluaciones)
            {
                die("Error BD.");
            }
        }
    }

    //Eliminar usuario
    $queryDeleteAbogado = "DELETE FROM Abogados WHERE idAbogado = $idAbogado";
    $resultDeleteAbogado = mysql_query($queryDeleteAbogado);
    if(!$resultDeleteAbogado)
    {
        die("1");
    }
    
    die("OK");
        
	//mysql_free_result($resultEntidad);
	Desconectar();
	
?>