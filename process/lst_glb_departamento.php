<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once ("../global/clsglbDepartamento.php");
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

$luo_dpto = new clsglbDepartamento();

switch ($paramAccion){
    
    case 1:
        break;
    
    case 2:
        $valida = [
            'pai_codigo'=>['filter'=>FILTER_VALIDATE_INT],
            'criterio'  =>['filter'=>FILTER_UNSAFE_RAW]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_dpto->lst_listar($parametros['pai_codigo'], $parametros['criterio']);
        
        echo $rowdata;
}

unset($luo_dpto);
unset($luo_segsesion);