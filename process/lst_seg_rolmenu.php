<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../security/clssegRolmenu.php");
require_once ("../security/clssegSession.php");

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$luo_rolmenu = new clssegRolmenu();
$luo_segsesion = new clssegSession();
$user_codigo=1;//$luo_segsesion->get_per_codigo();

if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

$paramAccion = $Variables['operacion'];

switch ($paramAccion)
{
    case 1:
        
    case 2:
        
    //opciones segun rol asignado ---------------------------------------------
    case 3:
         $valida=['rse_codigo'=>['filter'=>FILTER_VALIDATE_INT]];
        
         $parametros= filter_var_array($Variables,$valida);
         
         $rowdata = $luo_rolmenu->lst_rolmenu($parametros['rse_codigo']);
        
         echo $rowdata;
            
         break;
     
    // Modulos mostrar a usuario segun sistema y usuario
    case 4: 
        $valida = ['seg_codigo' => ['filter'    => FILTER_VALIDATE_INT]];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_rolmenu->lst_menuxusuario($user_codigo, $parametros['seg_codigo']);
        
        echo $rowdata;
        
        break;
}

