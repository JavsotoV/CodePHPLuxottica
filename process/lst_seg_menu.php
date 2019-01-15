<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: text/html; charset=utf-8;');
header('Cache-Control: no-cache');

require_once ("../security/clssegMenu.php");
require_once ("../security/clssegSession.php");

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

session_start();

$paramAccion = $Variables['operacion'];

$luo_segsesion = new clssegSession();
$user_codigo=1;//$luo_segsesion->get_per_codigo();


if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

$luo_menu = new clssegMenu($user_codigo);

switch ($paramAccion)
{
    case 1:
        $valida=[
            'accion'                => ['filter'    => FILTER_VALIDATE_INT],
            'men_codigo'            => ['filter'    => FILTER_VALIDATE_INT],
            'seg_codigo'            => ['filter'    => FILTER_VALIDATE_INT],
            'men_tipo'              => ['filter'    => FILTER_VALIDATE_INT],
            'men_key'               => ['filter'    => FILTER_UNSAFE_RAW],
            'men_url'               => ['filter'    => FILTER_UNSAFE_RAW],
            'men_denominacion'      => ['filter'    => FILTER_UNSAFE_RAW],
            'men_descripcion'       => ['filter'    => FILTER_UNSAFE_RAW],
            'men_imagen'            => ['filter'    => FILTER_UNSAFE_RAW],
            'men_orden'             => ['filter'    => FILTER_VALIDATE_INT],
            'men_parent'            => ['filter'    => FILTER_VALIDATE_INT],
            'plt_codigo'            => ['filter'    => FILER_VALIDATE_INT],
            'men_view'              => ['fllter'    => FILTER_UNSAFE_RAW],
            'men_itemid'            => ['filter'    => FILTER_UNSAFE_RAW]
            ];
        
            $parametros= filter_var_array($Variables, $valida);
            
            $luo_menu->loadData($parametros);
            
            $rowdata = $luo_menu->sp_seg_menu($parametros['accion']);
            
            echo $rowdata;
        
            break;

    case 2:
            $valida = [
                'men_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                'seg_codigo'        => ['filter'    => FILTER_VALIDATE_INT],
                'criterio'          => ['filter'    => FILTER_UNSAFE_RAW],
                'page'              => ['filter'    => FILTER_VALIDATE_INT],
                'limit'             => ['filter'    => FILTER_VALIDATE_INT]
            ];
        
            $parametros= filter_var_array($Variables,$valida);
   
            $rowdata = $luo_menu->lst_listar($parametros['seg_codigo'], $parametros['men_codigo'], $parametros['criterio'], (($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
            
            echo $rowdata;
            
            break;    
    
    
    //------------lista de directorios que pueden ser padres segun sistema ----
    case 3:
           $valida = [
              'seg_codigo'          => ['filter'    => FILTER_VALIDATE_INT]];  
        
           $parametros = filter_var_array($Variables,$valida);
           
           $rowdata = $luo_menu->lst_carpeta($parametros['seg_codigo']);
           
           echo $rowdata;
        
           break;
     
    // ----listado de orden segun sistema y parent-----------------------------     
    case 4:
        $valida = [
            'seg_codigo'            => ['filter'    => FILTER_VALIDATE_INT],
            'men_parent'            => ['filter'    => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_menu->lst_orden($parametros['seg_codigo'], $parametros['men_parent']);
        
        echo $rowdata;
}
unset($luo_menu);
unset($luo_segsession);
