<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../promocion/clsprmCatalogo.php');
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

$luo_catalogo = new clsprmCatalogo($user_codigo);

switch ($paramAccion){
    case 1:
        $valida = [
            'accion'        => ['filter'    => FILTER_VALIDATE_INT],
            'prm_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
            'prd_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
            'prc_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
            'ctc_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
            'codsap'        => ['filter'    => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY]
        ];   
        
        $parametros = filter_var_array($Variables,$valida);
        
        $luo_catalogo->loadData($parametros);
        
        $rowdata = $luo_catalogo->sp_prm_catalogo($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    case 2:
        $valida = [
              'prm_codigo'      => ['filter'    => FILTER_VALIDATE_INT],
              'criterio'        => ['filter'    => FILTER_UNSAFE_RAW],
              'page'            => ['filter'    => FILTER_VALIDATE_INT],
              'limit'           => ['filter'    => FILTER_VALIDATE_INT]];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_catalogo->lst_listar($parametros['prm_codigo'], $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
}

