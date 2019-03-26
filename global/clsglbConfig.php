<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsglbConfig
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsglbConfig {
    //put your code here
    
    private $_tda_codigo;
    private $_cfg_codigo;
    private $_ubg_codigo;
    private $_tda_usuario;
    private $_pai_codigo;
    private $_nombre;
    private $_email;
    private $_direccion;
    private $_codsap;
    
    
    function __construct($an_usuario) {
        $this->_tda_usuario=$an_usuario;
        $this->_pai_codigo=0;
        $this->_nombre='';
        $this->_email='';
        $this->_direccion='';
        $this->_ubg_codigo=0;
        $this->_codsap='';
    }
    
    function set_tda_codigo($_tda_codigo) {
        $this->_tda_codigo = $_tda_codigo;
    }

    function set_cfg_codigo($_cfg_codigo) {
        $this->_cfg_codigo = $_cfg_codigo;
    }

    function set_ubg_codigo($_ubg_codigo) {
        $this->_ubg_codigo = validaNull($_ubg_codigo,0,'int');
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = validaNull($_pai_codigo,0,'int');
    }

    function set_nombre($_nombre) {
        $this->_nombre = mb_strtoupper($_nombre,'utf-8');
    }

    function set_email($_email) {
        $this->_email = mb_strtolower($_email,'utf-8');
    }

    function set_direccion($_direccion) {
        $this->_direccion = mb_strtoupper($_direccion,'utf-8');
    }

    function set_codsap($_codsap) {
        $this->_codsap = $_codsap;
    }

    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_glb_config($an_accion){
        try{
            $ls_sql="begin
                        pck_glb_config.sp_glb_config (:an_accion,
                            :acr_retorno,
                            :an_cfg_codigo,
                            :an_tda_codigo,
                            :an_ubg_codigo,
                            :an_tda_usuario);
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_cfg_codigo',$this->_cfg_codigo,10);            
            oci_bind_by_name($stid,':an_tda_codigo',$this->_tda_codigo,10);            
            oci_bind_by_name($stid,':an_ubg_codigo',$this->_ubg_codigo,10);            
            oci_bind_by_name($stid,':an_tda_usuario',$this->_tda_usuario,10);
            
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
    
    public function sp_glb_oficina($an_accion){
        try{
            $ls_sql="begin
                    pck_glb_config.sp_glb_oficina (:an_accion,
                        :acr_retorno,
                        :an_cfg_codigo,
                        :an_pai_codigo,
                        :as_nombre,
                        :as_email,
                        :as_direccion,
                        :an_ubg_codigo,     
                        :as_codsap,
                        :an_tda_usuario);
                    end;";
            
            $luo_con= new  Db();
            
           $luo_set = new clsReference();
            
           if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
           };
           
           oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':an_cfg_codigo',$this->_cfg_codigo,10);
           oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
           oci_bind_by_name($stid,':as_nombre',$this->_nombre,120);
           oci_bind_by_name($stid,':as_email',$this->_email,120);
           oci_bind_by_name($stid,':as_direccion',$this->_direccion,120);
           oci_bind_by_name($stid,':an_ubg_codigo',$this->_ubg_codigo,10);
           oci_bind_by_name($stid,':as_codsap',$this->_codsap,10);
           oci_bind_by_name($stid,':an_tda_usuario',$this->_tda_usuario,10);
           
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
    
    public function lst_listar($an_pai_codigo,$an_cfg_codigo,$as_criterio,$an_tipo=1,$an_start,$an_limit){
        
        try{
           $ln_rowcount=0;
           
           if ($an_tipo<1){$an_tipo=1;}
            
            $ls_sql="begin
                        pck_glb_config.sp_lst_listar(:acr_cursor,
                            :ln_rowcount,
                            :an_pai_codigo,
                            :an_cfg_codigo,
                            :as_criterio,
                            :an_tipo,
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
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
             oci_bind_by_name($stid,':an_cfg_codigo',$an_cfg_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,120);
             oci_bind_by_name($stid,':an_tipo',$an_tipo,10);
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
    
    
    
    public function lst_localxtienda($an_tda_codigo,$as_criterio,$an_tipo=1,$an_start,$an_limit){
        try{
             $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_glb_config.sp_lst_localxtienda(:acr_cursor,
                            :ln_rowcount,
                            :an_tda_codigo,
                            :as_criterio,
                            :an_tipo,
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
             oci_bind_by_name($stid,':an_tda_codigo',$an_tda_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,120);
             oci_bind_by_name($stid,':an_tipo',$an_tipo,120);
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
    
  
}
