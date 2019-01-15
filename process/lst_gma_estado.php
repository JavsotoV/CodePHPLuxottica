<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../mda/clsgmaEstado.php');
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

$luo_est = new clsgmaEstado();

switch ($paramAccion){
    case 1:
        break;
    
    /*lista de los estados del ticket*/
    case 2:
        $rowdata = $luo_est->lst_listar();
        
        echo $rowdata;
        
        break;
    
    /*--lista solo dos estados todos,activos,cerrados para tiendas--*/
    case 3:
         $rowdata = $luo_est->lst_activo();
        
        echo $rowdata;
        
        break; 
    
    /*---listado estado para resolutores -----------------*/
    case 4:
         $rowdata = $luo_est->lst_activorst();
        
        echo $rowdata;
        
        break;          
}   

unset($luo_est);
unset($luo_segsesion);