<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgmaRequerimiento
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");


class clsgmaRequerimiento {
    private $_rqe_codigo;
    private $_srv_codigo;
    private $_rqe_denominacion;
    private $_rqe_prioridad;    
    private $_rqd_codigo;
    private $_rse_nivel;
    private $_pai_codigo;
    private $_rqd_tiemporpta;
    private $_rqe_tiempound;
    private $_rqe_usuario;
    
    function __construct($an_usuario) {
        $this->_rqe_usuario=$an_usuario;
        $this->_rqe_codigo=0;
        $this->_srv_codigo=0;
        $this->_rqe_prioridad=0;
        $this->_rqe_tiempound=0;
        $this->_rqd_codigo=[];
        $this->_rse_nivel=[];
        $this->_pai_codigo=[];
        $this->_rqd_tiemporpta=[];
    }
    
    function set_rqe_codigo($_rqe_codigo) {
        $this->_rqe_codigo = $_rqe_codigo;
    }

    function set_srv_codigo($_srv_codigo) {
        $this->_srv_codigo = $_srv_codigo;
    }

    function set_rqe_denominacion($_rqe_denominacion) {
        $this->_rqe_denominacion = mb_strtoupper($_rqe_denominacion,'utf-8');
    }

    function set_rqe_prioridad($_rqe_prioridad) {
        $this->_rqe_prioridad = $_rqe_prioridad;
    }
    
    function set_rqd_codigo($_rqd_codigo) {
        $this->_rqd_codigo = $_rqd_codigo;
    }

    function set_rse_nivel($_rse_nivel) {
        $this->_rse_nivel = $_rse_nivel;
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = $_pai_codigo;
    }
    
    function set_rqd_tiemporpta($_rqd_tiemporpta) {
        $this->_rqd_tiemporpta = $_rqd_tiemporpta;
    }

    function set_rqe_tiempound($_rqe_tiempound) {
        $this->_rqe_tiempound = $_rqe_tiempound;
    }
        
    public function loadData ( $lstParametros ){
     foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_gma_requerimiento($an_accion){
        try{
            $ls_sql="begin
                        mda.pck_gma_requerimiento.sp_gma_requerimiento (  :an_accion,
                            :acr_retorno,
                            :acr_cursor,
                            :an_rqe_codigo,
                            :an_srv_codigo,
                            :as_rqe_denominacion,
                            :an_rqe_prioridad,
                            :an_rqd_codigo,
                            :an_rse_nivel,
                            :an_pai_codigo,
                            :an_rqd_tiemporpta,
                            :an_rqe_tiempound,
                            :an_rqe_usuario);
                    end;";
            
            $luo_con= new  Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            if ($an_accion==3){
                $this->_rqd_codigo=Array(0,1);
                $this->_rse_nivel=Array(0,1);
                $this->_pai_codigo=Array(0,1);
                $this->_rqd_tiemporpta=Array(0,1);
            }
            
            $ln_count = count($this->_rqd_codigo);
            
            if ($ln_count<1){return clsViewData::showError(-1,'Array sin elementos');}
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_rqe_codigo',$this->_rqe_codigo,10);
            oci_bind_by_name($stid,':an_srv_codigo',$this->_srv_codigo,10);
            oci_bind_by_name($stid,':as_rqe_denominacion',$this->_rqe_denominacion,250);
            oci_bind_by_name($stid,':an_rqe_prioridad',$this->_rqe_prioridad,10);
            oci_bind_array_by_name($stid,':an_rqd_codigo',$this->_rqd_codigo,$ln_count,-1,SQLT_INT);
            oci_bind_array_by_name($stid,':an_rse_nivel',$this->_rse_nivel,$ln_count,-1,SQLT_INT);
            oci_bind_array_by_name($stid,':an_pai_codigo',$this->_pai_codigo,$ln_count,-1,SQLT_INT);
            oci_bind_array_by_name($stid,':an_rqd_tiemporpta',$this->_rqd_tiemporpta,$ln_count,-1,SQLT_INT);
            oci_bind_by_name($stid,':an_rqe_tiempound',$this->_rqe_tiempound,10);
            oci_bind_by_name($stid,':an_rqe_usuario',$this->_rqe_usuario,10);
            
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

    public function lst_listar($an_rqe_codigo,$an_srv_codigo,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        mda.pck_gma_requerimiento.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_rqe_codigo,
                            :an_srv_codigo,
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
             oci_bind_by_name($stid,':an_rqe_codigo',$an_rqe_codigo,10);
             oci_bind_by_name($stid,':an_srv_codigo',$an_srv_codigo,10);
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
