<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('../rrhh/clsgrhPlansede.php');
require_once ('../security/clssegSession.php');

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$luo_segsesion = new clssegSession();
$user_codigo=1;

if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

$paramAccion = $Variables ['operacion'];

$luo_sede = new clsgrhPlansede();

switch ($paramAccion){
    case 1:
        break;
    
    case 2:
        $valida = [
            'tpplan' => ['filter' => FILTER_UNSAFE_RAW]
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_sede->lst_listar($parametros['tpplan']);
        
        echo $rowdata;
        
        break;
}

unset($luo_sede);
unset($luo_segsession);