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
    require_once('../traking/clstrkimportardet.php');
    require_once('../traking/clstrkFormatArray.php');

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
    $luo_impdet           = new clstrkimportardet($user_codigo);
    $luo_frmArray         = new clstrkFormatArray(); 
    
    $paramAccion = $Variables ['operacion'];
    
    $valida = [
                'imp_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'pai_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'criterio'      => ['filter'    => FILTER_UNSAFE_RAW]];
        
    $parametros = filter_var_array($Variables, $valida);
    
    try{
        
        $luo_excel->Create('Reprogramacion');
        
        $rowData = $luo_impdet->lst_listar($parametros['imp_codigo'],$parametros['pai_codigo'],$parametros['criterio'], 1, 99999999);
   
        $luo_frmArray->lstImportardet($ArrayHeader,$ArrayHeaderWith, $ArrayFormat);
  
        $luo_excel->exportar($rowData, 0, 'Reprogramacion', $ArrayHeaderWith, $ArrayHeader, $ArrayFormat);
            
        $luo_excel->Save();
    }
    catch(Exception $ex){
        
        echo 'Error -> '. $ex->getMessage();
    }
    
    unset($luo_excel);
    unset($luo_session);
    unset($luo_impdet);
    unset($luo_frmArray);
    
?>