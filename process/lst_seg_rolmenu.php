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

$luo_rolmenu = new clssegRolmenu();

$paramAccion = $Variables['operacion'];

switch ($paramAccion)
{
    case 1:
        
    case 2:
        
    case 3:
         $valida=['rse_codigo'=>['filter'=>FILTER_VALIDATE_INT]];
        
         $parametros= filter_var_array($Variables,$valida);
         
         $rowdata = $luo_rolmenu->lst_rolmenu($parametros['rse_codigo']);
        
         echo $rowdata;
            
         break;
     
    // Modulos mostrar a usuario segun sistema y usuario
    case 4: 
}

