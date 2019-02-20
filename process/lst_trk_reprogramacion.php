<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once("../traking/clstrkReprogramacion.php");
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

$luo_rpro = new clstrkReprogramacion($luo_segsesion->get_cta_nombre());

switch ($paramAccion){
    case 1:
        $valida = [
            'accion'           => ['filter'     => FILTER_VALIDATE_INT],
            'enc_codigo'       => ['filter'     => FILTER_VALIDATE_INT],
            'mtv_codigo'       => ['filter'     => FILTER_VALIDATE_INT],
            'prg_fechaentrega' => ['filter'     => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'prg_observacion'  => ['filter'     => FILTER_UNSAFE_RAW]];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $luo_rpro->loadData($parametros);
         
        $rowdata = $luo_rpro->proc_mant_trk_reprogramacion($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    //----Listado de reprogramacion por encargo segun SAP-----------------------
    case 2:
        $valida = [
            'enc_codigo'        => ['filter'    => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_rpro->lst_listar($parametros['enc_codigo']);
        
        echo $rowdata;
        
        break; 
    
    //---listado de reprogramacion por encargo segun POS -----------------------
    case 3:
        $valida =[
            'encargo'   => ['filter'    => FILTER_UNSAFE_RAW]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_rpro->lst_listarxencargo($parametros['encargo']);
        
        echo $rowdata;
        
        break;
    
    //----listado del encargo por grupo segun reprogramacion ---------
    case 4:
        $valida =[
            'encargo'   => ['filter'    => FILTER_UNSAFE_RAW]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_rpro->lst_encargogrupo($parametros['encargo']);
        
        echo $rowdata;
        
        break;
}

unset($luo_rpro);

unset($luo_segsesion);