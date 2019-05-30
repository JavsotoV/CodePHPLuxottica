<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../logistica/clsmtaTarifadetalle.php');
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

$luo_tarifadetalle = new clsmtaTarifadetalle();

switch ($paramAccion){
    case 1:   
        
        $Variables['trd_precio']            = str_replace(",",".",$Variables['trd_precio']);
        $Variables['trd_precioiva']         = str_replace(",",".",$Variables['trd_precioiva']);
        
        $valida = [
            'accion'                => ['filter'        => FILTER_VALIDATE_INT],
            'trf_codigo'            => ['filter'        => FILTER_VALIDATE_INT],
            'trd_codigo'            => ['filter'        => FILTER_VALIDATE_INT],
            'cta_codigo'            => ['filter'        => FILTER_VALIDATE_INT],
            'trd_precio'            => ['filter'        => FILTER_VALIDATE_FLOAT],
            'trd_precioiva'         => ['filter'        => FILTER_VALIDATE_FLOAT]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_tarifadetalle->loadData($parametros);
        
        $rowdata = $luo_tarifadetalle->sp_mta_tarifadetalle($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    case 2:
        $valida = [
            'trf_codigo'            => ['filter'        => FILTER_VALIDATE_INT],
            'tipfamcod'             => ['filter'        => FILTER_UNSAFE_RAW],
            'fam_codigo'            => ['filter'        => FILTER_VALIDATE_INT],
            'sfa_codigo'            => ['filter'        => FILTER_VALIDATE_INT],
            'gfa_codigo'            => ['filter'        => FILTER_VALIDATE_INT],
            'criterio'              => ['filter'        => FILTER_UNSAFE_RAW],
            'page'                  => ['filter'        => FILTER_VALIDATE_INT],
            'limit'                 => ['filter'        => FILTER_VALIDATE_INT]];
        
            $parametros = filter_var_array($Variables, $valida);
            
            $rowdata = $luo_tarifadetalle->lst_listar($parametros['trf_codigo'], $parametros['tipfamcod'], $parametros['fam_codigo'], $parametros['sfa_codigo'], $parametros['gfa_codigo'], $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
                        
            echo $rowdata;
        
            break;
    
    case 3:
        $valida = ['cta_codigo'     => ['filter'        => FILTER_VALIDATE_INT]];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_tarifadetalle->lst_precioarticulo($parametros['cta_codigo']);
        
        echo $rowdata;
        
        break;
}