<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../logistica/clsmtaRegistrodet.php');
require_once ('../security/clssegSession.php');
require_once('../Base/clsViewData.php');

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

$luo_regdet =new clsmtaRegistrodet($user_codigo);

switch ($paramAccion){
    case 1:
         
        $Variables['rgd_fechaven']='01/'.$Variables['rgd_fechaven'];
        
                          
        $valida = [
             'accion'           => ['filter'    => FILTER_VALIDATE_INT],
             'reg_codigo'       => ['filter'    => FILTER_VALIDATE_INT],
             'rgd_codigo'       => ['filter'    => FILTER_VALIDATE_INT],
             'cta_codigo'       => ['filter'    => FILTER_VALIDATE_INT],
             'rgd_cantidad'     => ['filter'    => FILTER_VALIDATE_INT],
             'rgd_fechaven'     => ['filter'    => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
             'rgd_observacion'  => ['filter'    => FILTER_UNSAFE_RAW],
             'rgd_emisor'       => ['filter'    => FILTER_UNSAFE_RAW]
         ];
        
         $parametros = filter_var_array($Variables,$valida);
         
         $luo_regdet->loadData($parametros);
                  
         $rowdata = $luo_regdet->sp_gma_registrodet($parametros['accion']);
         
         echo $rowdata;
       
         break;
     
    case 2:
        $valida = [
            'reg_codigo'      => ['filter'        => FILTER_VALIDATE_INT],
            'rgd_codigo'      => ['filter'        => FILTER_VALIDATE_INT],
            'criterio'        => ['filter'        => FILTER_UNSAFE_RAW],
            'page'            => ['filter'        => FILTER_VALIDATE_INT],
            'limit'           => ['filter'        => FILTER_VALIDATE_INT]  
        ];    
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_regdet->lst_listar($parametros['reg_codigo'], $parametros['rgd_codigo'], $parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
    case 3:
        
        $valida = [
            'ctr_codigo'      => ['filter'        => FILTER_VALIDATE_INT],  
            'pai_codigo'      => ['filter'        => FILTER_VALIDATE_INT],
            'criterio'        => ['filter'        => FILTER_UNSAFE_RAW],
            'page'            => ['filter'        => FILTER_VALIDATE_INT],
            'limit'           => ['filter'        => FILTER_VALIDATE_INT]
            ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_regdet->lst_rgdpais($parametros['ctr_codigo'], $parametros['pai_codigo'], $parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        break;
}

unset($luo_regdet);
unset($luo_segsesion);