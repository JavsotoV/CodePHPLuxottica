<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clssegMenu
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clssegMenu {
    //put your code here
    private $_men_codigo;
    private $_seg_codigo;
    private $_men_tipo;
    private $_men_key;
    private $_men_url;
    private $_men_denominacion;
    private $_men_descripcion;
    private $_men_imagen;
    private $_men_orden;
    private $_men_parent;
    private $_men_usuario;
    private $_plt_codigo;
    private $_men_view;
    private $_men_itemid;

    function __construct($an_men_usuario) {
        $this->_men_codigo=0;
        $this->_men_usuario=$an_men_usuario;
        $this->_men_url="";
        $this->_plt_codigo=0;
        $this->_men_view="";
        $this->_men_itemid="";
    }
    
    function set_men_codigo($_men_codigo) {
        $this->_men_codigo = $_men_codigo;
    }

    function set_seg_codigo($_seg_codigo) {
        $this->_seg_codigo = $_seg_codigo;
    }

    function set_men_tipo($_men_tipo) {
        $this->_men_tipo = $_men_tipo;
    }

    function set_men_key($_men_key) {
        $this->_men_key = $_men_key;
    }

    function set_men_url($_men_url) {
        $this->_men_url = $_men_url;
    }

    function set_men_denominacion($_men_denominacion) {
        $this->_men_denominacion = $_men_denominacion;
    }

    function set_men_descripcion($_men_descripcion) {
        $this->_men_descripcion = $_men_descripcion;
    }

    function set_men_imagen($_men_imagen) {
        $this->_men_imagen = $_men_imagen;
    }

    function set_men_orden($_men_orden) {
        $this->_men_orden = $_men_orden;
    }

    function set_men_parent($_men_parent) {
        $this->_men_parent = $_men_parent;
    }

    function set_plt_codigo($_plt_codigo) {
        $this->_plt_codigo = $_plt_codigo;
    }

    function set_men_view($_men_view) {
        $this->_men_view = $_men_view;
    }

    function set_men_itemid($_men_itemid) {
        $this->_men_itemid = $_men_itemid;
    }

    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_seg_menu($an_accion){
        try{
            $ls_sql="begin
                        pck_seg_menu.sp_seg_menu (:an_accion,
                            :acr_retorno,
                            :acr_cursor,
                            :an_men_codigo,
                            :an_seg_codigo,
                            :an_men_tipo,
                            :as_men_key,
                            :as_men_url,
                            :as_men_denominacion,
                            :as_men_descripcion,
                            :as_men_imagen,
                            :an_men_orden,
                            :an_men_parent,
                            :an_plt_codigo,
                            :as_men_view,
                            :as_men_itemid,
                            :an_men_usuario);
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_men_codigo',$this->_men_codigo,10);
            oci_bind_by_name($stid,':an_seg_codigo',$this->_seg_codigo,10);
            oci_bind_by_name($stid,':an_men_tipo',$this->_men_tipo,10);
            oci_bind_by_name($stid,':as_men_key',$this->_men_key,120);
            oci_bind_by_name($stid,':as_men_url',$this->_men_url,250);
            oci_bind_by_name($stid,':as_men_denominacion',$this->_men_denominacion,120);
            oci_bind_by_name($stid,':as_men_descripcion',$this->_men_descripcion,250);
            oci_bind_by_name($stid,':as_men_imagen',$this->_men_imagen,120);
            oci_bind_by_name($stid,':an_men_orden',$this->_men_orden,10);
            oci_bind_by_name($stid,':an_men_parent',$this->_men_parent,10);
            oci_bind_by_name($stid,':an_plt_codigo',$this->_plt_codigo,10);
            oci_bind_by_name($stid,':as_men_view',$this->_men_view,500);
            oci_bind_by_name($stid,':as_men_itemid',$this->_men_itemid,120);
            oci_bind_by_name($stid,':an_men_usuario',$this->_men_usuario,10);
                        
            if(!$luo_set->ReadcrsMant($luo_con, $stid, $crto)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
            $luo_con->commitTransaction();
            
            $lstData = ( $an_accion != 3 ? parsearcursor($curs) : [] );
                
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                 
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
    
    public function lst_listar($an_seg_codigo,$an_men_codigo,$as_criterio,$an_start,$an_limit){
        try{
            
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_seg_menu.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_seg_codigo,
                            :an_men_codigo,
                            :as_criterio,
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
             oci_bind_by_name($stid,':an_seg_codigo',$an_seg_codigo,10);
             oci_bind_by_name($stid,':an_men_codigo',$an_men_codigo,10);             
             oci_bind_by_name($stid,':as_criterio',$as_criterio,60);
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
    
    public function lst_carpeta($an_seg_codigo){
        try{
            $ls_sql="begin
                        pck_seg_menu.sp_lst_carpeta (:acr_cursor,
                            :an_seg_codigo);
                    end;";
            
             $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_seg_codigo',$an_seg_codigo,10);
             
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
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
    
    public function lst_orden($an_seg_codigo,$an_men_parent){
        try{
            $ls_sql="begin
                        pck_seg_menu.sp_lst_orden(:acr_cursor,
                            :an_seg_codigo,
                            :an_men_parent);
                    end;";
            
             $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_seg_codigo',$an_seg_codigo,10);
             oci_bind_by_name($stid,':an_men_parent',$an_men_parent,10);
             
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
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
    
    public function lst_menurol($an_men_codigo,$an_rol_codigo){
        
        try{
            $luo_con=new Db();
            
            $ls_sql="begin pck_seg_menu.sp_lst_menurol(:acr_cursor,:an_men_codigo,:an_rol_codigo); end;";
            
           if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError()) ;}
          
            $stid=$luo_con->ociparse($ls_sql);
            
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $curs=$luo_con->ocinewcursor();
            if (!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}

            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR);
            oci_bind_by_name($stid,':an_men_codigo',$an_men_codigo,10);
            oci_bind_by_name($stid,':an_rol_codigo',$an_rol_codigo,10);

            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());};            
           
            $lstData = parsearcursor($curs);
                
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
