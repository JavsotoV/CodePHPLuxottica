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
    require_once('../logistica/clsmtaCatalogo.php');
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
    
    $luo_excel            = new clsExportExcel();
    $luo_catalogo         = new clsmtaCatalogo($user_codigo);
    $luo_frmArray         = new clsmtaFormatArray(); 
    
    $paramAccion = $Variables ['operacion'];
    
    $valida = [
                'pai_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'tipfamcod'     => ['filter'    => FILTER_UNSAFE_RAW],
                'fam_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'sfa_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'gfa_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'criterio'      => ['filter'    => FILTER_UNSAFE_RAM],
                'esf_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'cil_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'descatalogado' => ['filter'    => FILTER_UNSAFE_RAM]];
        
    $parametros = filter_var_array($Variables, $valida);
    
    try{
        
        $luo_excel->Create('CatalogoRegion');
        
        $rowData = $luo_catalogo->lst_listar($parametros['pai_codigo'],$parametros['tipfamcod'],$parametros['fam_codigo'],$parametros['sfa_codigo'],$parametros['gfa_codigo'], $parametros['criterio'],$parametros['esf_codigo'],$parametros['cil_codigo'],$parametros['descatalogado'], 1, 99999999);
   
        $luo_frmArray->lstCatalogo($ArrayHeader,$ArrayHeaderWith, $ArrayFormat);
  
        $luo_excel->exportar($rowData, 0, 'Catalogo x Region', $ArrayHeaderWith, $ArrayHeader, $ArrayFormat);
            
        $luo_excel->Save();
    }
    catch(Exception $ex){
        
        echo 'Error -> '. $ex->getMessage();
    }
    
    unset($luo_excel);
    unset($luo_session);
    unset($luo_catalogo);
    unset($luo_frmArray);
    
?>