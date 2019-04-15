<?php
    /** Error reporting */
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Europe/London');
    define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
    date_default_timezone_set('Europe/London');
    
    include("../_cnfgF/configuration.php");
    
    /**
     * PHPExcel
     *
     * Copyright (C) 2006 - 2012 PHPExcel
     *
     * This library is free software; you can redistribute it and/or
     * modify it under the terms of the GNU Lesser General Public
     * License as published by the Free Software Foundation; either
     * version 2.1 of the License, or (at your option) any later version.
     *
     * This library is distributed in the hope that it will be useful,
     * but WITHOUT ANY WARRANTY; without even the implied warranty of
     * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
     * Lesser General Public License for more details.
     *
     * You should have received a copy of the GNU Lesser General Public
     * License along with this library; if not, write to the Free Software
     * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
     *
     * @category   PHPExcel
     * @package    PHPExcel
     * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
     * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
     * @version    1.7.8, 2012-10-12
     */
    
     
    include_once "../PHPExcel/Classes/PHPExcel.php";
     
    $objPHPExcel = new PHPExcel();
    $objWorksheet = $objPHPExcel->getActiveSheet();
    
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $logo = '../img/logo/logo.png'; // Provide path to your logo file
    $objDrawing->setPath($logo);  //setOffsetY has no effect
    $objDrawing->setCoordinates('A1');
    $objDrawing->setHeight(100); // logo height
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    
    
    /***Estilo***/
    
    $estiloNombre = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => 'FFFFFF'),
            'size'  => 11,
            'name'  => 'Calibri'
        )
        );
    
        $estiloTituloTabla = array(
        'font'  => array(
            'bold'  => false,
            'color' => array('rgb' => 'FFFFFF'),
            'size'  => 11,
            'name'  => 'Calibri'
        )
        );
    
     $textoCentrado = array(
        'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
                            );       
    
    $estiloNombre = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => 'FFFFFF'),
            'size'  => 11,
            'name'  => 'Calibri'
        ),
        'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ));
    
            $estiloEsperado = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => 'FFFFFF'),
            'size'  => 11,
            'name'  => 'Calibri'
        ),
        'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )); 
    
    $fondoNegro =  array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '000000')
            )
        );
    
        
     $fondoGris =  array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C0C0C0')
            )
        );   
      
    
    $idAbogado = $_GET['idAbogado'];
    //$nombreArchivo = $_GET['nombreArchivo'];
    
    Conectar();
    
    $queryEvaluaciones = "SELECT * FROM Resultado WHERE idAbogado = $idAbogado ORDER BY fecha DESC LIMIT 0,1";
	$resultEvaluaciones = mysql_query($queryEvaluaciones);
	$numFilasEvaluaciones = mysql_num_rows($resultEvaluaciones);
    $lineEvaluaciones = mysql_fetch_assoc($resultEvaluaciones);
    $idResultado = $lineEvaluaciones['idResultado'];
    
    for($i = 1; $i <= 5; $i++)
    {
        $queryResultadoCompetencias = "SELECT * FROM ResultadosCompetencias WHERE idResultado = $idResultado AND idCompetencia = $i";
        $resultResultadoCompetencias = mysql_query($queryResultadoCompetencias);
        $lineResultadoCompetencias = mysql_fetch_assoc($resultResultadoCompetencias);
        
        if($i == 1)
        {
            $conocimientos = $lineResultadoCompetencias['porcentajeObtenido'];
        }
        elseif($i == 2)
        {
            $formaTrabajo = $lineResultadoCompetencias['porcentajeObtenido'];
        }
        elseif($i == 3)
        {
            $habilidades = $lineResultadoCompetencias['porcentajeObtenido'];
        }
        elseif($i == 4)
        {
            $eficiencia = $lineResultadoCompetencias['porcentajeObtenido'];
        }
        elseif($i == 5)
        {
            $actitud = $lineResultadoCompetencias['porcentajeObtenido'];
        }
    }
    
    $queryAbogados = "SELECT * FROM Abogados WHERE idAbogado = $idAbogado";
    $resultAbogados = mysql_query($queryAbogados) or die("1");
    $lineAbogados = mysql_fetch_assoc($resultAbogados);
    $nombreAbogado = utf8_encode($lineAbogados['nombre']);
    $apellidoPaterno = utf8_encode($lineAbogados['apPaterno']);
    $apellidoMaterno = utf8_encode($lineAbogados['apMaterno']);
    
    $nombreCompletoAbogado = $nombreAbogado . " " . $apellidoPaterno . " " . $apellidoMaterno;
    
    Desconectar();
    
    
    $sheet = $objPHPExcel->getActiveSheet();
    $sheet->mergeCells('A1:A6');
    
    $objPHPExcel->getDefaultStyle()
        ->getBorders()
        ->getTop()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
    $objPHPExcel->getDefaultStyle()
        ->getBorders()
        ->getBottom()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
    $objPHPExcel->getDefaultStyle()
        ->getBorders()
        ->getLeft()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
    $objPHPExcel->getDefaultStyle()
        ->getBorders()
        ->getRight()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
    
    
        
        
    $sheet->getCell('A7')->setValue($nombreCompletoAbogado);
    $sheet->getStyle('A7')->applyFromArray($estiloNombre);
    $sheet->getStyle('A7')->applyFromArray($textoCentrado);
    $sheet->getStyle('A7')->applyFromArray($fondoNegro);
    $sheet->getColumnDimension('A')->setWidth(40);
    $sheet->getColumnDimension('B')->setWidth(15);
    
    $sheet->getCell('A8')->setValue('Elementos a evaluar');
    $sheet->getCell('B8')->setValue('% Obtenido');
    $sheet->getStyle('A8:B8')->applyFromArray($fondoGris);
    $sheet->getStyle('A8:B8')->applyFromArray($estiloTituloTabla);
    $sheet->getStyle('B8')->applyFromArray($textoCentrado);
    
    
    $sheet->getCell('A9')->setValue('I. CONOCIMIENTOS JURÍDICOS');
    $sheet->getCell('A10')->setValue('II. FORMA DE TRABAJO DE LA FIRMA');
    $sheet->getCell('A11')->setValue('III. HABILIDADES Y CAPACIDADES');
    $sheet->getCell('A12')->setValue('IV. EFICIENCIA Y EJECUCIÓN');
    $sheet->getCell('A13')->setValue('V. ACTITUD');
    $sheet->getCell('A14')->setValue('COMPETENCIAS A DESARROLLAR');
    
    $sheet->getCell('B9')->setValue($conocimientos);
    $sheet->getCell('B10')->setValue($formaTrabajo);
    $sheet->getCell('B11')->setValue($habilidades);
    $sheet->getCell('B12')->setValue($eficiencia);
    $sheet->getCell('B13')->setValue($actitud);
    $sheet->getCell('B14')->setValue(' - ');
    $sheet->getStyle('B9:B14')->applyFromArray($textoCentrado);
    
    $sheet->getCell('C8')->setValue('Esperado');
    $sheet->getCell('C9')->setValue(100-$conocimientos);
    $sheet->getCell('C10')->setValue(100-$formaTrabajo);
    $sheet->getCell('C11')->setValue(100-$habilidades);
    $sheet->getCell('C12')->setValue(100-$eficiencia);
    $sheet->getCell('C13')->setValue(100-$actitud);
    
    $sheet->getStyle('C8:C14')->applyFromArray($estiloEsperado);
    
    
    
    //	Set the Labels for each data series we want to plot
    //		Datatype
    //		Cell reference for data
    //		Format Code
    //		Number of datapoints in series
    //		Data values
    //		Data Marker
    $dataseriesLabels = array(
        new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$8', null, 1),	//	2010
        new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$8', null, 1)	//	2011
        
    );
    //	Set the X-Axis Labels
    //		Datatype
    //		Cell reference for data
    //		Format Code
    //		Number of datapoints in series
    //		Data values
    //		Data Marker
    $xAxisTickValues = array(
        new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$9:$A$13', null, 5),	//	Q1 to Q4
    );
    //	Set the Data values for each data series we want to plot
    //		Datatype
    //		Cell reference for data
    //		Format Code
    //		Number of datapoints in series
    //		Data values
    //		Data Marker
    $dataSeriesValues = array(
        new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$9:$B$13', null, 5),
        new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$9:$C$13', null, 5),
    
        
    );
    //	Build the dataseries
    $series = new PHPExcel_Chart_DataSeries(
        PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
        PHPExcel_Chart_DataSeries::GROUPING_PERCENT_STACKED, // plotGrouping
        range(0, count($dataSeriesValues)-1),			// plotOrder
        $dataseriesLabels,								// plotLabel
        $xAxisTickValues,								// plotCategory
        $dataSeriesValues								// plotValues
    );
    //	Set additional dataseries parameters
    //		Make it a horizontal bar rather than a vertical column graph
    $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_BAR);
    //	Set the series in the plot area
    $plotarea = new PHPExcel_Chart_PlotArea(null, array($series));
    //	Set the chart legend
    $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);
    $title = new PHPExcel_Chart_Title('Resultados');
    $yAxisLabel = new PHPExcel_Chart_Title('% Obtenido');
    //	Create the chart
    $chart = new PHPExcel_Chart(
        'chart1',		// name
        $title,			// title
        $legend,		// legend
        $plotarea,		// plotArea
        true,			// plotVisibleOnly
        0,				// displayBlanksAs
        null,			// xAxisLabel
        $yAxisLabel		// yAxisLabel
    );
    //	Set the position where the chart should appear in the worksheet
    $chart->setTopLeftPosition('D3');
    $chart->setBottomRightPosition('P28');
    //	Add the chart to the worksheet
    $objWorksheet->addChart($chart);
    // Save Excel 2007 file
    
    // Redirect output to a client’s web browser (Excel2007)
    //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //header('Content-Disposition: attachment;filename="evaluacion.xlsx"');
    //header('Cache-Control: max-age=0');
    //
    //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    //$objWriter->setIncludeCharts(TRUE);
    //$objWriter->save('php://output');
    
    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //header("Content-Disposition: attachment;filename=\"$nombreArchivo\"");
    header('Content-Disposition: attachment;filename="ReporteDeEvaluacion.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');
    
    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0
    
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->setIncludeCharts(TRUE);
    $objWriter->save('php://output');


?>