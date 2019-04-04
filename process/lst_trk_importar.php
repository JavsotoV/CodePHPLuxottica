<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once("../traking/clstrkimportar.php");
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

$luo_imp = new clstrkimportar($user_codigo);

switch ($paramAccion){
    case 1:
        $valida =[
            'encargo'           => ['filter'        => FILTER_UNSAFE_RAW,'flags' => FILTER_REQUIRE_ARRAY],
            'fecha'             => ['filter'        => FILTER_UNSAFE_RAW,'flags' => FILTER_REQUIRE_ARRAY]
        ]; 
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_imp->loadData($parametros);
        
        $rowdata = $luo_imp->sp_trk_importar($parametros['accion']);
        
        echo $rowdata;
            
        break;
    
    case 2:       
        
        if(strlen($Variables['trk_fechai'])>=10)    {$Variables['trk_fechai'] = date('d/m/Y',strtotime($Variables['trk_fechai']));}
        
        if(strlen($Variables['trk_fechat'])>=10)    {$Variables['trk_fechat'] = date('d/m/Y',strtotime($Variables['trk_fechat']));}

        $valida = [
            'trk_fechai'            => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'trk_fechat'            => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'page'                  => ['filter'    => FILTER_VALIDATE_INT],
            'limit'                 => ['filter'    => FILTER_VALIDATE_INT]];
        
            $parametros = filter_var_array($Variables, $valida);
            
            $rowdata = $luo_imp->lst_listar($parametros['trk_fechai'],$parametros['trk_fechat'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
            
            echo $rowdata;
            
            break;
}

unset($luo_imp);
unset($luo_segsession);
