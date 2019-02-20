<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgcaDerecho
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");


class clsgcaDerecho {
    private $_con_codigo;
    private $_der_codigo;
    private $_cpo_codigo;
    private $_der_fechai;
    private $_der_fechat;
    private $_mon_codigo;
    private $_der_importe;
    private $_der_usuario;

    function __construct($an_der_usuario) {
           $this->_der_codigo=0;
           $this->_der_usuario=$an_der_usuario;
    }
    
    function set_con_codigo($_con_codigo) {
        $this->_con_codigo = $_con_codigo;
    }

    function set_der_codigo($_der_codigo) {
        $this->_der_codigo = $_der_codigo;
    }

    function set_cpo_codigo($_cpo_codigo) {
        $this->_cpo_codigo = $_cpo_codigo;
    }

    function set_der_fechai($_der_fechai) {
        $this->_der_fechai = $_der_fechai;
    }

    function set_der_fechat($_der_fechat) {
        $this->_der_fechat = validaNull($_der_fechat, '01/01/1900', 'date');
    }

    function set_mon_codigo($_mon_codigo) {
        $this->_mon_codigo = $_mon_codigo;
    }

    function set_der_importe($_der_importe) {
        $this->_der_importe = number_format(validaNull($_der_importe,0,'float'),2);
    }
    
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }

    public function sp_gca_derecho($an_accion){
        try{
            $ls_sql="begin
                        pck_gca_derecho.sp_gca_derecho (:an_accion,
                            :acr_retorno,
                            :an_con_codigo,
                            :an_der_codigo,
                            :an_cpo_codigo,
                            :ad_der_fechai,
                            :ad_der_fechat,
                            :an_mon_codigo,
                            to_number(:an_der_importe,'999,999,999,999.999'),
                            :an_der_usuario);
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
                                             
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_con_codigo',$this->_con_codigo,10);    
            oci_bind_by_name($stid,':an_der_codigo',$this->_der_codigo,10);    
            oci_bind_by_name($stid,':an_cpo_codigo',$this->_cpo_codigo,10);    
            oci_bind_by_name($stid,':ad_der_fechai',$this->_der_fechai,12);    
            oci_bind_by_name($stid,':ad_der_fechat',$this->_der_fechat,12);    
            oci_bind_by_name($stid,':an_mon_codigo',$this->_mon_codigo,12);    
            oci_bind_by_name($stid,':an_der_importe',$this->_der_importe,15);    
            oci_bind_by_name($stid,':an_der_usuario',$this->_der_usuario,10);    
            
            if(!$luo_set->ReadcrsMant($luo_con, $stid, $crto)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
            $luo_con->commitTransaction();
            
            $lstData = [];
                
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                             
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
    
    public function lst_listar($an_con_codigo){
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_gca_derecho.sp_lst_listar (:acr_cursor,
                            :an_con_codigo);
                     end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_con_codigo',$an_con_codigo,10);
             
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
    

}
