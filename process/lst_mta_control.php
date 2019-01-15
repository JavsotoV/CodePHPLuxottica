<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../logistica/clsmtaControl.php');
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

$luo_control = new clsmtaControl($user_codigo);

switch ($paramAccion){
    
    case 1:
        
        $valida=[
            'accion'            => ['filter' => FILTER_VALIDATE_INT],
            'ctr_codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'ctr_fechai'        => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'ctr_fechat'        => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']]
        ];
        
         $parametros = filter_var_array($Variables, $valida);
         
         $luo_control->loadData($parametros);
         
         $rowdata = $luo_control->sp_mta_control($parametros['accion']);
         
         echo $rowdata;
         
         break;
    
    case 2:
        
        $valida = [
            'ctr_codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'ctr_periodo'       => ['filter' => FILTER_VALIDATE_INT],
            'page'              => ['filter' => FILTER_VALIDATE_INT],
            'limit'             => ['filter' => FILTER_VALIDATE_INT]        
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_control->lst_listar($parametros['ctr_codigo'], $parametros['ctr_periodo'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
}
unset($luo_control);
unset($luo_segsesion);