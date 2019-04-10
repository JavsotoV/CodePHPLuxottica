<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgrhCentrolaboral
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsgrhCentrolaboral {
    //put your code here
    private $_ctl_codigo;
    private $_asg_codigo;
    private $_cfg_codigo;
    private $_ctl_fechai;
    private $_ctl_fechat;
    private $_ctl_usuario;

    function __construct($an_ctl_usuario) {
        $this->_ctl_usuario=$an_ctl_usuario;
        $this->_ctl_codigo=0;
        $this->_cfg_codigo=[];
    }
    
    function set_ctl_codigo($_ctl_codigo) {
        $this->_ctl_codigo = $_ctl_codigo;
    }

    function set_asg_codigo($_asg_codigo) {
        $this->_asg_codigo = $_asg_codigo;
    }

    function set_cfg_codigo($_cfg_codigo) {
        $this->_cfg_codigo = $_cfg_codigo;
    }

    function set_ctl_fechai($_ctl_fechai) {
        $this->_ctl_fechai = validaNull($_ctl_fechai,'01/01/1900','date');
    }

    function set_ctl_fechat($_ctl_fechat) {
        $this->_ctl_fechat = validaNull($_ctl_fechat,'01/01/1900','date');
    }

    public function loadData ( $lstParametros ){
     foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_grh_centrolaboral($an_accion){
        try{
            $ls_sql="begin
                        pck_grh_centrolaboral.sp_grh_centrolaboral (:an_accion,
                        :acr_retorno,
                        :an_ctl_codigo,
                        :an_asg_codigo,
                        :an_cfg_codigo,
                        to_date(:ad_ctl_fechai,'dd/mm/yyyy'),
                        to_date(:ad_ctl_fechat,'dd/mm/yyyy'),
                        :an_ctl_usuario);
                    end;";
            
            $luo_con= new  Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
           
           if ($an_accion==3){
                $this->_cfg_codigo=Array(0,1);
           }
            
           $ln_count = count($this->_cfg_codigo);
           
            if ($ln_count<1){return clsViewData::showError(-1,'Array de datos sin elementos');}
            
           oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':an_ctl_codigo',$this->_ctl_codigo,10);
           oci_bind_by_name($stid,':an_asg_codigo',$this->_asg_codigo,10);
           oci_bind_array_by_name($stid,':an_cfg_codigo',$this->_cfg_codigo,$ln_count,-1,SQLT_INT);
           oci_bind_by_name($stid,':ad_ctl_fechai',$this->_ctl_fechai,12);
           oci_bind_by_name($stid,':ad_ctl_fechat',$this->_ctl_fechat,12);           
           oci_bind_by_name($stid,':an_ctl_usuario',$this->_ctl_usuario,10);
           
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
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_listar($an_asg_codigo,$as_criterio,$an_start,$an_limit){
        try{
            
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_grh_centrolaboral.sp_lst_listar (:acr_cursor,
                        :ln_rowcount,
                        :an_asg_codigo,
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
             oci_bind_by_name($stid,':an_asg_codigo',$an_asg_codigo,60);
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
    
    public function lst_pendiente($an_asg_codigo,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                    pck_grh_centrolaboral.sp_lst_pendiente (:acr_cursor,
                    :ln_rowcount,
                    :an_asg_codigo,
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
             oci_bind_by_name($stid,':an_asg_codigo',$an_asg_codigo,10);
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
