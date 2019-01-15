<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clscntContenido
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clscntContenido {
    //put your code here
    private $_cnt_codigo;
    private $_cnt_denominacion;
    private $_cnt_icono;
    private $_pai_codigo;
    
    function set_cnt_codigo($_cnt_codigo) {
        $this->_cnt_codigo = ValidaNull($_cnt_codigo,0,'int');
    }

    function set_cnt_denominacion($_cnt_denominacion) {
        $this->_cnt_denominacion = $_cnt_denominacion;
    }
    
    function set_cnt_icono($_cnt_icono) {
        $this->_cnt_icono = $_cnt_icono;
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = $_pai_codigo;
    }

        
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }   
    
    public function sp_cnt_contenido($an_accion,$an_usuario){
        
        try{
            $luo_con = new Db();
            
            $ls_sql = "begin
                        varios.pck_cnt_contenido.sp_cnt_contenido (:an_accion,
                            :acr_retorno,
                            :acr_cursor,
                            :an_cnt_codigo,
                            :as_cnt_denominacion,
                            :as_cnt_icono,
                            :an_pai_codigo,
                            :an_cnt_usuario);
                        end;";
            
            if($luo_con->createConexion()==false){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $stid=$luo_con->ociparse($ls_sql);            
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $crto = $luo_con->ocinewcursor();            
            if(!$crto){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $curs = $luo_con->ocinewcursor();            
            if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_cnt_codigo',$this->_cnt_codigo,10);
            oci_bind_by_name($stid,':as_cnt_denominacion',$this->_cnt_denominacion,120);
            oci_bind_by_name($stid,':as_cnt_icono',$this->_cnt_icono,60);
            oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
            oci_bind_by_name($stid,':an_cnt_usuario',$an_usuario,10);
            
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
        catch(Exception $ex){
          clsViewData::showError($ex->getCode(), $ex->getMessage());              
        }
    }
    
    public function lst_listar($an_cnt_codigo,$as_criterio,$an_start,$an_limit){
        
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        varios.pck_cnt_contenido.sp_lst_listar (
                            :acr_cursor,
                            :ln_rowcount,
                            :an_cnt_codigo,
                            :as_criterio,
                            :an_start,
                            :an_limit);
                    end;";
            
            $luo_con = new Db();
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_cnt_codigo',$an_cnt_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,120);
             oci_bind_by_name($stid,':an_start',$an_start,10);
             oci_bind_by_name($stid,':an_limit',$an_limit,10);
             
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
            $rowdata= clsViewData::viewData(parsearcursor($curs),false,$ln_rowcount);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;
        }
        catch(Exception $ex){
            clsViewData::showError($ex->getCode(), $ex->getMessage());            
        }
    }
    
    public function lst_contenidoregion($an_pai_codigo){
        try{
            $ls_sql="begin
                        varios.pck_cnt_contenido.sp_lst_contenidoregion(
                            :acr_cursor,
                            :an_pai_codigo);
                    end;";
            
            $luo_con = new Db();
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();    
             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
             
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
