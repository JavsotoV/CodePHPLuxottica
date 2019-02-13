<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//header('Content-type: text/html; charset=utf-8;');
//header('Cache-Control: no-cache');

require_once ("../legal/clsgcaBinary.php");
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

$luo_binary = new clsgcaBinary();

switch ($paramAccion){
    case 1:
          $lstTmpFileUpload = ['bin_blob'];
          $lstStatusBlob = [];
          $ln_bandera=1;
        
          $valida=['accion'         =>['filter'=>FILTER_VALIDATE_INT],
                 'con_codigo'       =>['filter'=>FILTER_VALIDATE_INT],
                 'bin_codigo'       =>['filter'=>FILTER_VALIDATE_INT],
                 'bin_descripcion'  =>['filter'=>FILTER_UNSAFE_RAW]   
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
            
            $luo_binary->loadData($parametros);    
                
            if ( $lstStatusBlob [ 'bin_blob' ] !== null ){                  
                 
                $luo_binary->set_bin_blob($lstStatusBlob['bin_blob']);
                
                $ln_bandera=$luo_binary->get_bin_bandera();                    
            }
            
            if ($ln_bandera==1){
              
                    $rowdata = $luo_binary->sp_gca_binary($parametros['accion'], $user_codigo);
        
            echo $rowdata;}
            else {
                echo clsViewData::showError(-1,'Error cargando en memoria archivo seleccionado');            
            }
        }
        catch(Exception $ex ){
            echo clsViewData::showError($Ex->getCode(), $Ex->getMessage());            
        }
        
        break;
        
    
    case 2:
         $valida=['con_codigo'       =>['filter'=>FILTER_VALIDATE_INT]];
        
         $parametros = filter_var_array($Variables, $valida);
        
         $rowdata = $luo_binary->lst_listar($parametros['con_codigo']);

         echo $rowdata;
         
         break;
}

unset($luo_binary);
unset($luo_segsesion);

