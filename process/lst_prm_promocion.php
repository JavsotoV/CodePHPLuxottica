<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../promocion/clsprmPromocion.php');
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

$luo_promocion = new clsprmPromocion($user_codigo);


switch ($paramAccion){
    case 1:
        $valida = [
            'accion'            => ['filter'        => FILTER_VALIDATE_INT],
            'prm_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
            'plt_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
            'prm_denominacion'  => ['filter'        => FILTER_UNSAFE_RAW],
            'pai_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
            'prm_fechai'        => ['filter'        => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'prm_fechat'        => ['filter'        => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'pld_codigo'        => ['filter'        => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'prd_codigo'        => ['filter'        => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'prd_valor'         => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],
            'prd_rangoini'      => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],
            'prd_rangofin'      => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],
            'prd_estado'        => ['filter'        => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY]];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_promocion->loadData($parametros);
        
        $rowdata = $luo_promocion->sp_prm_promocion($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    case 2:
        $valida = [
            'pai_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
            'prm_activo'        => ['filter'        => FILTER_VALIDATE_INT],
            'criterio'          => ['filter'        => FILTER_UNSAFE_RAW],
            'page'              => ['filter'        => FILTER_VALIDATE_INT],
            'limit'             => ['filter'        => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_promocion->lst_listar($parametros['pai_codigo'],$parametros['prm_activo'], $parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;

}

unset($luo_promocion);
unset($luo_segsesion);