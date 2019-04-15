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
	$template->loadTemplatefile("mainTemplatePopupAbogados.html", true, true);
	
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
    
    $idUsuario = $_GET['idUsuario'];
    $tipoUsuario = $_GET['tipoUsuario'];
    
    if($tipoUsuario == 1)//Administrador
    {
        $queryAbogados = "SELECT * FROM Abogados ORDER BY nombre, apPaterno, apMaterno";
    }
    else
    {
        $queryAbogados = "SELECT * FROM Abogados WHERE idUsuario = $idUsuario ";
    }
	$resultAbogados = mysql_query($queryAbogados);
	$numFilasAbogados = mysql_num_rows($resultAbogados);
	
	if($numFilasAbogados > 0)
	{
		$strMenuBorrarAbogado = '<a id="menuBorrarAbogado" href="javascript:;" onclick="borrarAbogado()">- Borrar</a>';
        $strMenuEditarAbogado = '<a id="menuEditarAbogado" href="javascript:;" onclick="editarAbogado()">- Editar</a>';
	}
	else
	{
		$strMenuBorrarAbogado = '<a id="menuBorrarAbogado" class="hrefDisabled">- Borrar</a>';
        $strMenuEditarAbogado = '<a id="menuEditarAbogado" class="hrefDisabled">- Editar</a>';
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
    
	$template->setVariable("CLASE_MENU", "menuPopupAbogados");
	
	$template->setVariable("TOKEN_MAIN", $token);
	
	$template->setvariable("CLASE_CONTENIDO","contenidoPopupAbogados");
	$template->setvariable("ID_CONTENIDO","contenido");
	
	$template->addBlockFile('MENU', 'MENU_MAIN', './menu/menuAbogados.html');
	$template->setCurrentBlock("MENU_MAIN");
	$template->setVariable("MENU_EDITAR_ABOGADO", $strMenuEditarAbogado);
    $template->setVariable("MENU_BORRAR_ABOGADO", $strMenuBorrarAbogado);
	$template->parseCurrentBlock('MENU_MAIN');
	
	////// Agregamos el contenido principal de la pagina
	$template->addBlockfile("CONTENIDO", "PRINCIPAL", "./abogados/abogados.html");
	$template->setCurrentBlock("PRINCIPAL");
    $template->setVariable("ID_USUARIO_PRINCIPAL", $idUsuario);
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
    
	$template->parseCurrentBlock('PRINCIPAL');
	$template->show();
	
	//mysql_free_result($resultEntidad);
	//Desconectar();
	
?>
