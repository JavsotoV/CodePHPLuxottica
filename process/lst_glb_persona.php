<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lst_glb_persona
 *
 * @author JAVSOTO
 */
header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once("../global/clsglbPersona.php");
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

$luo_persona = new clsglbPersona();

switch ($paramAccion){
    //-------mantenimiento de persona-----------------------------------------
    case 1:
        $valida = [
            'accion'                => [ 'filter' => FILTER_VALIDATE_INT],
            'per_codigo'            => [ 'filter' => FILTER_VALIDATE_INT],
            'per_tipo'              => [ 'filter' => FILTER_UNSAFE_RAW],
            'per_apaterno'          => [ 'filter' => FILTER_UNSAFE_RAW],
            'per_amaterno'          => [ 'filter' => FILTER_UNSAFE_RAW],
            'per_pnombre'           => [ 'filter' => FILTER_UNSAFE_RAW],
            'per_snombre'           => [ 'filter' => FILTER_UNSAFE_RAW],
            'per_razonsocial'       => [ 'filter' => FILTER_UNSAFE_RAW],
            'tpo_codigo'            => [ 'filter' => FILTER_VALIDATE_INT],
            'per_nrodocidentidad'   => [ 'filter' => FILTER_UNSAFE_RAW],
            'per_genero'            => [ 'filter' => FILTER_VALIDATE_INT],
            'per_fechanac'          => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'pai_codigo'            => [ 'filter' => FILTER_VALIDATE_INT],
            'dom_codigo'            => [ 'filter' => FILTER_VALIDATE_INT],
            'dom_descripcion'       => [ 'filter' => FILTER_UNSAFE_RAW],
            'ubg_codigo'            => [ 'filter' => FILTER_VALIDATE_INT],
            'per_representante'     => [ 'filter' => FILTER_VALIDATE_INT],
            'ema_denominacion'      => [ 'filter' => FILTER_VALIDATE_EMAIL]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_persona->loadData($parametros);  
        
        $rowdata = $luo_persona->glb_persona($parametros['accion'], $user_codigo);
        
        echo $rowdata;
        
        break;
    
    //------listado de persona ------------------------------------------------
    case 2:
        $valida = [
            'pai_codigo'    => ['filter'=> FILTER_VALIDATE_INT],
            'criterio'      => [ 'filter' => FILTER_UNSAFE_RAW],
            'start'         => [ 'filter' => FILTER_VALIDATE_INT],
            'page'          => [ 'filter' => FILTER_VALIDATE_INT],
            'limit'         => [ 'filter' => FILTER_VALIDATE_INT]
        ];

        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata=$luo_persona->lst_listar($parametros['pai_codigo'],$parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);

        echo $rowdata;
        
        break;
    
    //----listado de persona con datos resumidos por region --------------------    
    case 3:
        
        $valida = [
            'pai_codigo'    => [ 'filter' => FILTER_VALIDATE_INT],
            'prc_codigo'    => ['filter'  => FILTER_VALIDATE_INT], 
            'org_codigo'    => [ 'filter' => FILTER_VALIDATE_INT],
            'criterio'      => [ 'filter' => FILTER_UNSAFE_RAW],
            'start'         => [ 'filter' => FILTER_VALIDATE_INT],
            'page'          => [ 'filter' => FILTER_VALIDATE_INT],
            'limit'         => [ 'filter' => FILTER_VALIDATE_INT]
        ];

        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata=$luo_persona->lst_personaregion($parametros['pai_codigo'],$parametros['prc_codigo'],$parametros['org_codigo'],$parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);

        echo $rowdata;
        
        break;   
}

unset($luo_persona);
unset($luo_segsesion);