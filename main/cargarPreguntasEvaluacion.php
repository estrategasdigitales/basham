<?php
    require_once "../HTML/Template/ITX.php";
    include("../_cnfgF/configuration.php");
    
    date_default_timezone_set('America/Mexico_City');
    
    Conectar();
    $idPractica = $_POST['idPractica'];
    $idNivel = $_POST['idNivel'];
    $seccion = $_POST['seccion'];
    
    if($seccion == 6)//Solo importa la practica para las preguntas de la seccion 'Competencias a desarrollar'
    {
        
    }
    else
    {
        $queryPreguntas = "SELECT * FROM Preguntas WHERE seccion = $seccion AND idNivel = $idNivel";
    }
    $resultPreguntas = mysql_query($queryPreguntas);
    $numFilasPregunas = mysql_num_rows($resultPreguntas);
    
    // Abrimos el template para llenar la descripcion
    $template = new HTML_Template_ITX('../templates');
    $template->loadTemplatefile("./preguntas/tablaPreguntas.html", true, true);
    
    $i = 1;
    while($linePreguntas = mysql_fetch_assoc($resultPreguntas))
    {	
        $idPregunta = $linePreguntas['idPregunta'];
        $pregunta = utf8_encode($linePreguntas['pregunta']);
        
        $template->setCurrentBlock("PREGUNTAS");
        
        $template->setVariable("ID_PREGUNTA", $idPregunta);
        $template->setVariable("NUMERO", $i);
        $template->setVariable("PREGUNTA", $pregunta);
        $template->setVariable("SECCION", $seccion);
        
        $template->parseCurrentBlock();
        $i++;
    }
    
    $template->show();
    
    Desconectar();
?>