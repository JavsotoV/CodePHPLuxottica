<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../legal/clsgcaRenta.php");
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

$luo_renta = new clsgcaRenta();

switch ($paramAccion){
    //-------mantenimiento de contrato -----------------------------------------
    case 1:      
        
        $Variables['rta_importe'] = str_replace(",",".",$Variables['rta_importe']);
        $Variables['rta_porcentajeipc'] = str_replace(",",".",$Variables['rta_porcentajeipc']);
        $Variables['rta_porcentaje'] = str_replace(",",".",$Variables['rta_porcentaje']);
        $Variables['rta_puntop'] = str_replace(",",".",$Variables['rta_puntop']);
        
        $valida=['accion'           =>['filter'=>FILTER_VALIDATE_INT],
                 'con_codigo'       =>['filter'=>FILTER_VALIDATE_INT],
                 'rta_codigo'       =>['filter'=>FILTER_VALIDATE_INT],
                 'rta_fechai'       =>['filter'=>FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
                 'rta_fechat'       =>['filter'=>FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
                 'rta_tipo'         =>['filter'=>FILTER_VALIDATE_INT],
                 'mon_codigo'       =>['filter'=>FILTER_VALIDATE_INT],
                 'rta_importe'      =>['filter'=>FILTER_VALIDATE_FLOAT],
                 'rta_tipoipc'      =>['filter'=>FILTER_VALIDATE_INT],
                 'rta_porcentajeipc'=>['filter'=>FILTER_VALIDATE_FLOAT],
                 'rta_porcentaje'   =>['filter'=>FILTER_VALIDATE_FLOAT],
                 'rta_puntop'       =>['filter'=>FILTER_VALIDATE_FLOAT]
            ];
        
        $parametros= filter_var_array($Variables,$valida);
     
        $luo_renta->loadData($parametros);    
        
        $rowdata = $luo_renta->sp_gca_renta($parametros['accion'], $user_codigo);
        
        echo $rowdata;
        
        break;
    
    //------listado de contrato ------------------------------------------------
    case 2:
        
        $valida = ['con_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
                   'rta_tipo' => [ 'filter' => FILTER_VALIDATE_INT]];

        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_renta->lst_listar($parametros['con_codigo'],$parametros['rta_tipo']);

        echo $rowdata;
        
        break;

}

unset($luo_renta);
