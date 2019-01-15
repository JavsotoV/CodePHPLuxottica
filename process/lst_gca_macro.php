<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../legal/clsgcaMacro.php");
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

$luo_macro = new clsgcaMacro();
 
$Variables['tipocambiolocal']=str_replace(",",".",$Variables['tipocambiolocal']);
$Variables['tipocambiodolar']=str_replace(",",".",$Variables['tipocambiodolar']);
$Variables['tipocambioeuro']=str_replace(",",".",$Variables['tipocambioeuro']);

$valida=[
            'pai_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'sta_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'mon_conversion'            => [ 'filter' => FILTER_VALIDATE_INT],
            'tipocambiolocal'           => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'tipocambiodolar'           => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'tipocambioeuro'            => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'page'                      => [ 'filter' => FILTER_VALIDATE_INT],
            'limit'                     => [ 'filter' => FILTER_VALIDATE_INT]
];    
        
$parametros = filter_var_array($Variables, $valida);
        
$luo_macro->loadData($parametros);

switch ($paramAccion){

    case 1:
        $luo_macro->lst_conexion();
        
        $rowdata = $luo_macro->lst_recordSet(1,(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        $luo_macro->lst_desconexion();
        
        echo $rowdata;
        
        break;
    
    //-----------exportar a excel ----------------------------------------------
    case 2:
        $rowdata = $luo_macro->lst_recordSet(2,(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;        

        break;
    
    //------proveedor ----------------------------------------------------------
    case 3:
        $rowdata = $luo_macro->lst_recordSet(3,(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;        

        break;
    
    case 4:
        $rowdata = $luo_macro->lst_recordSet(4,(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;        

        break;
}

unset($luo_macro);
unset($luo_segsesion);
