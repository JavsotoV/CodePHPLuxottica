<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);

    header('Content-type: text/html; charset=utf-8;');
    header('Cache-Control: no-cache');

    require_once('../utiles/clsExportExcel.php');
    require_once ('../security/clssegSession.php');
    require_once('../Base/clsViewData.php');
    require_once('../logistica/clsmtaRegistrodet.php');
    require_once('../logistica/clsmtaFormatArray.php');

    if (isset($_POST) && ( count($_POST) )) {
        $Variables = filter_input_array(INPUT_POST);
        } else {
        $Variables = filter_input_array(INPUT_GET);
    }

    session_start();
    
    $luo_session = new clssegSession();
    
    $user_codigo=$luo_session->get_per_codigo();
    
    if (!isset($user_codigo))  {
    
        echo clsViewData::showError('-1', 'Sesion de usuario a terminado ');
    
        return;
    }    
    
    $luo_excel    = new clsExportExcel();
    $luo_regdet    = new clsmtaRegistrodet();
    $luo_frmArray = new clsmtaFormatArray(); 
    
    $paramAccion = $Variables ['operacion'];
    
      $valida = [
             'ctr_codigo'  => [ 'filter' => FILTER_VALIDATE_INT],
             'pai_codigo'  => [ 'filter' => FILTER_VALIDATE_INT],
             'criterio'    => [ 'filter' => FILTER_UNSAFE_RAW]
          ];
        
    $parametros = filter_var_array($Variables, $valida);
    
    $luo_excel->Create('ListaProductoRegion');
        
    $rowData = $luo_regdet->lst_rgdpais($parametros['ctr_codigo'], $parametros['pai_codigo'], $parametros['criterio'], 1, 99999);
            
    $luo_frmArray->lstRegistrodet($ArrayHeader,$ArrayHeaderWith, $ArrayFormat);
    
    $luo_excel->exportar($rowData, 0, 'LISTADO PRODUCTOS', $ArrayHeaderWith, $ArrayHeader, $ArrayFormat);
            
    $luo_excel->Save();
        
    unset($luo_excel);
    unset($luo_session);
    unset($luo_regdet);
    unset($luo_frmArray);
        
?>