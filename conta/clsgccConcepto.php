<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgccConcepto
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsgccConcepto {
    //put your code here
    
    private $_cpt_codigo;
    private $_cpt_descripcion;
    private $_cta_numero;
    private $_cpt_usuario;
    
    function __construct($an_cpt_usuario) {
        $this->_cpt_usuario=$an_cpt_usuario;
    }
    
    function set_cpt_codigo($_cpt_codigo) {
        $this->_cpt_codigo = $_cpt_codigo;
    }

    function set_cpt_descripcion($_cpt_descripcion) {
        $this->_cpt_descripcion = $_cpt_descripcion;
    }
    
    function set_cta_numero($_cta_numero) {
        $this->_cta_numero = $_cta_numero;
    }
    
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_gcc_concepto($an_accion){
        try{
            $ls_sql="begin
                            pck_gcc_concepto.sp_gcc_concepto (  :an_accion,
                                :acr_retorno,
                                :acr_cursor,
                                :an_cpt_codigo,
                                :as_cpt_descripcion,
                                :as_cta_numero,
                                :an_cpt_usuario);
                    end;";
            
             $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_cpt_codigo',$this->_cpt_codigo,10);
            oci_bind_by_name($stid,':an_cpt_descripcion',$this->_cpt_descripcion,120);
            oci_bind_by_name($stid,':as_cta_numero',$this->_cta_numero,20);
            oci_bind_by_name($stid,':an_cpt_usuario',$this->_cpt_usuario,10);
            
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
    
    
    public function lst_listar($an_cpt_codigo,$as_criterio,$an_start,$an_limit){
        try{
           $ln_rowcount=0;
           
           $ls_sql="begin
                        pck_gcc_concepto.sp_lst_listar(:acr_cursor,
                            :ln_rowcount,
                            :an_cpt_codigo,
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
             oci_bind_by_name($stid,':an_cpt_codigo',$an_cpt_codigo,10);
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
