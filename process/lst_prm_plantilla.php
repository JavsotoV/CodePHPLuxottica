<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../promocion/clsprmPlantilla.php');
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

$luo_plt = new clsprmPlantilla($user_codigo);

switch ($paramAccion){
    case 1:
        $valida = [
            'accion'                => ['filter'    => FILTER_VALIDATE_INT],
            'plt_codigo'            => ['filter'    => FILTER_VALIDATE_INT],
            'plt_denominacion'      => ['filter'    => FILTER_UNSAFE_RAW],
            'plt_descripcion'       => ['filter'    => FILTER_UNSAFE_RAW],
            'ctg_codigo'            => ['filter'    => FILTER_VALIDATE_INT],
            'cpt_codigo'            => ['filter'    => FILTER_VALIDATE_INT],
            'plt_aplicacion'        => ['filter'    => FILTER_VALIDATE_INT],
            'plt_aplicar'           => ['filter'    => FILTER_VALIDATE_INT],
            'plt_grupo'             => ['filter'    => FILTER_VALIDATE_INT],
            'pld_codigo'            => ['filter'    => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'pld_grupo'             => ['filter'    => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'pld_valor'             => ['filter'    => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],
            'pld_rangoini'          => ['filter'    => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],
            'pld_rangofin'          => ['filter'    => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],
            'pld_estado'            => ['filter'    => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
            
        $luo_plt->loadData($parametros);
        
        $rowdata = $luo_plt->sp_prm_plantilla($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    case 2:
        $valida = [
                'criterio'          => ['filter'        => FILTER_UNSAFE_RAW],
                'page'              => ['filter'        => FILTER_VALIDATE_INT],
                'limit'             => ['filter'        => FILTER_VALIDATE_INT]
                ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_plt->lst_listar($parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
        
}

unset($luo_plt);
unset($luo_segsesion);

