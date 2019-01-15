<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsglbTienda
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clsglbTienda {
    //put your code here
    
    private $_tda_codigo;
    private $_ubg_codigo;
    private $_ctr_codigo;
    private $_tda_descripcion;
    private $_tda_codinterno;
    private $_cda_codigo;
    private $_tda_tipo;
    
    function set_tda_codigo($_tda_codigo) {
        $this->_tda_codigo = validaNull($_tda_codigo,0,'int');
    }

    function set_ubg_codigo($_ubg_codigo) {
        $this->_ubg_codigo = validaNull($_ubg_codigo,0,'int');
    }

    function set_ctr_codigo($_ctr_codigo) {
        $this->_ctr_codigo = validaNull($_ctr_codigo,0,'int');
    }

    function set_tda_descripcion($_tda_descripcion) {
        $this->_tda_descripcion = mb_strtoupper($_tda_descripcion,'utf-8');
    }

    function set_tda_codinterno($_tda_codinterno) {
        $this->_tda_codinterno = mb_strtoupper($_tda_codinterno,'utf-8');
    }
    
    function set_cda_codigo($_cda_codigo) {
        $this->_cda_codigo = validaNull($_cda_codigo,0,'int');
    }

    function set_tda_tipo($_tda_tipo) {
        $this->_tda_tipo = $_tda_tipo;
    }
    
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
        
    public function sp_glb_tienda($an_accion,$an_usuario){
        try{
            $luo_con = new Db();
            
            $ls_sql="begin pck_glb_tienda.sp_glb_tienda(
                :an_accion,
                :acr_retorno,
                :acr_cursor,    
                :an_tda_codigo,
                :an_ubg_codigo,
                :an_ctr_codigo,
                :as_tda_descripcion,
                :as_tda_codinterno,
                :an_cda_codigo,
                :an_tda_tipo,
                :an_tda_usuario); end;";
            
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
            oci_bind_by_name($stid,':an_tda_codigo',$this->_tda_codigo,10);
            oci_bind_by_name($stid,':an_ubg_codigo',$this->_ubg_codigo,10);
            oci_bind_by_name($stid,':an_ctr_codigo',$this->_ctr_codigo,10);
            oci_bind_by_name($stid,':as_tda_descripcion',$this->_tda_descripcion,120);
            oci_bind_by_name($stid,':as_tda_codinterno',$this->_tda_codinterno,20);
            oci_bind_by_name($stid,':an_cda_codigo',$this->_cda_codigo,10);
            oci_bind_by_name($stid,':an_tda_tipo',$this->_tda_tipo,10);
            oci_bind_by_name($stid,':an_tda_usuario',$an_usuario,10);
            
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());};            
            if(!$luo_con->ociExecute($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());};
            
            if (!$luo_con->ocifetchRetorno($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}   
            
            $luo_con->commitTransaction();
            
            $lstData = ( $an_accion != 3 ? parsearcursor($curs) : [] );
                
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                 
            oci_free_statement($crto);
            oci_free_statement($stid);
            
            $luo_con->closeConexion();
                   
            return $rowdata;         
        }
        
        catch(Exception $ex){            
            clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_listar($an_pai_codigo,$as_criterio,$an_start,$an_limit){
        $ln_tda_codigo=0;
        $ln_rowcount=0;
        
        $luo_con = new Db();        
        
        try{
            $ls_sql="begin pck_glb_tienda.sp_lst_listar(:acr_cursor,:ln_rowcount,:an_tda_codigo,:an_pai_codigo,
                :as_criterio,:an_start,:an_limit); end;";
            
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_tda_codigo',$ln_tda_codigo,10) or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10) or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':as_criterio',$as_criterio,60) or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_start',$an_start,10) or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_limit',$an_limit,10) or die(oci_error($luo_con->refConexion));
                      
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false,$ln_rowcount);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;    
        }
        catch(Exception $ex){
            clsViewData::showError($ex->getCode(),$ex->getMessage());
        }
    }
    
    
}
