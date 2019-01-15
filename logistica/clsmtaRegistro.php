<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsmtaRegistro
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsmtaRegistro {
    //put your code here
    private $_reg_codigo;
    private $_per_codigo;
    private $_reg_usuario;
    
    function __construct($an_user_codigo) {
        $this->_reg_usuario=$an_user_codigo;
        $this->_reg_codigo=0;
    }
    
    function set_reg_codigo($_reg_codigo) {
        $this->_reg_codigo = $_reg_codigo;
    }

    function set_per_codigo($_per_codigo) {
        $this->_per_codigo = $_per_codigo;
    }

    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_mta_registro($an_accion){
        try{
            $ls_sql="begin
                        pck_mta_registro.sp_mta_registro (:an_accion,
                        :acr_retorno,
                        :acr_cursor,
                        :an_reg_codigo,
                        :an_per_codigo,
                        :an_reg_usuario);
                    end;";
        
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_reg_codigo',$this->_reg_codigo,10);
            oci_bind_by_name($stid,':an_per_codigo',$this->_per_codigo,10);
            oci_bind_by_name($stid,':an_reg_usuario',$this->_reg_usuario,10);
            
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

    public function lst_listar($an_reg_codigo,$an_per_codigo,$an_ctr_periodo,$an_start,$an_limit){
        
        try{
        
            $ln_rowcount=0;
        
            $ls_sql="begin
                pck_mta_registro.sp_listar (:acr_cursor,
                    :ln_rowcount,
                    :an_reg_codigo,
                    :an_per_codigo,
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
             oci_bind_by_name($stid,':an_reg_codigo',$an_reg_codigo,10);
             oci_bind_by_name($stid,':an_per_codigo',$an_per_codigo,10);
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
                return clsViewData::showError($ex->getCode(), $ex->getMessage());
            }
    }
}
