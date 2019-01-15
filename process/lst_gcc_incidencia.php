<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../conta/clsgccIncidencia.php');
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

$luo_inci = new clsgccIncidencia($user_codigo);

switch ($paramAccion){
    case 1:
        $valida = [
            'accion'            => ['filter' => FILTER_VALIDATE_INT],
            'ren_codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'red_codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'inc_observacion'   => ['filter' => FILTER_UNSAFE_RAW],
            'inc_estado'        => ['filter' => FILTER_VALIDATE_INT]
        ];
        
          $parametros= filter_var_array($Variables,$valida);
          
          $luo_inci->loadData($parametros);
          
          $rowdata = $luo_inci->sp_gcc_incidencia($parametros['accion']);
          
          echo $rowdata;
          
          break;
        
    case 2:
        $valida = [
            'ren_codigo'    => ['filter'    => FILTER_VALIDATE_INT]
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_inci->lst_listar($parametros['ren_codigo']);
        
        echo $rowdata;
        
        break;
    
    case 3:
        $valida = [
             'cmp_codigo'   => ['filter'    => FILTER_VALIDATE_INT]   
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_inci->lst_comprobanteincidencia($parametros['cmp_codigo']);
        
        echo $rowdata;
}

unset($luo_inci);
unset($luo_segsesion);
