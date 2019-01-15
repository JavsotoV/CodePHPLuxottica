<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../global/clsgcaContratohisto.php");
require_once ('../security/clssegSession.php');

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

$luo_contratohisto = new clsgcaContratohisto();

switch ($paramAccion){
    //-------mantenimiento de contrato -----------------------------------------
    case 1:
        break;
    
    case 2:    
        $rowdata = $luo_contratohisto->lst_listar($an_con_codigo);

        echo $rowdata;

        break;
}

unset($luo_contratohisto);
unset($luo_segsesion);
