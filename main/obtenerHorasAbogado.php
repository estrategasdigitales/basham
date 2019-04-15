<?php
    include("../_cnfgF/configuration.php");
    
    date_default_timezone_set('America/Mexico_City');
    
    Conectar();
    $idAbogado = $_POST['idAbogado'];
    
    $queryAbogados = "SELECT * FROM Abogados WHERE idAbogado = $idAbogado";
    $resultAbogados = mysql_query($queryAbogados) or die("1");
    $lineAbogados = mysql_fetch_assoc($resultAbogados);
    $horasFacturadas = $lineAbogados['horasFacturadas'];
    $horasCargadas = $lineAbogados['horasCargadas'];
    
    Desconectar();
    
    $str = $horasCargadas . "_" . $horasFacturadas;
    
    print $str;
?>