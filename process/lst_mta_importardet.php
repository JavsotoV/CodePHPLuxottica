<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../logistica/clsmtaImportardet.php");
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

$luo_impdet = new clsmtaImportardet();

switch ($paramAccion){
    case 1:
        $valida = [
                'accion'            => ['filter'        => FILTER_VALIDATE_INT],
                'imp_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
                'imd_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
                'cdg'               => ['filter'        => FILTER_UNSAFE_RAW],
                'codigobarras'      => ['filter'        => FILTER_UNSAFE_RAW],
                'codsap'            => ['filter'        => FILTER_UNSAFE_RAW],
                'descripcion'       => ['filter'        => FILTER_UNSAFE_RAW],
                'familia'           => ['filter'        => FILTER_UNSAFE_RAW],
                'subfam'            => ['filter'        => FILTER_UNSAFE_RAW],
                'grupofam'          => ['filter'        => FILTER_UNSAFE_RAW],
                'descatalogado'     => ['filter'        => FILTER_UNSAFE_RAW],
                'alias'             => ['filter'        => FILTER_UNSAFE_RAW],
                'colores'           => ['filter'        => FILTER_UNSAFE_RAW],
                'indref'            => ['filter'        => FILTER_VALIDATE_FLOAT],
                'material'          => ['filter'        => FILTER_UNSAFE_RAW],
                'tipoarti'          => ['filter'        => FILTER_UNSAFE_RAW],
                'desdediametro'     => ['filter'        => FILTER_VALIDATE_FLOAT],  
                'hastadiametro'     => ['filter'        => FILTER_VALIDATE_FLOAT],  
                'desdecilindro'     => ['filter'        => FILTER_VALIDATE_FLOAT],  
                'hastacilindro'     => ['filter'        => FILTER_VALIDATE_FLOAT],  
                'desdeesfera'       => ['filter'        => FILTER_VALIDATE_FLOAT],  
                'hastaesfera'       => ['filter'        => FILTER_VALIDATE_FLOAT],  
                'altura'            => ['filter'        => FILTER_VALIDATE_FLOAT],  
                'calibre'           => ['filter'        => FILTER_VALIDATE_FLOAT],  
                'puente'            => ['filter'        => FILTER_VALIDATE_FLOAT],  
                'curvabase'         => ['filter'        => FILTER_VALIDATE_FLOAT],  
                'largovarilla'      => ['filter'        => FILTER_VALIDATE_FLOAT],  
                'polarized'         => ['filter'        => FILTER_UNSAFE_RAW],
                'diagonal'          => ['filter'        => FILTER_VALIDATE_FLOAT],  
                'horiz'             => ['filter'        => FILTER_VALIDATE_FLOAT],  
                'colorc'            => ['filter'        => FILTER_UNSAFE_RAW],
                'colorm'            => ['filter'        => FILTER_UNSAFE_RAW],
                'graduab'           => ['filter'        => FILTER_UNSAFE_RAW],
                'sexo'              => ['filter'        => FILTER_UNSAFE_RAW],
                'marca'             => ['filter'        => FILTER_UNSAFE_RAW],
                'zonaop'            => ['filter'        => FILTER_VALIDATE_FLOAT],      
                'eje'               => ['filter'        => FILTER_VALIDATE_FLOAT],  
                'radi'              => ['filter'        => FILTER_VALIDATE_FLOAT],
                'diametro'          => ['filter'        => FILTER_VALIDATE_FLOAT],
                'cilindro'          => ['filter'        => FILTER_VALIDATE_FLOAT],
                'esfera'            => ['filter'        => FILTER_VALIDATE_FLOAT],
                'esferah'           => ['filter'        => FILTER_VALIDATE_FLOAT],
                'estilo'            => ['filter'        => FILTER_VALIDATE_FLOAT],
                'cristal'           => ['filter'        => FILTER_VALIDATE_FLOAT],
                'aplica'            => ['filter'        => FILTER_VALIDATE_FLOAT],
                'tarifa'            => ['filter'        => FILTER_UNSAFE_RAW],
                'precioiva'         => ['filter'        => FILTER_VALIDATE_FLOAT]];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $luo_impdet->loadData($parametros);
        
        $rowdata = $luo_impdet->sp_mta_registrodet($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    case 2:
        $valida = [
            'imp_codigo'            => ['filter'        => FILTER_VALIDATE_INT],
            'criterio'              => ['filter'        => FILTER_UNSAFE_RAW],
            'page'                  => ['filter'        => FILTER_VALIDATE_INT],
            'limit'                 => ['filter'        => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_impdet->lst_listar($parametros['imp_codigo'],$parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
}

unset($luo_impdet);
unset($luo_segsession);