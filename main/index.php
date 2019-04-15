<?php
	require_once "../HTML/Template/ITX.php";
	include("../_cnfgF/cfgLocation.php");
	include("../_cnfgF/configuration.php");
	
	// ========================================================================
	//
	// 	Cargamos el template y desplegamos la pagina inicial 
	// 	de la configuracion de la empresa
	// 
	// ========================================================================
	$template = new HTML_Template_ITX('../templates');
	$template->loadTemplatefile("mainTemplate.html", true, true);
	
	$location = $cfgLocation['location'];
	
	$template->setVariable("CLASE_WRAP", "wrapContenidoLogin");
	
	// Agregamos el contenido principal de la pagina
	$template->addBlockFile('LOGIN', 'LOGIN', './login/login.html');
	$template->setCurrentBlock("LOGIN");
	$template->touchBlock("LOGIN");
	
	$template->show();
	
	//mysql_free_result($resultEntidad);
	//Desconectar();
	
?>
