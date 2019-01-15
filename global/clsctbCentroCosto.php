<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsGlbCentroCosto
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clsctbCentroCosto {
    private $_ctr_codigo=0;
    private $_pai_codigo;
    private $_ctr_descripcion;
    private $_ctr_codinterno;
    
    function set_ctr_codigo($_ctr_codigo) {
        
        if ($_ctr_codigo==null) {$_ctr_codigo=0; }
        
        $this->_ctr_codigo = $_ctr_codigo;
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = $_pai_codigo;
    }

    function set_ctr_descripcion($_ctr_descripcion) {
        $this->_ctr_descripcion = mb_strtoupper($_ctr_descripcion,'utf-8');
    }

    function set_ctr_codinterno($_ctr_codinterno) {
        $this->_ctr_codinterno = mb_strtoupper($_ctr_codinterno,'utf-8');
    }

    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_ctb_centrocosto($an_accion,$an_usuario=1) {
     
        try{
            $luo_con=new Db();
            
              $ls_sql="begin pck_ctb_centrocosto.sp_ctb_centrocosto(:an_accion,
                    :acr_retorno,
                    :acr_cursor,
                    :an_ctr_codigo,
                    :an_pai_codigo,
                    :as_ctr_descripcion,
                    :as_ctr_codinterno,
                    :an_ctr_usuario); end;";
        
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
            oci_bind_by_name($stid,':an_ctr_codigo',$this->_ctr_codigo,10);
            oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
            oci_bind_by_name($stid,':as_ctr_descripcion',$this->_ctr_descripcion,120);
            oci_bind_by_name($stid,':as_ctr_codinterno',$this->_ctr_codinterno,20);
            oci_bind_by_name($stid,':an_ctr_usuario',$an_usuario,10);
            
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
    
    public function lst_listar($an_pai_codigo,$as_criterio='%',$an_start=0,$an_limit=30){
        
        $ln_ctr_codigo=0;
        $ln_rowcount=0;
        
        $luo_con = new Db();        
        
        try{
            $ls_sql="begin pck_ctb_centrocosto.sp_lst_listar (:acr_cursor,:ln_rowcount,:an_pai_codigo,:an_ctr_codigo,
                :as_criterio,:an_start,:an_limit); end;";
            
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10) or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_ctr_codigo',$ln_ctr_codigo,10) or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':as_criterio',$as_criterio,60) or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_start',$an_start,10) or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_limit',$an_limit,10) or die(oci_error($luo_con->refConexion));
                      
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false,$ln_rowcount);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             return $rowdata;    
        }
        catch(Exception $ex){
            clsViewData::showError($ex->getCode(),$ex->getMessage());
        }
    }
}
