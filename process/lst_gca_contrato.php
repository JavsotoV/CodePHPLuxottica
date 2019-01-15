<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../legal/clsgcaContrato.php");
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

$luo_contrato = new clsgcaContrato();

switch ($paramAccion){
    //-------mantenimiento de contrato -----------------------------------------
    case 1:
        
        $Variables ['gra_importe'] = str_replace(",",".",$Variables ['gra_importe']);
        $Variables ['con_area'] = str_replace(",",".",$Variables ['con_area']);
        $Variables ['con_valormetro'] = str_replace(",",".",$Variables ['con_valormetro']);
        $Variables ['con_impfondopromo'] = str_replace(",",".",$Variables ['con_impfondopromo']);
        $Variables ['con_porcfondoprom'] = str_replace(",",".",$Variables ['con_porcfondoprom']);
        $Variables ['con_impingrllave'] = str_replace(",",".",$Variables ['con_impingrllave']);
        $Variables ['con_imprentadiciembre'] = str_replace(",",".",$Variables ['con_imprentadiciembre']);        
        $Variables ['con_importerevision'] = str_replace(",",".",$Variables ['con_importerevision']);
        $Variables ['gto_importe'] = str_replace(",",".",$Variables ['gto_importe']);
        $Variables ['rta_importeipc'] = str_replace(",",".",$Variables ['rta_importeipc']);
        $Variables ['rta_porcentaje'] = str_replace(",",".",$Variables ['rta_porcentaje']);
        $Variables ['rta_puntop'] = str_replace(",",".",$Variables ['rta_puntop']);

            
        $valida = [
            'accion'            => [ 'filter' => FILTER_VALIDATE_INT],
            'con_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'tda_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'pai_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'imb_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'con_direccion'     => [ 'filter' => FILTER_UNSAFE_RAW],
            'ubg_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'con_codgestion'    => [ 'filter' => FILTER_UNSAFE_RAW],    
            'sta_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'org_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'con_area'          => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'con_valormetro'    => [ 'filter' => FILTER_VALIDATE_FLOAT],    
            'con_fechaper'      => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'con_fechafirma'    => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],    
            'con_fechai'        => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'con_fechat'        => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'per_factura'       => [ 'filter' => FILTER_VALIDATE_INT],
            'cna_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'rja_codigo'        => [ 'filter' => FILTER_VALIDATE_INT],
            'con_observacion'   => [ 'filter' => FILTER_UNSAFE_RAW],
            'con_licencia'      => [ 'filter' => FILTER_UNSAFE_RAW],
            'con_nropredio'     => [ 'filter' => FILTER_UNSAFE_RAW],
            'con_parent'        => [ 'filter' => FILTER_VALIDATE_INT],
            'con_tipofondoprom' => [ 'filter' => FILTER_VALIDATE_INT],
            'con_basefondoprom' => [ 'filter' => FILTER_VALIDATE_INT],
            'con_porcfondoprom' => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'mon_fondoprom'     => [ 'filter' => FILTER_VALIDATE_INT],
            'con_impfondopromo' => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'mon_ingresollave'  => [ 'filter' => FILTER_VALIDATE_INT],
            'con_impingrllave'  => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'con_flagclausalida'=> [ 'filter' => FILTER_VALIDATE_INT],
            'con_plazominsalida'     => [ 'filter' => FILTER_VALIDATE_INT],   
            'con_flagrenovacionaut'  => [ 'filter' => FILTER_VALIDATE_INT],
            'con_flagplazominrenov'  => [ 'filter' => FILTER_VALIDATE_INT],
            'con_plazominrenov'      => [ 'filter' => FILTER_VALIDATE_INT],   
            'con_flagconremodelacion'=> [ 'filter' => FILTER_VALIDATE_INT], 
            'con_fecharemodelacion'  => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'con_flagrentadiciembre' => [ 'filter' => FILTER_VALIDATE_INT],
            'con_imprentadiciembre'  => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'mrc_codigo'             => [ 'filter' => FILTER_VALIDATE_INT],    
            'mon_codigorevision'     => [ 'filter' => FILTER_VALIDATE_INT], 
            'con_importerevision'    => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'per_codigoarrendador'   => [ 'filter' => FILTER_VALIDATE_INT],
            'con_sap'                => [ 'filter' => FILTER_UNSAFE_RAW],
            'gra_tipo'               => [ 'filter' => FILTER_VALIDATE_INT],                
            'gra_moncodigo'          => [ 'filter' => FILTER_VALIDATE_INT],
            'gra_importe'            => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'con_plazorenovacionaut' => [ 'filter' => FILTER_VALIDATE_INT],
            'con_undplazominrenov'   => [ 'filter' => FILTER_VALIDATE_INT],
            'con_undplazominsalida'  => [ 'filter' => FILTER_VALIDATE_INT],
            'con_undplazorenovacionaut' => [ 'filter' => FILTER_VALIDATE_INT],
            'fmp_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'gto_tipo'                  => [ 'filter' => FILTER_VALIDATE_INT],
            'gto_moncodigo'             => [ 'filter' => FILTER_VALIDATE_INT],
            'gto_importe'               => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'rta_fechai'                => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'rta_moncodigo'             => [ 'filter' => FILTER_VALIDATE_INT],
            'rta_importeipc'            => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'rta_porcentaje'            => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'rta_puntop'                => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'con_flaggarantia'          => [ 'filter' => FILTER_VALIDATE_INT],
            'rja_plazo'                 => [ 'filter' => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_contrato->loadData($parametros);
                           
        $rowdata = $luo_contrato->sp_gca_contrato($parametros['accion'], $user_codigo);
        
        echo $rowdata;
        
        break;
    
    //------listado de contrato x situacion ------------------------------------
    case 2:        
        $valida = [
            'pai_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'sta_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'criterio'   => [ 'filter' => FILTER_UNSAFE_RAW],
            'con_codigo' => [ 'filter' => FILTER_VALIDATE_INT],   
            'cda_codigo' => [ 'filter' => FILTER_VALIDATE_INT],   
            'start'      => [ 'filter' => FILTER_VALIDATE_INT],
            'page'       => [ 'filter' => FILTER_VALIDATE_INT],
            'limit'      => [ 'filter' => FILTER_VALIDATE_INT]
        ];

        $parametros = filter_var_array($Variables, $valida);
        
        $parametros['con_codigo']=validaNull($parametros['con_codigo'],0,'int');
                       
        $rowdata = $luo_contrato->lst_listar($parametros['pai_codigo'],$parametros['sta_codigo'],$parametros['cda_codigo'], $parametros['criterio'],$parametros['con_codigo'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);

        echo $rowdata;
        
        break;
    
    //-------listado de contratos por fecha de apertura ------------------------
    case 3:
        $valida = [
            'pai_codigo' => [ 'filter' => FILTER_VALIDATE_INT],
            'fecha_ini'  => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'fecha_ter'  => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'criterio'   => [ 'filter' => FILTER_UNSAFE_RAW],
            'start'      => [ 'filter' => FILTER_VALIDATE_INT],
            'page'       => [ 'filter' => FILTER_VALIDATE_INT],
            'limit'      => [ 'filter' => FILTER_VALIDATE_INT]
        ];

        $parametros = filter_var_array($Variables, $valida);
               
        $rowdata = $luo_contrato->lst_fecha_apertura($parametros['pai_codigo'],$parametros['fecha_ini'],$parametros['fecha_ter'], $parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);

        echo $rowdata;
        
        break;    
  
}

unset($luo_contrato);
unset($luo_segsesion);
