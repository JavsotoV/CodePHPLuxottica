<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgmaServicio
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");


class clsgmaServicio {
        //put your code here
    private $_srv_codigo;
    private $_srv_denominacion;
    private $_are_codigo;
    private $_srv_origen;
    private $_srv_usuario;
    
    function __construct($an_usuario) {
        $this->_srv_usuario=$an_usuario;
        $this->_srv_origen=1;
    }
    
    function set_srv_codigo($_srv_codigo) {
        $this->_srv_codigo = ValidaNull($_srv_codigo,0,'int');
    }

    function set_srv_denominacion($_srv_denominacion) {
        $this->_srv_denominacion =mb_strtoupper($_srv_denominacion,'utf-8');
    }

    function set_are_codigo($_are_codigo) {
        $this->_are_codigo = $_are_codigo;
    }
    
    function set_srv_origen($_srv_origen) {
        $this->_srv_origen = $_srv_origen;
    }
       
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_gma_servicio($an_accion){
        try{
            $ls_sql="   begin
                            mda.pck_gma_servicio.sp_gma_servicio (:an_accion,
                                :acr_retorno,
                                :acr_cursor,
                                :an_srv_codigo,
                                :as_srv_denominacion,
                                :an_are_codigo,
                                :an_srv_origen,
                                :an_srv_usuario);
                        end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_srv_codigo',$this->_srv_codigo,10);
            oci_bind_by_name($stid,':as_srv_denominacion',$this->_srv_denominacion,120);
            oci_bind_by_name($stid,':an_are_codigo',$this->_are_codigo,10);
            oci_bind_by_name($stid,':an_srv_origen',$this->_srv_origen,10);
            oci_bind_by_name($stid,':an_srv_usuario',$this->_srv_usuario,10);
            
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
    
    public function lst_listar($an_are_codigo,$an_srv_codigo,$an_srv_origen,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        mda.pck_gma_servicio.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_are_codigo,
                            :an_srv_codigo,
                            :an_srv_origen,
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
             oci_bind_by_name($stid,':an_are_codigo',$an_are_codigo,10);
             oci_bind_by_name($stid,':an_srv_codigo',$an_srv_codigo,10);
             oci_bind_by_name($stid,':an_srv_origen',$an_srv_origen,10);
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
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
        
    }


}
