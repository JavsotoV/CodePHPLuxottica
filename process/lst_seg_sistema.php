<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../security/clssegSistema.php");
require_once ("../security/clssegSession.php");

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$paramAccion = $Variables['operacion'];

$luo_seg = new clssegSistema();
$luo_segsesion = new clssegSession();
$user_codigo=1;//$luo_segsesion->get_per_codigo();

if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

switch ($paramAccion)
{
    case 1:
        $valida=[
            'accion'            => ['filter'    => FILTER_VALIDATE_INT],
            'seg_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
            'seg_denominacion'  => ['filter'    => FILTER_UNSAFE_RAW]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $luo_seg->loadData($parametros);
        
        $rowdata = $luo_seg->sp_seg_sistema($parametros['accion']);
        
        echo $rowdata;       
        
        break;
    
    case 2:
        $valida = [
            'seg_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
            'criterio'          => ['filter'    => FILTER_UNSAFE_RAW],
            'page'              => ['filter'    => FILTER_VALIDATE_INT],
            'limit'             => ['filter'    => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_seg->lst_listar($parametros['seg_codigo'], $parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
}

unset($luo_seg);

unset($luo_segsesion);