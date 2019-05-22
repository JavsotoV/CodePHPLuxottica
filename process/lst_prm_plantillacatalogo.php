<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../promocion/clsprmPlantillaCatalogo.php');
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

$luo_plc = new clsprmPlantillaCatalogo($user_codigo);

switch ($paramAccion){
    case 1:
        $valida = [
                    'accion'            => ['filter'        => FILTER_VALIDATE_INT],
                    'plt_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
                    'pld_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
                    'pca_codigo'        => ['filter'        => FILTER_VALIDATE_INT,   'flags' => FILTER_REQUIRE_ARRAY] ,
                    'pca_origen'        => ['filter'        => FILTER_VALIDATE_INT],
                    'pca_paquete'       => ['filter'        => FILTER_VALIDATE_INT],
                    'tipfamcod'         => ['filter'        => FILTER_UNSAFE_RAW,   'flags' => FILTER_REQUIRE_ARRAY],
                    'fam_codigo'        => ['filter'        => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],        
                    'sfa_codigo'        => ['filter'        => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
                    'gfa_codigo'        => ['filter'        => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY],
                    'pca_operador'      => ['filter'        => FILTER_VALIDATE_INT],
                    'trf_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
                    'pca_estado'        => ['filter'        => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY]
        ];
     
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_plc->loadData($parametros);
                
        $rowdata = $luo_plc->sp_prm_plantillacatalogo($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    case 2:
        $valida = [
            'plt_codigo'            => ['filter'        => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_plc->lst_listar($parametros['plt_codigo']);
        
        echo $rowdata;
        
        break;
    
    case 3:
        
        $valida = [
            'plt_codigo'            => ['filter'        => FILTER_VALIDATE_INT],
            'pld_codigo'            => ['filter'        => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_plc->lst_grupo($parametros['plt_codigo'],$parametros['pld_codigo']);
        
        echo $rowdata;
        
        break;
}

unset($luo_plc);
unset($luo_segsesion);