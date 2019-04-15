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
        
        $queryUsuarios = "SELECT * FROM Usuarios WHERE $strQuery ORDER BY nombre, apPaterno, apMaterno";
    }
    else
    {
		$queryUsuarios = "SELECT * FROM Usuarios ORDER BY nombre, apPaterno, apMaterno";
	}
	
	$resultUsuarios = mysql_query($queryUsuarios);
	$numFilasUsuarios = mysql_num_rows($resultUsuarios);
	
	if($error == 1)
	{
		print 0;
		die();
	}
    
    // Abrimos el template para llenar la descripcion
    $template = new HTML_Template_ITX('../templates');
    $template->loadTemplatefile("./usuarios/infoUsuarioCompleta.html", true, true);
    
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
    
    $template->show();
    
    Desconectar();
    
?>