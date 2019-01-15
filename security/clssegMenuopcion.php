<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clssegMenuopcion
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");


class clssegMenuopcion {
    //put your code here
    private $_mno_codigo;
    private $_men_codigo;
    private $_mno_denominacion;
    private $_mno_descripcion;
    private $_mno_orden;
    private $_mno_imagen;
    private $_pld_codigo;
    private $_mno_itemid;
    private $_mno_usuario;
    
    function __construct($an_mno_usuario) {
        $this->_mno_codigo=0;
        $this->_mno_usuario=$an_mno_usuario;
        $this->_pld_codigo=0;
    }
    
    function set_mno_codigo($_mno_codigo) {
        $this->_mno_codigo = $_mno_codigo;
    }

    function set_men_codigo($_men_codigo) {
        $this->_men_codigo = $_men_codigo;
    }

    function set_mno_denominacion($_mno_denominacion) {
        $this->_mno_denominacion = $_mno_denominacion;
    }

    function set_mno_descripcion($_mno_descripcion) {
        $this->_mno_descripcion = $_mno_descripcion;
    }

    function set_mno_orden($_mno_orden) {
        $this->_mno_orden = $_mno_orden;
    }

    function set_mno_imagen($_mno_imagen) {
        $this->_mno_imagen = $_mno_imagen;
    }

    function set_pld_codigo($_pld_codigo) {
        $this->_pld_codigo = $_pld_codigo;
    }

    function set_mno_itemid($_mno_itemid) {
        $this->_mno_itemid = $_mno_itemid;
    }

    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_seg_menuopcion($an_accion){
        try{
            $ls_sql="begin
                        pck_seg_menuopcion.sp_seg_menuopcion(:an_accion,
                                :acr_retorno,
                                :acr_cursor,
                                :an_mno_codigo,
                                :an_men_codigo,
                                :as_mno_denominacion,
                                :as_mno_descripcion,
                                :as_mno_itemid,
                                :an_mno_orden,
                                :as_mno_imagen,
                                :an_pld_codigo,
                                :an_mno_usuario);
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_mno_codigo',$this->_mno_codigo,10);
            oci_bind_by_name($stid,':an_men_codigo',$this->_men_codigo,10);
            oci_bind_by_name($stid,':as_mno_denominacion',$this->_mno_denominacion,120);
            oci_bind_by_name($stid,':as_mno_descripcion',$this->_mno_descripcion,120);
            oci_bind_by_name($stid,':as_mno_itemid',$this->_mno_itemid,120);
            oci_bind_by_name($stid,':an_mno_orden',$this->_mno_orden,10);
            oci_bind_by_name($stid,':as_mno_imagen',$this->_mno_imagen,120);
            oci_bind_by_name($stid,':an_pld_codigo',$this->_pld_codigo,10);
            oci_bind_by_name($stid,':an_mno_usuario',$this->_mno_usuario,10);
                        
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
    
    
    public function lst_listar($an_mno_codigo,$an_men_codigo){
        try{
            $ls_sql="begin
                        pck_seg_menuopcion.sp_listar (:acr_cursor,
                            :an_mno_codigo,
                            :an_men_codigo);
                     end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));             
             oci_bind_by_name($stid,':an_mno_codigo',$an_mno_codigo,10);       
             oci_bind_by_name($stid,':an_men_codigo',$an_men_codigo,10);
            
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
    
public function lst_orden($an_men_codigo    ){
    try{
        $ls_sql="begin
                    pck_seg_menuopcion.sp_lst_orden(:acr_cursor,:an_men_codigo);
                 end;";
        
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));             
             oci_bind_by_name($stid,':an_men_codigo',$an_men_codigo,10);
            
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             unset($luo_set);
             
             return $rowdata;    
    } 
    catch (Exception $ex) {
        return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }    
    }
}