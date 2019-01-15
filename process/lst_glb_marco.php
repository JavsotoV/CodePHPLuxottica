<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once ("../global/clsglbMarco.php");
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

$luo_marco = new clsglbMarco();

switch ($paramAccion){
    
    case 1:
          $valida = [
                'accion'            => ['filter'    => FILTER_VALIDATE_INT],
                'mrc_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                'mrc_descripcion'   => ['filter'    => FILTER_UNSAFE_RAW]];
        
           $parametros = filter_var_array($Variables,$valida);
           
           $luo_marco->loadData($parametros);
           
           $rowdata = $luo_marco->sp_glb_marco($parametros['accion'], $user_codigo);
           
           echo $rowdata;
           
           break;
    
    case 2:
        $rowdata = $luo_marco->lst_listar();
        
        echo $rowdata;

        break;
    
    
    case 3:
        $valida = [
            'mrc_codigo'     => ['filter'    => FILTER_VALIDATE_INT],
            'criterio'       => ['filter'    => FILTER_UNSAFE_RAW],
            'page'           => ['filter'    => FILTER_VALIDATE_INT],
            'limit'          => ['filter'    => FILTER_VALIDATE_INT]];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_marco->lst_lista($parametros['mrc_codigo'], $parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
}    

unset($luo_marco);
unset($luo_segsesion);

