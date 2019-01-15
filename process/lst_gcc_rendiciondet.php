<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../conta/clsgccRendiciondet.php');
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

$luo_rendet = new clsgccRendiciondet($user_codigo);

switch ($paramAccion){
    case 1:
        $valida = [
            'accion'            =>  ['filter'   => FILTER_VALIDATE_INT],
            'ren_codigo'        =>  ['filter'   => FILTER_VALIDATE_INT],
            'red_codigo'        =>  ['filter'   => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'cmp_codigo'        =>  ['filter'   => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_rendet->loadData($parametros);
        
        $rowdata = $luo_rendet->sp_gcc_rendiciondet($parametros['accion']);
        
        echo $rowdata;
        
        break;
     
    case 2:
        $valida = [
            'ren_codigo'        => ['filter'   => FILTER_VALIDATE_INT],
            'criterio'          => ['filter'   => FILTER_UNSAFE_RAW],
            'page'              => ['filter'   => FILTER_VALIDATE_INT],
            'limit'             => ['filter'   => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_rendet->lst_listar($parametros['ren_codigo'], $parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
    case 3:
        $valida = [
            'ent_codigo'        => ['filter'   => FILTER_VALIDATE_INT],
            'criterio'          => ['filter'   => FILTER_UNSAFE_RAW],
            'page'              => ['filter'   => FILTER_VALIDATE_INT],
            'limit'             => ['filter'   => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_rendet->lst_pendienterendicion($parametros['ent_codigo'], $parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
}

unset($luo_rendet);
unset($luo_segsesion);
