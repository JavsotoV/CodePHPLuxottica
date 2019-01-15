<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clssegRolSistema
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clssegRolSistema {
    //put your code here
    private $_rse_codigo;
    private $_seg_codigo;
    private $_rol_codigo;
    private $_rse_usuario;
    
    function __construct($an_rse_usuario) {
        $this->_rse_codigo=0;
        $this->_rse_usuario=$an_rse_usuario;
    }
    
    function set_rse_codigo($_rse_codigo) {
        $this->_rse_codigo = $_rse_codigo;
    }

    function set_seg_codigo($_seg_codigo) {
        $this->_seg_codigo = $_seg_codigo;
    }

    function set_rol_codigo($_rol_codigo) {
        $this->_rol_codigo = $_rol_codigo;
    }

    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_seg_rolsistema($an_accion){
        try{
            $ls_sql="begin
                        pck_seg_rolsistema.sp_seg_rolsistema (:an_accion,
                                :acr_retorno,
                                :acr_cursor,
                                :an_rse_codigo,
                                :an_seg_codigo,
                                :an_rol_codigo,
                                :an_rse_usuario);
                      end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_rse_codigo',$this->_rse_codigo,10);
            oci_bind_by_name($stid,':an_seg_codigo',$this->_seg_codigo,10);
            oci_bind_by_name($stid,':an_rol_codigo',$this->_rol_codigo,10);
            oci_bind_by_name($stid,':an_rse_usuario',$this->_rse_usuario,10);
            
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
    
    public function lst_listar($an_rse_codigo,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
             
            $ls_sql="begin
                        pck_seg_rolsistema.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_rse_codigo,     
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
            return clsViewData::showError($ex->getCode(),$ex->getMessage());                    
        }
    }
    
}
