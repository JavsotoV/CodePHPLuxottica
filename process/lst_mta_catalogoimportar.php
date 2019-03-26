<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once("../utiles/fnUtiles.php");
require_once ( "../../excel/PHPExcel.php");
require_once ( "../../excel/PHPExcel/Cell/AdvancedValueBinder.php");
require_once ( "../../excel/PHPExcel/IOFactory.php");

extract($_POST);

$name = $_FILES['bin_blob']['name']; 
$tname = $_FILES['bin_blob']['tmp_name'];
$type = $_FILES['bin_blob']['type'];
$tipfamcod = $_POST['tipfamcod'];
$imp_origen=$_POST['imp_origen'];

if ($type=='application/vnd.ms-excel')
    {$ext = 'Excel5';
        }
    elseif ($type=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
    {$ext='Excel2007';
        }
    else{
        echo json_encode(['success'=>false,'data'=>'']);
        exit;
    }

$objReader = PHPExcel_IOFactory::createReader($ext);

$objReader->setReadDataOnly(true);
 
$objPHPExcel = $objReader->load($tname);

$objWorksheet = $objPHPExcel->getActiveSheet();

$rowdata= [];

$fil=0;
$col=0;
$filadata=6;

if ($imp_origen==1) {
    if ($tipfamcod=='C'){
        $lst_campos = array('cdg','codigobarras','codsap','descripcion','familia','subfam','grupofam','alias','ivacb','nomcom',
        'colores','material','desdediametro','hastadiametro','desdecilindro','hastacilindro','desdeesfera','hastaesfera');
    };

    if ($tipfamcod=='M'){
        $lst_campos= array('cdg','codigobarras','codsap','descripcion','familia','subfam','grupofam','alias','ivacb','nomcom',
        'colores','material','altura','calibre','puente','curvabase','largovarilla','diagonal','horiz');
    }

    if ($tipfamcod=='G'){
        $lst_campos= array('cdg','codigobarras','codsap','descripcion','familia','subfam','grupofam','alias','ivacb','nomcom',
        'material','colorc','colorm','graduable','sexo','diagonal','horiz','altura','curvabase','puente','largovarilla','polarized');
    }

    if ($tipfamcod=='L'){
            $lst_campos= array('cdg','codigobarras','codsap','descripcion','familia','subfam','grupofam','alias','ivacb','nomcom',
            'colores','marca','zonaop','eje','radio','desdeesfera','hastaesfera','curvabase','desdediametro','desdecilindro');
    }
}

if ($imp_origen==2){
        $lst_campos= array('codsap','descripcion','familia','subfam','grupofam','tarifa','precio','precioiva');
    
}

if ($imp_origen==3){
            $lst_campos= array('codsap','descripcion','familia','subfam','grupofam','descatalogado');            
}


$ln_rowcount=0;

foreach ($objWorksheet->getRowIterator() as $row) {
 
    $cellIterator = $row->getCellIterator();
    
    $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,

    $col=0;
    $fil++;
    
    if ($fil>$filadata){
        
        $ln_rowcount++;
        
        foreach ($cellIterator as $cell) {
                     $data[$col] =  $cell->getValue();
                     $col++;                       
        }
    
            if ($imp_origen==1) {
                if ($tipfamcod=='C'){
                    array_push ( $rowdata, [ $lst_campos[0]=>$data[0],
                                             $lst_campos[1]=>$data[1],
                                             $lst_campos[2]=>$data[2],
                                             $lst_campos[3]=>$data[3],
                                             $lst_campos[4]=>$data[4],
                                             $lst_campos[5]=>$data[5],
                                             $lst_campos[6]=>$data[6],
                                             $lst_campos[7]=>$data[7],
                                             $lst_campos[8]=>$data[8],
                                             $lst_campos[9]=>$data[9],
                                             $lst_campos[10]=>$data[10],
                                             $lst_campos[11]=>$data[11],
                                             $lst_campos[12]=>$data[12],
                                             $lst_campos[13]=>$data[13],
                                             $lst_campos[14]=>$data[14],
                                             $lst_campos[15]=>$data[15],
                                             $lst_campos[16]=>$data[16],
                                             $lst_campos[17]=>$data[17]] );}
                                             
                if ($tipfamcod=='M'){
                    array_push ( $rowdata, [ $lst_campos[0]=>$data[0],
                                             $lst_campos[1]=>$data[1],
                                             $lst_campos[2]=>$data[2],
                                             $lst_campos[3]=>$data[3],
                                             $lst_campos[4]=>$data[4],
                                             $lst_campos[5]=>$data[5],
                                             $lst_campos[6]=>$data[6],
                                             $lst_campos[7]=>$data[7],
                                             $lst_campos[8]=>$data[8],
                                             $lst_campos[9]=>$data[9],
                                             $lst_campos[10]=>$data[10],
                                             $lst_campos[11]=>$data[11],
                                             $lst_campos[12]=>$data[12],
                                             $lst_campos[13]=>$data[13],
                                             $lst_campos[14]=>$data[14],
                                             $lst_campos[15]=>$data[15],
                                             $lst_campos[16]=>$data[16],
                                             $lst_campos[17]=>$data[17],
                                             $lst_campos[18]=>$data[18]] );}    
                                             
                if ($tipfamcod=='G') {
                    array_push ( $rowdata, [ $lst_campos[0]=>$data[0],
                                             $lst_campos[1]=>$data[1],
                                             $lst_campos[2]=>$data[2],
                                             $lst_campos[3]=>$data[3],
                                             $lst_campos[4]=>$data[4],
                                             $lst_campos[5]=>$data[5],
                                             $lst_campos[6]=>$data[6],
                                             $lst_campos[7]=>$data[7],
                                             $lst_campos[8]=>$data[8],
                                             $lst_campos[9]=>$data[9],
                                             $lst_campos[10]=>$data[10],
                                             $lst_campos[11]=>$data[11],
                                             $lst_campos[12]=>$data[12],
                                             $lst_campos[13]=>$data[13],
                                             $lst_campos[14]=>$data[14],
                                             $lst_campos[15]=>$data[15],
                                             $lst_campos[16]=>$data[16],
                                             $lst_campos[17]=>$data[17],
                                             $lst_campos[18]=>$data[18],
                                             $lst_campos[19]=>$data[19],
                                             $lst_campos[20]=>$data[20],
                                             $lst_campos[21]=>$data[21]] );}
                if ($tipfamcod=='L'){
                      array_push ( $rowdata, [ $lst_campos[0]=>$data[0],
                                             $lst_campos[1]=>$data[1],
                                             $lst_campos[2]=>$data[2],
                                             $lst_campos[3]=>$data[3],
                                             $lst_campos[4]=>$data[4],
                                             $lst_campos[5]=>$data[5],
                                             $lst_campos[6]=>$data[6],
                                             $lst_campos[7]=>$data[7],
                                             $lst_campos[8]=>$data[8],
                                             $lst_campos[9]=>$data[9],
                                             $lst_campos[10]=>$data[10],
                                             $lst_campos[11]=>$data[11],
                                             $lst_campos[12]=>$data[12],
                                             $lst_campos[13]=>$data[13],
                                             $lst_campos[14]=>$data[14],
                                             $lst_campos[15]=>$data[15],
                                             $lst_campos[16]=>$data[16],
                                             $lst_campos[17]=>$data[17],
                                             $lst_campos[18]=>$data[18],
                                             $lst_campos[19]=>$data[19]] );
                }                             
            }
            
            if ($imp_origen==2){
                array_push($rowdata,[
                    $lst_campos[0]=>$data[0],
                    $lst_campos[1]=>$data[1],
                    $lst_campos[2]=>$data[2],
                    $lst_campos[3]=>$data[3],
                    $lst_campos[4]=>$data[4],
                    $lst_campos[5]=>$data[5],
                    $lst_campos[6]=>$data[6],
                    $lst_campos[7]=>$data[7]
                ]);
            }
            
            
            if ($imp_origen==3) {
                    array_push ( $rowdata, [ $lst_campos[0]=>$data[0],
                                             $lst_campos[1]=>$data[1],
                                             $lst_campos[2]=>$data[2],
                                             $lst_campos[3]=>$data[3],
                                             $lst_campos[4]=>$data[4],
                                             $lst_campos[5]=>$data[5]]);
                
            }
            
        }
    
    
 }
 
echo json_encode(['success'=>true,'proceso'=>true,'data'=>$rowdata,'total'=>$ln_rowcount]);
