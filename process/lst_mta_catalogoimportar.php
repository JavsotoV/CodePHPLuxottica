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

$name = $_FILES['filedata']['name']; 
$tname = $_FILES['filedata']['tmp_name'];
$type = $_FILES['filedata']['type'];

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

$lst_cristal = array('cdg','codigobarras','codsap','descripcion','familia','subfam','grupofam','descatalogado','alias','ivacb','priprov','nomcom','inventariar','liquidacion','etiquetar',
    'colores','material','desdediametro','hastadiametro','desdecilindro','hastacilindro','desdeesfera','hastaesfera');

foreach ($objWorksheet->getRowIterator() as $row) {
 
    $cellIterator = $row->getCellIterator();
    
    $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,

    $col=0;
    $fil++;
    
    if ($fil>1){
    foreach ($cellIterator as $cell) {
       $data[$col] =  $cell->getValue();
        $col++;                       
    }
    
    array_push ( $rowdata, [ $campos[0]=>$data[0],
                             $campos[1]=>$data[1],
                             $campos[2]=>$data[2],
                             $campos[3]=>$data[3],
                             $campos[4]=>$data[4],
                             $campos[5]=>$data[5],
                             $campos[6]=>$data[6],
                             $campos[7]=>$data[7],
                             $campos[8]=>$data[8],
                             $campos[9]=>$data[9],
                             $campos[10]=>$data[10],
                             $campos[11]=>$data[11],
                             $campos[12]=>$data[12],
                             $campos[13]=>$data[13],
                             $campos[14]=>$data[14],
                             $campos[15]=>$data[15],
                             $campos[16]=>$data[16],
                             $campos[17]=>$data[17],
                             $campos[18]=>$data[18],
                             $campos[19]=>$data[19],
                             $campos[20]=>$data[20],
                             $campos[21]=>$data[21],
                             $campos[22]=>$data[22]] );
    } 
 }
 
echo json_encode(['success'=>true,'data'=>$rowdata]);
