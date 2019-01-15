<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../security/clssegMenuopcion.php");
require_once ("../security/clssegSession.php");

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$paramAccion = $Variables['operacion'];

$luo_segsesion = new clssegSession();
$user_codigo=1;//$luo_segsesion->get_per_codigo();


if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

$luo_mnuopc = new clssegMenuopcion($user_codigo);

switch ($paramAccion)
{
    case 1:
          $valida = [
              'accion'                  => ['filter'        => FILTER_VALIDATE_INT],
              'mno_codigo'              => ['filter'        => FILTER_VALIDATE_INT],
              'men_codigo'              => ['filter'        => FILTER_VALIDATE_INT],
              'mno_denominacion'        => ['filter'        => FILTER_UNSAFE_RAW],
              'mno_descripcion'         => ['filter'        => FILTER_UNSAFE_RAM],
              'mno_orden'               => ['filter'        => FILTER_VALIDATE_INT],
              'mno_imagen'              => ['filter'        => FILTER_UNSAFE_RAW],
              'pld_codigo'              => ['filter'        => FILTER_VALIDATE_INT],
              'mno_itemid'              => ['filter'        => FILTER_UNSAFE_RAW]
              ];  
        
            $parametros = filter_var_array($Variables,$valida);
            
            $luo_mnuopc->loadData($parametros);
            
            $rowdata = $luo_mnuopc->sp_seg_menuopcion($parametros['accion']);
            
            echo $rowdata;
            
            break;
      
    case 2:
            $valida = [
                'mno_codigo'            => ['filter'        => FILTER_VALIDATE_INT],
                'men_codigo'            => ['filter'        => FILTER_VALIDATE_INT]
            ];
        
            $parametros = filter_var_array($Variables,$valida);
            
            $rowdata = $luo_mnuopc->lst_listar($parametros['mno_codigo'], $parametros['men_codigo']);
            
            echo $rowdata;
            
            break;  
        
    case 3:
            $valida = [
                'men_codigo'            => ['filter' => FILTER_VALIDATE_INT]
            ];
        
            $parametros = filter_var_array($Variables,$valida);
            
            $rowdata = $luo_mnuopc->lst_orden($parametros['men_codigo']);
            
            echo $rowdata;
            
            break;
}

unset($luo_mnuopc);
unset($luo_segsesion);