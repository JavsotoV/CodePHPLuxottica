<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../rrhh/clsgrhCentrolaboral.php');
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

$luo_centrolaboral = new clsgrhCentrolaboral($user_codigo);

switch ($paramAccion){
    case 1:
        $valida = [
            'accion'            => ['filter'    => FILTER_VALIDATE_INT],
            'ctl_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
            'asg_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
            'cfg_codigo'        => ['filter'    => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'ctl_fechai'        => ['filter'    => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'ctl_fechat'        => ['filter'    => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']]];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_centrolaboral->loadData($parametros);
        
        $rowdata = $luo_centrolaboral->sp_grh_centrolaboral($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    case 2:
        $valida = [
            'asg_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
            'criterio'      => ['filter'    => FILTER_UNSAFE_RAW],
            'page'          => ['filter'    => FILTER_VALIDATE_INT],
            'limit'         => ['filter'    => FILTER_VALIDATE_INT]];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_centrolaboral->lst_listar($parametros['asg_codigo'], $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
    case 3:
        $valida = [
            'asg_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
            'criterio'      => ['filter'    => FILTER_UNSAFE_RAW],
            'page'          => ['filter'    => FILTER_VALIDATE_INT],
            'limit'         => ['filter'    => FILTER_VALIDATE_INT]];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_centrolaboral->lst_pendiente($parametros['asg_codigo'],  $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
}

unset($luo_centrolaboral);
unset($luo_segsesion);
