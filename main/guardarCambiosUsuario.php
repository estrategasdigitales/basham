<?php
	require_once "../HTML/Template/ITX.php";
	include("../_cnfgF/cfgLocation.php");
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
        
    Conectar();
	
	/*
	
	var params = "nombre="+nombre+"&aPaterno="+aPaterno+"&aMaterno="+aMaterno+
	"&password="+password+"&login="+login+"&idUsuario="+idUsuario+"&email="+email+
	"&tipoUsuario="+tipoUsuario;
	
	*/
        
	$idUsuario = $_POST['idUsuario'];
	
    $nombre = utf8_decode($_POST['nombre']);
    $aPaterno = utf8_decode($_POST['aPaterno']);
    $aMaterno = utf8_decode($_POST['aMaterno']);
    $password = utf8_decode($_POST['password']);
    $login = utf8_decode($_POST['login']);
    $email = utf8_decode($_POST['email']);
	$tipoUsuario = $_POST['tipoUsuario'];
    
    $error = 0;
    
    if(count(explode("'",$nombre))>1 || count(explode('"',$nombre))>1){
        $error = 1;
    }
    if(count(explode("'",$aPaterno))>1 || count(explode('"',$aPaterno))>1){
        $error = 1;
    }
    if(count(explode("'",$aMaterno))>1 || count(explode('"',$aMaterno))>1){
        $error = 1;
    }
    if(count(explode("'",$password))>1 || count(explode('"',$password))>1){
        $error = 1;
    }
    if(count(explode("'",$login))>1 || count(explode('"',$login))>1){
        $error = 1;
    }
    if(count(explode("'",$email))>1 || count(explode('"',$email))>1){
        $error = 1;
    }
	if(count(explode("'",$tipoUsuario))>1 || count(explode('"',$tipoUsuario))>1){
        $error = 1;
    }
    
    $fechaHoy = date("Y-m-d H:i:00");
    
    if($error == 0)
    {
        if($idUsuario == 0)
		{
			//Validar que el nombre del usuario en la misma institucion no exista
			$query = "SELECT * FROM Usuarios WHERE nombre = '$nombre' AND apPaterno = '$aPaterno'
					AND apMaterno = '$aMaterno'";
			$result = mysql_query($query);
			$numFilas = mysql_num_rows($result);
			if($numFilas > 0)
			{
				die("2");
			}
			
			//Validar que el nombre del usuario no exista
			$query = "SELECT * FROM Usuarios WHERE userName = '$login'";
			$result = mysql_query($query);
			$numFilas = mysql_num_rows($result);
			if($numFilas > 0)
			{
				die("3");
			}
			
			//Validar que el correo del usuario no exista
			$query = "SELECT * FROM Usuarios WHERE mail = '$email'";
			$result = mysql_query($query);
			$numFilas = mysql_num_rows($result);
			if($numFilas > 0)
			{
				die("4");
			}	
			
			if($password == "")
			{
				$password = generaPasswd();
			}
			
			$passwd = sha1($password);
			
			$query = "INSERT INTO Usuarios(nombre,apPaterno,apMaterno,password,userName,mail,tipoUsuario)
									VALUES('$nombre','$aPaterno','$aMaterno','$passwd','$login','$email','$tipoUsuario')";
			
			$result = mysql_query($query) or die("1");
			
			$nombreCompletoUsuario = $nombre . " " . $aPaterno . " " . $aMaterno;
            
			$fecha = date("Y-m-d H:i:s");
	    
            Desconectar();
            
//            // Mandamos correo de bienvenida con usuario y password
//            $to      = $login;
//            $subject = 'Mensaje de bienvenida';
//            $message = '
//
//            Estimado(a): '.$nombreCompletoUsuario.':
//
//            Bienvenido al sistema. Para poder ingresar,
//            
//            accese a la siguiente liga: 
//            
//            
//            
//            con los siguientes datos:
//            
//            -------------------------
//            Usuario: '.$login.'
//            Clave: '.$password.'
//            -------------------------
//            
//            Atentamente:
//            
//            Administrador del Sistema.
//            
//            ----------------------------------------------------------------------------
//              No responda a este correo. Fue generado desde una cuenta
//              no monitoreada.
//            ----------------------------------------------------------------------------
//            ';
//			$headers = 'From:admin@kerma.com.mx' . "\r\n";
//			
//			mail($to, $subject, $message, $headers);
		}
		else
		{
			//Validar que el nombre del usuario en la misma institucion no exista
			$query = "SELECT * FROM Usuarios WHERE nombre = '$nombre' AND apPaterno = '$aPaterno'
					AND apMaterno = '$aMaterno' AND idUsuario != $idUsuario";
			$result = mysql_query($query);
			$numFilas = mysql_num_rows($result);
			if($numFilas > 0)
			{
				die("2");
			}
			
			//Validar que el nombre del usuario no exista
			$query = "SELECT * FROM Usuarios WHERE userName = '$login' AND idUsuario != $idUsuario";
			$result = mysql_query($query);
			$numFilas = mysql_num_rows($result);
			if($numFilas > 0)
			{
				die("3");
			}
			
			//Validar que el correo del usuario no exista
			$query = "SELECT * FROM Usuarios WHERE mail = '$email' AND idUsuario != $idUsuario";
			$result = mysql_query($query);
			$numFilas = mysql_num_rows($result);
			if($numFilas > 0)
			{
				die("4");
			}
			
			if($password != "")
			{
				$passwd = sha1($password);
				$strPwd = "password = '$passwd',";
			}
			else
			{
				$strPwd = "";
			}
			
			$query = "UPDATE Usuarios SET
				nombre = '$nombre',
				apPaterno = '$aPaterno',
				apMaterno = '$aMaterno',
				$strPwd
				userName = '$login',
				mail = '$email',
				tipoUsuario = '$tipoUsuario'
				WHERE idUsuario = $idUsuario";
			
			$result = mysql_query($query) or die("1");
			
			//if($password != "")
			//{
			//	//Solo si se cambió la contraseña de un usuario, se debe enviar un correo para avisarle
			//	$nombreCompletoUsuario = $nombre . " " . $aPaterno . " " . $aMaterno;
			//         
			//	$fecha = date("Y-m-d H:i:s");
			//
			//	Desconectar();
			//	
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
		}
        print "OK";
        die();
    }
    else
    {
        print 0;
        die();
    }
?>