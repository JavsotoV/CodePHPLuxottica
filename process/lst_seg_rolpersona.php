<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../security/clssegRolPersona.php");
require_once ("../security/clssegSession.php");

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$paramAccion = $Variables['operacion'];

$luo_segrolpersona = new clssegRolPersona();
$luo_segsesion = new clssegSession();
$user_codigo=$luo_segsesion->get_per_codigo();
$rol_codigo=$luo_segsesion->get_rol_codigo();

if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

switch ($paramAccion)
{
    case 1:
        
    case 2:
        
    case 3:
         $rowdata = $luo_segrolpersona->lst_rolsegper($user_codigo,$rol_codigo);
        
         echo $rowdata;
            
         break;
     
    //-------roles de usuario en general por sistema ---------------------------
     case 4:
        $rowdata = $luo_segrolpersona->lst_sistemapersona($user_codigo);
        
        echo $rowdata;
        
        break;
}

unset($luo_segsesion);
unset($luo_segrolpersona);

