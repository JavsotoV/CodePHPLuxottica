<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../mda/clsgmaTicketAlerta.php');
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

$luo_tckalerta = new clsgmaTicketAlerta();


switch ($paramAccion){
    
    case 1:         
        $rowdata = $luo_tckalerta->lst_rst_ticket($user_codigo);
        
        echo $rowdata;
        
        break;
    
    case 2:        
        $valida = [
            'codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'condicion'     => ['filter' => FILTER_UNSAFE_RAW],
            'page'          => ['filter' => FILTER_VALIDATE_INT],
            'limit'         => ['filter' => FILTER_VALIDATE_INT]
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_tckalerta->lst_det_ticket($user_codigo, $parametros['codigo'], $parametros['condicion'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
}

unset($luo_tckalerta);
unset($luo_segsesion);

