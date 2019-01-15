<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../mda/clsgmaResolutor.php');
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

$luo_rse = new clsgmaResolutor($user_codigo);

switch ($paramAccion){
    
    case 1:
        $valida = [
            'accion'        => ['filter' => FILTER_VALIDATE_INT],
            'rse_codigo'    => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'pai_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'per_codigo'    => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'srv_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'rse_nivel'     => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'rse_estado'    => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY]];
        
         $parametros= filter_var_array($Variables,$valida);
         
         $luo_rse->loadData($parametros);
 
         $rowdata = $luo_rse->sp_gma_resolutor($parametros['accion']);
        
        echo $rowdata;
        
        break;
     
    case 2:
        
        $valida = [
            'rse_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'are_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'pai_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'criterio'      => ['filter' => FILTER_UNSAFE_RAW],
            'page'          => ['filter' => FILTER_VALIDATE_INT],
            'limit'         => ['filter' => FILTER_VALIDATE_INT]        
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_rse->lst_listar($parametros['rse_codigo'],$parametros['are_codigo'], $parametros['pai_codigo'], $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
    case 3:
        $valida = [
            'pai_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'srv_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'page'          => ['filter' => FILTER_VALIDATE_INT],
            'limit'         => ['filter' => FILTER_VALIDATE_INT]        
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_rse->lst_rstpaissrv($parametros['pai_codigo'], $parametros['srv_codigo']);
        
        echo $rowdata;
        
        break;
    
    //-------- lista de servicios activos por pais -----------------------------
    case 4:
        $valida = [
            'pai_codigo'     => ['filter' => FILTER_VALIDATE_INT],
            'are_codigo'     => ['filter' => FILTER_VALIDATE_INT],
            'tps_codigo'     => ['filter' => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_rse->lst_srvregion($parametros['pai_codigo'],$parametros['are_codigo'],$parametros['tps_codigo']);
        
        echo $rowdata;
        
        break;        
}

unset($luo_rse);
unset($luo_segsesion);
