<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clssegAutenticacion
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../utiles/fnUtiles.php");


class clssegAutenticacion {
    //put your code here
    private $_per_usuario;
    private $_per_password;
    private $_seg_codigo;
    
    function __construct() {
        $this->_per_usuario="";
        $this->_per_password="";
        $this->_seg_codigo=0;
    }
    
    function set_per_usuario($_per_usuario) {
        $this->_per_usuario = strtoupper($_per_usuario);
    }

    function set_per_password($_per_password) {
        $this->_per_password = $_per_password;
    }
    
    function set_seg_codigo($_seg_codigo) {
        $this->_seg_codigo = $_seg_codigo;
    }
    
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_validar(){
        try{
            $luo_con = new Db();
            
            $ls_sql="begin
                        pck_seg_cuenta.sp_autenticacion(
                        :acr_retorno,
                        :as_per_usuario,
                        :as_cta_password,
                        :an_seg_codigo);
                        end;";
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError()) ;}
          
            $stid=$luo_con->ociparse($ls_sql);
            
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $crto=$luo_con->ocinewcursor();
            if (!$crto){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $curs=$luo_con->ocinewcursor();
            if (!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}

            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR);
            oci_bind_by_name($stid,':as_per_usuario',$this->_per_usuario,20);
            oci_bind_by_name($stid,':as_cta_password',$this->_per_password,64);
            oci_bind_by_name($stid,':an_seg_codigo',$this->_seg_codigo,10);
           
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());};            
           
            if(!$luo_con->ociExecute($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());};
            
            $lstData = parsearcursor($crto);
            
            $arrayIP = array('IPADDRESS' => fn_GetIp());
            
            $lstData = array(array_merge($lstData['0'],$arrayIP));
          
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
            
            oci_free_statement($stid);
            
            $luo_con->closeConexion();
            
            unset($luo_con);
            
            return $rowdata;     
         
        }
        catch(Exception $ex){           
           return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
        
    }
    
    public function sp_valglprofile(){
        try{
            $ls_sql="begin
                        gmo.pck_seg_glprofile.sp_autenticacion (:acr_retorno,
                        :as_per_usuario,
                        :as_per_password);
                    end;";
            
            $luo_con = new Db();
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError()) ;}
          
            $stid=$luo_con->ociparse($ls_sql);
            
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $crto=$luo_con->ocinewcursor();
            if (!$crto){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $curs=$luo_con->ocinewcursor();
            if (!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}

            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR);
            oci_bind_by_name($stid,':as_per_usuario',$this->_per_usuario,20);
            oci_bind_by_name($stid,':as_per_password',$this->_per_password,64);
           
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());};            
           
            if(!$luo_con->ociExecute($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());};
            
            $lstData = parsearcursor($crto);
            
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                 
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
