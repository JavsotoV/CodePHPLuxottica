<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../legal/clsgcaorigen.php');
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

$luo_origen = new clsgcaorigen();

switch ($paramAccion){
    case 1:
        break;
    
    case 2:
        $rowdata = $luo_origen->lst_listar();
        
        echo $rowdata;
        
        break;
}        

unset($luo_origen);
unset($luo_segsesion);

