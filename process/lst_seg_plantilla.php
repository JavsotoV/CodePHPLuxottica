<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../security/clssegPlantilla.php");
require_once ("../security/clssegSession.php");

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$paramAccion = $Variables['operacion'];

$luo_segsesion = new clssegSession();
$user_codigo=1;//$luo_segsesion->get_per_codigo();


if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

$luo_plt = new clssegPlantilla();

switch ($paramAccion)
{
      case 1:
          break;
      
      
      case 2;
          
          $rowdata = $luo_plt->lst_listar();
          
          echo $rowdata;
          
          break;
}

unset($luo_plt);
unset($luo_segsesion);