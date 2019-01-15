<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../mda/clsgmaTipoServicioPais.php');
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

$luo_tiposrvpais = new clsgmaTipoServicioPais($user_codigo);

switch ($paramAccion){
    
    case 1:
        $valida= [
                'accion'            => ['filter'    => FILTER_VALIDATE_INT],
                'tpp_codigo'        => ['filter'    => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
                'pai_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                'tps_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                'srv_codigo'        => ['filter'    => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY]];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $luo_tiposrvpais->loadData($parametros);
        
        $rowdata = $luo_tiposrvpais->sp_gma_tiposerviciopais($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    case 2:   
        $valida = [
            'are_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
            'pai_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
            'criterio'          => ['filter'    => FILTER_UNSAFE_RAW],
            'page'              => ['filter'    => FILTER_VALIDATE_INT],
            'limit'             => ['filter'    => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_tiposrvpais->lst_listar($parametros['are_codigo'], $parametros['pai_codigo'], $parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
    //------Listado de servicios por area, pais y tipo-------------------------
    case 3:
        $valida = [
            'are_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
            'pai_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
            'tps_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
            'srv_origen'        => ['filter'    => FILTER_VALIDATE_INT]];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_tiposrvpais->sp_lst_srvtipopais($parametros['are_codigo'],$parametros['pai_codigo'],$parametros['tps_codigo'],$parametros['srv_origen']);
        
        echo $rowdata;
        
        break;
    
    //-----listado de servicios pendientes de asignacion -----------------------
    case 4:
        $valida = [
            'are_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
            'pai_codigo'        => ['filter'    => FILTER_VALIDATE_INT]];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_tiposrvpais->lst_srvpendienteasignacion($parametros['are_codigo'],$parametros['pai_codigo']);
        
        echo $rowdata;
        
        break;
}

unset($luo_tiposrvpais);
unset($luo_segsesion);

