<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../global/clsglbGlprofile.php');
require_once ('../security/clssegSession.php');
require_once('../Base/clsViewData.php');

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$luo_segsesion = new clssegSession();
$user_codigo=1;

        //$luo_segsesion->get_per_codigo();

if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

$paramAccion = $Variables ['operacion'];

$luo_glp = new clsglbGlprofile();

switch ($paramAccion){
    
    case 1:
        break;
    
    case 2:
        $valida= [
            'accion'            => ['filter' => FILTER_VALIDATE_INT],
            'pai_codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'criterio'          => ['filter' => FILTER_UNSAFE_RAW],
            'page'              => ['filter' => FILTER_VALIDATE_INT],
            'limit'             => ['filter' => FILTER_VALIDATE_INT]            
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_glp->lst_listar($parametros['pai_codigo'],$parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;    
}

unset($luo_glp);

unset($luo_segsesion);

