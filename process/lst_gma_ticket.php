<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../mda/clsgmaTicket.php');
require_once ('../security/clssegSession.php');
require_once('../Base/clsViewData.php');

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

ini_set('session.cookie_lifetime',3600);
ini_set('session.gc_maxlifetime',3600);

session_start();

$luo_segsesion = new clssegSession();
$user_codigo=$luo_segsesion->get_per_codigo();

if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

$paramAccion = $Variables ['operacion'];

$luo_tck = new clsgmaTicket($user_codigo);

switch ($paramAccion){
    
    case 1:
        $lstTmpFileUpload = ['bin_blob'];
        $lstStatusBlob = [];
          
        $valida = [
            'accion'              => ['filter' => FILTER_VALIDATE_INT],
            'tck_codigo'          => ['filter' => FILTER_VALIDATE_INT],
            'pai_codigo'          => ['filter' => FILTER_VALIDATE_INT],
            'per_codigo'          => ['filter' => FILTER_VALIDATE_INT],
            'rqe_codigo'          => ['filter' => FILTER_VALIDATE_INT],
            'tck_detalle'         => ['filter' => FILTER_UNSAFE_RAW],
            'rpe_codigo'          => ['filter' => FILTER_VALIDATE_INT], 
            'tck_emisor'          => ['filter' => FILTER_UNSAFE_RAW],
            'tck_ip'              => ['filter' => FILTER_UNSAFE_RAW],
            'rse_nivel'           => ['filter' => FILTER_VALIDATE_INT]];
        
            $parametros= filter_var_array($Variables,$valida);
            
            try{ 
              //------ revisando documento adjunto -----------------------------------
            foreach ( $lstTmpFileUpload as $Data ){
                    if ( isset ( $_FILES [ $Data ] ) && ( $_FILES [ $Data ] [ 'tmp_name' ] !== '' ) ){
                        if ( !is_uploaded_file ( $_FILES [ $Data ] [ 'tmp_name' ] ) ){
                             throw new Exception( 'Fallo al tratar de subir el archivo ' . $_FILES [ $Data ] [ 'name' ] , -10000 );
                        }
                        $lstStatusBlob [ $Data ] = $_FILES [ $Data ];
                    } else {
                        $lstStatusBlob [ $Data ] = null;
                    }
             }
             
             $parametros['tck_ip'] = $luo_segsesion->get_IPaddress();
            
             $luo_tck->loadData($parametros);    
                
             if ( $lstStatusBlob [ 'bin_blob' ] !== null ){
                      $luo_tck->set_bin_blob($lstStatusBlob['bin_blob']);                       
                    }        
         
                $rowdata = $luo_tck->sp_gma_ticket($parametros['accion']);
        
                echo $rowdata;
           }
           catch(Exception $ex){
               echo clsViewData::showError($Ex->getCode(), $Ex->getMessage());            
           }
        
        break;
     
     /*---listado de tickets quienes emiten ---*/   
    case 2:
        
        if(strlen($Variables['fechai'])>=10)        {$Variables['fechai']      = date('d/m/Y',strtotime($Variables['fechai']));}        
        if(strlen($Variables['fechat'])>=10)        {$Variables['fechat']      = date('d/m/Y',strtotime($Variables['fechat']));}
     
        $valida = [
            'tck_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'per_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'tck_estado'    => ['filter' => FILTER_VALIDATE_INT],
            'fechai'        => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'fechat'        => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'criterio'      => ['filter' => FILTER_UNSAFE_RAW],
            'tck_origen'    => ['filter' => FILTER_VALIDATE_INT],
            'page'          => ['filter' => FILTER_VALIDATE_INT],
            'limit'         => ['filter' => FILTER_VALIDATE_INT]        
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        if (!is_numeric($parametros['tck_origen'])){$parametros['tck_origen']=1;}
         
        $rowdata = $luo_tck->lst_listar($parametros['tck_codigo'],$parametros['per_codigo'],$parametros['tck_estado'],$parametros['fechai'],$parametros['fechat'], $parametros['criterio'],$parametros['tck_origen'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
     /*-------listado de tickets quienes deben resolver---------------------------*/   
    case 3:
        if(strlen($Variables['fechai'])>=10)        {$Variables['fechai']      = date('d/m/Y',strtotime($Variables['fechai']));}        
        if(strlen($Variables['fechat'])>=10)        {$Variables['fechat']      = date('d/m/Y',strtotime($Variables['fechat']));}
     
        $valida = [
            'tck_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'per_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'tck_estado'    => ['filter' => FILTER_VALIDATE_INT],
            'fechai'        => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'fechat'        => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'criterio'      => ['filter' => FILTER_UNSAFE_RAW],
            'page'          => ['filter' => FILTER_VALIDATE_INT],
            'limit'         => ['filter' => FILTER_VALIDATE_INT]        
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_tck->lst_listar_rst($parametros['tck_codigo'],$parametros['per_codigo'],$parametros['tck_estado'],$parametros['fechai'],$parametros['fechat'], $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
    // ---ticket generado desde la seleccion de un destinatario
    case 4:
        
        $lstTmpFileUpload = ['bin_blob'];
        $lstStatusBlob = [];
          
        $valida = [
            'accion'              => ['filter' => FILTER_VALIDATE_INT],
            'tck_codigo'          => ['filter' => FILTER_VALIDATE_INT],
            'pai_codigo'          => ['filter' => FILTER_VALIDATE_INT],
            'per_codigo'          => ['filter' => FILTER_VALIDATE_INT],
            'rqe_codigo'          => ['filter' => FILTER_VALIDATE_INT],
            'tck_titulo'          => ['filter' => FILTER_UNSAFE_RAW],
            'tck_detalle'         => ['filter' => FILTER_UNSAFE_RAW],
            'per_destinatario'    => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
            'tck_emisor'          => ['filter' => FILTER_UNSAFE_RAW],
            'tck_ip'              => ['filter' => FILTER_UNSAFE_RAW]];
        
            $parametros= filter_var_array($Variables,$valida);
          
           try{ 
              //------ revisando documento adjunto -----------------------------------
            foreach ( $lstTmpFileUpload as $Data ){
                    if ( isset ( $_FILES [ $Data ] ) && ( $_FILES [ $Data ] [ 'tmp_name' ] !== '' ) ){
                        if ( !is_uploaded_file ( $_FILES [ $Data ] [ 'tmp_name' ] ) ){
                             throw new Exception( 'Fallo al tratar de subir el archivo ' . $_FILES [ $Data ] [ 'name' ] , -10000 );
                        }
                        $lstStatusBlob [ $Data ] = $_FILES [ $Data ];
                    } else {
                        $lstStatusBlob [ $Data ] = null;
                    }
             }
             
             $parametros['tck_ip'] = $luo_segsesion->get_IPaddress();             
             $parametros['tck_emisor'] = $luo_segsesion->get_cta_nombre();
                       
             $luo_tck->loadData($parametros);    
                
             if ( $lstStatusBlob [ 'bin_blob' ] !== null ){
                      $luo_tck->set_bin_blob($lstStatusBlob['bin_blob']);                       
                    }        
         
              $rowdata = $luo_tck->sp_gma_message($parametros['accion']);
        
                echo $rowdata;
           }
           catch(Exception $ex){
               echo clsViewData::showError($Ex->getCode(), $Ex->getMessage());            
           }
        
        break;
    
    
        /*---listado de tickets con destinatario personalizado -------*/    
    case 5:
        
        if(strlen($Variables['fechai'])>=10)        {$Variables['fechai']      = date('d/m/Y',strtotime($Variables['fechai']));}        
        if(strlen($Variables['fechat'])>=10)        {$Variables['fechat']      = date('d/m/Y',strtotime($Variables['fechat']));}
     
        $valida = [
            'per_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'tck_estado'    => ['filter' => FILTER_VALIDATE_INT],
            'fechai'        => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'fechat'        => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'criterio'      => ['filter' => FILTER_UNSAFE_RAW],
            'page'          => ['filter' => FILTER_VALIDATE_INT],
            'limit'         => ['filter' => FILTER_VALIDATE_INT]        
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_tck->lst_listar_msg($parametros['per_codigo'],$parametros['tck_estado'],$parametros['fechai'],$parametros['fechat'], $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
        
    //-----listado de tickets por region ---------------------------------------    
    case 6:
        if(strlen($Variables['fechai'])>=10)        {$Variables['fechai']      = date('d/m/Y',strtotime($Variables['fechai']));}        
        if(strlen($Variables['fechat'])>=10)        {$Variables['fechat']      = date('d/m/Y',strtotime($Variables['fechat']));}
     
        $valida = [
            'pai_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'fechai'        => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'fechat'        => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
            'criterio'      => ['filter' => FILTER_UNSAFE_RAW],
            'page'          => ['filter' => FILTER_VALIDATE_INT],
            'limit'         => ['filter' => FILTER_VALIDATE_INT]        
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_tck->lst_listar_rge($parametros['pai_codigo'],$parametros['fechai'],$parametros['fechat'], $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
}

unset($luo_tck);
unset($luo_segsesion);

