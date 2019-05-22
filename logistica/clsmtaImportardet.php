<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsmtaImportardet
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsmtaImportardet {
    //put your code here
    private $_imp_codigo;
    private $_imd_codigo;        
    private $_cdg;
    private $_codigobarras;
    private $_codsap;
    private $_descripcion;
    private $_familia;
    private $_subfam;
    private $_grupofam;
    private $_descatalogado;
    private $_alias;
    private $_colores;
    private $_indref;
    private $_material;
    private $_tipoarti;
    private $_desdediametro;
    private $_hastadiametro;
    private $_desdecilindro;
    private $_hastacilindro;
    private $_desdeesfera;
    private $_hastaesfera;
    private $_altura;
    private $_calibre;
    private $_puente;
    private $_curvabase;
    private $_largovarilla;
    private $_polarized;
    private $_diagonal;
    private $_horizontal;
    private $_colorc;
    private $_colorm;
    private $_graduable;
    private $_sexo;
    private $_marca;
    private $_zonaop;
    private $_eje;
    private $_radio;
    private $_diametro;
    private $_cilindro;
    private $_esfera;
    private $_esferah;
    private $_estilo;
    private $_cristal;
    private $_aplica;
    private $_tarifa;
    private $_precioiva;
    private $_imp_usuario;
    
    function __construct($an_imp_usuario) {
        $this->_imp_usuario=$an_imp_usuario;   
        $this->_indref=0;
        $this->_desdediametro=0;
        $this->_hastadiametro=0;
        $this->_desdecilindro=0;
        $this->_hastacilindro=0;
        $this->_desdeesfera=0;
        $this->_hastaesfera=0;
        $this->_altura=0;
        $this->_calibre=0;
        $this->_cilindro=0;
        $this->_diagonal=0;
        $this->_horizontal=0;
        $this->_curvabase=0;
        $this->_largovarilla=0;
        $this->_puente=0;
        $this->_zonaop=0;
        $this->_eje=0;
        $this->_radio=0;
        $this->_diametro=0;
        $this->_cilindro=0;
        $this->_esfera=0;
        $this->_esferah=0;
        $this->_precioiva=0;
    }
    
    function set_imp_codigo($_imp_codigo) {
        $this->_imp_codigo = $_imp_codigo;
    }

    function set_imd_codigo($_imd_codigo) {
        $this->_imd_codigo = $_imd_codigo;
    }

    function set_cdg($_cdg) {
        $this->_cdg = $_cdg;
    }

    function set_codigobarras($_codigobarras) {
        $this->_codigobarras = $_codigobarras;
    }

    function set_codsap($_codsap) {
        $this->_codsap = $_codsap;
    }

    function set_descripcion($_descripcion) {
        $this->_descripcion = mb_strtoupper($_descripcion);
    }

    function set_familia($_familia) {
        $this->_familia = $_familia;
    }

    function set_subfam($_subfam) {
        $this->_subfam = $_subfam;
    }

    function set_grupofam($_grupofam) {
        $this->_grupofam = $_grupofam;
    }

    function set_descatalogado($_descatalogado) {
        $this->_descatalogado = $_descatalogado;
    }

    function set_alias($_alias) {
        $this->_alias = $_alias;
    }

    function set_colores($_colores) {
       $this->_colores = $_colores;
    }

    function set_indref($_indref) {
        $this->_indref = number_format(validaNull($_indref, 0, 'float'),2);;
    }

    function set_material($_material) {
        $this->_material = $_material;
    }

    function set_tipoarti($_tipoarti) {
        $this->_tipoarti = $_tipoarti;
    }

    function set_desdediametro($_desdediametro) {
        $this->_desdediametro = number_format(validaNull($_desdediametro, 0, 'float'),2);
    }

    function set_hastadiametro($_hastadiametro) {
        $this->_hastadiametro = number_format(validaNull($_hastadiametro, 0, 'float'),2);
    }

    function set_desdecilindro($_desdecilindro) {
        $this->_desdecilindro = number_format(validaNull($_desdecilindro, 0, 'float'),2);
    }

    function set_hastacilindro($_hastacilindro) {
        $this->_hastacilindro = number_format(validaNull($_hastacilindro, 0, 'float'),2);
    }

    function set_desdeesfera($_desdeesfera) {
        $this->_desdeesfera = number_format(validaNull($_desdeesfera, 0, 'float'),2);
    }

    function set_hastaesfera($_hastaesfera) {
        $this->_hastaesfera = number_format(validaNull($_hastaesfera, 0, 'float'),2);
    }

    function set_altura($_altura) {
        $this->_altura = number_format(validaNull($_altura, 0, 'float'),2);
    }

    function set_calibre($_calibre) {
        $this->_calibre = number_format(validaNull($_calibre, 0, 'float'),2);
    }

    function set_puente($_puente) {
        $this->_puente = number_format(validaNull($_puente, 0, 'float'),2);
    }

    function set_curvabase($_curvabase) {
        $this->_curvabase = number_format(validaNull($_curvabase, 0, 'float'),2);
    }

    function set_largovarilla($_largovarilla) {
        $this->_largovarilla = number_format(validaNull($_largovarilla, 0, 'float'),2);
    }

    function set_polarized($_polarized) {
        $this->_polarized = $_polarized;
    }

    function set_diagonal($_diagonal) {
        $this->_diagonal = number_format(validaNull($_diagonal, 0, 'float'),2);
    }

    function set_horizontal($_horizontal) {
        $this->_horizontal = number_format(validaNull($_horizontal, 0, 'float'),2);
    }

    function set_colorc($_colorc) {
        $this->_colorc = $_colorc;
    }

    function set_colorm($_colorm) {
        $this->_colorm = $_colorm;
    }

    function set_graduable($_graduable) {
        $this->_graduable = $_graduable;
    }

    function set_sexo($_sexo) {
        $this->_sexo = $_sexo;
    }

    function set_marca($_marca) {
        $this->_marca = $_marca;
    }

    function set_zonaop($_zonaop) {
        $this->_zonaop = number_format(validaNull($_zonaop, 0, 'float'),2);
    }

    function set_eje($_eje) {
        $this->_eje = number_format(validaNull($_eje, 0, 'float'),2);
    }

    function set_radio($_radio) {
        $this->_radio = number_format(validaNull($_radio, 0, 'float'),2);
    }

    function set_diametro($_diametro) {
        $this->_diametro = number_format(validaNull($_diametro, 0, 'float'),2);
    }

    function set_cilindro($_cilindro) {
        $this->_cilindro = number_format(validaNull($_cilindro, 0, 'float'),2);
    }

    function set_esfera($_esfera) {
        $this->_esfera = number_format(validaNull($_esfera, 0, 'float'),2);
    }

    function set_esferah($_esferah) {
        $this->_esferah = number_format(validaNull($_esferah, 0, 'float'),2);
    }

    function set_estilo($_estilo) {
        $this->_estilo = $_estilo;
    }

    function set_cristal($_cristal) {
        $this->_cristal = $_cristal;
    }

    function set_aplica($_aplica) {
        $this->_aplica = $_aplica;
    }

    function set_tarifa($_tarifa) {
        $this->_tarifa = $_tarifa;
    }

    function set_precioiva($_precioiva) {
        $this->_precioiva = number_format(validaNull($_precioiva, 0, 'float'),2);
    }
    
     public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_mta_registrodet($an_accion){
        try{
             $ls_sql="begin
                 pck_mta_importar.sp_mta_importardet(:an_accion,
                    :acr_retorno,
                    :an_imp_codigo,
                    :an_imd_codigo,
                    :as_cdg,
                    :as_codigobarras,
                    :as_codsap,
                    :as_descripcion,
                    :as_familia,
                    :as_subfam,
                    :as_grupofam,
                    :as_descatalogado,
                    :as_alias,
                    :as_colores,
                    :as_material,
                    to_number(:an_indref,'999.999'),
                    to_number(:an_desdediametro,'999.999'),
                    to_number(:an_hastadiametro,'999.999'),
                    to_number(:an_desdecilindro,'999.999'),
                    to_number(:an_hastacilindro,'999.999'),
                    to_number(:an_desdeesfera,'999.999'),
                    to_number(:an_hastaesfera,'999.999'),
                    to_number(:an_altura,'999.999'),
                    to_number(:an_calibre,'999.999'),
                    to_number(:an_puente,'999.999'),
                    to_number(:an_curvabase,'999.999'),
                    to_number(:an_largovarilla,'999.999'),
                    :as_polarized,
                    to_number(:an_diagonal,'999.999'),
                    to_number(:an_horizontal,'999.999'),
                    :as_colorc,
                    :as_colorm,
                    :as_graduable,
                    :as_sexo,
                    :as_marca,
                    to_number(:an_zonaop,'999.999'),
                    to_number(:an_eje,'999.999'),
                    to_number(:an_radio,'999,9999'),
                    to_number(:an_diametro,'999.999'),
                    to_number(:an_cilindro,'999.999'),
                    to_number(:an_esfera,'999.9999'),
                    to_number(:an_esferah,'999.999'),
                    :as_estilo,
                    :as_cristal,
                    :as_aplica,
                    :as_tarifa,
                    to_number(:an_precioiva,'999,999,999.999999'));
                end;";
            
             $luo_con = new Db();
            
             $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_imp_codigo',$this->_imp_codigo,10);
            oci_bind_by_name($stid,':an_imd_codigo',$this->_imd_codigo,10);
            oci_bind_by_name($stid,':as_cdg',$this->_cdg,20);
            oci_bind_by_name($stid,':as_codigobarras',$this->_codigobarras,20);
            oci_bind_by_name($stid,':as_codsap',$this->_codsap,20);
            oci_bind_by_name($stid,':as_descripcion',$this->_descripcion,120);
            oci_bind_by_name($stid,':as_familia',$this->_familia,10);
            oci_bind_by_name($stid,':as_subfam',$this->_subfam,10);
            oci_bind_by_name($stid,':as_grupofam',$this->_grupofam,10);
            oci_bind_by_name($stid,':as_descatalogado',$this->_descatalogado,1);
            oci_bind_by_name($stid,':as_alias',$this->_alias,20);
            oci_bind_by_name($stid,':as_colores',$this->_colores,15);
            oci_bind_by_name($stid,':as_material',$this->_material,10);
            oci_bind_by_name($stid,':an_indref',$this->_indref,15);
            oci_bind_by_name($stid,':an_desdediametro',$this->_desdediametro,15);
            oci_bind_by_name($stid,':an_hastadiametro',$this->_hastadiametro,15);
            oci_bind_by_name($stid,':an_desdecilindro',$this->_desdecilindro,15);
            oci_bind_by_name($stid,':an_hastacilindro',$this->_hastacilindro,15);
            oci_bind_by_name($stid,':an_desdeesfera',$this->_desdeesfera,15);
            oci_bind_by_name($stid,':an_hastaesfera',$this->_hastaesfera,15);
            oci_bind_by_name($stid,':an_altura',$this->_altura,15);
            oci_bind_by_name($stid,':an_calibre',$this->_calibre,15);
            oci_bind_by_name($stid,':an_puente',$this->_puente,15);
            oci_bind_by_name($stid,':an_curvabase',$this->_curvabase,15);
            oci_bind_by_name($stid,':an_largovarilla',$this->_largovarilla,15);
            oci_bind_by_name($stid,':as_polarized',$this->_polarized,1);
            oci_bind_by_name($stid,':an_diagonal',$this->_diagonal,15);
            oci_bind_by_name($stid,':an_horizontal',$this->_horizontal,15);
            oci_bind_by_name($stid,':as_colorc',$this->_colorc,15);
            oci_bind_by_name($stid,':as_colorm',$this->_colorm,15);
            oci_bind_by_name($stid,':as_graduable',$this->_graduable,10);
            oci_bind_by_name($stid,':as_sexo',$this->_sexo,10);
            oci_bind_by_name($stid,':as_marca',$this->_marca,10);
            oci_bind_by_name($stid,':an_zonaop',$this->_zonaop,15);
            oci_bind_by_name($stid,':an_eje',$this->_eje,15);
            oci_bind_by_name($stid,':an_radio',$this->_radio,15);
            oci_bind_by_name($stid,':an_diametro',$this->_diametro,15);
            oci_bind_by_name($stid,':an_cilindro',$this->_cilindro,15);
            oci_bind_by_name($stid,':an_esfera',$this->_esfera,15);
            oci_bind_by_name($stid,':an_esferah',$this->_esferah,15);
            oci_bind_by_name($stid,':as_estilo',$this->_estilo,15);
            oci_bind_by_name($stid,':as_cristal',$this->_cristal,15);
            oci_bind_by_name($stid,':as_aplica',$this->_aplica,10);
            oci_bind_by_name($stid,':as_tarifa',$this->_tarifa,10);
            oci_bind_by_name($stid,':an_precioiva',$this->_precioiva,15);
            
            if(!$luo_set->ReadcrsMant($luo_con, $stid, $crto)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
            $luo_con->commitTransaction();
            
            $lstData = [];
            
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                 
            oci_free_statement($crto);
            
            oci_free_statement($stid);
           
            $luo_con->closeConexion();
            
            unset($luo_set);
                   
            return $rowdata;          
        }
        catch(Exception $ex){            
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
        
    }

        
    public function lst_listar($an_imp_codigo,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_mta_importardet.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_imp_codigo,
                            :as_criterio,
                            :an_start,
                            :an_limit);
                    end;";            
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_imp_codigo',$an_imp_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,120);
             oci_bind_by_name($stid,':an_start',$an_start,10);
             oci_bind_by_name($stid,':an_limit',$an_limit,10);
            
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false,$ln_rowcount);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;      
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
            
        }
        
    }
}
