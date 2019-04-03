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
    require_once('../conta/clsgccEntidad.php');
    require_once('../conta/clsgccFormatArray.php');

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
    
    $luo_excel            = new clsExportExcel();
    $luo_entidad          = new clsgccEntidad($user_codigo);
    $luo_frmArray         = new clsgccFormatArray(); 
    
    $paramAccion = $Variables ['operacion'];
    
    $valida = [
            'ent_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
            'pai_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
            'prc_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
            'criterio'      => ['filter'    => FILTER_UNSAFE_RAW],
            'page'          => ['filter'    => FILTER_VALIDATE_INT],
            'limit'         => ['filter'    => FILTER_VALIDATE_INT]
            ];
        
    $parametros= filter_var_array($Variables,$valida);
        
    $luo_excel->Create('Entidades');
        
    $rowData = $luo_entidad->lst_listar($parametros['ent_codigo'], $parametros['pai_codigo'], $parametros['prc_codigo'], $parametros['criterio'], 1,9999999);
   
    $luo_frmArray->lstEntidad($ArrayHeader,$ArrayHeaderWith, $ArrayFormat);
  
    $luo_excel->exportar($rowData, 0, 'Entidades', $ArrayHeaderWith, $ArrayHeader, $ArrayFormat);
            
    $luo_excel->Save();
    
    unset($luo_excel);
    unset($luo_session);
    unset($luo_entidad);
    unset($luo_frmArray);
    
?>