<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsprmPlantillaCatalogo
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");


class clsprmPlantillaCatalogo {
    private $_plt_codigo;
    private $_pld_codigo;
    private $_pca_codigo;
    private $_pca_origen;
    private $_pca_paquete;
    private $_tipfamcod;
    private $_fam_codigo;
    private $_sfa_codigo;
    private $_gfa_codigo;
    private $_cta_codigo;
    private $_pca_operador;
    private $_pca_usuario;

    function __construct($an_pca_usuario) {
        $this->_pca_usuario=$an_pca_usuario;
        $this->_pca_paquete=0;
        $this->_pca_codigo=0;
        $this->_fma_codigo=0;
        $this->_sfa_codigo=0;
        $this->_gfa_codigo=0;
        $this->_cta_codigo=0;
        $this->_pca_operador=0;
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

    function set_pca_origen($_pca_origen) {
        $this->_pca_origen = $_pca_origen;
    }

    function set_pca_paquete($_pca_paquete) {
        $this->_pca_paquete = $_pca_paquete;
    }

    function set_tipfamcod($_tipfamcod) {
        $this->_tipfamcod = $_tipfamcod;
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

    function set_pca_operador($_pca_operador) {
        $this->_pca_operador = $_pca_operador;
    }

    public function loadData ( $lstParametros ){
     foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
        
    public function sp_prm_plantillacatalogo($an_accion){
        try{
            $ls_sql="begin
                        pck_prm_plantillacatalogo.sp_prm_plantillacatalogo (:an_accion,
                            :acr_retorno,
                            :an_plt_codigo,
                            :an_pld_codigo,
                            :an_pca_codigo,
                            :an_pca_origen,
                            :an_pca_paquete,
                            :as_tipfamcod,
                            :an_fam_codigo,
                            :an_sfa_codigo,
                            :an_gfa_codigo,
                            :an_cta_codigo,
                            :an_pca_operador,
                            :an_pca_usuario);
                     end;";
            
                $luo_con= new  Db();
            
           $luo_set = new clsReference();
            
           if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
           };
            
           oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':an_plt_codigo',$this->_plt_codigo,10);
           oci_bind_by_name($stid,':an_pld_codigo',$this->_pld_codigo,10);
           oci_bind_by_name($stid,':an_pca_codigo',$this->_pca_codigo,10);
           oci_bind_by_name($stid,':an_pca_origen',$this->_pca_origen,10);
           oci_bind_by_name($stid,':an_pca_paquete',$this->_pca_paquete,10);
           oci_bind_by_name($stid,':as_tipfamcod',$this->_tipfamcod,10);
           oci_bind_by_name($stid,':an_fam_codigo',$this->_fam_codigo,10);
           oci_bind_by_name($stid,':an_sfa_codigo',$this->_sfa_codigo,10);
           oci_bind_by_name($stid,':an_gfa_codigo',$this->_gfa_codigo,10);
           oci_bind_by_name($stid,':an_cta_codigo',$this->_cta_codigo,10);
           oci_bind_by_name($stid,':an_pca_operador',$this->_pca_operador,10);
           oci_bind_by_name($stid,':an_pca_usuario',$this->_pca_usuario,10);
           
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
    
    public function lst_listar($an_plt_codigo,$an_pld_codigo){
        try{
            $ls_sql="begin
                        pck_prm_plantillacatalogo.sp_lst_listar (:acr_cursor,
                            :an_plt_codigo) ;
                     end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_plt_codigo',$an_plt_codigo,10);
            
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
