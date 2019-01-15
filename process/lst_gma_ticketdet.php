<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../mda/clsgmaTicketdet.php');
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

$luo_tkd = new clsgmaTicketdet($user_codigo);

switch ($paramAccion){
    
    //--registro de resolutores de segundo nivel ------------------------------
    case 1:
        
        $valida = [
            'accion'        => ['filter' => FILTER_VALIDATE_INT],
            'tck_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'rpe_codigo'    => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'rse_nivel'     => ['filter' => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $luo_tkd->loadData($parametros);
        
        $rowdata = $luo_tkd->sp_gma_ticketdet($parametros['accion']);
        
        echo $rowdata;
        
        break;
     
    case 2:
        $valida = [
            'tck_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'criterio'      => ['filter' => FILTER_UNSAFE_RAW],
            'page'          => ['filter' => FILTER_VALIDATE_INT],
            'limit'         => ['filter' => FILTER_VALIDATE_INT]        
        ];
        
        $parametros= filter_var_array($Variables,$valida);
         
        $rowdata = $luo_tkd->lst_listar($parametros['tck_codigo'],$parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
    /*--listado de resolutores de segundo nivel pendientes de asignacion por ticket ---- */
    case 3:
        $valida=[
            'tck_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'rqe_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'rse_nivel'     => ['filter' => FILTER_VALIDATE_INT]
        ];
        
        $parametros= filter_var_array($Variables,$valida);
         
        $rowdata = $luo_tkd->lst_rstsegundonivel($parametros['tck_codigo'],$parametros['rqe_codigo'],$parametros['rse_nivel']);
        
        echo $rowdata;
        
        break;
}

unset($luo_tkd);
unset($luo_segsesion);
