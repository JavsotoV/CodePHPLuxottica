<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgrhAsignacion
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsgrhAsignacion {
    //put your code here
    private $_asg_codigo;
    private $_pai_codigo;
    private $_per_codigo;
    private $_crg_codigo;
    private $_asg_fechai;
    private $_asg_fechat;
    private $_asg_usuario;

    function __construct($an_asg_usuario) {
        $this->_asg_usuario=$an_asg_usuario;
        $this->_asg_codigo=0;
    }
    
    function set_asg_codigo($_asg_codigo) {
        $this->_asg_codigo = $_asg_codigo;
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = $_pai_codigo;
    }

    function set_per_codigo($_per_codigo) {
        $this->_per_codigo = $_per_codigo;
    }

    function set_crg_codigo($_crg_codigo) {
        $this->_crg_codigo = $_crg_codigo;
    }

    function set_asg_fechai($_asg_fechai) {
        $this->_asg_fechai = validaNull($_asg_fechai,'01/01/1900','date');
    }

    function set_asg_fechat($_asg_fechat) {
        $this->_asg_fechat = validaNull($_asg_fechat,'01/01/1900','date');
    }

    public function loadData ( $lstParametros ){
     foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_grh_asignacion($an_accion){
        try{
            $ls_sql="begin
                        pck_grh_asignacion.sp_grh_asignacion (:an_accion,
                        :acr_retorno,
                        :an_asg_codigo,
                        :an_pai_codigo,
                        :an_per_codigo,
                        :an_crg_codigo,
                        to_date(:ad_asg_fechai,'dd/mm/yyyy'),
                        to_date(:ad_asg_fechat,'dd/mm/yyyy'),
                        :an_asg_usuario);
                     end;";
            
            $luo_con= new  Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
           
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_asg_codigo',$this->_asg_codigo,10);
            oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
            oci_bind_by_name($stid,':an_per_codigo',$this->_per_codigo,10);
            oci_bind_by_name($stid,':an_crg_codigo',$this->_crg_codigo,10);
            oci_bind_by_name($stid,':ad_asg_fechai',$this->_asg_fechai,12);
            oci_bind_by_name($stid,':ad_asg_fechat',$this->_asg_fechat,12);
            oci_bind_by_name($stid,':an_asg_usuario',$this->_asg_usuario,12);
            
            if(!$luo_set->ReadcrsMant($luo_con, $stid, $crto)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
            $luo_con->commitTransaction();
            
            $lstData = [];
                
            $rowdata = clsViewData::viewData($lstData, false, 1,$luo_con->getMsgRetorno());
                 
            oci_free_statement($crto);
            
            oci_free_statement($stid);
            
            $luo_con->closeConexion();
            
            unset($luo_con);
            
            unset($luo_set);
                   
            return $rowdata;                
            
        }
        catch(Exception $ex){
            return clsViewData::showError(($ex->getCode()), $ex->getMessage());
        }
    }
    
    public function lst_listar($an_pai_codigo,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_grh_asignacion.sp_lst_listar (:acr_cursor,
                        :ln_rowcount,
                        :an_pai_codigo,
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
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,60);
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
