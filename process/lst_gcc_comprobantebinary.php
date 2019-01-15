<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../conta/clsgccComprobantebinary.php');
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

$luo_binary = new clsgccComprobantebinary($user_codigo);

switch ($paramAccion){
    
    case 1:
        $lstTmpFileUpload = ['bin_blob'];
        $lstStatusBlob = [];
        
        $valida =[
                'accion'                => ['filter'    => FILTER_VALIDATE_INT],
                'cmp_codigo'            => ['filter'    => FILTER_VALIDATE_INT],                    
                'bin_codigo'            => ['filter'    => FILTER_VALIDATE_INT],
                'bin_descripcion'       => ['filter'    => FILTER_UNSAFE_RAW]
            ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        try{
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
             
                    $luo_binary->loadData($parametros);
                    
                    if ( $lstStatusBlob [ 'bin_blob' ] !== null ){                        
                        $luo_binary->set_bin_blob($lstStatusBlob [ 'bin_blob' ]);
                    }
          
                    $rowdata = $luo_binary->sp_gcc_comprobantebinary($parametros['accion']);
                
                    echo $rowdata;                    
                }                
                catch(Exception $ex){
                   echo clsViewData::showError($Ex->getCode(), $Ex->getMessage());            
                }               
        break;
    
    case 2:
        $valida = [
            'cmp_codigo'        => ['filter'    => FILTER_VALIDATE_INT]
        ];    
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_binary->lst_listar($parametros['cmp_codigo']);
        
        echo $rowdata;
        
        break;
}

unset($luo_binary);
unset($luo_segsesion);
