<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once ('../security/clssegAutenticacion.php');
require_once ('../security/clssegSession.php');



if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$paramAccion = $Variables ['operacion'];

$luo_autenticacion = new clssegAutenticacion();
$luo_session = new clssegSession();

switch($paramAccion){
    
    case 1:
        $valida = [
                'per_usuario'   => [ 'filter' => FILTER_UNSAFE_RAW],
                'per_password'  => [ 'filter' => FILTER_UNSAFE_RAW],
                'seg_codigo'    => [ 'filter' => FILTER_VALIDAR_INT]
            ];

        $parametros = filter_var_array($Variables, $valida);
 
        $luo_autenticacion->loadData($parametros);
        
        $rowdata = $luo_autenticacion->sp_validar();
    
        $luo_session->lst_iniciar($rowdata);
        
        echo $rowdata;
    
        break;
    
    case 2:
         $valida = [
                'per_usuario' => [ 'filter' => FILTER_UNSAFE_RAW],
                'per_password' => [ 'filter' => FILTER_UNSAFE_RAW]
            ];

        $parametros = filter_var_array($Variables, $valida);
 
        $luo_autenticacion->loadData($parametros);
 
        $rowdata = $luo_autenticacion->sp_valglprofile();
    
        $luo_session->lst_iniciar($rowdata);
   
        echo $rowdata;
    
        break;
    
    //-----------datos de sesion de usuario-----------------
    case 3:
        
        $rowdata = $luo_session->get_data();
        
        echo $rowdata;
        
        break;        
} 

unset($luo_autenticacion);
unset($luo_segsesion);
 
 
