<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once("../rrhh/clsgrhSolgrhcb.php");
require_once ('../security/clssegSession.php');

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$luo_segsesion = new clssegSession();
$user_codigo=1; //$luo_segsesion->get_per_codigo();

if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

$paramAccion = $Variables ['operacion'];

$luo_sol = new clsgrhSolgrhcb();

switch ($paramAccion){
    //-------mantenimiento de persona-----------------------------------------
    case 1:
        
        $Variables ['montosol'] = str_replace(",",".",$Variables ['montosol']);
        
        $valida = [
            'accion'            => ['filter'=> FILTER_VALIDATE_INT],
            'cdg'               => ['filter' => FILTER_VALIDATE_INT],
            'glprofile'         => ['filter' => FILTER_UNSAFE_RAW],
            'tpsolgrh'          => ['filter' => FILTER_UNSAFE_RAW],
            'montosol'          => ['filter' => FILTER_VALIDATE_FLOAT],
            'solicitud'         => ['filter' => FILTER_UNSAFE_RAW], 
            'tpplan'            => ['filter' => FILTER_UNSAFE_RAW],
            'pln_codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'ubg_codigo'        => ['filter' => FILTER_VALIDATE_INT],         
            'sede'              => ['filter' => FILTER_UNSAFE_RAW],
            'nrocupon'          => ['filter' => FILTER_VALIDATE_INT]
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $luo_sol->loadData($parametros);
            
        $rowdata = $luo_sol->sp_grh_solgrhcb($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    case 2:
        
        if(strlen($Variables['fechai'])>=10)        {$Variables['fechai']      = date('d/m/Y',strtotime($Variables['fechai']));}        
        if(strlen($Variables['fechat'])>=10)        {$Variables['fechat']      = date('d/m/Y',strtotime($Variables['fechat']));}
         
        $valida =[
            'cdg'           => ['filter'  => FILTER_VALIDATE_INT],
            'glprofile'     => ['filter'  => FILTER_UNSAFE_RAW],
            'criterio'      => ['filter'  => FILTER_UNSAFE_RAW],
            'fechai'        => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'fechat'        => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'start'         => [ 'filter' => FILTER_VALIDATE_INT],
            'page'          => [ 'filter' => FILTER_VALIDATE_INT],
            'limit'         => [ 'filter' => FILTER_VALIDATE_INT]
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_sol->lst_listar($parametros['cdg'],$parametros['glprofile'], $parametros['criterio'], $parametros['fechai'], $parametros['fechat'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
    // revisa una solicitud generada     
    case 3:
         
         $Variables ['monto'] = str_replace(",",".",$Variables ['monto']);
        
         $valida = [
                'accion'         => ['filter' => FILTER_VALIDATE_INT],   
                'cdg'            => ['filter' => FILTER_VALIDATE_INT],   
                'aprobado'       => ['filter' => FILTER_UNSAFE_RAW],   
                'observacion'    => ['filter' => FILTER_UNSAFE_RAW],   
                'fdesde'         => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
                'fhasta'         => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
                'monto'          => ['filter' => FILTER_VALIDATE_FLOAT],
                'idmotivo'       => ['filter' => FILTER_VALIDATE_INT],
                'nrocuota'       => ['filter' => FILTER_VALIDATE_INT]
            ];
        
            $parametros= filter_var_array($Variables,$valida);
            
            $luo_sol->loadData($parametros);
            
            $rowdata = $luo_sol->sp_revision($parametros['accion']);
            
            echo $rowdata;
            
            break;
        
    // listado de solicitudes por fecha y criterio de busqueda
    case 4:
        if(strlen($Variables['fechai'])>=10)        {$Variables['fechai']      = date('d/m/Y',strtotime($Variables['fechai']));}        
        if(strlen($Variables['fechat'])>=10)        {$Variables['fechat']      = date('d/m/Y',strtotime($Variables['fechat']));}
         
        $valida =[
            'criterio'      => ['filter'  => FILTER_UNSAFE_RAW],
            'fechai'        => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'fechat'        => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'start'         => [ 'filter' => FILTER_VALIDATE_INT],
            'page'          => [ 'filter' => FILTER_VALIDATE_INT],
            'limit'         => [ 'filter' => FILTER_VALIDATE_INT]
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_sol->lst_listartot($parametros['criterio'], $parametros['fechai'], $parametros['fechat'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
        
    case 5:
        $valida =[
            'cdg'       => ['filter' => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        
        break;
}

unset($luo_sol);
unset($luo_segsesion);