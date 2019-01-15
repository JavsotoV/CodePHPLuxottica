<?php

    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);

    header('Content-type: text/html; charset=utf-8;');
    header('Cache-Control: no-cache');

    require_once('../utiles/clsExportExcel.php');
    require_once ('../security/clssegSession.php');
    require_once('../Base/clsViewData.php');
    require_once('../rrhh/clsgrhSolgrhcb.php');
    require_once('../rrhh/clsgrhFormatArray.php');
    
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
    $luo_solgrh    = new clsgrhSolgrhcb();
    $luo_frmArray = new clsgrhFormatArray(); 
    
    $paramAccion = $Variables ['operacion'];
    
    //if(strlen($Variables['fechai'])>=10)        {$Variables['fechai']      = date('d/m/Y',strtotime($Variables['fechai']));}        
    //if(strlen($Variables['fechat'])>=10)        {$Variables['fechat']      = date('d/m/Y',strtotime($Variables['fechat']));}
         
    $valida =[
            'criterio'      => ['filter'  => FILTER_UNSAFE_RAW],
            'fechai'        => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'fechat'        => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']]
    ];
        
    $parametros = filter_var_array($Variables, $valida);
    
    $rowdata = $luo_solgrh->lst_listartot($parametros['criterio'], $parametros['fechai'], $parametros['fechat'],1,9999999);
  
    $luo_excel->Create('ReporteSolicitudes');
    
    $luo_frmArray->lstsolgrhcb($ArrayHeader,$ArrayHeaderWith, $ArrayFormat);
    
    $luo_excel->exportar($rowdata, 0, 'SOLICITUDES DESCUENTO', $ArrayHeaderWith, $ArrayHeader, $ArrayFormat);
    
    $luo_excel->Save();
        
    unset($luo_excel);
    unset($luo_session);
    unset($luo_sol);
        
        
    
?>