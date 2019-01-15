<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cls_grh_solgrhcb
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clsgrhSolgrhcb {
    //put your code here
    private $_cdg;
    private $_glprofile;
    private $_tpsolgrh;
    private $_montosol;
    private $_solicitud;
    private $_tpplan;
    private $_pln_codigo;
    private $_ubg_codigo;
    private $_sede;
    private $_nrocupon;
    private $_aprobado;
    private $_observacion;
    private $_fdesde;
    private $_fhasta;
    private $_monto;
    private $_idmotivo;
    private $_nrocuota;
    
    function __construct() {
        $this->_cdg=0;
        $this->_montosol=0;        
        $this->_monto=0;
        $this->_idmotivo=0;
        $this->_nrocuota=0;
        $this->_pln_codigo=0;
        $this->_ubg_codigo=0;
        $this->_tpplan=0;
    }
    
    function set_cdg($_cdg) {
        $this->_cdg = ValidaNull($_cdg,0,'int');
    }

    function set_glprofile($_glprofile) {
        $this->_glprofile = $_glprofile;
    }

    function set_tpsolgrh($_tpsolgrh) {
        $this->_tpsolgrh = $_tpsolgrh;
    }

    function set_montosol($_montosol) {
        $this->_montosol =number_format(ValidaNull($_montosol,0,'float'),2);
    }

    function set_solicitud($_solicitud) {
        $this->_solicitud = $_solicitud;
    }

    function set_tpplan($_tpplan) {
        $this->_tpplan = $_tpplan;
    }

    function set_pln_codigo($_pln_codigo) {
        $this->_pln_codigo = validaNull($_pln_codigo,0,'int');
    }

    function set_ubg_codigo($_ubg_codigo) {
        $this->_ubg_codigo = validaNull($_ubg_codigo,0,'int');
    }

    function set_sede($_sede) {
        $this->_sede = $_sede;
    }

    function set_nrocupon($_nrocupon) {
        $this->_nrocupon = ValidaNull($_nrocupon,0,'int');
    }
    
    function set_aprobado($_aprobado) {
        $this->_aprobado = $_aprobado;
    }

    function set_observacion($_observacion) {
        $this->_observacion = $_observacion;
    }

    function set_fdesde($_fdesde) {
        $this->_fdesde = ValidaNull($_fdesde,'01/01/1900','date');
    }

    function set_fhasta($_fhasta) {
        $this->_fhasta = ValidaNull($_fhasta,'01/01/1900','date');
    }

    function set_monto($_monto) {
        $this->_monto = number_format(ValidaNull($_monto,'0','float'),2);
    }

    function set_idmotivo($_idmotivo) {
        $this->_idmotivo = $_idmotivo;
    }

    function set_nrocuota($_nrocuota) {
        $this->_nrocuota = $_nrocuota;
    }
        
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_grh_solgrhcb($an_accion){
        try{
            $ls_sql="begin
                gmo.pck_grh_solgrhcb.sp_solgrhcb (:an_accion,
                :acr_retorno,
                :acr_cursor,
                :an_cdg,
                :as_glprofile,
                :as_tpsolgrh,
                to_number(:an_montosol,'999,999,999,999.999'),
                :as_solicitud,
                :as_tpplan,
                :an_pln_codigo,
                :an_ubg_codigo,
                :as_sede,
                :an_nrocupon);
        end;";
            
        $luo_con = new Db();
        
        if($luo_con->createConexion()==false){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
        $stid=$luo_con->ociparse($ls_sql);            
        if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
        $crto = $luo_con->ocinewcursor();            
        if(!$crto){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
        $curs = $luo_con->ocinewcursor();            
        if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
        oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
        oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
        oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
        oci_bind_by_name($stid,':an_cdg',$this->_cdg,10) or die(oci_error($luo_con->refConexion));
        oci_bind_by_name($stid,':as_glprofile',$this->_glprofile,20) or die(oci_error($luo_con->refConexion));
        oci_bind_by_name($stid,':as_tpsolgrh',$this->_tpsolgrh,5) or die(oci_error($luo_con->refConexion));
        oci_bind_by_name($stid,':an_montosol',$this->_montosol,32) or die(oci_error($luo_con->refConexion));        
        oci_bind_by_name($stid,':as_solicitud',$this->_solicitud,250) or die(oci_error($luo_con->refConexion));
        oci_bind_by_name($stid,':as_tpplan',$this->_tpplan,5) or die(oci_error($luo_con->refConexion));
        oci_bind_by_name($stid,':an_pln_codigo',$this->_pln_codigo,10) or die(oci_error($luo_con->refConexion));
        oci_bind_by_name($stid,':an_ubg_codigo',$this->_ubg_codigo,10) or die(oci_error($luo_con->refConexion));
        oci_bind_by_name($stid,':as_sede',$this->_sede,250) or die(oci_error($luo_con->refConexion));
        oci_bind_by_name($stid,':an_nrocupon',$this->_nrocupon,10) or die(oci_error($luo_con->refConexion));
    
        if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError().' $stid');}
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
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function sp_revision($an_accion){
        try{
            $ls_sql="begin
                        gmo.pck_grh_solgrhcb.sp_revision(:an_accion,
                            :acr_retorno,
                            :acr_cursor,
                            :an_cdg,
                            :as_aprobado,
                            :as_observacion,
                            to_date(:ad_fdesde,'dd/mm/yyyy'),
                            to_date(:ad_fhasta,'dd/mm/yyyy'),
                            to_number(:an_monto,'999,999,999,999.999'),
                            :an_idmotivo,
                            :an_nrocuota);
                     end;";
        
        $luo_con = new Db();
             
        if($luo_con->createConexion()==false){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
        $stid=$luo_con->ociparse($ls_sql);            
        if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
        $crto = $luo_con->ocinewcursor();            
        if(!$crto){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
        $curs = $luo_con->ocinewcursor();            
        if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
        oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
        oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
        oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
        oci_bind_by_name($stid,':an_cdg',$this->_cdg,10);
        oci_bind_by_name($stid,':as_aprobado',$this->_aprobado,10);
        oci_bind_by_name($stid,':as_observacion',$this->_observacion,250);
        oci_bind_by_name($stid,':ad_fdesde',$this->_fdesde,12);        
        oci_bind_by_name($stid,':ad_fhasta',$this->_fhasta,12);
        oci_bind_by_name($stid,':an_monto',$this->_monto,20);
        oci_bind_by_name($stid,':an_idmotivo',$this->_idmotivo,10);
        oci_bind_by_name($stid,':an_nrocuota',$this->_nrocuota,10);
    
        if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError().' $stid');}
        
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
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_listar($an_cdg, $as_glprofile,$as_criterio,$ad_fechai,$ad_fechat,$an_start,$an_limit){
        try{
            
            $ln_rowcount=0;
            
            $ls_sql="begin
                    gmo.pck_grh_solgrhcb.sp_lst_listar (:acr_cursor,
                    :ln_rowcount,
                    :an_cdg,
                    :as_glprofile,
                    :as_criterio,
                    to_date(:ad_fechai,'dd/mm/yyyy'),
                    to_date(:ad_fechat,'dd/mm/yyyy'),
                    :an_start,
                    :an_limit);
            end;";
            
            $luo_con = new Db();
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError()) ;}
           
            $stid=$luo_con->ociparse($ls_sql);             
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
            $curs = $luo_con->ocinewcursor();             
            if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
            oci_bind_by_name($stid,':an_cdg',$an_cdg,10);
            oci_bind_by_name($stid,':as_glprofile',$as_glprofile,20);
            oci_bind_by_name($stid,':as_criterio',$as_criterio,120);
            oci_bind_by_name($stid,':ad_fechai',$ad_fechai,12);
            oci_bind_by_name($stid,':ad_fechat',$ad_fechat,12);
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
            return clsViewData::showError($ex->getCode(),$ex->getMessage());
        }        
    }
    
    public function lst_listartot($as_criterio,$ad_fechai,$ad_fechat,$an_start,$an_limit){
    try{
        
        $ln_rowcount=1;
        
        $ls_sql="begin
                    gmo.pck_grh_solgrhcb.sp_lst_listartot (:acr_cursor,
                        :ln_rowcount,
                        :as_criterio,
                        to_date(:ad_fechai,'dd/mm/yyyy'),
                        to_date(:ad_fechat,'dd/mm/yyyy'),
                        :an_start,
                        :an_limit);
                end;";
        
          $luo_con = new Db();
        
          if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError()) ;}
           
            $stid=$luo_con->ociparse($ls_sql);             
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
            $curs = $luo_con->ocinewcursor();             
            if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
            oci_bind_by_name($stid,':as_criterio',$as_criterio,120);
            oci_bind_by_name($stid,':ad_fechai',$ad_fechai,12);
            oci_bind_by_name($stid,':ad_fechat',$ad_fechat,12);
            oci_bind_by_name($stid,':an_start',$an_start,10);
            oci_bind_by_name($stid,':an_limit',$an_limit,10);
                      
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
            $rowdata= clsViewData::viewData(parsearcursor($curs),false,$ln_rowcount);
             
            oci_free_statement($stid);
             
            $luo_con->closeConexion();
             
            unset($luo_con);
             
            return $rowdata;     
        
    }
 catch (Exception $ex){
        return clsViewData::showError($ex->getCode(), $ex->getMessage());
 }
    }
}

