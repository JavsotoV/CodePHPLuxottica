<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../conta/clsgccRendicion.php');
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

$luo_rend = new clsgccRendicion($user_codigo);

switch ($paramAccion){
    case 1:
        $valida = [
            'accion'            =>  ['filter'   => FILTER_VALIDATE_INT],
            'ren_codigo'        =>  ['filter'   => FILTER_VALIDATE_INT],
            'ent_codigo'        =>  ['filter'   => FILTER_VALIDATE_INT],
            'ren_observacion'   =>  ['filter'   => FILTER_UNSAFE_RAW]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_rend->loadData($parametros);
        
        $rowdata = $luo_rend->sp_gcc_rendicion($parametros['accion']);
        
        echo $rowdata;
        
        break;
     
    /*-------lista las rendiciones de una entidas seleccionada--------------------*/
    case 2:
        $valida = [
            'ren_codigo'        => ['filter'   => FILTER_VALIDATE_INT],
            'ent_codigo'        => ['filter'   => FILTER_VALIDATE_INT],
            'ren_periodo'       => ['filter'   => FILTER_VALIDATE_INT],
            'criterio'          => ['filter'   => FILTER_UNSAFE_RAW],
            'page'              => ['filter'   => FILTER_VALIDATE_INT],
            'limit'             => ['filter'   => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_rend->lst_listar($parametros['ren_codigo'], $parametros['ent_codigo'], $parametros['ren_periodo'], $parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
    /*---listado de rendiciones segun jefe zonal o jefe inmediato superior --------------*/
    case 3:
          $valida = [
              'ren_periodo'     => ['filter'    => FILTER_VALIDATE_INT],
              'ren_estado'      => ['filter'    => FILTER_VALIDATE_INT],
              'criterio'        => ['filter'    => FILTER_UNSAFE_RAW],
              'page'            => ['filter'    => FILTER_VALIDATE_INT],
              'limit'           => ['filter'    => FILTER_VALIDATE_INT]
          ];  
        
          $parametros = filter_var_array($Variables,$valida);
          
          $rowdata = $luo_rend->lst_zonal($parametros['ren_periodo'], $user_codigo, $parametros['ren_estado'], $parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
          
          echo $rowdata;
          
          break;
      
     /*---listado de rendiciones para su verificacion por contabilidad --------------*/
    case 4:
          $valida = [
              'pai_codigo'      => ['filter'    => FILTER_VALIDATE_INT],
              'ren_periodo'     => ['filter'    => FILTER_VALIDATE_INT],              
              'ren_estado'      => ['filter'    => FILTER_VALIDATE_INT],
              'criterio'        => ['filter'    => FILTER_UNSAFE_RAW],
              'page'            => ['filter'    => FILTER_VALIDATE_INT],
              'limit'           => ['filter'    => FILTER_VALIDATE_INT]
          ];  
        
          $parametros = filter_var_array($Variables,$valida);
          
          $rowdata = $luo_rend->lst_conta($parametros['pai_codigo'], $parametros['ren_periodo'], $parametros['ren_estado'], $parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
          
          echo $rowdata;
          
          break;  
        
}

unset($luo_rend);
unset($luo_segsesion);
