<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgmaResolutor
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");


class clsgmaResolutor {
    //put your code here
    private $_rse_codigo;
    private $_srv_codigo;
    private $_pai_codigo;
    private $_per_codigo;
    private $_rse_nivel;
    private $_rse_estado;
    private $_rse_usuario;
    
    function __construct($an_rse_usuario) {
        $this->_rse_codigo=[];
        $this->_per_codigo=[];
        $this->_rse_nivel=[];
        $this->_rse_estado=[];        
        $this->_rse_usuario=$an_rse_usuario;
    }
    
    function set_rse_codigo($_rse_codigo) {
        $this->_rse_codigo = $_rse_codigo;
    }

    function set_srv_codigo($_srv_codigo) {
        $this->_srv_codigo = $_srv_codigo;
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = $_pai_codigo;
    }

    function set_per_codigo($_per_codigo) {
        $this->_per_codigo = $_per_codigo;
    }
    
    function set_rse_nivel($_rse_nivel) {
        $this->_rse_nivel = $_rse_nivel;
    }

    function set_rse_estado($_rse_estado) {
        $this->_rse_estado = $_rse_estado;
    }

    public function loadData ( $lstParametros ){
      foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }

    public function sp_gma_resolutor($an_accion){
        try{
            $ls_sql="begin
                        mda.pck_gma_resolutor.sp_gma_resolutor (:an_accion,
                                    :acr_retorno,
                                    :an_rse_codigo,
                                    :an_pai_codigo,
                                    :an_per_codigo,
                                    :an_srv_codigo,
                                    :an_rse_nivel,
                                    :an_rse_estado,
                                    :an_rse_usuario);
                      end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            $ln_count = count($this->_rse_codigo);
                                 
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_array_by_name($stid,':an_rse_codigo',$this->_rse_codigo,$ln_count,-1,SQLT_INT);
            oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);            
            oci_bind_array_by_name($stid,':an_per_codigo',$this->_per_codigo,$ln_count,-1,SQLT_INT);
            oci_bind_by_name($stid,':an_srv_codigo',$this->_srv_codigo,10);            
            oci_bind_array_by_name($stid,':an_rse_nivel',$this->_rse_nivel,$ln_count,-1,SQLT_INT);
            oci_bind_array_by_name($stid,':an_rse_estado',$this->_rse_estado,$ln_count,-1,SQLT_INT);
            oci_bind_by_name($stid,':an_rse_usuario',$this->_rse_usuario,10);
            
            $curs = $crto;
            
            if(!$luo_set->ReadcrsMant($luo_con, $stid, $crto)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
            $luo_con->commitTransaction();
            
            $lstData = [];
                
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                             
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
    
     public function lst_listar($an_rse_codigo,$an_are_codigo,$an_pai_codigo,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        mda.pck_gma_resolutor.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_rse_codigo,
                            :an_are_codigo,
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
             oci_bind_by_name($stid,':an_rse_codigo',$an_rse_codigo,10);
             oci_bind_by_name($stid,':an_are_codigo',$an_are_codigo,10);
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,120);
             oci_bind_by_name($stid,':an_start',$an_start,10);
             oci_bind_by_name($stid,':an_limit',$an_limit,10);
            
              if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false,$ln_rowcount);
             
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
    
    public function lst_rstpaissrv($an_pai_codigo,$an_srv_codigo){
        
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        mda.pck_gma_resolutor.sp_lst_rstpaissrv(:acr_cursor,
                            :ln_rowcount,
                            :an_pai_codigo,
                            :an_srv_codigo);
                     end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
             oci_bind_by_name($stid,':an_srv_codigo',$an_srv_codigo,10);
                         
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false,$ln_rowcount);
             
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
    
    public function lst_srvregion($an_pai_codigo,$an_are_codigo,$an_tps_codigo){
        try{
            $ls_sql="begin
                        mda.pck_gma_resolutor.sp_lst_srvpais (:acr_cursor,
                        :an_pai_codigo,
                        :an_are_codigo,
                        :an_tps_codigo);
                     end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
             oci_bind_by_name($stid,':an_are_codigo',$an_are_codigo,10);
             oci_bind_by_name($stid,':an_tps_codigo',$an_tps_codigo,10);
                         
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
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
}
