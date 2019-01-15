<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once("../traking/clstrkEncargo.php");
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

$luo_trk = new clstrkEncargo();

switch ($paramAccion){
    case 1:
        break;
    
    //----busca un encargo por el numero SAP ---
    case 2:
        $valida = [
            'enc_numero' =>['filter'=> FILTER_UNSAFE_RAW]
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_trk->lst_listar($parametros['enc_numero']);
        
        echo $rowdata;
        
        break;
    
    //----detalle de un encargo (lineas)
    case 3:
       $valida = [
           'pai_codigo'     =>  ['filter'=> FILTER_VALIDATE_INT],
            'encargo'       =>  ['filter'=> FILTER_UNSAFE_RAW]
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_trk->lst_encargodetalle($parametros['pai_codigo'],$parametros['encargo']);
        
        echo $rowdata;
        
        break; 
    
    
    //--listado de encargos por cliente o por numero de encargo
    case 4:
       
        $valida = [
           'condicion'      =>  ['filter'=> FILTER_VALIDATE_INT],
            'pai_codigo'     => ['filter'=> FILTER_VALIDATE_INT],
           'criterio'       =>  ['filter'=> FILTER_UNSAFE_RAW]
        ];
       
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_trk->lst_encargoxcliente($parametros['condicion'],$parametros['pai_codigo'],$parametros['criterio'],true);
        
        echo $rowdata;
        
        break;
    
    
}

unset($luo_trk);

unset($luo_segsesion);