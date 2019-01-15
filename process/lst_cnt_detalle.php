<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('../contenido/clscntDetalle.php');
require_once ('../security/clssegSession.php');

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$luo_segsesion = new clssegSession();
$user_codigo=1;
//$luo_segsesion->get_per_codigo();

if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

$paramAccion = $Variables ['operacion'];

$luo_detalle = new clscntDetalle();

switch ($paramAccion){
    case 1:
         $lstTmpFileUpload = ['bin_blob'];
         $lstStatusBlob = [];
          
        $valida = [
                'accion'            => ['filter' => FILTER_VALIDATE_INT],
                'det_codigo'        => ['filter' => FILTER_VALIDATE_INT],
                'cnt_codigo'        => ['filter' => FILTER_VALIDATE_INT],
                'det_tiponodo'      => ['filter' => FILTER_VALIDATE_INT],
                'det_fechapub'      => [ 'filter' => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
                'det_orden'         => ['filter' => FILTER_VALIDATE_INT],
                'det_parent'        => ['filter' => FILTER_VALIDATE_INT],
                'det_denominacion'  => ['filter' => FILTER_UNSAFE_RAW],
                'det_resumen'       => ['filter' => FILTER_UNSAFE_RAW],
                'det_referencia'    => ['filter' => FILTER_UNSAFE_RAW]
            ];
        
        $parametros = filter_var_array($Variables, $valida);
        
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
            
            $luo_detalle->loadData($parametros);
            
             if ( $lstStatusBlob [ 'bin_blob' ] !== null ){
                 $luo_detalle->set_bin_blob($lstStatusBlob['bin_blob']);
             }
             
            $rowdata = $luo_detalle->sp_cnt_detalle($parametros['accion'], $user_codigo);
        
            echo $rowdata;
        }
        
        catch(Exception $ex ){
            echo clsViewData::showError($Ex->getCode(), $Ex->getMessage());            
        }
        
        break;
    
    
    case 2:
        $valida=[
                    'det_codigo' => ['filter'   => FILTER_VALIDATE_INT],
                    'cnt_codigo' => ['filter'   => FILTER_VALIDATE_INT],
                    'criterio'   => ['filter'   => FILTER_UNSAFE_RAW],
                    'start'      => ['filter'   => FILTER_VALIDATE_INT],
                    'page'       => ['filter'   => FILTER_VALIDATE_INT],
                    'limit'      => ['filter'   => FILTER_VALIDATE_INT]      
            ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_detalle->lst_listar($parametros['det_codigo'], $parametros['cnt_codigo'], $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
    case 3:
        $valida=[
                'cnt_codigo'    => ['filter'    => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_detalle->lst_carpeta($parametros['cnt_codigo']);
        
        echo $rowdata;
        
        break;
    
    case 4:
        $valida=[
                'cnt_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'det_parent'    => ['filter'    => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_detalle->lst_orden($parametros['cnt_codigo'],$parametros['det_parent']);
        
        echo $rowdata;
        
        break; 
    
    case 5:
        $valida=[
                    'cnt_codigo' => ['filter'   => FILTER_VALIDATE_INT],
                    'criterio'   => ['filter'   => FILTER_UNSAFE_RAW],
                    'page'       => ['filter'   => FILTER_VALIDATE_INT],
                    'limit'      => ['filter'   => FILTER_VALIDATE_INT]      
            ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_detalle->lst_lista_nodo($parametros['cnt_codigo'], $parametros['criterio'],1,9999);
        
        echo $rowdata;
        
        break;
}

unset($luo_detalle);
unset($luo_segsesion);