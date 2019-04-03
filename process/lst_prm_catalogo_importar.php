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
$filadata=1;

$lst_campos = array('codsap','familia','subfam','grupofam');

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
    
            array_push ( $rowdata, [ $lst_campos[0]=>$data[0],
                                             $lst_campos[1]=>$data[1],
                                             $lst_campos[2]=>$data[2],
                                             $lst_campos[3]=>$data[3]]);}
 }
 
echo json_encode(['success'=>true,'proceso'=>true,'data'=>$rowdata,'total'=>$ln_rowcount]);
