<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../mda/clsgmaSeguimiento.php');
require_once ('../security/clssegSession.php');
require_once('../Base/clsViewData.php');

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

$luo_seg = new clsgmaSeguimiento($user_codigo);

switch ($paramAccion){
    
    case 1:
        
        $lstTmpFileUpload = ['bin_blob'];
       
        $lstStatusBlob = [];
        
        $valida = [
            'accion'            => ['filter' => FILTER_VALIDATE_INT],
            'tck_codigo'        => ['filter' => FILTER_VALIDATE_INT],
            'sga_observacion'   => ['filter' => FILTER_UNSAFE_RAW],
            'sga_estado'        => ['filter' => FILTER_VALIDATE_INT],
            'bin_filename'      => ['filter' => FILTER_UNSAFE_RAW],
            'tck_evaluacion'    => ['filter' => FILTER_VALIDATE_INT],
            'flag_emisor'       => ['filter' => FILTER_UNSAFE_RAW]
            ];
            
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
            
                $luo_seg->loadData($parametros);    
                
                if ( $lstStatusBlob [ 'bin_blob' ] !== null ){
                      $luo_seg->set_bin_blob($lstStatusBlob['bin_blob']);                       
                    }        
         
                $rowdata = $luo_seg->sp_gma_seguimiento($parametros['accion']);
        
                echo $rowdata;
           }
           catch(Exception $ex){
               echo clsViewData::showError($Ex->getCode(), $Ex->getMessage());            
           }
        
        break;
     
    case 2:
        
        $valida = [
            'tck_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'sga_codigo'    => ['filter' => FILTER_VALIDATE_INT],
            'criterio'      => ['filter' => FILTER_UNSAFE_RAW],
            'page'          => ['filter' => FILTER_VALIDATE_INT],
            'limit'         => ['filter' => FILTER_VALIDATE_INT]        
        ];
        
        $parametros= filter_var_array($Variables,$valida);
        
        $rowdata = $luo_seg->lst_listar($parametros['tck_codigo'], $parametros['sga_codigo'], $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
}

unset($luo_seg);

unset($luo_segsesion);

