<?php
    require_once "HTML/Template/ITX.php";
	
    include("../_cnfgF/configuration.php");
    
    // ========================================================================
    //
    // 	Cargamos el template y desplegamos la pagina inicial 
    // 	de la configuracion de la empresa
    // 
    // ========================================================================
    $template = new HTML_Template_ITX('../templates');
    $template->loadTemplatefile("mainTemplate.html", true, true);
    
    $template->setVariable("CLASE_WRAP", "wrapContenido");
    
    $template->setVariable("CLASE_MENU", "menu");
	
    $template->addBlockFile('CONTENIDO', 'RECUPERA_PWD', './pwd/recuperarContrasenia.html');
    $template->setCurrentBlock("RECUPERA_PWD");
    $template->touchBlock("RECUPERA_PWD");
    
    $template->show();
?>
