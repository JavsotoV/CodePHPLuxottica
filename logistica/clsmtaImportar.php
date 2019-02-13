<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsmtaImportar
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");


class clsmtaImportar {
    //put your code here
    private $_imp_codigo;
    private $_pai_codigo;
    private $_tipfamcod;
    private $_imp_origen;
    private $_imp_observacion;
    private $_imp_usuario;
    
    private $_cdg;
    private $_codigobarras;
    private $_codsap;
    private $_descripcion;
    private $_familia;
    private $_subfam;
    private $_grupofam;
    private $_descatalogado;
    private $_alias;
    private $_ivacb;
    private $_priprov;
    private $_nomcom;
    private $_inventariar;
    private $_liquidacion;
    private $_etiquetar;
    private $_colores;
    private $_material;
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
    private $_diagonal;
    private $_horiz;
    private $_colorc;
    private $_colorm;
    private $_graduable;
    private $_sexo;
    private $_marca;
    private $_zonaop;
    private $_eje;
    private $_radio;
    
    function __construct($an_imp_usuario) {
        $this->_imp_codigo=0;
        $this->_imp_usuario=$an_imp_usuario;
        
        $this->_cdg=[];
        $this->_codigobarras=[];
        $this->_codsap=[];
        $this->_descripcion=[];
        $this->_familia=[];
        $this->_subfam=[];
        $this->_grupofam=[];
        $this->_descatalogado=[];
        $this->_alias=[];
        $this->_ivacb=[];
        $this->_priprov=[];
        $this->_nomcom=[];
        $this->_inventariar=[];
        $this->_liquidacion=[];
        $this->_etiquetar=[];
        $this->_colores=[];
        $this->_material=[];
        $this->_desdediametro=[];
        $this->_hastadiametro=[];
        $this->_desdecilindro=[];
        $this->_hastacilindro=[];
        $this->_desdeesfera=[];
        $this->_hastaesfera=[];
        $this->_altura=[];
        $this->_calibre=[];
        $this->_puente=[];
        $this->_curvabase=[];
        $this->_largovarilla=[];
        $this->_diagonal=[];
        $this->_horiz=[];
        $this->_colorc=[];
        $this->_colorm=[];
        $this->_graduable=[];
        $this->_sexo=[];
        $this->_marca=[];
        $this->_zonaop=[];
        $this->_eje=[];
        $this->_radio=[];
    }
    
    function set_imp_codigo($_imp_codigo) {
        $this->_imp_codigo = $_imp_codigo;
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = $_pai_codigo;
    }

    function set_tipfamcod($_tipfamcod) {
        $this->_tipfamcod = $_tipfamcod;
    }

    function set_imp_origen($_imp_origen) {
        $this->_imp_origen = $_imp_origen;
    }

