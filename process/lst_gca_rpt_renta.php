<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../legal/clsgcaRpt.php");
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

$luo_rpt = new clsgcaRpt();

switch ($paramAccion){

    case 1:
        
        if(strlen($Variables['rta_fechai'])>=10)    {$Variables['rta_fechai'] = date('d/m/Y',strtotime($Variables['rta_fechai']));}
        if(strlen($Variables['rta_fechat'])>=10)    {$Variables['rta_fechat'] = date('d/m/Y',strtotime($Variables['rta_fechat']));}

        $Variables['tipocambiolocal']=str_replace(",",".",$Variables['tipocambiolocal']);
        $Variables['tipocambiodolar']=str_replace(",",".",$Variables['tipocambiodolar']);
        $Variables['tipocambioeuro']=str_replace(",",".",$Variables['tipocambioeuro']);
        
        $valida=[
            'pai_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'dpt_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'prv_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'ubg_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'imb_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'cna_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'cda_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'sta_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'rta_fechai'                => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'rta_fechat'                => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'mon_conversion'            => [ 'filter' => FILTER_VALIDATE_INT],
            'tipocambiolocal'           => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'tipocambiodolar'           => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'tipocambioeuro'            => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'page'                      => [ 'filter' => FILTER_VALIDATE_INT],
            'limit'                     => [ 'filter' => FILTER_VALIDATE_INT]
        ];    
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_rpt->loadData($parametros);  
        
        $rowdata = $luo_rpt->lst_listarenta((($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
    //-----------exportar a excel ----------------------------------------------
    case 2:
          
        if(strlen($Variables['rta_fechai'])>=10)    {$Variables['rta_fechai'] = date_format(date_create($Variables['rta_fechai']),'d/m/Y');}
        if(strlen($Variables['rta_fechat'])>=10)    {$Variables['rta_fechat'] = date_format(date_create($Variables['rta_fechat']),'d/m/Y');}
        
        $Variables['tipocambiolocal']=str_replace(",",".",$Variables['tipocambiolocal']);
        $Variables['tipocambiodolar']=str_replace(",",".",$Variables['tipocambiodolar']);
        $Variables['tipocambioeuro']=str_replace(",",".",$Variables['tipocambioeuro']);
        
        $valida=[
            'pai_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'dpt_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'prv_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'ubg_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'imb_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'cna_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'cda_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'sta_codigo'                => [ 'filter' => FILTER_VALIDATE_INT],
            'rta_fechai'                => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'rta_fechat'                => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'mon_conversion'            => [ 'filter' => FILTER_VALIDATE_INT],
            'tipocambiolocal'           => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'tipocambiodolar'           => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'tipocambioeuro'            => [ 'filter' => FILTER_VALIDATE_FLOAT],
            'page'                      => [ 'filter' => FILTER_VALIDATE_INT],
            'limit'                     => [ 'filter' => FILTER_VALIDATE_INT]
        ];    
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_rpt->loadData($parametros);
        
        $rowdata = $luo_rpt->lst_listarenta(1 ,999999);
        
        $ArrayHeader=Array( 'con_nroregistro'			=> 'NRO. REGISTRO',
                            'con_codgestion'			=> 'GESTION',
                            'ctr_codinterno'                    => 'CECCO',                            
                            'tda_descripcion'			=> 'LOCAL',
                            'con_direccion'			=> 'DIRECCION',
                            'ubg_denominacion'			=> 'DISTRITO / COMUNA',
                            'imb_descripcion'			=> 'GRUPO INMOBILIARIO',
                            'cna_descripcion'			=> 'CANAL',
                            'con_fechaper'			=> 'FECHA APERTURA',                            
                            'con_fechafirma'			=> 'FECHA FIRMA',
                            'con_fechai'			=> 'FECHA INICIO',
                            'con_fechat'			=> 'FEC. VENCIMIENTO',
                            'con_area'				=> 'AREA',
                            'gra_tipodescripcion'		=> 'TIPO GARANTIA',
                            'rta_moneda'			=> 'MONEDA MT2',
                            'con_valormetro'			=> 'VALOR METRO 2',                            
                            'gra_moneda'			=> 'MONEDA GARANTIA',
                            'gra_importe'			=> 'GARANTIA IMPORTE',
                            'rta_fechai'                        => 'FEC.INI.RTA.MIN',    
                            'rta_fechat'                        => 'FEC.TER.RTA.MIN',    
                            'rta_importeipc'			=> 'RENTA MINIMA',
                            'rta_porcentaje'			=> 'RENTA VARIABLE',
                            'des_flagrentadiciembre'            => 'RTA. DICIEMBRE',
                            'con_imprentadiciembre'             => 'IMP. RTA. DICIEMBRE',   
                            'gto_tipodescripcion'		=> 'TIPO GASTO COMUN',
                            'gto_moneda'			=> 'MONEDA GASTO COMUN',
                            'gto_importe'			=> 'IMPORTE GASTO COMUN',
                            'des_flagclausalida'		=> 'CLAUSULA SALIDA',
                            'con_plazominsalida'                => 'PLAZO CLAUSULA SALIDA',
                            'des_flagrenovacionaut'             => 'RENOV. AUT.',  
                            'con_plazorenovacionaut'            => 'PLAZO RENOV. AUT',
                            'des_undplazorenovacionaut'         => 'TIEMPO',    
                            'con_plazominrenov'                 => 'PLAZO MIN. RENOV.',
                            'con_observacion'			=> 'OBSERVACION');
        
        $ArrayHeaderWith=Array(10,10,10,120,120,30,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,200);
        
        $ArrayFormat=Array('con_fechaper'    => 'dd/mm/yyyy',   
                           'con_fechai'      => 'dd/mm/yyyy',
                           'con_fechafirma'  => 'dd/mm/yyyy',
                           'con_fechat'      => 'dd/mm/yyyy', 
                           'rta_fechai'      => 'dd/mm/yyyy',
                           'rta_fechat'      => 'dd/mm/yyyy', 
                           'con_area'        => '#,##0.00',
                           'con_valormetro'  => '#,##0.00',
                           'gra_importe'     => '#,##0.00',
                           'rta_importeipc'  => '#,##0.00',
                           'rta_porcentaje'  => '#,##0.00',
                           'con_imprentadiciembre'  => '#,##0.00',
                           'gto_importe'            => '#,##0.00');
       
        $luo_exportExcel = new clsgcaExportExcel();
         
        $luo_exportExcel->exportar($rowdata, 'REPORTE RENTA MINIMA', 'reporterentaminima',$ArrayHeaderWith,$ArrayHeader,$ArrayFormat);
        
        break;
}

unset($luo_rpt);
unset($luo_segsesion);