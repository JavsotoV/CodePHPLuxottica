<?php

require_once ('../convenio/clscnvRegistro.php');
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

$luo_reg = new clscnvRegistro();

switch ($paramAccion){
    case 1:
         break;
    
    case 2:
        $valida = [
            'reg_codigo'    => ['filter' => FILTER_VALIDANTE_INT],
            'criterio'      => ['filter' => FILTER_UNSAFE_RAW],
            'start'         => [ 'filter' => FILTER_VALIDATE_INT],
            'page'          => [ 'filter' => FILTER_VALIDATE_INT],
            'limit'         => [ 'filter' => FILTER_VALIDATE_INT]  
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_reg->lst_listar($parametros['reg_codigo'], $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
}

unset($luo_reg);
unset($luo_session);