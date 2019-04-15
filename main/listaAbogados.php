<?php
    require_once "../HTML/Template/ITX.php";
    include("../_cnfgF/configuration.php");
    
    date_default_timezone_set('America/Mexico_City');
    
    Conectar();
    
	if(isset($_POST['nombre']))
    {
        $nombre = $_POST['nombre'];
        $apPaterno = $_POST['apPaterno'];
		$apMaterno = $_POST['apMaterno'];
        
        $error = 0;
        if(count(explode("'",$nombre))>1 || count(explode('"',$nombre))>1){
            $error = 1;
        }
		if(count(explode("'",$apPaterno))>1 || count(explode('"',$apPaterno))>1){
            $error = 1;
        }
        if(count(explode("'",$apMaterno))>1 || count(explode('"',$apMaterno))>1){
            $error = 1;
        }
        
		$i = 0;
        $strQuery = "";
        if($nombre != "")
        {
			if($i == 0)
			{
				$strQuery = " nombre LIKE '$nombre%' ";
			}
			$i = 1;
        }
		
        if($apPaterno != "")
        {
			if($i == 0)
			{
				$strQuery = " apPaterno LIKE '$apPaterno%' ";
			}
			elseif($i == 1)
			{
				$strQuery = " AND apPaterno LIKE '$apPaterno%' ";
			}
        }
        
        if($apMaterno != "")
        {
			if($i == 0)
			{
				$strQuery = " apMaterno LIKE '$apMaterno%' ";
			}
			elseif($i == 1)
			{
				$strQuery = " AND apMaterno LIKE '$apMaterno%' ";
			}
        }
        
        $queryAbogados = "SELECT * FROM Abogados WHERE $strQuery ORDER BY nombre, apPaterno, apMaterno";
    }
    else
    {
		$queryAbogados = "SELECT * FROM Abogados ORDER BY nombre, apPaterno, apMaterno";
	}
	
	$resultAbogados = mysql_query($queryAbogados);
	$numFilasAbogados = mysql_num_rows($resultAbogados);
	
	if($error == 1)
	{
		print 0;
		die();
	}
    
    $strNivelesSel = "<option value=\"0\">-----------</option>";
    $queryNiveles = "SELECT * FROM Niveles ORDER BY nivel";
    $resultNiveles = mysql_query($queryNiveles);
	while($lineNiveles = mysql_fetch_assoc($resultNiveles))
	{
		$idNivel = $lineNiveles['idNivel'];
		$nombre = utf8_encode($lineNiveles['nivel']);
		
        $strNivelesSel .= "<option value=\"$idNivel\">$nombre</option>";
	}
	
	$strPracticasSel = "<option value=\"0\">-----------</option>";
    $queryPracticas = "SELECT * FROM Practicas ORDER BY Practica";
    $resultPracticas = mysql_query($queryPracticas);
	while($linePracticas = mysql_fetch_assoc($resultPracticas))
	{
		$idPractica = $linePracticas['idPractica'];
		$nombre = utf8_encode($linePracticas['practica']);
		
        $strPracticasSel .= "<option value=\"$idPractica\">$nombre</option>";
	}
    
    // Abrimos el template para llenar la descripcion
    $template = new HTML_Template_ITX('../templates');
    $template->loadTemplatefile("./abogados/infoAbogadoCompleta.html", true, true);
    
    $template->setVariable("NUMERO_ABOGADOS", $numFilasAbogados);
	$template->setVariable("NIVELES_SEL", $strNivelesSel);
	$template->setVariable("PRACTICAS_SEL", $strPracticasSel);
	
	
    if($numFilasAbogados > 0)
	{
		$i = 1;
		while($lineAbogados = mysql_fetch_assoc($resultAbogados))
		{	
			$idAbogado = $lineAbogados['idAbogado'];
			$nombre = utf8_encode($lineAbogados['nombre']);
			$apellidoPaterno = utf8_encode($lineAbogados['apPaterno']);
			$apellidoMaterno = utf8_encode($lineAbogados['apMaterno']);
			
			$nombreCompletoAbogado = $nombre . " " . $apellidoPaterno . " " . $apellidoMaterno;
            
            $template->setCurrentBlock("LISTA_ABOGADOS");
			$template->setVariable("ID_ABOGADO", $idAbogado);
			$template->setVariable("NUMERO", $i);
			
			$template->setVariable("NOMBRE_ABOGADO_LISTA", $nombreCompletoAbogado);
        
            if(($i % 2) == 0){
                $template->setVariable("CLASE_DATO", "dato_par");
            }
            else{
                $template->setVariable("CLASE_DATO", "dato_non");
            }
			$template->parseCurrentBlock();
			$i++;
        }
    }
    
    $template->show();
    
    Desconectar();
    
?>