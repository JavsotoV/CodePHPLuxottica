<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../global/clsglbConfig.php");
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

$luo_config = new clsglbConfig($user_codigo);

switch ($paramAccion){
    
    //---estableciendo relacion entre glb_config(POS) y glb_tienda
    case 1:
            $valida= [
                'accion'        => ['filter' => FILTER_VALIDATE_INT],
                'cfg_codigo'    => ['filter' => FILTER_VALIDATE_INT],
                'tda_codigo'    => ['filter' => FILTER_VALIDATE_INT],
                'ubg_codigo'    => ['filter' => FILTER_VALIDATE_INT]
            ];
        
            $parametros = filter_var_array($Variables, $valida);
            
            $luo_config->loadData($parametros);
            
            $rowdata = $luo_config->sp_glb_config($parametros['accion']);
            
            echo $rowdata;
        
            break;
    
    //----listado de glb_config x pais    
    case 2:
            $valida = [
                'pai_codigo'        => ['filter' => FILTER_VALIDATE_INT],
                'cfg_codigo'        => ['filter' => FILTER_VALIDATE_INT],
                'criterio'          => ['filter' => FILTER_UNSAFE_RAW],
                'tipo'              => ['filter' => FILTER_VALIDATE_INT],
                'page'              => ['filter' => FILTER_VALIDATE_INT],
                'limit'             => ['filter' => FILTER_VALIDATE_INT]
            ];
        
            $parametros = filter_var_array($Variables,$valida);
            
            $rowdata = $luo_config->lst_listar($parametros['pai_codigo'],$parametros['cfg_codigo'], $parametros['criterio'],$parametros['tipo'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
            
            echo $rowdata;
            
            break;
        
    // --- listado de locales asociados a un registro de tienda ----------------    
    case 3:
            $valida = [
                'tda_codigo'        => ['filter' => FILTER_VALIDATE_INT],
                'criterio'          => ['filter' => FILTER_UNSAFE_RAW],
                'tipo'              => ['filter' => FILTER_VALIDATE_INT],
                'page'              => ['filter' => FILTER_VALIDATE_INT],
                'limit'             => ['filter' => FILTER_VALIDATE_INT]
            ];
        
            $parametros = filter_var_array($Variables,$valida);
            
            $rowdata = $luo_config->lst_localxtienda($parametros['tda_codigo'],$parametros['criterio'],$parametros['tipo'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
            
            echo $rowdata;
            
            break;
    
        //----mantenimiento de oficinas adm----------------
    case 4:    
            $valida = [
                'accion'            => ['filter'    => FILTER_VALIDATE_INT],
                'cfg_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                'pai_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                'nombre'            => ['filter'    => FILTER_UNSAFE_RAW],
                'email'             => ['filter'    => FILTER_VALIDATE_EMAIL],
                'direccion'         => ['filter'    => FILTER_UNSAFE_RAW],
                'ubg_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                'codsap'            => ['filter'    => FILTER_UNSAFE_RAW]
            ];
        
            $parametros = filter_var_array($Variables,$valida);
            
            $luo_config->loadData($parametros);
            
            $rowdata = $luo_config->sp_glb_oficina($parametros['accion']);
            
            echo $rowdata;
            
            break;
}

unset($luo_config);
unset($luo_segsesion);