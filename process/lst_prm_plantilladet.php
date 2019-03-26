<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../promocion/clsprmPlantilladet.php');
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

$luo_pld = new clsprmPlantilladet($user_codigo);

switch ($paramAccion){
    
    case 1:
        $valida = [
                    'accion'            => ['filter'        => FILTER_VALIDATE_INT],
                    'plt_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
                    'pld_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
                    'pld_grupo'         => ['filter'        => FILTER_VALIDATE_INT],
                    'pld_valor'         => ['filter'        => FILTER_VALIDATE_FLOAT],
                    'pld_rangoini'      => ['filter'        => FILTER_VALIDATE_FLOAT],
                    'pld_rangofin'      => ['filter'        => FILTER_VALIDATE_FLOAT]
                  ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_pld->loadData($parametros);
        
        $rowdata = $luo_pld->sp_prm_plantilladet($parametros['accion']);
        
        echo $rowdata;
        
        break;
        
    case 2:
        
        $valida = [
                    'plt_codigo'        => ['filter'        => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_pld->lst_listar($parametros['plt_codigo']);
        
        echo $rowdata;
        
        break;
}

unset($luo_pld);
unset($luo_segsesion);

