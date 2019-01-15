<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('../global/clsglbCadena.php');
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

$luo_cadena = new clsglbCadena();

switch ($paramAccion){
    case 1:
        $valida = [
             'accion'           => [ 'filter' => FILTER_VALIDATE_INT],
             'cda_codigo'       => [ 'filter' => FILTER_VALIDATE_INT],
             'cda_descripcion'  => [ 'filter' => FILTER_UNSAFE_RAW],
             'cda_codinterno'   => [ 'filter' => FILTER_UNSAFE_RAW]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_cadena->loadData($parametros);
        
        $rowdata = $luo_cadena->sp_glb_contrato($parametros['accion'], $user_codigo);
        
        echo $rowdata;
        
        break;
    
    
    case 2:
        
        $valida = [
             'criterio' => [ 'filter' => FILTER_UNSAFE_RAW]
         ];
        
         $parametros = filter_var_array($Variables, $valida);
         
        $rowdata = $luo_cadena->lst_listar($parametros['criterio']);
        
        echo $rowdata;
        
        break;
}

unset($luo_cadena);
unset($luo_segsesion);