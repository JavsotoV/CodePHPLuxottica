<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once("../traking/clstrkimportar.php");
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

$luo_imp = new clstrkimportar($user_codigo);

switch ($paramAccion){
    case 1:
        $valida =[
            'encargo'           => ['filter'        => FILTER_UNSAFE_RAW,'flags' => FILTER_REQUIRE_ARRAY],
            'fecha'             => ['filter'        => FILTER_UNSAFE_RAW,'flags' => FILTER_REQUIRE_ARRAY]
        ]; 
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_imp->loadData($parametros);
        
        $rowdata = $luo_imp->sp_trk_importar($parametros['accion']);
        
        echo $rowdata;
            
        break;
    
    case 2:
        break;
}

unset($luo_imp);
unset($luo_segsession);
