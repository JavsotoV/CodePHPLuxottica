<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../conta/clsgccReposicion.php');
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

$luo_repo = new clsgccReposicion($user_codigo);

switch ($paramAccion){
    case 1:
        
        $Variables['rpo_importe'] = str_replace(",",".",$Variables['rpo_importe']);
        
        $valida = ['accion'             => ['filter'    => FILTER_VALIDATE_INT],
                   'rpo_codigo'         => ['filter'    => FILTER_VALIDATE_INT],
                   'ent_codigo'         => ['filter'    => FILTER_VALIDATE_INT],    
                   'rpo_fecha'          => ['filter'    => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
                   'rpo_observacion'    => ['filter'    => FILTER_UNSAFE_RAW],
                   'mon_codigo'         => ['filter'    => FILTER_VALIDATE_INT],
                   'rpo_importe'        => ['filter'    => FILTER_VALIDATE_FLOAT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
 
        $luo_repo->loadData($parametros);
        
        $rowdata = $luo_repo->sp_gcc_reposicion($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    case 2:
        $valida = ['rpo_codigo'     => ['filter'    => FILTER_VALIDATE_INT],
                   'rpo_periodo'    => ['filter'    => FILTER_VALIDATE_INT],
                   'ent_codigo'     => ['filter'    => FILTER_VALIDATE_INT],
                   'criterio'       => ['filter'    => FILTER_UNSAFE_RAW],
                   'page'           => ['filter'    => FILTER_VALIDATE_INT],
                   'limit'          => ['filter'    => FILTER_VALIDATE_INT]
            ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_repo->lst_listar($parametros['rpo_codigo'], $parametros['rpo_periodo'], $parametros['ent_codigo'],$parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
}

unset($luo_repo);
unset($luo_segsesion);