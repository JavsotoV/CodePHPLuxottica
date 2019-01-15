<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clssegChangePwd
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clssegChangePwd {
      private $_per_codigo;
      private $_pwd_act;
      private $_pwd_nvo;
      
      function __construct($_per_codigo) {
          $this->_per_codigo=$_per_codigo;
      }
      
      function set_per_codigo($_per_codigo) {
          $this->_per_codigo = $_per_codigo;
      }

      function set_pwd_act($_pwd_act) {
          $this->_pwd_act = $_pwd_act;
      }

      function set_pwd_nvo($_pwd_nvo) {
          $this->_pwd_nvo = $_pwd_nvo;
      }
      
      public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
          }
      }
      
      public function changepwd(){
          try{
              $luo_con = new Db();
              
              $ls_sql="begin
                  pck_seg_cuenta.sp_changepwd(:acr_retorno,
                  :an_per_codigo,
                  :as_cta_password,
                  :as_cta_nuevo);  
                  end;";
              
                if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError()) ;}
                
                $stid=$luo_con->ociparse($ls_sql);       
                if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                
                $crto = $luo_con->ocinewcursor();            
                if(!$crto){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
                oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
                oci_bind_by_name($stid,':an_per_codigo',$this->_per_codigo,20);
                oci_bind_by_name($stid,':as_cta_password',$this->_pwd_act,64);
                oci_bind_by_name($stid,':as_cta_nuevo',$this->_pwd_nvo,64);
         
                if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                
                if(!$luo_con->ociExecute($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());};
            
                $luo_con->commitTransaction();
                
                $lstData = parsearcursor($crto);
                
                $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
              
                oci_free_statement($stid);
                
                $luo_con->closeConexion();
            
                unset($luo_con);
                   
                return $rowdata;      
                
          }
          catch(Exception $ex){
            return    clsViewData::showError($ex->getCode(),$ex->getMessage());
          }
      }


}
