<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../global/clsglbZona.php");
require_once ('../security/clssegSession.php');

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$paramAccion = $Variables ['operacion'];

$luo_segsesion = new clssegSession();
$per_codigo=$luo_segsesion->get_per_codigo();

if (!isset($per_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

$luo_zona = new clsglbZona();

switch ($paramAccion){
    //--mantenimiento de zonas por ubigeo --------------------------------------
    case 1:
          //mantenimiento  
          break;  
    
    //--lista de zonas por ubigeo-----------------------------------------------  
    case 2:
        $valida=['ubg_codigo' => [ 'filter' => FILTER_VALIDATE_INT]];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata=$luo_zona->lst_listar($parametros['ubg_codigo']);

        echo $rowdata;
        
        break;   
}   

unset($luo_zona);
unset($luo_segsesion);