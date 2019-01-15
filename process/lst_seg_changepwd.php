<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once ('../security/clssegChangePwd.php');
require_once ('../security/clssegSession.php');


if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$paramAccion = $Variables['operacion'];

$luo_segsesion = new clssegSession();
$user_codigo=$luo_segsesion->get_per_codigo();

if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

$luo_changepwd = new clssegChangePwd($user_codigo);

switch($paramAccion){
     case 1:
         $valida = [
             'pwd_act'  => [ 'filter' => FILTER_UNSAFE_RAW],
             'pwd_nvo' => [ 'filter' => FILTER_UNSAFE_RAW]
         ];
         
          $parametros = filter_var_array($Variables, $valida);
          
          $luo_changepwd->loadData($parametros);
          
          $rowdata = $luo_changepwd->changepwd();
          
          echo $rowdata;
          
          break;
}

unset($luo_changepwd);
unset($luo_segsesion);


