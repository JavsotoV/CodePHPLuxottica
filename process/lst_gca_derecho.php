<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../legal/clsgcaDerecho.php");
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

$luo_derecho = new clsgcaDerecho($user_codigo);

switch ($paramAccion){
    //-------mantenimiento de contrato -----------------------------------------
    case 1:
        
        $Variables ['der_importe'] = str_replace(",",".",$Variables ['der_importe']);
        
        $valida = [
            'accion'            => ['filter'        => FILTER_VALIDATE_INT],
            'con_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
            'der_codigo'        => ['filter'        => FILTER_VALIDATE_INT],    
            'cpo_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
            'der_fechai'        => ['filter'        => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'der_fechat'        => ['filter'        => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'mon_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
            'der_importe'       => ['filter'        => FILTER_VALIDATE_FLOAT]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_derecho->loadData($parametros);
        
        $rowdata = $luo_derecho->sp_gca_derecho($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    case 2:
        $valida = [
            'con_codigo'    => ['filter'    => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_derecho->lst_listar($parametros['con_codigo']);
        
        echo $rowdata;
        
        break;
}