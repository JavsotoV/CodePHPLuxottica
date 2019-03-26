<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../conta/clsgccLiquidaciondocumento.php');
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

$luo_liqui = new clsgccLiquidaciondocumento($user_codigo);

switch ($paramAccion){
    
    case 1:
        $lstTmpFileUpload = ['bin_blob'];
        $lstStatusBlob = [];
        
        $Variables ['cmp_tipocambio'] = str_replace(",",".",$Variables ['cmp_tipocambio']);
        $Variables ['cmp_venta'] = str_replace(",",".",$Variables ['cmp_venta']);
        $Variables ['imp_porcentaje'] = str_replace(",",".",$Variables ['imp_porcentaje']);
        $Variables ['cmp_impuesto'] = str_replace(",",".",$Variables ['cmp_impuesto']);
        $Variables ['cmp_impnogravado'] = str_replace(",",".",$Variables ['cmp_impnogravado']);
        $Variables ['cmp_importe'] = str_replace(",",".",$Variables ['cmp_importe']);
        $Variables ['trb_porcentaje'] = str_replace(",",".",$Variables ['trb_porcentaje']);
        $Variables ['trb_importe'] = str_replace(",",".",$Variables ['trb_importe']);
        
        $valida= [   'accion'           => ['filter'    => FILTER_VALIDATE_INT],
                    'cmp_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                    'ent_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                    'pai_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                    'per_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                    'cmp_fecha'         => ['filter'    => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']],
                    'tpc_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                    'cmp_serie'         => ['filter'    => FILTER_UNSAFE_RAW],
                    'cmp_numero'        => ['filter'    => FILTER_UNSAFE_RAW],
                    'cmp_fechaven'      => ['filter'    => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']], 
                    'mon_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                    'cmp_tipocambio'    => ['filter'    => FILTER_VALIDATE_FLOAT],    
                    'cmp_venta'         => ['filter'    => FILTER_VALIDATE_FLOAT],    
                    'imp_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                    'imp_porcentaje'    => ['filter'    => FILTER_VALIDATE_FLOAT],         
                    'cmp_impuesto'      => ['filter'    => FILTER_VALIDATE_FLOAT],    
                    'cmp_impnogravado'  => ['filter'    => FILTER_VALIDATE_FLOAT],    
                    'cmp_importe'       => ['filter'    => FILTER_VALIDATE_FLOAT],    
                    'cmp_uuid'          => ['filter'    => FILTER_UNSAFE_RAW],    
                    'trb_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                    'trb_porcentaje'    => ['filter'    => FILTER_VALIDATE_FLOAT],    
                    'trb_importe'       => ['filter'    => FILTER_VALIDATE_FLOAT],    
                    'lqd_codigo'        => ['filter'    => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
                    'cpt_codigo'        => ['filter'    => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
                    'lqd_observacion'   => ['filter'    => FILTER_UNSAFE_RAW, 'flags' => FILTER_REQUIRE_ARRAY],
                    'lqd_importe'       => ['filter'    => FILTER_VALIDATE_FLOAT, 'flags' => FILTER_REQUIRE_ARRAY],
                    'lqd_afectoimp'     => ['filter'    => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
                    'lqd_estado'        => ['filter'    => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY]
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
             
                    $luo_liqui->loadData($parametros);
                    
                    if ( $lstStatusBlob [ 'bin_blob' ] !== null ){                        
                        $luo_liqui->set_bin_blob($lstStatusBlob [ 'bin_blob' ]);
                    }
          
                    $rowdata = $luo_liqui->sp_gcc_liquidacion($parametros['accion']);
                
                    echo $rowdata;
                }                
                catch(Exception $ex){
                   echo clsViewData::showError($Ex->getCode(), $Ex->getMessage());            
                }
                break;    
    
    case 2:
        $valida = [ 'cmp_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                    'ent_codigo'     => ['filter'    => FILTER_VALIDATE_INT],                    
                    'criterio'      => ['filter'    => FILTER_UNSAFE_RAW],
                    'page'          => ['filter'    => FILTER_VALIDATE_INT],
                    'limit'         => ['filter'    => FILTER_VALIDATE_INT]
            ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_liqui->lst_listar($parametros['cmp_codigo'],$parametros['ent_codigo'], $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
}

unset($luo_liqui);
unset($luo_segsesion);