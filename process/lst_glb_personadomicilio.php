<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once ('../global/clsglbPersonadomicilio.php');
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

$luo_personadomicilio = new clsglbPersonadomicilio();

switch ($paramAccion){
    case 1:
        
         $valida = [
            'accion' => [ 'filter' => FILTER_VALIDATE_INT],
            'per_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'dom_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'ubg_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'tzo_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'zna_descripcion' => [ 'filter' => FILTER_UNSAFE_RAW],
            'via_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'dom_vianombre' => [ 'filter' => FILTER_UNSAFE_RAW],
            'dom_vianumero' => [ 'filter' => FILTER_UNSAFE_RAW],
            'dom_descripcion' => [ 'filter' => FILTER_UNSAFE_RAW],
            'dom_departamento' => [ 'filter' => FILTER_UNSAFE_RAW],
            'dom_interior' => [ 'filter' => FILTER_UNSAFE_RAW],
            'dom_manzana' => [ 'filter' => FILTER_UNSAFE_RAW],
            'dom_nrolote' => [ 'filter' => FILTER_UNSAFE_RAW],
            'dom_etapa' => [ 'filter' => FILTER_UNSAFE_RAW],
            'dom_referencia' => [ 'filter' => FILTER_UNSAFE_RAW],
            'dom_block' => [ 'filter' => FILTER_UNSAFE_RAW],
            'dom_defecto' => [ 'filter' => FILTER_UNSAFE_RAW]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
  
        $luo_personadomicilio->loadData($parametros);
                
        $rowdata = $luo_personadomicilio->sp_glb_personadomicilio($parametros['accion'],$user_codigo);
        
        echo $rowdata;
        
        break;
    
    case 2:
        
         $valida = [
             'per_codigo'  => [ 'filter' => FILTER_VALIDATE_INT] 
         ];
        
         $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_personadomicilio->lst_listar($parametros['per_codigo']);
        
        echo $rowdata;
        
        break;   
}

unset($luo_personadomicilio);
unset($luo_segsesion);
