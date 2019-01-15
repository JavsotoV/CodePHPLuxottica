<?php

require_once ('../contenido/clscntContenido.php');
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

$luo_cnt = new clscntContenido();

switch ($paramAccion){
    case 1:
         $valida = [
            'accion'                => [ 'filter' => FILTER_VALIDATE_INT],
            'cnt_codigo'            => [ 'filter' => FILTER_VALIDATE_INT],
            'cnt_denominacion'      => [ 'filter' => FILTER_UNSAFE_RAW],
            'cnt_icono'             => [ 'filter' => FILTER_UNSAFE_RAW],
            'pai_codigo'            => [ 'filter' => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
   
        $luo_cnt->loadData($parametros);
        
        $rowdata = $luo_cnt->sp_cnt_contenido($parametros['accion'], $user_codigo);
        
        echo $rowdata;
        
        break;
    
    case 2:
        $valida = [
            'cnt_codigo'    => ['filter' => FILTER_VALIDANTE_INT],
            'criterio'      => ['filter' => FILTER_UNSAFE_RAW],
            'start'         => [ 'filter' => FILTER_VALIDATE_INT],
            'page'          => [ 'filter' => FILTER_VALIDATE_INT],
            'limit'         => [ 'filter' => FILTER_VALIDATE_INT]  
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_cnt->lst_listar($parametros['cnt_codigo'], $parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
    case 3:
        $valida = [
            'pai_codigo'    => ['filter' => FILTER_VALIDATE_INT]  
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $rowdata = $luo_cnt->lst_contenidoregion($parametros['pai_codigo']);
        
        echo $rowdata;
        
        break;
}

unset($luo_cnt);
unset($luo_session);