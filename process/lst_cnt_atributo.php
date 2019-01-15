<?php

require_once ('../contenido/clscntAtributo.php');
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

$luo_atributo = new clscntAtributo();

switch ($paramAccion){
    
    case 1:
        $rowdata = $luo_atributo->lst_tiponodo();
        
        echo $rowdata;
        
        break;
}

unset($luo_atributo);
unset($luo_segsesion);