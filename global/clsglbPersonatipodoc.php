<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsglbPersonatipodoc
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clsglbPersonatipodoc {
    //put your code here
    private $_per_codigo;
    private $_ptd_codigo;
    private $_tpo_codigo;
    private $_ptd_nrodocidentidad;
    private $_ptd_defecto;
    
    function set_per_codigo($_per_codigo) {
        $this->_per_codigo = $_per_codigo;
    }

    function set_ptd_codigo($_ptd_codigo) {
        $this->_ptd_codigo = $_ptd_codigo;
    }

    function set_tpo_codigo($_tpo_codigo) {
        $this->_tpo_codigo = $_tpo_codigo;
    }

    function set_ptd_nrodocidentidad($_ptd_nrodocidentidad) {
        $this->_ptd_nrodocidentidad = $_ptd_nrodocidentidad;
    }

    function set_ptd_defecto($_ptd_defecto) {
        $this->_ptd_defecto = $_ptd_defecto;
    }
    
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }

    public function sp_glb_personatipodoc($an_accion,$an_usuario){
        
        $luo_con= new Db();
        
        try{
               $ls_sql=" pck_glb_personatipodoc.sp_glb_personatipodoc (:an_accion,
                         :acr_retorno,
                         :acr_cursor,
                         :an_per_codigo,
                         :an_ptd_codigo,
                         :an_tpo_codigo,
                         :as_ptd_nrodocidentidad,
                         :as_ptd_defecto,
                         :an_ptd_usuario)"; 
               
                  $stid=$luo_con->ociparse($ls_sql);
            
                  $stid=$luo_con->ociparse($ls_sql);            
                  if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
                  $crto = $luo_con->ocinewcursor();            
                  if(!$crto){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
                  $curs = $luo_con->ocinewcursor();            
                  if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                  
                  oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
                  oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
                  oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
                  oci_bind_by_name($stid,':an_per_codigo',$this->_per_codigo,10);
                  oci_bind_by_name($stid,':an_ptd_codigo',$this->_ptd_codigo,10);
                  oci_bind_by_name($stid,':an_tpo_codigo',$this->_tpo_codigo,10);
                  oci_bind_by_name($stid,':as_ptd_nrodocidentidad',$this->_ptd_nrodocidentidad,20);
                  oci_bind_by_name($stid,':as_ptd_defecto',$this->_ptd_defecto,20);
                  oci_bind_by_name($stid,':an_ptd_usuario',$an_usuario,10);
                  
                  if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                  if(!$luo_con->ociExecute($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
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
            
            catch(exception $ex){
                clsViewData::showError($ex->getCode(), $ex->getMessage());
            }
    }
    
    public function lst_listar($an_per_codigo){
        
        $luo_con = new Db();
        $ln_ptd_codigo=0;
        
        try{ 
            $ls_sql="begin pck_glb_personatipodoc.sp_lst_listar(:acr_cursor,:an_per_codigo,:an_ptd_codigo); end;";
            
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
       
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_per_codigo',$an_per_codigo,10);
             oci_bind_by_name($stid,':an_per_codigo',$ln_ptd_codigo,10);
             
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;    
        }
        catch(Exception $ex){
            clsViewData::showError($ex->getCode(), $ex->getMessage());
        }        
    }
}
