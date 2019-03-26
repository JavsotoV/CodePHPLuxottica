<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsprmPromocionCatalogo
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsprmPromocionCatalogo {
    //put your code here
    private $_prm_codigo;
    private $_prd_codigo;
    private $_prc_codigo;
    private $_plt_codigo;
    private $_pld_codigo;
    private $_pca_codigo;
    private $_fam_codigo;
    private $_sfa_codigo;
    private $_gfa_codigo;
    private $_cta_codigo;
    private $_prc_usuario;
    
    function __construct($an_prc_usuario) {
        $this->_prc_codigo=0;
        $this->_prc_usuario=$an_prc_usuario;
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

    function set_plt_codigo($_plt_codigo) {
        $this->_plt_codigo = $_plt_codigo;
    }

    function set_pld_codigo($_pld_codigo) {
        $this->_pld_codigo = $_pld_codigo;
    }

    function set_pca_codigo($_pca_codigo) {
        $this->_pca_codigo = $_pca_codigo;
    }

    function set_fam_codigo($_fam_codigo) {
        $this->_fam_codigo = $_fam_codigo;
    }

    function set_sfa_codigo($_sfa_codigo) {
        $this->_sfa_codigo = $_sfa_codigo;
    }

    function set_gfa_codigo($_gfa_codigo) {
        $this->_gfa_codigo = $_gfa_codigo;
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
    
    function sp_prm_promocioncatalogo($an_accion){
        try{
            $ls_sql="begin
                        pck_prm_promocioncatalogo.sp_prm_promocioncatalogo (:an_accion,
                            :acr_retorno,
                            :an_prm_codigo,
                            :an_prd_codigo,
                            :an_prc_codigo,
                            :an_plt_codigo,
                            :an_pld_codigo,
                            :an_pca_codigo,
                            :an_fam_codigo,
                            :an_sfa_codigo,
                            :an_gfa_codigo,
                            :an_cta_codigo,
                            :an_prc_usuario);
                        end;";
            
           $luo_con= new  Db();
            
           $luo_set = new clsReference();
            
           if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
           };
            
           oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':an_prm_codigo',$this->_prm_codigo,10);
           oci_bind_by_name($stid,':an_prd_codigo',$this->_prd_codigo,10);
           oci_bind_by_name($stid,':an_prc_codigo',$this->_prc_codigo,10);
           oci_bind_by_name($stid,':an_plt_codigo',$this->_plt_codigo,10);
           oci_bind_by_name($stid,':an_pld_codigo',$this->_pld_codigo,10);
           oci_bind_by_name($stid,':an_pca_codigo',$this->_pca_codigo,10);
           oci_bind_by_name($stid,':an_fam_codigo',$this->_fam_codigo,10);
           oci_bind_by_name($stid,':an_sfa_codigo',$this->_sfa_codigo,10);
           oci_bind_by_name($stid,':an_gfa_codigo',$this->_gfa_codigo,10);
           oci_bind_by_name($stid,':an_cta_codigo',$this->_cta_codigo,10);
           oci_bind_by_name($stid,':an_prc_usuario',$this->_prc_usuario,10);
            
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
    
    function lst_listar($an_prm_codigo){
        try{
            $ls_sql="begin
                        pck_prm_promocioncatalogo.sp_lst_listar (:acr_cursor,:an_prm_codigo) ;
                     end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_prm_codigo',$an_prm_codigo,10);
            
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
