<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgccEntidad
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");
//require_once("clsEnviarEmail.php");

class clsgccEntidad {
    //put your code here
    
    private $_ent_codigo;
    private $_pai_codigo;
    private $_prc_codigo;
    private $_per_codigo;
    private $_per_responsable;
    private $_mon_codigo;
    private $_ent_importe;
    private $_ent_usuario;
    
    function __construct($an_ent_usuario) {
        $this->_ent_usuario=$an_ent_usuario;
        $this->_ent_codigo=0;
        $this->_ent_importe=0;
    }
    
    function set_ent_codigo($_ent_codigo) {
        $this->_ent_codigo = $_ent_codigo;
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = $_pai_codigo;
    }

    function set_prc_codigo($_prc_codigo) {
        $this->_prc_codigo = $_prc_codigo;
    }

    function set_per_codigo($_per_codigo) {
        $this->_per_codigo = $_per_codigo;
    }

    function set_per_responsable($_per_responsable) {
        $this->_per_responsable = $_per_responsable;
    }

    function set_mon_codigo($_mon_codigo) {
        $this->_mon_codigo = $_mon_codigo;
    }
    
    function set_ent_importe($_ent_importe) {
        $this->_ent_importe =number_format(validaNull($_ent_importe,0,'float'),2);
    }

    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_gcc_entidad($an_accion){
        try{
            $ls_sql="begin
                        pck_gcc_entidad.sp_gcc_entidad (  :an_accion,
                            :acr_retorno,
                            :acr_cursor,
                            :an_ent_codigo,
                            :an_pai_codigo,
                            :an_prc_codigo,
                            :an_per_codigo,
                            :an_per_responsable,
                            :an_mon_codigo,
                            :an_ent_importe,
                            :an_ent_usuario) ;
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_ent_codigo',$this->_ent_codigo,10);
            oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
            oci_bind_by_name($stid,':an_prc_codigo',$this->_prc_codigo,10);
            oci_bind_by_name($stid,':an_per_codigo',$this->_per_codigo,10);
            oci_bind_by_name($stid,':an_per_responsable',$this->_per_responsable,10);
            oci_bind_by_name($stid,':an_mon_codigo',$this->_mon_codigo,10);
            oci_bind_by_name($stid,':an_ent_importe',$this->_ent_importe,15);
            oci_bind_by_name($stid,':an_ent_usuario',$this->_ent_usuario,10);
            
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
        catch (Exception $ex){
            
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_listar($an_ent_codigo,$an_pai_codigo,$an_prc_codigo,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_gcc_entidad.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_ent_codigo,
                            :an_pai_codigo,
                            :an_prc_codigo,
                            :as_criterio,
                            :an_start,
                            :an_limit) ;
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_ent_codigo',$an_ent_codigo,10);
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
             oci_bind_by_name($stid,':an_prc_codigo',$an_prc_codigo,10);
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
    
    public function lst_entidadxresponsable($an_prc_codigo,$an_per_responsable,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_gcc_entidad.sp_lst_entidadxresponsable (:acr_cursor,
                            :ln_rowcount,
                            :an_prc_codigo,
                            :an_per_responsable,
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
             oci_bind_by_name($stid,':an_prc_codigo',$an_prc_codigo,10);
             oci_bind_by_name($stid,':an_per_responsable',$an_per_responsable,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,10);
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
