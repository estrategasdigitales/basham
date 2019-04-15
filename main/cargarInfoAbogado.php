<?php
    require_once "../HTML/Template/ITX.php";
    include("../_cnfgF/configuration.php");
    
    date_default_timezone_set('America/Mexico_City');
    
    Conectar();
    $idAbogado = $_POST['idAbogado'];
    
    $queryAbogados = "SELECT * FROM Abogados WHERE idAbogado = $idAbogado";
    $resultAbogados = mysql_query($queryAbogados) or die("1");
    $lineAbogados = mysql_fetch_assoc($resultAbogados);
    $nombreAbogado = utf8_encode($lineAbogados['nombre']);
    
    $apellidoPaterno = utf8_encode($lineAbogados['apPaterno']);
    $apellidoMaterno = utf8_encode($lineAbogados['apMaterno']);
    $clave = utf8_encode($lineAbogados['claveIdentificacion']);
    $nivel = $lineAbogados['idNivel'];
    $practica = $lineAbogados['idPractica'];
    $horasFacturadas = $lineAbogados['horasFacturadas'];
    $horasCargadas = $lineAbogados['horasCargadas'];
    $sueldo = $lineAbogados['sueldo'];
    
    if($horasFacturadas == '')
    {
        $horasFacturadas = 0;
    }
    
    $strNivelesSel = "<option value=\"0\">-----------</option>";
    $queryNiveles = "SELECT * FROM Niveles ORDER BY nivel";
    $resultNiveles = mysql_query($queryNiveles);
	while($lineNiveles = mysql_fetch_assoc($resultNiveles))
	{
		$idNivel = $lineNiveles['idNivel'];
		$nombre = utf8_encode($lineNiveles['nivel']);
		
        if($nivel == $idNivel)
        {
            $strNivelesSel .= "<option value=\"$idNivel\" selected=\"selected\">$nombre</option>";
        }
        else
        {
            $strNivelesSel .= "<option value=\"$idNivel\">$nombre</option>";
        }
	}
	
	$strPracticasSel = "<option value=\"0\">-----------</option>";
    $queryPracticas = "SELECT * FROM Practicas ORDER BY Practica";
    $resultPracticas = mysql_query($queryPracticas);
	while($linePracticas = mysql_fetch_assoc($resultPracticas))
	{
		$idPractica = $linePracticas['idPractica'];
		$nombre = utf8_encode($linePracticas['practica']);
        
        if($practica == $idPractica)
        {
            $strPracticasSel .= "<option value=\"$idPractica\" selected=\"selected\">$nombre</option>";
        }else
        {
		
        $strPracticasSel .= "<option value=\"$idPractica\">$nombre</option>";
        }
	}
    
    
    // Abrimos el template para llenar la descripcion
    $template = new HTML_Template_ITX('../templates');
    $template->loadTemplatefile("./abogados/infoAbogado.html", true, true);
    
    $template->setVariable("CLAVE_IDENTIFICACION", $clave);
    $template->setVariable("NOMBRE_ABOGADO", $nombreAbogado);
	$template->setVariable("AP_PATERNO_ABOGADO", $apellidoPaterno);
    $template->setVariable("AP_MATERNO_ABOGADO", $apellidoMaterno);
    $template->setVariable("NIVELES_SEL", $strNivelesSel);
    $template->setVariable("PRACTICAS_SEL", $strPracticasSel);
    $template->setVariable("HORAS_CARGADAS", $horasCargadas);
	$template->setVariable("HORAS_FACTURADAS", $horasFacturadas);
    $template->setVariable("SUELDO", $sueldo);
    $template->setVariable("SELECTED_$tipoUsuario", 'selected="selected"');
    
    $template->show();
    
    Desconectar();
?>