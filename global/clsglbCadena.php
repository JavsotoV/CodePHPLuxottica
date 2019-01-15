<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsglbCadena
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");


class clsglbCadena {
    private $_cda_codigo;
    private $_cda_descripcion;
    private $_cda_codinterno;
    
    function __construct() {
        $this->_cda_codigo=0;
    }
   
    function set_cda_codigo($_cda_codigo) {
        $this->_cda_codigo =ValidaNull($_cda_codigo,0,'int');
    }

    function set_cda_descripcion($_cda_descripcion) {
        $this->_cda_descripcion = mb_strtoupper($_cda_descripcion,'utf-8');
    }

    function set_cda_codinterno($_cda_codinterno) {
        $this->_cda_codinterno = mb_strtoupper($_cda_codinterno,'utf-8');
    }

    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_glb_contrato($an_accion,$an_usuario){
      try{
          
          $luo_con= new Db();
          
          $ls_sql="begin
                    pck_glb_cadena.sp_glb_cadena (:an_accion,
                        :acr_retorno,
                        :acr_cursor,
                        :an_cda_codigo,
                        :as_cda_descripcion,
                        :as_cda_codinterno,
                        :an_cda_usuario);
                    end;";
          
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError()) ;}
          
            $stid=$luo_con->ociparse($ls_sql);
            
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $crto=$luo_con->ocinewcursor();
            if (!$crto){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $curs=$luo_con->ocinewcursor();
            if (!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10);
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR);
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR);
            oci_bind_by_name($stid,':an_cda_codigo',$this->_cda_codigo,10);
            oci_bind_by_name($stid,':as_cda_descripcion',$this->_cda_descripcion,120);
            oci_bind_by_name($stid,':as_cda_codinterno',$this->_cda_codinterno,20);
            oci_bind_by_name($stid,':an_cda_usuario',$this->_cda_usuario,10);
            
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());};            
            if(!$luo_con->ociExecute($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());};
            
            if (!$luo_con->ocifetchRetorno($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}   
            
            $luo_con->commitTransaction();
            
            $lstData = ( $an_accion != 3 ? parsearcursor($curs) : [] );
                
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                 
            oci_free_statement($crto);
            oci_free_statement($stid);
            
            $luo_con->closeConexion();
            
            unset($luo_con);
                   
            return $rowdata;         
          
      }  
      catch(Exception $ex){
          return clsViewData::showError($ex->getCode(), $ex->getMessage());
      }
    }
    
    public function lst_listar($as_criterio){
        try{
            $ln_cda_codigo=0;
            
            $luo_con = new Db();
            
            $ls_sql="begin
                	pck_glb_cadena.sp_lst_listar(:acr_cursor,
                            :an_cda_codigo,
                            :as_criterio);
                      end;";
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_cda_codigo',$ln_cda_codigo,10) or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':as_criterio',$as_criterio,60) or die(oci_error($luo_con->refConexion));
                      
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             return $rowdata;    

        }
     catch (Exception $ex){
     return clsViewData::showError($ex->getCode(), $ex->getMessage());
 }
    }
    
    
}
