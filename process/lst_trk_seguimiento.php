<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once("../traking/clstrkSeguimiento.php");
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

$luo_segui = new clstrkSeguimiento($luo_segsesion->get_cta_nombre());

switch ($paramAccion){
    case 1:
        break;
    
    //--------estatus segun id (nro encargo SAP)
    case 2:
        $valida = [
            'enc_codigo'        => ['filter' => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_segui->lst_listar($parametros['enc_codigo']);
        
        echo $rowdata;
        
        break;
    
    //---status por encargo y pais--------------------------
    
    case 3:
        $valida =[
            'pai_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
            'encargo'           => ['filter'    => FILTER_UNSAFE_RAW]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_segui->lst_estatusxencargo($parametros['pai_codigo'], $parametros['encargo']);
        
        echo $rowdata;
        
        break;
}

unset($luo_segui);
unset($luo_segsesion);