    function set_imp_observacion($_imp_observacion) {
        $this->_imp_observacion = $_imp_observacion;
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
        $this->_descripcion = $_descripcion;
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

    function set_ivacb($_ivacb) {
        $this->_ivacb = $_ivacb;
    }

    function set_priprov($_priprov) {
        $this->_priprov = $_priprov;
    }

    function set_nomcom($_nomcom) {
        $this->_nomcom = $_nomcom;
    }

    function set_inventariar($_inventariar) {
        $this->_inventariar = $_inventariar;
    }

    function set_liquidacion($_liquidacion) {
        $this->_liquidacion = $_liquidacion;
    }

    function set_etiquetar($_etiquetar) {
        $this->_etiquetar = $_etiquetar;
    }

    function set_colores($_colores) {
        $this->_colores = $_colores;
    }

    function set_material($_material) {
        $this->_material = $_material;
    }

    function set_desdediametro($_desdediametro) {
        $this->_desdediametro = $_desdediametro;
    }

    function set_hastadiametro($_hastadiametro) {
        $this->_hastadiametro = $_hastadiametro;
    }

    function set_desdecilindro($_desdecilindro) {
        $this->_desdecilindro = $_desdecilindro;
    }

    function set_hastacilindro($_hastacilindro) {
        $this->_hastacilindro = $_hastacilindro;
    }

    function set_desdeesfera($_desdeesfera) {
        $this->_desdeesfera = $_desdeesfera;
    }

    function set_hastaesfera($_hastaesfera) {
        $this->_hastaesfera = $_hastaesfera;
    }

    function set_altura($_altura) {
        $this->_altura = $_altura;
    }

    function set_calibre($_calibre) {
        $this->_calibre = $_calibre;
    }

    function set_puente($_puente) {
        $this->_puente = $_puente;
    }

    function set_curvabase($_curvabase) {
        $this->_curvabase = $_curvabase;
    }

    function set_largovarilla($_largovarilla) {
        $this->_largovarilla = $_largovarilla;
    }

    function set_diagonal($_diagonal) {
        $this->_diagonal = $_diagonal;
    }

    function set_horiz($_horiz) {
        $this->_horiz = $_horiz;
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
        $this->_zonaop = $_zonaop;
    }

    function set_eje($_eje) {
        $this->_eje = $_eje;
    }

    function set_radio($_radio) {
        $this->_radio = $_radio;
    }

        
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_mta_importar($an_accion){
        try{
            $ls_sql="begin
                        pck_mta_importar.sp_mta_importar (:an_accion,
                            :acr_retorno,
                            :acr_cursor,
                            :an_imp_codigo,
                            :an_pai_codigo,
                            :as_tipfamcod,
                            :an_imp_origen,
                            :as_imp_observacion,
                            :as_cdg,
                            :as_codigobarras,
                            :as_codsap,
                            :as_descripcion,
                            :as_familia,
                            :as_subfam,
                            :as_grupofam,           
                            :as_descatalogado,
                            :as_alias,
                            to_number(:an_ivacb,'999,999.999'),
                            to_number(:an_priprov,'999,999.999'),
                            :as_nomcom,
                            :as_inventariar,
                            :as_liquidacion,
                            :as_etiquetar,
                            :as_colores,
                            :as_material,
                            to_number(:an_desdediametro,'999,999.999'),
                            to_number(:an_hastadiametro,'999,999.999'),
                            to_number(:an_desdecilindro,'999,999.999'),
                            to_number(:an_hastacilindro,'999,999.999'),
                            to_number(:an_desdeesfera,'999,999.999'),
                            to_number(:an_hastaesfera,'999,999.999'),
                            to_number(:an_altura,'999,999.999'),
                            to_number(:an_calibre,'999,999.999'),
                            to_number(:an_puente,'999,999.999'),
                            to_number(:an_curvabase,'999,999.999'),
                            to_number(:an_largovarilla,'999,999.999'),
                            to_number(:an_diagonal,'999,999.999'),
                            to_number(:an_horiz,'999,999.999'),
                            :as_colorc,
                            :as_colorm,
                            :as_graduable,
                            :as_sexo,
                            :as_marca,
                            to_number(:an_zonaop,'999,999.999'), 
                            to_number(:an_eje,'999,999.999'),
                            to_number(:an_radio,'999,999.999'),
                            :an_imp_usuario);
                    end;";
            
            $ln_count = count($this->_cdg);
            
            if ($ln_count<1){return clsViewData::showError(-1,'Array sin elementos');}
            
            $luo_con= new  Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_imp_codigo',$this->_imp_codigo,10);
            oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
            oci_bind_by_name($stid,':as_tipfamcod',$this->_tipfamcod,10);
            oci_bind_by_name($stid,':an_imp_origen',$this->_imp_origen,10);
            oci_bind_by_name($stid,':as_imp_observacion',$this->_imp_observacion,250);
            oci_bind_array_by_name($stid,':as_cdg',$this->_cdg,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_codigobarras',$this->_codigobarras,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_codsap',$this->_codsap,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_descripcion',$this->_descripcion,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_familia',$this->_familia,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_subfam',$this->_subfam,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_grupofam',$this->_grupofam,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_descatalogado',$this->_descatalogado,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_alias',$this->_alias,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':an_ivacb',$this->_ivacb,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_priprov',$this->_priprov,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':as_nomcom',$this->_nomcom,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_inventariar',$this->_inventariar,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_liquidacion',$this->_liquidacion,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_etiquetar',$this->_etiquetar,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_colores',$this->_colores,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_material',$this->_material,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':an_desdediametro',$this->_desdediametro,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_hastadiametro',$this->_hastadiametro,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_desdecilindro',$this->_desdecilindro,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_hastacilindro',$this->_hastacilindro,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_desdeesfera',$this->_desdeesfera,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_hastaesfera',$this->_hastaesfera,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_altura',$this->_altura,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_calibre',$this->_calibre,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_puente',$this->_puente,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_curvabase',$this->_curvabase,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_largovarilla',$this->_largovarilla,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_diagonal',$this->_diagonal,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_horiz',$this->_horiz,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':as_colorc',$this->_colorc,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_colorm',$this->_colorm,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_graduable',$this->_graduable,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_sexo',$this->_sexo,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':as_marca',$this->_marca,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':an_zonaop',$this->_zonaop,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_eje',$this->_eje,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_radio',$this->_radio,$ln_count,-1,SQLT_FLT);
            oci_bind_by_name($stid,':an_imp_usuario',$this->_imp_usuario,10);           
            
              if(!$luo_set->ReadcrsMant($luo_con, $stid, $crto)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
            $luo_con->commitTransaction();
            
            $lstData = ( $an_accion != 3 ? parsearcursor($curs) : [] );
                
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                 
            oci_free_statement($crto);
            
            oci_free_statement($stid);
            
            $luo_con->closeConexion();
            
            unset($luo_con);
            
            unset($luo_set);
                   
            return $rowdata;         
            
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_listar($an_imp_periodo,$as_criterio,$an_start,$an_limit){
        try{
            
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_mta_importar.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_imp_periodo,
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
             oci_bind_by_name($stid,':an_imp_periodo',$an_imp_periodo,10);
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
