<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lst_glb_grupoinmobiliario
 *
 * @author JAVSOTO
 */
header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../global/clsglbGrupoinmobiliario.php");
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

$paramAccion = $Variables['operacion'];

$luo_grupoimb = new clsglbGrupoinmobiliario();

switch ($paramAccion){
    case 1:            
            $valida = [
                'accion'            => ['filter'    => FILTER_VALIDATE_INT],
                'imb_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                'pai_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                'imb_descripcion'   => ['filter'    => FILTER_UNSAFE_RAW]];
        
            $parametros = filter_var_array($Variables,$valida);
            
            $luo_grupoimb->loadData($parametros);
            
            $rowdata=$luo_grupoimb->sp_glb_grupoinmobiliaria($parametros['accion'], $user_codigo);
            
            echo $rowdata;
            
            break;  
      
    case 2:
            $valida = [
            'pai_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'criterio'   => [ 'filter' => FILTER_UNSAFE_RAW],
            'condicion'  => ['filter' => FILTER_UNSAFE_RAW]];
        
            $parametros = filter_var_array($Variables, $valida);
        
            $rowdata=$luo_grupoimb->lst_listar($parametros['pai_codigo'], $parametros['criterio'], $parametros['condicion']); 
            
            echo $rowdata;
            
            break;
        
    case 3:
            $valida = [
            'pai_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'criterio'   => [ 'filter' => FILTER_UNSAFE_RAW],
            'page'       => [ 'filter' => FILTER_VALIDATE_INT],
            'limit'      => [ 'filter' => FILTER_VALIDATE_INT]];
        
            $parametros = filter_var_array($Variables, $valida);
        
            $rowdata=$luo_grupoimb->lst_lista($parametros['pai_codigo'], $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
            
            echo $rowdata;
            
            break;    
}

unset($luo_grupoimb);
unset($luo_segsesion);