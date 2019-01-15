<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgmaResponsable
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsgmaResponsable {
    //put your code here
    private $_rpe_codigo;
    private $_rqe_codigo;
    private $_rse_codigo;
    private $_rpe_usuario;
    
    function __construct($an_usuario) {
        $this->_rpe_codigo=[];
        $this->_rqe_codigo=[];
        $this->_rpe_usuario=$an_usuario;
    }
    
    function set_rpe_codigo($_rpe_codigo) {
        $this->_rpe_codigo = $_rpe_codigo;
    }
    function set_rqe_codigo($_rqe_codigo) {
        $this->_rqe_codigo = $_rqe_codigo;
    }

    function set_rse_codigo($_rse_codigo) {
        $this->_rse_codigo = $_rse_codigo;
    }

    
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_gma_responsable($an_accion){
        try{
            $ls_sql="begin
                        mda.pck_gma_responsable.sp_gma_responsable (:an_accion,
                            :acr_retorno,
                            :an_rpe_codigo,
                            :an_rqe_codigo,
                            :an_rse_codigo,
                            :an_rpe_usuario);
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
             $ln_count = count($this->_rpe_codigo);
             
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_array_by_name($stid,':an_rpe_codigo',$this->_rpe_codigo,$ln_count,-1,SQLT_INT);
            oci_bind_array_by_name($stid,':an_rqe_codigo',$this->_rqe_codigo,$ln_count,-1,SQLT_INT);
            oci_bind_by_name($stid,':an_rse_codigo',$this->_rse_codigo,10);
            oci_bind_by_name($stid,':an_rpe_usuario',$this->_rpe_usuario,10);
            
            if(!$luo_set->ReadcrsMant($luo_con, $stid, $crto)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
            $luo_con->commitTransaction();
            
            $lstData = [];
                
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
    
    public function lst_listar($an_rse_codigo,$as_criterio,$an_start,$an_limit){
        try{
            
            $ls_sql="begin
                        mda.pck_gma_responsable.sp_lst_listar (:acr_cursor,
                            :an_rse_codigo,
                            :as_criterio);
                     end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_rse_codigo',$an_rse_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,120);
            
              if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;
            
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
        
    }
   
    public function sp_lst_reqpendiente($an_rse_codigo,$an_start,$an_limit){
        try{
            
            $ln_rowcount=0;
            
            $ls_sql="begin
                        mda.pck_gma_responsable.sp_lst_reqpendiente(:acr_cursor,
                            :ln_rowcount,
                            :an_rse_codigo,
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
             oci_bind_by_name($stid,':an_rse_codigo',$an_rse_codigo,10);
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
    
    public function lst_rpexsrvxregion($an_srv_codigo,$an_pai_codigo){
        try{
            $ls_sql="begin
                        mda.pck_gma_responsable.sp_lst_rpexsrvxregion (:acr_cursor,
                        :an_srv_codigo,
                        :an_pai_codigo);
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_srv_codigo',$an_srv_codigo,10);
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
            
              if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
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
