<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsExportCSV
 *
 * @author JAVSOTO
 */
header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');
//use ("..\Spout\Reader\ReaderFactory");
//use ("..\Spout\Common\Type");
require_once("../Spout/Common/Type.php");
require_once("../Spout/Reader/ReaderFactory.php");


class clsExportCSV {
    //put your code here
    public $refLibro;
    public function Create($as_namefile){
        
        try{
            $refLibro = ReaderFactory::Create(Type::CSV);
        
            if (!$refLibro){
                echo 'Referencia de libro '.$refLibro;
                return;
            }        
            $refLibro->setFieldDelimiter('|');
            $refLibro->setFieldEnclosure('@');
            $refLibro->setEndOfLineCharacter("\r");
            $refLibro->setEncoding('UTF-16LE');    
        
        } catch (Exception $ex) {
            echo $ex->getMessage();    
        }
        
        
    }
}
