<?php

    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);

    header('Content-type: text/html; charset=utf-8;');
    header('Cache-Control: no-cache');

    require_once('../utiles/clsExportExcel.php');
    require_once ('../security/clssegSession.php');
    require_once('../Base/clsViewData.php');
    require_once('../global/clsglbConfig.php');
    require_once('../global/clsglbFormatArray.php');
    
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
    $luo_config    = new clsglbConfig();
    $luo_frmArray = new clsglbFormatArray(); 
    
    $paramAccion = $Variables ['operacion'];
    
      $valida = [
             'pai_codigo'  => [ 'filter' => FILTER_VALIDATE_INT],
             'criterio' => [ 'filter' => FILTER_UNSAFE_RAW]
         ];
        
    $parametros = filter_var_array($Variables, $valida);
    
    $luo_excel->Create('ListadoLocales');
        
    $rowData = $luo_config->lst_listar($parametros['pai_codigo'],0,$parametros['criterio'],1, 999999);
            
    $luo_frmArray->lstConfig($ArrayHeader,$ArrayHeaderWith, $ArrayFormat);
    
    $luo_excel->exportar($rowData, 0, 'LISTADO LOCALES', $ArrayHeaderWith, $ArrayHeader, $ArrayFormat);
            
    $luo_excel->Save();
        
    unset($luo_excel);
    unset($luo_session);
    unset($luo_config);
    unset($luo_frmArray);
        
?>