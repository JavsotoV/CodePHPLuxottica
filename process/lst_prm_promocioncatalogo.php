<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../promocion/clsprmPromocionCatalogo.php');
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

$luo_promcat = new clsprmPromocionCatalogo($user_codigo);


switch ($paramAccion){
    case 1:
        $valida = [
            'accion'        =>    ['filter'   => FILTER_VALIDATE_INT],  
            'prm_codigo'     =>   ['filter'   => FILTER_VALIDATE_INT],
            'prd_codigo'     =>   ['filter'   => FILTER_VALIDATE_INT],
            'prc_codigo'     =>   ['filter'   => FILTER_VALIDATE_INT],
            'plt_codigo'     =>   ['filter'   => FILTER_VALIDATE_INT],
            'pld_codigo'     =>   ['filter'   => FILTER_VALIDATE_INT],
            'pca_codigo'     =>   ['filter'   => FILTER_VALIDATE_INT],
            'fam_codigo'     =>   ['filter'   => FILTER_VALIDATE_INT],
            'sfa_codigo'     =>   ['filter'   => FILTER_VALIDATE_INT],
            'gfa_codigo'     =>   ['filter'   => FILTER_VALIDATE_INT],
            'cta_codigo'     =>   ['filter'   => FILTER_VALIDATE_INT]];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_promcat->loadData($parametros);
        
        $rowdata = $luo_promcat->sp_prm_promocioncatalogo($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    case 2:
        $valida = [
            'prm_codigo'     =>   ['filter'   => FILTER_VALIDATE_INT]];
            
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_promcat->lst_listar($parametros['prm_codigo']);
        
        echo $rowdata;
        
        break;
}

unset($luo_promcat);
unset($luo_segsession);