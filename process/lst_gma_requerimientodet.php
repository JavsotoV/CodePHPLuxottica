<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../mda/clsgmaRequerimientodet.php');
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

$luo_rqd = new clsgmaRequerimientodet($user_codigo);

switch ($paramAccion){
    case 1:
        break;
    
    //---listado de SLA por requerimiento o tema -------------------------------
    case 2:
        $valida=[
            'rqe_codigo'    => ['filter'    => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_rqd->lst_listar($parametros['rqe_codigo']);
        
        echo $rowdata;
        
        break;   
  
    
}

unset($luo_rqd);
unset($luo_segsesion);