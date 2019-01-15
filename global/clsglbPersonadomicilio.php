<?php

/*
 * To change this license header; choose License Headers in Project Properties.
 * To change this template file; choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsglbPersonadomicilio
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clsglbPersonadomicilio {
    //put your code here
    
    private $_per_codigo;
    private $_dom_codigo;
    private $_ubg_codigo;
    private $_tzo_codigo;
    private $_zna_descripcion;
    private $_via_codigo;
    private $_dom_vianombre;
    private $_dom_vianumero;
    private $_dom_descripcion;
    private $_dom_departamento;
    private $_dom_interior;
    private $_dom_manzana;
    private $_dom_nrolote;
    private $_dom_etapa;
    private $_dom_referencia;
    private $_dom_block;
    private $_dom_defecto;
    
    function set_per_codigo($_per_codigo) {
        $this->_per_codigo = $_per_codigo;
    }

    function set_dom_codigo($_dom_codigo) {
        $this->_dom_codigo = validaNull($_dom_codigo,0,'int');
    }

    function set_ubg_codigo($_ubg_codigo) {
        $this->_ubg_codigo = $_ubg_codigo;
    }

    function set_tzo_codigo($_tzo_codigo) {
        $this->_tzo_codigo = validaNull($_tzo_codigo,0,'int');
    }

    function set_zna_descripcion($_zna_descripcion) {
        $this->_zna_descripcion = mb_strtoupper($_zna_descripcion,'utf-8');
    }

    function set_via_codigo($_via_codigo) {        
        $this->_via_codigo = validaNull($_via_codigo,0,'int');
    }

    function set_dom_vianombre($_dom_vianombre) {
        $this->_dom_vianombre = mb_strtoupper($_dom_vianombre,'utf-8');
    }

    function set_dom_vianumero($_dom_vianumero) {
        $this->_dom_vianumero = mb_strtoupper($_dom_vianumero,'utf-8');
    }

    function set_dom_descripcion($_dom_descripcion) {
        $this->_dom_descripcion = mb_strtoupper($_dom_descripcion,'utf-8');
    }

    function set_dom_departamento($_dom_departamento) {
        $this->_dom_departamento = mb_strtoupper($_dom_departamento,'utf-8');
    }

    function set_dom_interior($_dom_interior) {
        $this->_dom_interior = mb_strtoupper($_dom_interior,'utf-8');
    }

    function set_dom_manzana($_dom_manzana) {
        $this->_dom_manzana = mb_strtoupper($_dom_manzana,'utf-8');
    }

    function set_dom_nrolote($_dom_nrolote) {
        $this->_dom_nrolote = mb_strtoupper($_dom_nrolote,'utf-8');
    }

    function set_dom_etapa($_dom_etapa) {
        $this->_dom_etapa = mb_strtoupper($_dom_etapa,'utf-8');
    }

    function set_dom_referencia($_dom_referencia) {
        $this->_dom_referencia = mb_strtoupper($_dom_referencia,'utf-8');
    }

    function set_dom_block($_dom_block) {
        $this->_dom_block = mb_strtoupper($_dom_block,'utf-8');
    }

    function set_dom_defecto($_dom_defecto) {
        $this->_dom_defecto = $_dom_defecto;
    }

    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_glb_personadomicilio($an_accion,$an_usuario){
        try{
            
            $luo_con=new Db();
            
            $ls_sql="begin
            pck_glb_personadomicilio.sp_glb_personadomicilio(
                :an_accion,
                :acr_retorno,
                :acr_cursor,
                :an_per_codigo,
                :an_dom_codigo,
                :an_ubg_codigo,
                :an_tzo_codigo,
                :as_zna_descripcion,
                :an_via_codigo,
                :as_dom_vianombre,
                :as_dom_vianumero,
                :as_dom_descripcion,
                :as_dom_departamento,
                :as_dom_interior,
                :as_dom_manzana,
                :as_dom_nrolote,
                :as_dom_etapa,
                :as_dom_referencia,
                :as_dom_block,
                :as_dom_defecto,
                :an_dom_usuario);  
            end;";
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError()) ;}
            
            $stid=$luo_con->ociparse($ls_sql);            
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $crto = $luo_con->ocinewcursor();            
            if(!$crto){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $curs = $luo_con->ocinewcursor();            
            if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_per_codigo',$this->_per_codigo,10);
            oci_bind_by_name($stid,':an_dom_codigo',$this->_dom_codigo,10);
            oci_bind_by_name($stid,':an_ubg_codigo',$this->_ubg_codigo,10);
            oci_bind_by_name($stid,':an_tzo_codigo',$this->_tzo_codigo,10);
            oci_bind_by_name($stid,':as_zna_descripcion',$this->_zna_descripcion,120);
            oci_bind_by_name($stid,':an_via_codigo',$this->_via_codigo,10);
            oci_bind_by_name($stid,':as_dom_vianombre',$this->_dom_vianombre,60);
            oci_bind_by_name($stid,':as_dom_vianumero',$this->_dom_vianumero,120);
            oci_bind_by_name($stid,':as_dom_descripcion',$this->_dom_descripcion,250);
            oci_bind_by_name($stid,':as_dom_departamento',$this->_dom_departamento,120);
            oci_bind_by_name($stid,':as_dom_interior',$this->_dom_interior,120);
            oci_bind_by_name($stid,':as_dom_manzana',$this->_dom_manzana,60);
            oci_bind_by_name($stid,':as_dom_nrolote',$this->_dom_nrolote,60);
            oci_bind_by_name($stid,':as_dom_etapa',$this->_dom_etapa,120);
            oci_bind_by_name($stid,':as_dom_referencia',$this->_dom_referencia,120);
            oci_bind_by_name($stid,':as_dom_block',$this->_dom_block,120);
            oci_bind_by_name($stid,':as_dom_defecto',$this->_dom_defecto,1);
            oci_bind_by_name($stid,':an_dom_usuario',$an_usuario,10);
            
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            if(!$luo_con->ociExecute($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            if (!$luo_con->ocifetchRetorno($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $luo_con->commitTransaction();
            
            $lstData = ( $an_accion != 3 ? parsearcursor($curs) : [] );
                
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                 
            oci_free_statement($crto);
            oci_free_statement($stid);
            
            $luo_con->closeConexion();
                
            unset($luo_con);
                   
            return $rowdata;      
        }
        catch (Exception $ex){
            clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }

    public function lst_listar($an_per_codigo){
        try{
            $luo_con=new Db();
            
            $ln_dom_codigo=0;
            
            $ls_sql="begin pck_glb_personadomicilio.sp_lst_listar(
                        :acr_cursor,
                        :an_per_codigo,
                        :an_dom_codigo); end;";
            
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
       
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_per_codigo',$an_per_codigo,10);
             oci_bind_by_name($stid,':an_dom_codigo',$ln_dom_codigo,10);
             
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;    
        }
        catch (Exception $ex){
            clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
}
