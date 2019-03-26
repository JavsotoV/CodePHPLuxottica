<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsprmCatalogo
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsprmCatalogo {
    //put your code here
    private $_prm_codigo;
    private $_prd_codigo;
    private $_prc_codigo;
    private $_ctc_codigo;
    private $_cta_codigo;
    private $_ctc_usuario;

    function __construct($an_ctc_usuario) {
        $this->_ctc_usuario=$an_ctc_usuario;
        $this->_ctc_codigo=[];
        $this->_cta_codigo=[];
    }    
    
    function set_prm_codigo($_prm_codigo) {
        $this->_prm_codigo = $_prm_codigo;
    }

    function set_prd_codigo($_prd_codigo) {
        $this->_prd_codigo = $_prd_codigo;
    }

    function set_prc_codigo($_prc_codigo) {
        $this->_prc_codigo = $_prc_codigo;
    }

    function set_ctc_codigo($_ctc_codigo) {
        $this->_ctc_codigo = $_ctc_codigo;
    }

    function set_cta_codigo($_cta_codigo) {
        $this->_cta_codigo = $_cta_codigo;
    }

    public function loadData ( $lstParametros ){
     foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    function sp_prm_catalogo($an_accion){
        try{
            $ls_sql="begin
                        pck_prm_catalogo.sp_prm_catalogo (:an_accion,
                            :acr_retorno,
                            :an_prm_codigo,
                            :an_prd_codigo,
                            :an_prc_codigo,
                            :an_ctc_codigo,
                            :an_cta_codigo,
                            :an_ctc_usuario);
                    end;";
            
           $luo_con= new  Db();
            
           $luo_set = new clsReference();
            
           if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
           };
           
           if ($an_accion==3){
                $this->_cta_codigo=Array(0,1);               
           }
            
           $ln_count = count($this->_pld_codigo);
           
            if ($ln_count<1){return clsViewData::showError(-1,'Array de datos sin elementos');}
            
           oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':an_prm_codigo',$this->_prm_codigo,10);
           oci_bind_by_name($stid,':an_prd_codigo',$this->_prd_codigo,10);
           oci_bind_by_name($stid,':an_prc_codigo',$this->_prc_codigo,10);
           oci_bind_array_by_name($stid,':an_ctc_codigo',$this->_ctc_codigo,$ln_count,-1,SQLT_INT);
           oci_bind_array_by_name($stid,':an_cta_codigo',$this->_cta_codigo,$ln_count,-1,SQLT_INT);
           
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
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
}
