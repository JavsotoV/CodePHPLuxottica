<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../logistica/clsmtaRegistro.php');
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

$luo_registro = new clsmtaRegistro($user_codigo);

switch ($paramAccion){
    
    case 1:
        $valida = [
            'accion'            => ['filter' => FILTER_VALIDATE_INT],            
            'reg_codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'per_codigo'        => ['filter' => FILTER_VALIDATE_INT]];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $luo_registro->loadData($parametros);
        
        $rowdata = $luo_registro->sp_mta_registro($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    case 2:
        $valida = [
            'reg_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
            'ctr_periodo'       => ['filter'    => FILTER_VALIDATE_INT],
            'per_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
            'page'              => ['filter'    => FILTER_VALIDATE_INT],
            'limit'             => ['filter'    => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_registro->lst_listar($parametros['reg_codigo'], $parametros['per_codigo'], $parametros['ctr_periodo'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
}

unset($luo_registro);
unset($luo_segsesion);
