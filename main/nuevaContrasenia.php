<?php

    require_once "HTML/Template/ITX.php";
    include("../_cnfgF/configuration.php");
    date_default_timezone_set('America/Mexico_City');
	
    function generaPasswd($length = 8){
		$password = "";
		// Posibles Caracteres
		$posibles = "123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ"; 
  
		$i = 0; 
		// Agregar caracteres aleatoriamente hasta el tamaÃ±o definido.
		while ($i < $length) { 
			// Escoger un caracter
			$char = substr($posibles, mt_rand(0, strlen($posibles)-1), 1);
			//Checar que el caracter no se haya ingresado antes
			if (!strstr($password, $char)) { 
				$password .= $char;
				$i++;
			}
		}
	  
		return $password;
      
    }
    
    $email = $_POST['correoElectronico'];
	$login = $_POST['nombreUsuario'];
	
    if($email != '' && $login != '')
    {
		Conectar();
		
        $query = "SELECT * FROM Usuarios WHERE mail='$email' AND userName='$login'";
		//die($query);
        $result = mysql_query($query) or die("Recuperar pwd");
        if(mysql_num_rows($result)>0)
        {
            $passwd = generaPasswd();
            $pwd2 = sha1("$passwd");
            $row = mysql_fetch_assoc($result);
			$idUsuario = $row['idUsuario'];
            $nombre = $row['nombre'];
			$apellidoPaterno = $row['apPaterno'];
			$apellidoMaterno = $row['apMaterno'];
			
			$nombreCompletoUsuario = $nombre . " " . $apellidoPaterno . " " . $apellidoMaterno;
            
			$fecha = date("Y-m-d H:i:s");
	    
            $query = "UPDATE Usuarios SET password = '$pwd2' WHERE idUsuario = '$idUsuario'";
            
            mysql_query($query) or die("Query update pwd");
            
//            $query = "INSERT INTO logs (Fecha, Accion, Modificacion, Campo, UsuarioID)
//		    VALUES ('$fecha', 1, 'CONTRASEÑA', '$nombreCompleto','$idPersona')";
//		
//            mysql_query($query) or die("Query actualizar ultima actualizacion");
            
            Desconectar();
            
            //	// Mandamos correo de bienvenida con usuario y password
			//	$to      = $login;
			//	$subject = 'Cambio de clave';
			//	$message = '
			//
			//	Estimado(a): '.$nombreCompletoUsuario.':
			//
			//	Su clave ha sido cambiada. Para volver a utilizar el sistema,
			//	
			//	ingrese a la siguiente liga: 
			//	
			//	
			//	
			//	con los siguientes datos:
			//	
			//	-------------------------
			//	Usuario: '.$login.'
			//	Clave: '.$password.'
			//	-------------------------
			//	
			//	Atentamente:
			//	
			//	Administrador del Sistema.
			//	
			//	----------------------------------------------------------------------------
			//	  No responda a este correo. Fue generado desde una cuenta
			//	  no monitoreada.
			//	----------------------------------------------------------------------------
			//	';
			//	$headers = 'From:admin@kerma.com.mx' . "\r\n";
			//
			//	mail($to, $subject, $message, $headers);
			//}
            
            $template = new HTML_Template_ITX('../templates');
            $template->loadTemplatefile("mainTemplate.html", true, true);
	    
			$template->setVariable("CLASE_WRAP", "wrapContenido");
		
			$template->setVariable("CLASE_MENU", "menu");
			
			//// Agregamos el contenido principal de la pagina
			$template->addBlockFile('LOGIN', 'LOGIN', './login/login.html');
			$template->setCurrentBlock("LOGIN");
			$template->touchBlock("LOGIN");
				
			$template->addBlockfile("CONTENIDO", "MENSAJE_CAMBIO_CONTRASENIA", "./pwd/mensajeCambioContrasenia.html");
			$template->setCurrentBlock("MENSAJE_CAMBIO_CONTRASENIA");
			$template->touchBlock('MENSAJE_CAMBIO_CONTRASENIA');
			
			$template->show();
				
		}
        else
        {
			$query = "SELECT * FROM Usuarios WHERE mail='$email'";
			//die($query);
			$result = mysql_query($query) or die("Recuperar pwd");
			if(mysql_num_rows($result) == 0)
			{
				echo "<script>
						alert('Introduzca una direcci\u00f3n de correo v\u00e1lida');
						window.location='recuperarContrasenia.php';
					  </script>";
			}
			else
			{
				$query = "SELECT * FROM Usuarios WHERE userName='$login'";
				//die($query);
				$result = mysql_query($query) or die("Recuperar pwd");
				if(mysql_num_rows($result) == 0)
				{
					echo "<script>
							alert('Introduzca un nombre de usuario v\u00e1lida');
							window.location='recuperarContrasenia.php';
						  </script>";
				}
			}
	    }
        
    }
    elseif($email=='')
    {
        echo "<script>
                alert('Introduzca su direcci\u00f3n de correo electr\u00f3nico');
                window.location='recuperarContrasenia.php';
              </script>";
    }
	elseif($login=='')
    {
        echo "<script>
                alert('Introduzca su nombre de usuario');
                window.location='recuperarContrasenia.php';
              </script>";
    }
    
?>