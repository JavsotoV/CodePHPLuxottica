<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgmaTipoServicioPais
 *
 * @author JAVSOTO
 */


require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");


class clsgmaTipoServicioPais {
    //put your code here
    
    private $_tpp_codigo;
    private $_pai_codigo;
    private $_tps_codigo;
    private $_srv_codigo;
    private $_tpp_usuario;
    
    function __construct($an_tpp_usuario) {
        $this->_tpp_codigo=[];
        $this->_srv_codigo=[];
        $this->_tpp_usuario=$an_tpp_usuario;
    }
    
    function set_tpp_codigo($_tpp_codigo) {
        $this->_tpp_codigo = $_tpp_codigo;
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = $_pai_codigo;
    }

    function set_tps_codigo($_tps_codigo) {
        $this->_tps_codigo = $_tps_codigo;
    }

    function set_srv_codigo($_srv_codigo) {
        $this->_srv_codigo = $_srv_codigo;
    }


    public function loadData ( $lstParametros ){
      foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_gma_tiposerviciopais($an_accion){
        try{
            $ls_sql="begin
                        mda.pck_gma_tiposerviciopais.sp_gma_tiposerviciopais(:an_accion,
                            :acr_retorno,
                            :an_tpp_codigo,
                            :an_pai_codigo,
                            :an_tps_codigo,
                            :an_srv_codigo,
                            :an_tpp_usuario);
                      end;";
            
              $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            $ln_count = count($this->_tpp_codigo);
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_array_by_name($stid,':an_tpp_codigo',$this->_tpp_codigo,$ln_count,-1,SQLT_INT);
            oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);            
            oci_bind_by_name($stid,':an_tps_codigo',$this->_tps_codigo,10);
            oci_bind_array_by_name($stid,':an_srv_codigo',$this->_srv_codigo,$ln_count,-1,SQLT_INT);            
            oci_bind_by_name($stid,':an_tpp_usuario',$this->_tpp_usuario,10);
            
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
    
    
    public function lst_listar($an_are_codigo,$an_pai_codigo,$as_criterio,$an_start,$an_limit){
        try{
            
            $ln_rowcount=0;
                    
            $ls_sql="begin
                        mda.pck_gma_tiposerviciopais.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
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
    
      public function sp_lst_srvtipopais($an_are_codigo,$an_pai_codigo,$an_tps_codigo,$an_srv_origen){
        try{
            
            $ls_sql="begin
                        mda.pck_gma_tiposerviciopais.sp_lst_srvtipopais(:acr_cursor,
                            :an_are_codigo,
                            :an_pai_codigo,
                            :an_tps_codigo,
                            :an_srv_origen);
                        end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_are_codigo',$an_are_codigo,10);
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
             oci_bind_by_name($stid,':an_tps_codigo',$an_tps_codigo,10);
             oci_bind_by_name($stid,':an_srv_origen',$an_srv_origen,10);
            
             if(!$luo_con->ociExecute($stid)){
                 
                 return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
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
    
    public function lst_srvpendienteasignacion($an_are_codigo,$an_pai_codigo){
        
        try{
               $ls_sql="begin
                        mda.pck_gma_tiposerviciopais.sp_lst_srvpendienteasignacion(:acr_cursor,
                            :an_are_codigo,
                            :an_pai_codigo);
                        end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_are_codigo',$an_are_codigo,10);
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
             
             if(!$luo_con->ociExecute($stid)){
                 
                 return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
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
