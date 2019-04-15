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
	$template->loadTemplatefile("mainTemplatePopupUsuarios.html", true, true);
	
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
                
                if($tipoUsuario == 2)
                {
                    //Cerrar ventana
                    die();
                }
			}
		}
	}
    
    $idUsuario = $_GET['idUsuario'];
    $tipoUsuario = $_GET['tipoUsuario'];
    
    $queryUsuarios = "SELECT * FROM Usuarios ORDER BY nombre, apPaterno, apMaterno";
	$resultUsuarios = mysql_query($queryUsuarios);
	$numFilasUsuarios = mysql_num_rows($resultUsuarios);
	
//	if($numFilasUsuarios > 0)
//	{
//		$strMenuBorrarUsuario = '<a id="menuBorrarUsuario" href="javascript:;" onclick="borrarUsuario()">- Borrar</a>';
//        $strMenuEditarUsuario = '<a id="menuEditarUsuario" href="javascript:;" onclick="editarUsuario()">- Editar</a>';
//	}
//	else
//	{
//		$strMenuBorrarUsuario = '<a id="menuBorrarUsuario" class="hrefDisabled">- Borrar</a>';
//        $strMenuEditarUsuario = '<a id="menuEditarUsuario" class="hrefDisabled">- Editar</a>';
//	}

	$strMenuBorrarUsuario = '<a id="menuBorrarUsuario" class="hrefDisabled">- Borrar</a>';
    $strMenuEditarUsuario = '<a id="menuEditarUsuario" class="hrefDisabled">- Editar</a>';
    
	$template->setVariable("CLASE_MENU", "menuPopupUsuarios");
	
	$template->setVariable("TOKEN_MAIN", $token);
	
	$template->setvariable("CLASE_CONTENIDO","contenidoPopupUsuarios");
	$template->setvariable("ID_CONTENIDO","contenido");
	
	$template->addBlockFile('MENU', 'MENU_MAIN', './menu/menuUsuarios.html');
	$template->setCurrentBlock("MENU_MAIN");
	$template->setVariable("MENU_EDITAR_USUARIO", $strMenuEditarUsuario);
    $template->setVariable("MENU_BORRAR_USUARIO", $strMenuBorrarUsuario);
	$template->parseCurrentBlock('MENU_MAIN');
	
	////// Agregamos el contenido principal de la pagina
	$template->addBlockfile("CONTENIDO", "PRINCIPAL", "./usuarios/usuarios.html");
	$template->setCurrentBlock("PRINCIPAL");
    $template->setVariable("ID_USUARIO_PRINCIPAL", $idUsuario);
	$template->setVariable("NUMERO_USUARIOS", $numFilasUsuarios);
	
    if($numFilasUsuarios > 0)
	{
		$i = 1;
		while($lineUsuarios = mysql_fetch_assoc($resultUsuarios))
		{	
			$idUsuario = $lineUsuarios['idUsuario'];
			$nombre = utf8_encode($lineUsuarios['nombre']);
			$apellidoPaterno = utf8_encode($lineUsuarios['apPaterno']);
			$apellidoMaterno = utf8_encode($lineUsuarios['apMaterno']);
			
			$nombreCompletoUsuario = $nombre . " " . $apellidoPaterno . " " . $apellidoMaterno;
            
            $template->setCurrentBlock("LISTA_USUARIOS");
			$template->setVariable("ID_USUARIO", $idUsuario);
			$template->setVariable("NUMERO", $i);
			
			$template->setVariable("NOMBRE_USUARIO_LISTA", $nombreCompletoUsuario);
        
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
