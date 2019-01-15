<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsmtaRegistrodet
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsmtaRegistrodet {
    private $_reg_codigo;
    private $_rgd_codigo;
    private $_cta_codigo;
    private $_rgd_cantidad;
    private $_rgd_fechaven;
    private $_rgd_observacion;
    private $_rgd_emisor;
    private $_rgd_usuario;
    
    function __construct($an_rgd_usuario) {
        $this->_rgd_codigo=0;
        $this->_rgd_usuario=$an_rgd_usuario;
    }
    
    function set_reg_codigo($_reg_codigo) {
        $this->_reg_codigo = $_reg_codigo;
    }

    function set_rgd_codigo($_rgd_codigo) {
        $this->_rgd_codigo = $_rgd_codigo;
    }

    function set_cta_codigo($_cta_codigo) {
        $this->_cta_codigo = $_cta_codigo;
    }

    function set_rgd_cantidad($_rgd_cantidad) {
        $this->_rgd_cantidad = $_rgd_cantidad;
    }

    function set_rgd_fechaven($_rgd_fechaven) {
        $this->_rgd_fechaven = $_rgd_fechaven;
    }

    function set_rgd_observacion($_rgd_observacion) {
        $this->_rgd_observacion = $_rgd_observacion;
    }
    
    function set_rgd_emisor($_rgd_emisor) {
        $this->_rgd_emisor = mb_strtoupper($_rgd_emisor,'utf-8');
    }
    
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_gma_registrodet($an_accion){
        try{
            $ls_sql="begin
                        pck_mta_registrodet.sp_mta_registrodet (:an_accion,
                            :acr_retorno,
                            :acr_cursor,
                            :an_reg_codigo,
                            :an_rgd_codigo,
                            :an_cta_codigo,
                            :an_rgd_cantidad,
                            to_date(:ad_rgd_fechaven,'dd/mm/yyyy'),
                            :as_rgd_observacion,
                            :as_rgd_emisor,
                            :an_rgd_usuario);
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_reg_codigo',$this->_reg_codigo,10);
            oci_bind_by_name($stid,':an_rgd_codigo',$this->_rgd_codigo,10);
            oci_bind_by_name($stid,':an_cta_codigo',$this->_cta_codigo,10);
            oci_bind_by_name($stid,':an_rgd_cantidad',$this->_rgd_cantidad,10);
            oci_bind_by_name($stid,':ad_rgd_fechaven',$this->_rgd_fechaven,12);
            oci_bind_by_name($stid,':as_rgd_observacion',$this->_rgd_observacion,120);
            oci_bind_by_name($stid,':as_rgd_emisor',$this->_rgd_emisor,20);
            oci_bind_by_name($stid,':an_rgd_usuario',$this->_rgd_usuario,10);
            
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
    
    public function lst_listar($an_reg_codigo,$an_rgd_codigo,$as_criterio,$an_start,$an_limit){
        try{
            
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_mta_registrodet.sp_listar ( :acr_cursor,
                            :ln_rowcount,
                            :an_reg_codigo,
                            :an_rgd_codigo,
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
             oci_bind_by_name($stid,':an_reg_codigo',$an_reg_codigo,10);
             oci_bind_by_name($stid,':an_rgd_codigo',$an_rgd_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,60);
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
    
    
     public function lst_rgdpais($an_ctr_codigo,$an_pai_codigo,$as_criterio,$an_start,$an_limit){
        try{
            
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_mta_registrodet.sp_lst_rgdpais ( :acr_cursor,
                            :ln_rowcount,
                            :an_ctr_codigo,
                            :an_pai_codigo,
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
             oci_bind_by_name($stid,':an_ctr_codigo',$an_ctr_codigo,10);
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,60);
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
