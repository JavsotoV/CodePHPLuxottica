<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgmaTicketdet
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsgmaTicketdet {
    private $_tck_codigo;
    private $_rpe_codigo;
    private $_rse_nivel;
    private $_tkd_usuario;
    
    function __construct($an_tkd_usuario) {
        $this->_tkd_usuario=$an_tkd_usuario;
        $this->_rse_nivel=2;
        $this->_rpe_codigo=[];
    }
    function set_tck_codigo($_tck_codigo) {
        $this->_tck_codigo = $_tck_codigo;
    }

    function set_rpe_codigo($_rpe_codigo) {
        $this->_rpe_codigo = $_rpe_codigo;
    }
    
    function set_rse_nivel($_rse_nivel) {
        $this->_rse_nivel = $_rse_nivel;
    }

    public function loadData ( $lstParametros ){
      foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_gma_ticketdet($an_accion){
        try{
            $ls_sql="begin
                        mda.pck_gma_ticketdet.sp_gma_ticketdetrst (:an_accion,
                            :acr_retorno,
                            :acr_cursor,
                            :an_tck_codigo,
                            :an_rpe_codigo,
                            :an_rse_nivel,
                            :an_tkd_usuario);
                     end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            $ln_count = count($this->_rpe_codigo);
                                 
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_tck_codigo',$this->_tck_codigo,10);            
            oci_bind_array_by_name($stid,':an_rpe_codigo',$this->_rpe_codigo,$ln_count,-1,SQLT_INT);
            oci_bind_by_name($stid,':an_rse_nivel',$this->_rse_nivel,10);
            oci_bind_by_name($stid,':an_tkd_usuario',$this->_tkd_usuario,10);
            
            if(!$luo_set->ReadcrsMant($luo_con, $stid, $crto)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
            $luo_con->commitTransaction();
            
            $lstData = ( $an_accion != 3 ? parsearcursor($curs) : [] );
                
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
    
    
    public function lst_listar($an_tck_codigo,$as_criterio,$an_start,$an_limit){
        try{
            $ls_sql="begin
                        mda.pck_gma_ticketdet.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_tck_codigo,
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
             oci_bind_by_name($stid,':an_tck_codigo',$an_tck_codigo,10);
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
    
    public function lst_rstsegundonivel($an_tck_codigo,$an_rqe_codigo,$an_rse_nivel){        
         try{
            $ls_sql="begin
                        mda.pck_gma_ticketdet.sp_lst_rstxticketpend (:acr_cursor,
                        :an_tck_codigo,
                        :an_rqe_codigo,
                        :an_rse_nivel);
                     end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_tck_codigo',$an_tck_codigo,10);
             oci_bind_by_name($stid,':an_rqe_codigo',$an_rqe_codigo,10);
             oci_bind_by_name($stid,':an_rse_nivel',$an_rse_nivel,10);
             
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
