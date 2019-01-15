<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgccRendiciondet
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsgccRendiciondet {
    //put your code here
    private $_ren_codigo;
    private $_red_codigo;
    private $_cmp_codigo;
    private $_red_usuario;
    
    function __construct($an_red_usuario) {
        $this->_red_usuario=$an_red_usuario;
        $this->_red_codigo=[];
        $this->_cmp_codigo=[];
    }
    
    function set_ren_codigo($_ren_codigo) {
        $this->_ren_codigo = $_ren_codigo;
    }

    function set_red_codigo($_red_codigo) {
        $this->_red_codigo = $_red_codigo;
    }

    function set_cmp_codigo($_cmp_codigo) {
        $this->_cmp_codigo = $_cmp_codigo;
    }

    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_gcc_rendiciondet($an_accion){
        try{
            $ls_sql="begin
                        pck_gcc_rendiciondet.sp_gcc_rendiciondet (:an_accion,
                            :acr_retorno,
                            :an_ren_codigo,
                            :an_red_codigo,
                            :an_cmp_codigo,
                            :an_red_usuario);
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            $ln_count = count($this->_red_codigo);
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_ren_codigo',$this->_ren_codigo,10);
            oci_bind_array_by_name($stid,':an_red_codigo',$this->_red_codigo,$ln_count,-1,SQLT_INT);
            oci_bind_array_by_name($stid,':an_cmp_codigo',$this->_cmp_codigo,$ln_count,-1,SQLT_INT);
            oci_bind_by_name($stid,':an_red_usuario',$this->_red_usuario,10);
            
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
    
    public function lst_listar($an_ren_codigo,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_gcc_rendiciondet.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_ren_codigo,
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
             oci_bind_by_name($stid,':an_ren_codigo',$an_ren_codigo,10);
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
    
    function lst_pendienterendicion($an_ent_codigo,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_gcc_rendiciondet.sp_lst_pendienterendicion (:acr_cursor,
                            :ln_rowcount,
                            :an_ent_codigo,
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
             oci_bind_by_name($stid,':an_ent_codigo',$an_ent_codigo,10);
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
