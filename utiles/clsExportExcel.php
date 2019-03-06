<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsExportExcel
 *
 * @author JAVSOTO
 */
header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once("../utiles/fnUtiles.php");
require_once ( "../../excel/PHPExcel.php");
require_once ( "../../excel/PHPExcel/Cell/AdvancedValueBinder.php");
require_once ( "../../excel/PHPExcel/IOFactory.php");

class clsExportExcel {
    //put your code here
    public $refLibro;
    
     public function Create($as_namefile) {
        
        try{
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
            header('Content-Disposition: attachment;filename="tmpfile.xls"');
            header('Cache-Control: max-age=0');
        
            $tmpFile = $as_namefile . rand() . '.xlsx';
         
            header('Content-Disposition: attachment;filename=' . $tmpFile);
            PHPExcel_Cell::setValueBinder(new PHPExcel_Cell_AdvancedValueBinder());
            $this->refLibro = new PHPExcel();        
            
        }
        catch(Exception $ex){
            header('Content-Type: application/text');
            header('Content-Disposition: attachment;filename="error.txt"');
        
        }
    }
    
      public function Save(){
        
        $objWriter = PHPExcel_IOFactory::createWriter($this->refLibro, 'Excel2007');
        
        $objWriter->save('php://output');
    }
    
    public function exportar(&$rowData,$an_hoja,$as_Title,&$ArrayHeaderWith,&$ArrayHeaders,&$ArrayFormat){
        
       try{
        $Lista = json_decode($rowData, true);
        
        if ($an_hoja!=0){$this->refLibro->createSheet($an_hoja);}
              
        $this->refLibro->setActiveSheetIndex($an_hoja);
                        
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

        $this->refLibro->getActiveSheet()->getStyle('A1')->applyFromArray($styleArrayPrincipal);
        $this->refLibro->getActiveSheet()->setCellValue('A1', $as_Title);
         
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
                $this->refLibro->getActiveSheet()->getStyle(getNumToColExcel($i) . '2')->applyFromArray($styleArrayTitle);
                $this->refLibro->getActiveSheet()->setCellValue(getNumToColExcel($i) . '2', $item);
                $i++;
        }
        
        //-----dimensionando longitud de celdas --------------------------------
        $nc=0;
        foreach ($ArrayHeaderWith as $w) {
                $this->refLibro->getActiveSheet()->getColumnDimensionByColumn($nc)->setWidth($w);
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
                        
                        $this->refLibro->getActiveSheet()->setCellValue(getNumToColExcel($x). $y, $Valor);
                        
                        if ((empty($Valor)==false) && (strlen(trim($Valor))>0)) {
                            
                             if (array_key_exists($KeyArrayDato,$ArrayFormat)){
                              
                              $FormatoDato=$ArrayFormat[$KeyArrayDato];
                              
                              if ($FormatoDato=="@"){
                                  $this->refLibro->getActiveSheet()->setCellValueExplicit(getNumToColExcel($x). $y, $Valor,PHPExcel_Cell_DataType::TYPE_STRING);                        
                              }
                              
                              $this->refLibro->getActiveSheet()->getStyle(getNumToColExcel($x) . $y)
                                ->getNumberFormat()
                                ->setFormatCode($FormatoDato);
                           }
                        
                        }
                        $x++;}
                    }                    
                }
            }            
        }       
        
        unset($Lista);   
        
       }
       catch (Exception $ex) {
            header('Content-Type: application/text');
            header('Content-Disposition: attachment;filename="error.txt"');
       
       }
    }
}
