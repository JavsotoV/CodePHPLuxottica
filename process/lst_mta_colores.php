<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../logistica/clsmtaColores.php');
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

$luo_colores = new clsmtaColores();

switch ($paramAccion){
    case 1:            
        
        break;
    
    case 2:
        $valida = [
                'pai_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                'tipfamcod'         => ['filter'    => FILTER_UNSAFE_RAW],
                'col_entidad'       => ['filter'    => FILTER_UNSAFE_RAW]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_colores->lst_listar($parametros['pai_codigo'], $parametros['tipfamcod'], $parametros['col_entidad']);
        
        echo $rowdata;
        
        break;
}

unset($luo_colores);
unset($luo_segsession);