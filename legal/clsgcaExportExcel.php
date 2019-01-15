<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgcaExportExcel
 *
 * @author JAVSOTO
 */

header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once("../utiles/fnUtiles.php");
require_once ( "../../excel/PHPExcel.php");
require_once ( "../../excel/PHPExcel/Cell/AdvancedValueBinder.php");
require_once ( "../../excel/PHPExcel/IOFactory.php");

class clsgcaExportExcel {
    //put your code here
    public function exportar($rowData,$as_Title,$as_namefile,$ArrayHeaderWith,$ArrayHeaders,$ArrayFormat){
        
       try{
        $Lista = json_decode($rowData, true);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
        header('Content-Disposition: attachment;filename="tmpfile.xls"');
        header('Cache-Control: max-age=0');
        
        $tmpFile = $as_namefile . rand() . '.xlsx';
         
        header('Content-Disposition: attachment;filename=' . $tmpFile);
        PHPExcel_Cell::setValueBinder(new PHPExcel_Cell_AdvancedValueBinder());
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->setActiveSheetIndex(0);  
        
        //--- formateando titulo -----------------------------------------------
        $styleArrayPrincipal = array(
                'font' => array(
                    'bold' => true,
                    'size' => 20
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
        );

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArrayPrincipal);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $as_Title);
         
        $styleArrayTitle = array(
                'font' => array(
                    'bold' => true
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'argb' => 'C4C4C4',
                    )
                )
        );
        
        //---------insertando cabecera de archivo -----------------------------
        $i = 0;
        foreach ($ArrayHeaders as $item) {
                $objPHPExcel->getActiveSheet()->getStyle(getNumToColExcel($i) . '2')->applyFromArray($styleArrayTitle);
                $objPHPExcel->getActiveSheet()->setCellValue(getNumToColExcel($i) . '2', $item);
                $i++;
        }
        
        //-----dimensionando longitud de celdas --------------------------------
        $nc=0;
        foreach ($ArrayHeaderWith as $w) {
                $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($nc)->setWidth($w);
                $nc++;
        }
        
        $y=2;
        
        foreach($Lista as $KeyRow=>$Data){
            if (is_array($Data)){
                foreach($Data as $Key=>$item){
                    $y++;
                    $x=0;
                    foreach($item as $Cel=>$Valor){            
                        $KeyArrayDato = key($item);
                        next($item);
                    if (array_key_exists($KeyArrayDato,$ArrayHeaders)){
                        
                        if (array_key_exists($KeyArrayDato,$ArrayFormat))
                        {
                              $Valor=str_replace(",", ".",$Valor);
                        }
                        
                        $objPHPExcel->getActiveSheet()->setCellValue(getNumToColExcel($x). $y, $Valor);
                        
                        if ((empty($Valor)==false) && (strlen(trim($Valor))>0)){
                            
                              if (array_key_exists($KeyArrayDato,$ArrayFormat)){
                              
                                    $FormatoDato=$ArrayFormat[$KeyArrayDato];
                              
                                    $objPHPExcel->getActiveSheet()->getStyle(getNumToColExcel($x) . $y)
                                        ->getNumberFormat()
                                        ->setFormatCode($FormatoDato);
                              }                        
                        }
                        $x++;}
                    }                    
                }
            }            
        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');   
       }
       catch (Exception $ex) {
            header('Content-Type: application/text');
            header('Content-Disposition: attachment;filename="error.txt"');
       
       }
    }
}
