<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once("../global/clsglbRepresentante.php");
require_once ('../security/clssegSession.php');

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

$luo_representante = new clsglbRepresentante();

switch ($paramAccion){
    case 1:
         $valida = [
            'accion' => [ 'filter' => FILTER_UNSAFE_RAW],
            'rpl_codigo'=>['filter'=>FILTER_VALIDATE_INT],
            'per_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'per_representante' => [ 'filter' => FILTER_VALIDATE_INT], 
        ];
                
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_representante->loadData($parametros);
        
        $rowdata = $luo_representante->sp_glb_representante($parametros['accion'], $user_codigo);
        
        echo $rowdata;
        
        break;
    
    case 2:
        $valida=[
            'per_codigo'=>['filter'=>FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_representante->lst_listar($parametros['per_codigo']);
        
        echo $rowdata;
        
        break;
}

unset($luo_representante);
unset($luo_segsesion);

