<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../logistica/clsmtaImportar.php");
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

$luo_importar = new clsmtaImportar($user_codigo);


switch ($paramAccion){
    case 1:
            $valida = [
                'accion'            => ['filter'        => FILTER_VALIDATE_INT],
                'imp_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
                'pai_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
                'tipfamcod'         => ['filter'        => FILTER_UNSAFE_RAW],
                'imp_origen'        => ['filter'        => FILTER_VALIDATE_INT],
                'imp_observacion'   => ['filter'        => FILTER_UNSAFE_RAW],
                'cdg'               => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'codigobarras'      => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'codsap'            => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'descripcion'       => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'familia'           => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'subfam'            => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'grupofam'          => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'descatalogado'     => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'alias'             => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'ivacb'             => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],
                'priprov'           => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],  
                'nomcom'            => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'inventariar'       => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'liquidacion'       => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'etiquetar'         => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'colores'           => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'material'          => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'desdediametro'     => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],  
                'hastadiametro'     => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],  
                'desdecilindro'     => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],  
                'hastacilindro'     => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],  
                'desdeesfera'       => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],  
                'hastaesfera'       => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],  
                'altura'            => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],  
                'calibre'           => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],  
                'puente'            => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],  
                'curvabase'         => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],  
                'largovarilla'      => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],  
                'polarized'         => ['filter'        => FILTER_UNSAFE_RAW,     'flags' => FILTER_REQUIRE_ARRAY],
                'diagonal'          => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],  
                'horiz'             => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],  
                'colorc'            => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'colorm'            => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'graduable'         => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'sexo'              => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'marca'             => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'zonaop'            => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],      
                'eje'               => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],  
                'radio'             => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],
                'tarifa'            => ['filter'        => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                'precio'            => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],
                'precioiva'         => ['filter'        => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY]
                ];
        
            $parametros = filter_var_array($Variables, $valida);
   
            $luo_importar->loadData($parametros);
            
            $rowdata = $luo_importar->sp_mta_importar($parametros['accion']);
               
            echo $rowdata;
            
            break;
        
    case 2:
            $valida = [
                'imp_periodo'           => ['filter'    => FILTER_VALIDATE_INT],
                'criterio'              => ['filter'    => FILTER_UNSAFE_RAW],
                'page'                  => ['filter'    => FILTER_VALIDATE_INT],
                'limit'                 => ['filter'    => FILTER_VALIDATE_INT]
            ];
        
            $parametros = filter_var_array($Variables, $valida);
            
            $rowdata = $luo_importar->lst_listar($parametros['imp_periodo'], $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
            
            echo $rowdata;
            
            break;     
        
    case 3:
           $valida = [
               'accion'          => ['filter'        => FILTER_VALIDATE_INT],
               'imp_codigo'      => ['filter'        => FILTER_VALIDATE_INT]];
        
            $parametros = filter_var_array($Variables, $valida);
     
            $rowdata = $luo_importar->lst_replicar($parametros['accion'],$parametros['imp_codigo']);
            
            echo $rowdata;
            
            break;
}

unset($luo_importar);
unset($luo_segsesion);