<?php

    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);

    header('Content-type: text/html; charset=utf-8;');
    header('Cache-Control: no-cache');

    require_once('../utiles/clsExportExcel.php');
    require_once ('../security/clssegSession.php');
    require_once('../Base/clsViewData.php');
    require_once('../legal/clsgcaMacro.php');
    require_once('../legal/clsgcaFormatArray.php');
    
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
    $luo_macro    = new clsgcaMacro();
    $luo_frmArray = new clsgcaFormatArray(); 
    
    $paramAccion = $Variables ['operacion'];
    
     
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
    
    $luo_excel->Create('ReporteMacro');
    
    if (!$luo_macro->lst_conexion()){ return;}
        
    switch ($paramAccion){
        
        case 1:
            //---------contratos -------------------------------------------------- 
            $rowData = $luo_macro->lst_recordSet(1, 1,99999);  
            
            $luo_frmArray->lstContrato($ArrayHeader,$ArrayHeaderWith, $ArrayFormat);
            
            $memoria= memory_get_usage();
             
            $luo_excel->exportar($rowData, 0, 'CONTRATOS ', $ArrayHeaderWith, $ArrayHeader, $ArrayFormat);
            
            $rowData = $luo_macro->lst_recordSet(3, 1,99999); 
            
            $luo_macro->lst_desconexion();
         
            $luo_frmArray->lstRenta($ArrayHeader, $ArrayHeaderWith, $ArrayFormat);
        
            $memoria= memory_get_usage();
            
            $luo_excel->exportar($rowData, 1, 'RENTA FIJA Y VARIABLE ', $ArrayHeaderWith, $ArrayHeader, $ArrayFormat);
        
            break;     
        }
        
        $luo_excel->Save();
        
        unset($luo_excel);
        unset($luo_session);
        unset($luo_macro);      
        
    
?>