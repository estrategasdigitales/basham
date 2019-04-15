<?php
    require_once "../HTML/Template/ITX.php";
    include("../_cnfgF/configuration.php");
    
    $query = "SELECT * FROM Abogados";
    
    Conectar();
    
    if(!isset($_GET['dato']))
    {
        $accion = $_POST['tipo'];
        if(isset($_POST['nombre']))
            $nombre = $_POST['nombre'];
        if(isset($_POST['aPaterno']))
            $aPaterno = $_POST['aPaterno'];
        if(isset($_POST['aMaterno']))
            $aMaterno = $_POST['aMaterno'];
        if(isset($_POST['practica']))
            $practica = $_POST['practica'];
        if(isset($_POST['nivel']))
            $nivel = $_POST['nivel'];
        
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
        if(count(explode("'",$practica))>1 || count(explode('"',$practica))>1){
                $error = 1;
        }
        
        if(count(explode("'",$nivel))>1 || count(explode('"',$nivel))>1){
                $error = 1;
        }
        
        if($error == 1)
        {
            print 0;
            die();
        }
        
        if($accion == 'uno')
        {
            $i = 0;
            
            $query .= " WHERE (";
            
            if($nombre != "")
            {
                //Convertir string a mayusculas y quitar acentos y comillas
                $nombre = strtoupper($nombre);
                $nombre = preg_replace("/[^A-Za-z0-9 _]/","%",$nombre);
                
                $query .= "nombre LIKE '%$nombre%'";
                $i = 1;
            }
            if($aPaterno != "")
            {
                //Convertir string a mayusculas y quitar acentos y comillas
                $aPaterno = strtoupper($aPaterno);
                $aPaterno = preg_replace("/[^A-Za-z0-9 _]/","%",$aPaterno);
                
                if($i == 0)
                {
                    $query .= "apPaterno LIKE '%$aPaterno%'";
                }
                else
                {
                    $query .= " AND apPaterno LIKE '%$aPaterno%'";
                }
                $i = 1;
            }
            if($aMaterno != "")
            {
                //Convertir string a mayusculas y quitar acentos y comillas
                $aMaterno = strtoupper($aMaterno);
                $aMaterno = preg_replace("/[^A-Za-z0-9 _]/","%",$aMaterno);
                
                if($i == 0)
                {
                    $query .= "apMaterno LIKE '%$aMaterno%'";
                }
                else
                {
                    $query .= " AND apMaterno LIKE '%$aMaterno%'";
                }
                $i = 1;
            }
            if($practica != 0)
            {
                
                
                if($i == 0)
                {
                    $query .= "idPractica LIKE $practica";
                }
                else
                {
                    $query .= " AND idPractica LIKE $practica";
                }
                $i = 1;
            }
            
            if($nivel != 0)
            {
                
                
                if($i == 0)
                {
                    $query .= "idNivel LIKE $nivel";
                }
                else
                {
                    $query .= " AND idNivel LIKE $nivel";
                }
                $i = 1;
            }
            
            $query .= ")";
            
        }
        else
        {
            $query .= "";
        }
    }
    else
    {
        $dato = $_GET['dato'];
        
        $dato = strtoupper($dato);
        $dato = preg_replace("/[^A-Za-z0-9 _]/","%",$dato);
        
        $query .= " WHERE ((nombre LIKE '%$dato%') OR (apPaterno LIKE '%$dato%')
                OR (apMaterno LIKE '%$dato%') OR (idPractica LIKE '%$dato%')) AND (Nombre != 'UsuarioCero')";
    }
    
    $query .= " ORDER BY apPaterno, apMaterno, nombre";
    
    // Abrimos el template para llenar la descripcion
    $template = new HTML_Template_ITX('../templates');
    $template->loadTemplatefile("./main/resultadoBusquedaAbogados.html", true, true);
    //die($query);                         
    $result = mysql_query($query) or die("1");
    
    $numFilas = mysql_num_rows($result);
    
    if($numFilas == 0)
    {
        print 0;
        die();
    }
    
    $template->setVariable("NUMERO_ABOGADOS", $numFilas);
    
    $i=1;
    while($line = mysql_fetch_assoc($result))
    {
            $idAbogado = $line['idAbogado'];
            
            $nombre = utf8_encode($line['nombre']);
            $aPaterno = utf8_encode($line['apPaterno']);
            $aMaterno = utf8_encode($line['apMaterno']);
            $practica = utf8_encode($line['idPractica']);
            $nivel = utf8_encode($line['idNivel']);
            
            if($practica != 0)
            {
                $queryPracticas = "SELECT * FROM Practicas WHERE idPractica = $practica";
                $resultPracticas = mysql_query($queryPracticas);
                $linePracticas = mysql_fetch_assoc($resultPracticas);
                $strPracticas = utf8_encode($linePracticas['practica']);
            }
            else
            {
                $strPracticas = "&nbsp;";
            }
            
            if($nivel != 0)
            {
                $queryNiveles = "SELECT * FROM Niveles WHERE idNivel = $nivel";
                $resultNiveles = mysql_query($queryNiveles);
                $lineNiveles = mysql_fetch_assoc($resultNiveles);
                $strNiveles = utf8_encode($lineNiveles['nivel']);
            }
            else
            {
                $strNiveles = "&nbsp;";
            }
            
            if($nombre == "")
            {
                $nombre = "&nbsp;";
            }
            if($aPaterno == "")
            {
                $aPaterno = "&nbsp;";
            }
            if($aMaterno == "")
            {
                $aMaterno = "&nbsp;";
            }
            
            $template->setCurrentBlock("LISTA_ABOGADOS");
            $template->setVariable("ID_ABOGADO", $idAbogado);
            $template->setVariable("NUMERO", $i);
            
            $template->setVariable("AP_PATERNO_ABOGADO_LISTA", $aPaterno);
            $template->setVariable("AP_MATERNO_ABOGADO_LISTA", $aMaterno);
            $template->setVariable("NOMBRE_ABOGADO_LISTA", $nombre);
            $template->setVariable("PRACTICA_ABOGADO_LISTA", $strPracticas);
            $template->setVariable("NIVEL_ABOGADO_LISTA", $strNiveles);
            $template->setVariable("ID_PRACTICA", $practica);
            $template->setVariable("ID_NIVEL", $nivel);
            
            if(($i % 2) == 0){
                    $template->setVariable("CLASE_DATO", "dato_par");
            }
            else{
                    $template->setVariable("CLASE_DATO", "dato_non");
            }
        
            $template->parseCurrentBlock();
            $i++;
    }
    
    $template->show();
    
    mysql_free_result($result);
    Desconectar();
?>