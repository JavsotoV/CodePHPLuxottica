<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../mda/clsgmaRequerimiento.php');
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

$luo_rqe = new clsgmaRequerimiento($user_codigo);

switch ($paramAccion){
    case 1:
        $valida= [
            'accion'            => ['filter' => FILTER_VALIDATE_INT],
            'srv_codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'rqe_codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'rqe_denominacion'  => ['filter' => FILTER_UNSAFE_RAW],
            'rqe_prioridad'     => ['filter' => FILTER_VALIDATE_INT],
            'rqd_codigo'        => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'rse_nivel'         => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'pai_codigo'        => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'rqd_tiemporpta'    => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'rqe_tiempound'     => ['filter' => FILTER_VALIDATE_INT]
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $luo_rqe->loadData($parametros);
        
        $rowdata = $luo_rqe->sp_gma_requerimiento($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    case 2:
        $valida = [
                'srv_codigo'  => ['filter' => FILTER_VALIDATE_INT],
                'rqe_codigo'  => ['filter' => FILTER_VALIDATE_INT],  
                'criterio'    => ['filter' => FILTER_UNSAFE_RAW],
                'page'        => ['filter' => FILTER_VALIDATE_INT],
                'limit'       => ['filter' => FILTER_VALIDATE_INT]
            ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_rqe->lst_listar($parametros['rqe_codigo'],$parametros['srv_codigo'],$parametros['$criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
}

unset($luo_rqe);
unset($luo_segsesion);