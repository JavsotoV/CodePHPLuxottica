<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once ("../legal/clsgcaArrendador.php");
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

$luo_arrendador = new clsgcaArrendador();

switch ($paramAccion){
    //-------mantenimiento de contrato -----------------------------------------
    case 1:
        $valida = [
            'accion'            => [ 'filter' => FILTER_VALIDATE_INT],
            'con_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'ard_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'per_codigo'        => [ 'filter' => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_arrendador->loadData($parametros);
                
        $rowdata = $luo_arrendador->sp_gca_arrendador($parametros['accion'], $user_codigo);
        
        echo $rowdata;
        
        break;
    
    //------listado de contrato ------------------------------------------------
    case 2:
        
        $valida = ['con_codigo' => [ 'filter' => FILTER_VALIDATE_INT]];

        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_arrendador->lst_listar($parametros['con_codigo']);

        echo $rowdata;
        
        break;

}

unset($luo_arrendador);
unset($luo_segsesion);
