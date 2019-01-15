<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../legal/clsgcaContratoAlerta.php");
require_once ('../security/clssegSession.php');
require_once("../legal/clsgcaExportExcel.php");

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

$luo_contratoalerta = new clsgcaContratoAlerta();
        
switch ($paramAccion){

    case 1:
        $valida = [
            'pai_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'cda_codigo' => [ 'filter'=> FILTER_VALIDATE_INT],
            'criterio'   => [ 'filter' => FILTER_UNSAFE_RAW],
            'start'      => [ 'filter' => FILTER_VALIDATE_INT],
            'page'       => [ 'filter' => FILTER_VALIDATE_INT],
            'limit'      => [ 'filter' => FILTER_VALIDATE_INT]
            ];
   
        $parametros = filter_var_array($Variables, $valida);
    
        $rowdata = $luo_contratoalerta->lst_alerta($parametros['pai_codigo'],$parametros['cda_codigo'], $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);

        echo $rowdata; 
        
        break;
 
    
    case 2:
        
        $valida = ['con_codigo'=>[ 'filter' => FILTER_VALIDATE_INT]];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_contratoalerta->lst_resumen($parametros['con_codigo']);
        
        echo $rowdata;
        
        break;
    
    //-----------generando archivo de excel ------------------------------------
    case 3:
         $valida = [
            'pai_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'cda_codigo' => [ 'filter'=> FILTER_VALIDATE_INT],
            'criterio'   => [ 'filter' => FILTER_UNSAFE_RAW],
            'start'      => [ 'filter' => FILTER_VALIDATE_INT],
            'page'       => [ 'filter' => FILTER_VALIDATE_INT],
            'limit'      => [ 'filter' => FILTER_VALIDATE_INT]
            ];
   
        $parametros = filter_var_array($Variables, $valida);
        
         $rowdata = $luo_contratoalerta->lst_alerta($parametros['pai_codigo'],$parametros['cda_codigo'], $parametros['criterio'],1 , 999999);
        
        $ArrayHeader=Array('ale_descripcion'=>'TIPO',
                           'con_codgestion'=>'NRO. INTERNO',
                           'tda_descripcion'=>'LOCAL',
                           'con_direccion'=>'DIRECCION',
                           'pai_denominacion'=>'PAIS',
                           'con_fechai'=>'VIGENCIA',
                           'con_fechat'=>'VENCIMIENTO',
                           'des_flagrenovacionaut'=>'RENOV. AUT.',
                           'con_observacion'=>'OBSERVACIONES');
        
        $ArrayHeaderWith=Array(30,20,120,120,30,20,20,20,200);
        
         $ArrayFormat=Array('con_fechai'      => 'dd/mm/yyyy',
                            'con_fechat'      => 'dd/mm/yyyy');
        
        $luo_exportExcel = new clsgcaExportExcel();
    
        $luo_exportExcel->exportar($rowdata, 'CONTRATOS ALERTA', 'ContratoAlerta',$ArrayHeaderWith,$ArrayHeader,$ArrayFormat);
        
        break;
        
}

    unset($luo_contratoalerta);
    unset($luo_segsesion);