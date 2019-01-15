<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../legal/clsgcaContratoAlerta.php");
require_once ("../security/clssegSession.php");
require_once("../utiles/fnUtiles.php");
require_once ( "../../excel/PHPExcel.php");
require_once ( "../../excel/PHPExcel/Cell/AdvancedValueBinder.php");
require_once ( "../../excel/PHPExcel/IOFactory.php");

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$luo_segsesion = new clssegSession();
$user_codigo=$luo_segsesion->get_per_codigo();

if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

$paramAccion = $Variables ['operacion'];

$luo_contratoalerta = new clsgcaContratoAlerta();

switch ($paramAccion){

    case 1:
        $valida = [
            'pai_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'criterio'   => [ 'filter' => FILTER_UNSAFE_RAW]
            ];
   
        $parametros = filter_var_array($Variables, $valida);
      
        $rowdata = $luo_contratoalerta->lst_alerta($parametros['pai_codigo'],$parametros['criterio'],1 , 999999);

        $Lista = json_decode($rowdata, true);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
        header('Content-Disposition: attachment;filename="tmpfile.xls"');
        header('Cache-Control: max-age=0');

        $tmpFile = 'ControAlerta' . rand() . '.xlsx';

        header('Content-Disposition: attachment;filename=' . $tmpFile);
        PHPExcel_Cell::setValueBinder(new PHPExcel_Cell_AdvancedValueBinder());
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0);
        
        $y=1;
        
        foreach($Lista as $KeyRow=>$Data){
            if (is_array($Data)){
                foreach($Data as $Key=>$item){
                    $y++;
                    $x=0;
                    foreach($item as $Cel=>$Valor){
                        $x++;
                        if ($y==2){                            
                            $objPHPExcel->getActiveSheet()->setCellValue(getNumToColExcel($x). 1, key($item));                            
                            next($item);
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue(getNumToColExcel($x). $y, $Valor);
                    }
                }
            }            
        }
        
         $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
         $objWriter->save('php://output');        
         
         break;
                   
}
unset($luo_contratoalerta);
unset($luo_segsesion);
