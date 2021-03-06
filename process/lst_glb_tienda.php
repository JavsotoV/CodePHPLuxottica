<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once ('../global/clsglbTienda.php');
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

$luo_tienda = new clsglbTienda();

switch ($paramAccion){
    case 1:
        
         $valida = [
            'accion'            => [ 'filter' => FILTER_VALIDATE_INT],
            'tda_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'ubg_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'ctr_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'tda_descripcion'   => [ 'filter' => FILTER_UNSAFE_RAW],
            'tda_codinterno'    => [ 'filter' => FILTER_UNSAFE_RAW],
            'cda_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'tda_tipo'          => [ 'filter' => FILTER_VALIDATE_INT]
        ];
                
        $parametros = filter_var_array($Variables, $valida);
   
        $luo_tienda->loadData($parametros);
        
        $rowdata = $luo_tienda->sp_glb_tienda($parametros['accion'],$user_codigo);
        
        echo $rowdata;
        
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
        
        $rowdata = $luo_tienda->lst_listar($parametros['pai_codigo'],$parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;   
}

unset($luo_tienda);
unset($luo_segsesion);
