<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('../conta/clsctbTipocomprobanteimp.php');
require_once ('../security/clssegSession.php');

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$luo_segsesion = new clssegSession();
$user_codigo=1;

if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

$paramAccion = $Variables ['operacion'];

$luo_imp = new clsctbTipocomprobanteimp();

switch ($paramAccion){
    
    case 1:
        break;
    
    case 2:
       
        if(strlen($Variables['cmp_fecha'])>=10)      {$Variables['cmp_fecha']    = date('d/m/Y',strtotime($Variables['cmp_fecha']));}
        
        $valida = [
            'pai_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
            'tpc_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
            'cmp_fecha'         => ['filter'    => FILTER_VALIDATE_REGEXP, 'options' => [ 'regexp' => '/^(\d){2}.(\d){2}.(\d){4}$/']]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
             
        $rowdata = $luo_imp->lst_impuesto($parametros['pai_codigo'], $parametros['tpc_codigo'], $parametros['cmp_fecha']);
        
        echo $rowdata;
        
        break;
        
}
unset($luo_imp);
unset($luo_segsesion);
