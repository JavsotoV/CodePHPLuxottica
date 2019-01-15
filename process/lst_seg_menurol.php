<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../security/clssegMenu.php");
require_once ("../security/clssegSession.php");

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$paramAccion = $Variables['operacion'];

$luo_segmenu = new clssegMenu();
$luo_segsesion = new clssegSession();
$user_codigo=$luo_segsesion->get_per_codigo();

if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

switch ($paramAccion)
{
    case 1:
        
    case 2:
        
    case 3:
         $valida=['men_codigo'=>    ['filter'   => FILTER_VALIDATE_INT],
                  'rol_codigo'=>    ['filter'   => FILTER_VALIDATE_INT]
             ];
        
         $parametros= filter_var_array($Variables,$valida);
         
         if (empty($parametros['rol_codigo'])) {$parametros['rol_codigo']=$luo_segsesion->get_rol_codigo();}
         
         $rowdata = $luo_segmenu->lst_menurol($parametros['men_codigo'],$parametros['rol_codigo']);
        
         echo $rowdata;
            
         break;
}

unset($luo_segmenu);
unset($luo_segsession);


