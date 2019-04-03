<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsprmLocal
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsprmLocal {
    //put your code here
    private $_lco_codigo;
    private $_prm_codigo;
    private $_cfg_codigo;
    private $_lco_usuario;
    
    function __construct($an_lco_usuario) {
        $this->_lco_usuario=$an_lco_usuario;
        $this->_lco_codigo=0;
        $this->_cfg_codigo=[];
    }
    
    function set_lco_codigo($_lco_codigo) {
        $this->_lco_codigo = $_lco_codigo;
    }

    function set_prm_codigo($_prm_codigo) {
        $this->_prm_codigo = $_prm_codigo;
    }

    function set_cfg_codigo($_cfg_codigo) {
        $this->_cfg_codigo = $_cfg_codigo;
    }

    public function loadData ( $lstParametros ){
     foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
     function sp_prm_local($an_accion){
         try{
             $ls_sql="begin
                            pck_prm_local.sp_prm_local (:an_accion,
                            :acr_retorno,
                            :an_lco_codigo,
                            :an_prm_codigo,
                            :an_cfg_codigo,
                            :an_lco_usuario);
                      end;";
               $luo_con= new  Db();
            
           $luo_set = new clsReference();
            
           if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
           };
           
           if ($an_accion==3){
                $this->_cfg_codigo=Array(0,1);               
           }
            
           $ln_count = count($this->_cfg_codigo);
           
            if ($ln_count<1){return clsViewData::showError(-1,'Array de datos sin elementos');}
            
           oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':an_lco_codigo',$this->_lco_codigo,10);
           oci_bind_by_name($stid,':an_prm_codigo',$this->_prm_codigo,10);
           oci_bind_array_by_name($stid,':an_cfg_codigo',$this->_cfg_codigo,$ln_count,-1,SQLT_INT);
           oci_bind_by_name($stid,':an_lco_usuario',$this->_lco_usuario,10);
           
           if(!$luo_set->ReadcrsMant($luo_con, $stid, $crto)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
            $luo_con->commitTransaction();
            
            $lstData = [];
                
            $rowdata = clsViewData::viewData($lstData, false, 1,$luo_con->getMsgRetorno());
                 
            oci_free_statement($crto);
            
            oci_free_statement($stid);
            
            $luo_con->closeConexion();
            
            unset($luo_con);
            
            unset($luo_set);
                   
            return $rowdata;
             
         }
         catch(Exception $ex){
             return clsViewData::showError(($ex->getCode()), $ex->getMessage());
         }
     }
     
     public function lst_listar($an_prm_codigo,$as_criterio,$an_start,$an_limit){
         try{
             $ln_rowcount=0;
             
             $ls_sql="begin
                        pck_prm_local.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_prm_codigo,
                            :as_criterio,
                            :an_start,
                            :an_limit) ;
                      end;";
             
              $luo_con = new Db();
            
              $luo_set = new clsReference();
            
              if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
              }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_prm_codigo',$an_prm_codigo,10);
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
     
     public function lst_pendiente($an_prm_codigo,$as_criterio,$an_start,$an_limit){
         try{
             $ln_rowcount=0;
             
             $ls_sql="begin
                        pck_prm_local.sp_lst_pendiente (:acr_cursor,
                            :ln_rowcount,
                            :an_prm_codigo,
                            :as_criterio,
                            :an_start,
                            :an_limit) ;  
                      end;";
             
              $luo_con = new Db();
            
              $luo_set = new clsReference();
            
              if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
              }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_prm_codigo',$an_prm_codigo,10);
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
