<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../legal/clsgcaGarantia.php");
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

$luo_garantia = new clsgcaGarantia();

switch ($paramAccion){
    //-------mantenimiento de contrato -----------------------------------------
    case 1:
        $Variables['gra_importe'] = str_replace(",",".",$Variables['gra_importe']);
            
        $valida = [
            'accion' => [ 'filter' => FILTER_VALIDATE_INT],
            'con_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'gra_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'tpc_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'gra_banco' => [ 'filter' => FILTER_UNSAFE_RAW],
            'mon_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'gra_tipo' => [ 'filter' => FILTER_VALIDATE_INT],
            'gra_importe' => [ 'filter' => FILTER_VALIDATE_FLOAT],            
            'gra_fechai' => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'gra_fechat' => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'gra_operacion' => [ 'filter' => FILTER_UNSAFE_RAW],
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_garantia->loadData($parametros);
        
        $rowdata = $luo_garantia->sp_gca_garantia($parametros['accion'],$user_codigo);
        
        echo $rowdata;
        
        break;
    
    //------listado de contrato ------------------------------------------------
    case 2:
        
        $valida = ['con_codigo' => [ 'filter' => FILTER_VALIDATE_INT]];

        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_garantia->lst_listar($parametros['con_codigo']);

        echo $rowdata;
        
        break;

}

unset($luo_garantia);
unset($luo_segsesion);
