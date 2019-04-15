<?php
	require_once "../HTML/Template/ITX.php";
	include("../_cnfgF/cfgLocation.php");
	include("../_cnfgF/configuration.php");
	
	date_default_timezone_set('America/Mexico_City');
	
	// ========================================================================
	//
	// 	Cargamos el template y desplegamos la pagina inicial 
	// 	de la configuracion de la empresa
	// 
	// ========================================================================
	$template = new HTML_Template_ITX('../templates');
	$template->loadTemplatefile("mainTemplate.html", true, true);
	
	$location = $cfgLocation['location'];
	
	if(!(isset($_GET['token']))){
		header("location: $location");
	}
	else{
		
		Conectar();
			
		$idUsuario = 0;
		$nombre = '';
		$apellidos = '';
		
		$token = $_GET['token'];
		
		$query = mysql_query("SELECT idUsuario, horaFecha FROM Sesion WHERE token = '$token'");
		if(($row = mysql_fetch_assoc($query)) == null){
			Desconectar();
			header("location: ../main/errorSesion.php"); // La sesion se ha cerrado
		}// if
		else{
			$idUsuario = $row['idUsuario'];
			$fechaHora = $row['horaFecha'];
			
			$query = mysql_query("SELECT nombre, apPaterno, apMaterno, tipoUsuario
					     FROM Usuarios
					     WHERE idUsuario = $idUsuario");
			
			if(($row = mysql_fetch_assoc($query)) == null){
				Desconectar();
				header("location: ../main/errorSesion.php"); // La sesion se ha cerrado
			}// if
			else{
				$nombre = $row['nombre'];
				$apellidoPaterno = $row['apPaterno'];
				$apellidoMaterno = $row['apMaterno'];
				$tipoUsuario = $row['tipoUsuario'];
			}
		}
	}
	
	if($apellidoMaterno != "")
	{
	    $nombreCompletoUsuario = $apellidoPaterno . " " . $apellidoMaterno . ", " . $nombre;
	}
	else
	{
	    $nombreCompletoUsuario = $apellidoPaterno . ", " . $nombre;
	}
	
	$queryTiempo = mysql_query("SELECT NOW()");
	$row = mysql_fetch_array($queryTiempo);
	$tiempo = $row[0];
	$duration = abs(strtotime($tiempo) - strtotime($fechaHora));
	if($duration > $cfgLocation['tiempo'])
	{
		mysql_query("DELETE FROM Sesion WHERE Token = '$token'");
		Desconectar();
		header("location: ../main/errorSesion.php"); // La sesion se ha explirado
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
	
	if($tipoUsuario == 1)//Administrador
	{
		//$strDisplayEvaluaciones = 'style="display: none;"';
		$strDisplayEvaluaciones = "";
		$strDisplayAdministrador = "";
	}
	elseif($tipoUsuario == 2)//Evaluador
	{
		$strDisplayEvaluaciones = "";
		$strDisplayAdministrador = 'style="display: none;"';
	}
	
	$template->setVariable("CLASE_WRAP", "wrapContenido");
	
	$template->setVariable("CLASE_MENU", "menu");
	
	$template->setVariable("TOKEN_MAIN", $token);
	
	$template->setvariable("CLASE_CONTENIDO","contenido");
	$template->setvariable("ID_CONTENIDO","contenido");
	
	$template->addBlockFile('POPUP_EVALUACION', 'POPUP_EVALUACION_MAIN', './popups/reporteEvaluacion.html');
	$template->setCurrentBlock("POPUP_EVALUACION_MAIN");
	//$template->parseCurrentBlock('MENU_MAIN');
	$template->touchBlock("POPUP_EVALUACION_MAIN");
	
	$template->addBlockFile('POPUP_GENERAR_REPORTE_EVALUACION', 'POPUP_GENERAR_REPORTE_EVALUACION_MAIN', './popups/generarReporteEvaluacion.html');
	$template->setCurrentBlock("POPUP_GENERAR_REPORTE_EVALUACION_MAIN");
	//$template->parseCurrentBlock('MENU_MAIN');
	$template->touchBlock("POPUP_GENERAR_REPORTE_EVALUACION_MAIN");
	
	$template->addBlockFile('POPUP_CARGAR_HORAS_ABOGADO', 'POPUP_CARGAR_HORAS_ABOGADO_MAIN', './popups/capturarHorasAbogado.html');
	$template->setCurrentBlock("POPUP_CARGAR_HORAS_ABOGADO_MAIN");
	//$template->parseCurrentBlock('MENU_MAIN');
	$template->touchBlock("POPUP_CARGAR_HORAS_ABOGADO_MAIN");

	$template->addBlockFile('MENU', 'MENU_MAIN', './menu/menu.html');
	$template->setCurrentBlock("MENU_MAIN");
	$template->setVariable("STYLE_EVALUACIONES", $strDisplayEvaluaciones);
	$template->setVariable("STYLE_ADMINISTRADOR", $strDisplayAdministrador);
	$template->parseCurrentBlock('MENU_MAIN');
	
	// Agregamos el contenido principal de la pagina
	$template->addBlockfile("CONTENIDO", "PRINCIPAL", "./main/principal.html");
	$template->setCurrentBlock("PRINCIPAL");
	$template->setVariable("ID_USUARIO", $idUsuario);
	$template->setVariable("TIPO_USUARIO", $tipoUsuario);
	$template->setVariable("NIVELES_SEL", $strNivelesSel);
	$template->setVariable("PRACTICAS_SEL", $strPracticasSel);
	$template->parseCurrentBlock('PRINCIPAL');
	
	$template->show();
	
	//mysql_free_result($resultEntidad);
	//Desconectar();
	
?>
