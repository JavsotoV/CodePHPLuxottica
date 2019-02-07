<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsmtaCatalogoImportar
 *
 * @author JAVSOTO
 */

header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once("../utiles/fnUtiles.php");
require_once ( "../../excel/PHPExcel.php");
require_once ( "../../excel/PHPExcel/Cell/AdvancedValueBinder.php");
require_once ( "../../excel/PHPExcel/IOFactory.php");

extract($_POST);

class clsmtaCatalogoImportar {
    //put your code here
}
