<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../logistica/clsmtaCatalogo.php');
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

$luo_catalogo = new clsmtaCatalogo();

switch ($paramAccion){
    case 1:    
         
        $Variables['ivacb']                 = str_replace(",",".",$Variables['ivacb']);
        $Variables['priprov']               = str_replace(",",".",$Variables['priprov']);
        $Variables['stock_minimo']          = str_replace(",",".",$Variables['stock_minimo']);
        $Variables['cri_diametroini']       = str_replace(",",".",$Variables['cri_diametroini']);
        $Variables['cri_diametrofin']       = str_replace(",",".",$Variables['cri_diametrofin']);
        $Variables['cri_cilindroini']       = str_replace(",",".",$Variables['cri_cilindroini']);
        $Variables['cri_cilindrofin']       = str_replace(",",".",$Variables['cri_cilindrofin']);
        $Variables['cri_esferaini']         = str_replace(",",".",$Variables['cri_esferaini']);
        $Variables['cri_esferafin']         = str_replace(",",".",$Variables['cri_esferafin']);
        $Variables['gfa_diagonal']          = str_replace(",",".",$Variables['gfa_diagonal']);
        $Variables['gfa_horizontal']        = str_replace(",",".",$Variables['gfa_horizontal']);
        $Variables['gfa_altura']            = str_replace(",",".",$Variables['gfa_altura']);
        $Variables['gfa_curvabase']         = str_replace(",",".",$Variables['gfa_curvabase']);
        $Variables['gfa_puente']            = str_replace(",",".",$Variables['gfa_puente']);
        $Variables['gfa_largovarilla']      = str_replace(",",".",$Variables['gfa_largovarilla']);
        $Variables['len_zonaop']            = str_replace(",",".",$Variables['len_zonaop']);
        $Variables['len_eje']               = str_replace(",",".",$Variables['len_eje']);
        $Variables['len_radi']              = str_replace(",",".",$Variables['len_radi']);
        $Variables['len_diametro']          = str_replace(",",".",$Variables['len_diametro']);
        $Variables['len_esfera']            = str_replace(",",".",$Variables['len_esfera']);
        $Variables['len_cilindro']          = str_replace(",",".",$Variables['len_cilindro']);
        $Variables['len_curvabase']         = str_replace(",",".",$Variables['len_curvabase']);
        $Variables['len_esferah']           = str_replace(",",".",$Variables['len_esferah']);
        $Variables['mon_altura']            = str_replace(",",".",$Variables['mon_altura']);
        $Variables['mon_calibre']           = str_replace(",",".",$Variables['mon_calibre']);
        $Variables['mon_puente']            = str_replace(",",".",$Variables['mon_puente']);
        $Variables['mon_diagonal']          = str_replace(",",".",$Variables['mon_diagonal']);
        $Variables['mon_horizontal']        = str_replace(",",".",$Variables['mon_horizontal']);
        $Variables['mon_curvabase']         = str_replace(",",".",$Variables['mon_curvabase']);
        $Variables['mon_largovarilla']      = str_replace(",",".",$Variables['mon_largovarilla']);
        
        
        $valida = [
                'accion'            => ['filter'        => FILTER_VALIDATE_INT],
                'cta_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
                'pai_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
                'cdg'               => ['filter'        => FILTER_UNSAFE_RAW],
                'codigobarras'      => ['filter'        => FILTER_UNSAFE_RAW],
                'codsap'            => ['filter'        => FILTER_UNSAFE_RAW],
                'descripcion'       => ['filter'        => FILTER_UNSAFE_RAW],
                'descatalogado'     => ['filter'        => FILTER_UNSAFE_RAW],
                'tipfamcod'         => ['filter'        => FILTER_UNSAFE_RAW],
                'gfa_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
                'alias'             => ['filter'        => FILTER_UNSAFE_RAW],
                'ivacb'             => ['filter'        => FILTER_VALIDATE_FLOAT],
                'priprov'           => ['filter'        => FILTER_VALIDATE_FLOAT],
                'nomcom'            => ['filter'        => FILTER_UNSAFE_RAW],
                'inventariar'       => ['filter'        => FILTER_UNSAFE_RAW],
                'stock_minimo'      => ['filter'        => FILTER_VALIDATE_FLOAT],
                'liquidacion'       => ['filter'        => FILTER_UNSAFE_RAW],
                'etiquetar'         => ['filter'        => FILTER_UNSAFE_RAW],
                'col_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
                'cri_diametroini'   => ['filter'        => FILTER_VALIDATE_FLOAT],
                'cri_diametrofin'   => ['filter'        => FILTER_VALIDATE_FLOAT],    
                'cri_cilindroini'   => ['filter'        => FILTER_VALIDATE_FLOAT],
                'cri_cilindrofin'   => ['filter'        => FILTER_VALIDATE_FLOAT],                
                'cri_esferaini'     => ['filter'        => FILTER_VALIDATE_FLOAT],
                'cri_esferafin'     => ['filter'        => FILTER_VALIDATE_FLOAT],
                'col_codigoc'       => ['filter'        => FILTER_VALIDATE_INT],
                'col_codigom'       => ['filter'        => FILTER_VALIDATE_INT],
                'mta_codigo'        => ['filter'        => FILTER_VALIDATE_INT],
                'gfa_graduable'     => ['filter'        => FILTER_UNSAFE_RAW],
                'gfa_cristal'       => ['filter'        => FILTER_UNSAFE_RAW],
                'gfa_sexo'          => ['filter'        => FILTER_UNSAFE_RAW],
                'gfa_diagonal'      => ['filter'        => FILTER_VALIDATE_FLOAT],
                'gfa_horizontal'    => ['filter'        => FILTER_VALIDATE_FLOAT],    
                'gfa_altura'        => ['filter'        => FILTER_VALIDATE_FLOAT],
                'gfa_curvabase'     => ['filter'        => FILTER_VALIDATE_FLOAT],
                'gfa_puente'        => ['filter'        => FILTER_VALIDATE_FLOAT],
                'gfa_largovarilla'  => ['filter'        => FILTER_VALIDATE_FLOAT],
                'gfa_polarized'     => ['filter'        => FILTER_UNSAFE_RAW],
                'len_marca'         => ['filter'        => FILTER_UNSAFE_RAW],
                'len_zonaop'        => ['filter'        => FILTER_VALIDATE_FLOAT],
                'len_eje'           => ['filter'        => FILTER_VALIDATE_FLOAT],
                'len_radi'          => ['filter'        => FILTER_VALIDATE_FLOAT],
                'len_diametro'      => ['filter'        => FILTER_VALIDATE_FLOAT],
                'len_esfera'        => ['filter'        => FILTER_VALIDATE_FLOAT],
                'len_cilindro'      => ['filter'        => FILTER_VALIDATE_FLOAT],
                'len_curvabase'     => ['filter'        => FILTER_VALIDATE_FLOAT],
                'len_esferah'       => ['filter'        => FILTER_VALIDATE_FLOAT],    
                'mon_altura'        => ['filter'        => FILTER_VALIDATE_FLOAT],
                'mon_calibre'       => ['filter'        => FILTER_VALIDATE_FLOAT],
                'mon_puente'        => ['filter'        => FILTER_VALIDATE_FLOAT],    
                'mon_diagonal'      => ['filter'        => FILTER_VALIDATE_FLOAT],
                'mon_horizontal'    => ['filter'        => FILTER_VALIDATE_FLOAT],
                'mon_curvabase'     => ['filter'        => FILTER_VALIDATE_FLOAT],
                'mon_largovarilla'  => ['filter'        => FILTER_VALIDATE_FLOAT]
        ];
        
        $parametros = filter_var_array($Variables, $valida);
        
        $luo_catalogo->loadData($parametros);
        
        $rowdata = $luo_catalogo->sp_mta_catalogo($parametros['accion']);
        
        echo $rowdata;
        
        break;
    
    case 2:
        $valida=[
                'pai_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'tipfamcod'     => ['filter'    => FILTER_UNSAFE_RAW],
                'fam_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'sfa_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'gfa_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'criterio'      => ['filter'    => FILTER_UNSAFE_RAM],
                'esf_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'cil_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'descatalogado' => ['filter'    => FILTER_UNSAFE_RAM],
                'page'          => ['filter'    => FILTER_VALIDATE_INT],
                'limit'         => ['filter'    => FILTER_VALIDATE_INT]];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_catalogo->lst_listar($parametros['pai_codigo'],$parametros['tipfamcod'],$parametros['fam_codigo'],$parametros['sfa_codigo'],$parametros['gfa_codigo'], $parametros['criterio'],$parametros['esf_codigo'],$parametros['cil_codigo'],$parametros['descatalogado'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
    
    //---atributos de articulo
    case 3:
        $valida = [
            'cta_codigo'        => ['filter'    => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_catalogo->lst_catalogoatributo($parametros['cta_codigo']);
        
        echo $rowdata;
        
        break;
    
    case 4:
        
        $valida = [
            'cta_codigo'            => ['filter'    => FILTER_VALIDATE_INT]
        ];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_catalogo->lst_catalogoxid($parametros['cta_codigo']);
        
        echo $rowdata;
        
        break;
    
    case 5:          
        $valida=[
                'pai_codigo'    => ['filter'    => FILTER_VALIDATE_INT],
                'criterio'      => ['filter'    => FILTER_UNSAFE_RAM],
                'page'          => ['filter'    => FILTER_VALIDATE_INT],
                'limit'         => ['filter'    => FILTER_VALIDATE_INT]];
        
        $parametros = filter_var_array($Variables,$valida);
        
        $rowdata = $luo_catalogo->lst_devolucion($parametros['pai_codigo'],$parametros['criterio'],(($parametros['page'] -1) * $parametros['limit']) , $parametros['limit']);
        
        echo $rowdata;
        
        break;
}

unset($luo_catalogo);
unset($luo_segsesion);
