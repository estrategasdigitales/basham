<?php
    require_once "../HTML/Template/ITX.php";
    include("../_cnfgF/configuration.php");
    
    date_default_timezone_set('America/Mexico_City');
    
    Conectar();
    $idUsuario = $_POST['idUsuario'];
    
    $queryUsuarios = "SELECT * FROM Usuarios WHERE idUsuario = $idUsuario";
    $resultUsuarios = mysql_query($queryUsuarios) or die("1");
    $lineUsuarios = mysql_fetch_assoc($resultUsuarios);
    $nombreUsuario = utf8_encode($lineUsuarios['nombre']);
    $apellidoPaterno = utf8_encode($lineUsuarios['apPaterno']);
    $apellidoMaterno = utf8_encode($lineUsuarios['apMaterno']);
    $login = utf8_encode($lineUsuarios['userName']);
    $email = utf8_encode($lineUsuarios['mail']);
    $tipoUsuario = $lineUsuarios['tipoUsuario'];
    
    // Abrimos el template para llenar la descripcion
    $template = new HTML_Template_ITX('../templates');
    $template->loadTemplatefile("./usuarios/infoUsuario.html", true, true);
    
    $template->setVariable("NOMBRE_USUARIO", $nombreUsuario);
	$template->setVariable("AP_PATERNO_USUARIO", $apellidoPaterno);
    $template->setVariable("AP_MATERNO_USUARIO", $apellidoMaterno);
    $template->setVariable("LOGIN_USUARIO", $login);
    $template->setVariable("EMAIL_USUARIO", $email);
    $template->setVariable("SELECTED_$tipoUsuario", 'selected="selected"');
    
    $template->show();
    
    Desconectar();
?>