<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsmtaControl
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsmtaControl {
    //put your code here
    private $_ctr_codigo;
    private $_ctr_fechai;
    private $_ctr_fechat;
    private $_ctr_usuario;
    
    function __construct($an_ctr_usuario) {
        $this->_ctr_usuario=$an_ctr_usuario;
    }
    
    function set_ctr_codigo($_ctr_codigo) {
        $this->_ctr_codigo = $_ctr_codigo;
    }

    function set_ctr_fechai($_ctr_fechai) {
        $this->_ctr_fechai = validaNull($_ctr_fechai,'date','01/01/1900');
    }

    function set_ctr_fechat($_ctr_fechat) {
        $this->_ctr_fechat = validaNull($_ctr_fechat,'date','01/01/1900');
    }

     public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }

    public function sp_mta_control($an_accion){
        try{
            $ls_sql="begin
                        pck_mta_control.sp_mta_control (:an_accion,
                            :acr_retorno,
                            :acr_cursor,
                            :an_ctr_codigo,
                            to_date(:ad_ctr_fechai,'dd/mm/yyyy'),
                            to_date(:ad_ctr_fechat,'dd/mm/yyyy'),
                            :an_ctr_usuario);
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_ctr_codigo',$this->_ctr_codigo,10);
            oci_bind_by_name($stid,':ad_ctr_fechai',$this->_ctr_fechai,12);
            oci_bind_by_name($stid,':ad_ctr_fechat',$this->_ctr_fechat,12);
            oci_bind_by_name($stid,':an_ctr_usuario',$this->_ctr_usuario,10);
            
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
    
    public function lst_listar($an_ctr_codigo,$an_ctr_periodo,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_mta_control.sp_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_ctr_codigo,
                            :an_ctr_periodo,
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
             oci_bind_by_name($stid,':an_ctr_codigo',$an_ctr_codigo,10);
             oci_bind_by_name($stid,':an_ctr_periodo',$an_ctr_periodo,10);
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
            return clsViewData::showError($ex->getCode(),$ex->getMessage());
        }
    }

}
