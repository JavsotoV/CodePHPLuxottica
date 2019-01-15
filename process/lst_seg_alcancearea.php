<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once ('../security/clssegAlcancearea.php');
require_once('../security/clssegSession.php');

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

$luo_segalcancearea = new clssegAlcancearea();

switch ($paramAccion){
    
    case 1:
        break;
    
    case 2:    
        break;
    
    //--------alcance de region por opcion del modulo --------------------------
    case 3:
        $rowdata = $luo_segalcancearea->lst_alcanceuser($user_codigo);
        
        echo $rowdata;
        
        break;  
    
}

unset($luo_segalcancearea);
unset($luo_segsesion);
