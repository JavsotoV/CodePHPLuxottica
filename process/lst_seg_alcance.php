<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once ('../security/clssegAlcance.php');
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

$luo_segalcance = new clssegAlcance();

switch ($paramAccion){
    
    case 1:
        break;
    
    case 2:    
        break;
    
    //--------alcance de region por opcion del modulo --------------------------
    case 3:
        $valida = [
            'men_codigo' => [ 'filter' => FILTER_VALIDATE_INT]];
                
        $parametros = filter_var_array($Variables, $valida);
     
        $rowdata = $luo_segalcance->lst_alcanceuser($user_codigo, $parametros['men_codigo']);
        
        echo $rowdata;
        
        break;  
    
}

unset($luo_segalcance);
unset($luo_segsesion);

