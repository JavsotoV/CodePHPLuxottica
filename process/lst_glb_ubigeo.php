<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once ('../global/clsglbUbigeo.php');
require_once ('../security/clssegSession.php');

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$paramAccion = $Variables ['operacion'];

$luo_segsesion = new clssegSession();
$user_codigo=$luo_segsesion->get_per_codigo();

if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

$luo_ubigeo = new clsglbUbigeo();

switch ($paramAccion){
    case 1:
        /*
         $valida = [
            'accion' => [ 'filter' => FILTER_VALIDATE_INT],
            'tda_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'ubg_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'ctr_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'tda_descripcion' => [ 'filter' => FILTER_UNSAFE_RAW]
        ];
        
        
        $parametros = filter_var_array($Variables, $valida);
   
        $luo_tienda->loadData($parametros);
        
        $usuario=1;
        
        $rowdata = $luo_tienda->sp_glb_tienda($parametros['accion'],$usuario);
        
        echo $rowdata;*/
        
        break;
    
    case 2:
         $valida = [
             'pai_codigo'  => [ 'filter' => FILTER_VALIDATE_INT],
             'criterio' => [ 'filter' => FILTER_UNSAFE_RAW],
             'start'    => [ 'filter' => FILTER_VALIDATE_INT],
             'page'    => [ 'filter' => FILTER_VALIDATE_INT],
             'limit'    => [ 'filter' => FILTER_VALIDATE_INT]  
         ];
        
         $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_ubigeo->lst_ubigeoxpais($parametros['pai_codigo'],$parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;   
    
    case 3:
        $valida=[
                    'prv_codigo' => ['filter'=>FILTER_VALIDATE_INT],
                    'criterio'   => ['filter'=>FILTER_UNSAFE_RAW]    
                ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_ubigeo->lst_listar($parametros['prv_codigo'], $parametros['criterio']);
        
        echo $rowdata;
        
        break;
}

unset($luo_ubigeo);
unset($luo_segsesion);
