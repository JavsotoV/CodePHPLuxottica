<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lst_gca_gasto
 *
 * @author JAVSOTO
 */
header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../legal/clsgcaGasto.php");
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

$luo_gasto = new clsgcaGasto();

switch ($paramAccion){
    case 1:
        
           $Variables['gto_importe']=str_replace(",",".",$Variables['gto_importe']);
        
         $valida = [
            'accion'            => [ 'filter' => FILTER_VALIDATE_INT],
            'con_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'gto_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'gto_fechai'        => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'gto_fechat'        => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'gto_tipo'          => [ 'filter' => FILTER_VALIDATE_INT],
            'mon_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'gto_importe'       => [ 'filter' => FILTER_VALIDATE_FLOAT]
           ];

        $parametros = filter_var_array($Variables, $valida);
        
        $luo_gasto->loadData($parametros);
        
        $rowdata = $luo_gasto->sp_gca_gasto($parametros['accion'], $user_codigo);
        
        echo $rowdata;
        
        break;
    
    case 2:
         $valida = [
            'con_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'gto_codigo'        => [ 'filter' => FILTER_VALIDATE_INT]
             ];   
        
        $parametros = filter_var_array($Variables, $valida);

        $rowdata = $luo_gasto->lst_listar($parametros['con_codigo']);    
        
        echo $rowdata;
        
        break;
    }
    
unset($luo_gasto);
unset($luo_segsesion);