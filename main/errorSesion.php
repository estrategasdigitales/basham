<?php
	require_once "../HTML/Template/ITX.php";
	include("../_cnfgF/cfgLocation.php");
	include("../_cnfgF/configuration.php");
	
	Conectar();
	// ========================================================================
	//
	// 	Cargamos el template y desplegamos la pagina inicial 
	// 	de la configuracion de la empresa
	// 
	// ========================================================================
	$template = new HTML_Template_ITX('../templates');
	$template->loadTemplatefile("mainTemplate.html", true, true);
	
	$location = $cfgLocation['location'];
	
	$template->setVariable("CLASE_WRAP", "wrapContenido");
	
	$template->setVariable("CLASE_MENU", "menu");
	
	//$template->setvariable("CLASE_CONTENIDO","contenido");
	//$template->setvariable("ID_CONTENIDO","contenido");
	//
	//
	//// Agregamos el contenido principal de la pagina
	//$template->addBlockfile("CONTENIDO", "LOGIN", "./login/login.html");
	//$template->setCurrentBlock("LOGIN");
	//$template->touchBlock("LOGIN");
	
	$template->addBlockFile('LOGIN', 'LOGIN', './login/login.html');
	$template->setCurrentBlock("LOGIN");
	$template->touchBlock("LOGIN");
	
	// Agregamos el contenido principal de la pagina
	$template->addBlockfile("CONTENIDO", "MENSAJE_ERROR_SESION", "./error/errorSesion.html");
	$template->setCurrentBlock("MENSAJE_ERROR_SESION");
	$template->touchBlock('MENSAJE_ERROR_SESION');
	
	$template->show();
	
?>
