<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../conta/clsgccEntidad.php');
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

$luo_ent = new clsgccEntidad($user_codigo);

switch ($paramAccion){
    case 1:
        
        $Variables ['ent_importe'] = str_replace(",",".",$Variables ['ent_importe']);
        
        $valida = [
            'accion'            => ['filter' => FILTER_VALIDATE_INT],
            'ent_codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'pai_codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'prc_codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'per_codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'per_responsable'   => ['filter' => FILTER_VALIDATE_INT],
            'mon_codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'ent_importe'       => ['filter' => FILTER_VALIDATE_FLOAT]
        ];
        
          $parametros= filter_var_array($Variables,$valida);
          
          $luo_ent->loadData($parametros);
          
          $rowdata = $luo_ent->sp_gcc_entidad($parametros['accion']);
          
          echo $rowdata;
          
          break;
        
    case 2:
        $valida = [
            'ent_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
            'pai_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
            'prc_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
            'criterio'      => ['filter'    => FILTER_UNSAFE_RAW],
            'page'          => ['filter'    => FILTER_VALIDATE_INT],
            'limit'         => ['filter'    => FILTER_VALIDATE_INT]
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_ent->lst_listar($parametros['ent_codigo'], $parametros['pai_codigo'], $parametros['prc_codigo'], $parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
    case 3:
        $valida = [
            'prc_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
            'criterio'      => ['filter'    => FILTER_UNSAFE_RAW],
            'page'          => ['filter'    => FILTER_VALIDATE_INT],
            'limit'         => ['filter'    => FILTER_VALIDATE_INT]
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_ent->lst_entidadxresponsable($parametros['prc_codigo'], $user_codigo, $parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
}

unset($luo_ent);
unset($luo_segsesion);