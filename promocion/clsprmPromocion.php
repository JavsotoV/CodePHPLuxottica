<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsprmPromocion
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");


class clsprmPromocion {
    //put your code here
    private $_prm_codigo;
    private $_plt_codigo;
    private $_prm_denominacion;
    private $_pai_codigo;
    private $_prm_fechai;
    private $_prm_fechat;
    private $_prm_usuario;
    private $_prd_codigo;
    private $_pld_codigo;
    private $_prd_valor;
    private $_prd_rangoini;
    private $_prd_rangofin;
    private $_prd_estado;
    
    function __construct($an_prm_usuario) {
        $this->_prm_codigo=0;        
        $this->_prm_usuario=$an_prm_usuario;
        $this->_prd_codigo=[];
        $this->_pld_codigo=[];
        $this->_prd_valor=[];
        $this->_prd_rangoini=[];
        $this->_prd_rangofin=[];
        $this->_prd_estado=[];
    }
    
    function set_prm_codigo($_prm_codigo) {
        $this->_prm_codigo = $_prm_codigo;
    }

    function set_plt_codigo($_plt_codigo) {
        $this->_plt_codigo = $_plt_codigo;
    }

    function set_prm_denominacion($_prm_denominacion) {
        $this->_prm_denominacion = $_prm_denominacion;
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = $_pai_codigo;
    }

    function set_prm_fechai($_prm_fechai) {
        $this->_prm_fechai = $_prm_fechai;
    }

    function set_prm_fechat($_prm_fechat) {
        $this->_prm_fechat = validaNull($_prm_fechat, '01/01/1900', 'date');
    }

    function set_prd_codigo($_prd_codigo) {
        $this->_prd_codigo = $_prd_codigo;
    }

    function set_pld_codigo($_pld_codigo) {
        $this->_pld_codigo = $_pld_codigo;
    }

    function set_prd_valor($_prd_valor) {
        $this->_prd_valor = $_prd_valor;
    }

    function set_prd_rangoini($_prd_rangoini) {
        $this->_prd_rangoini = $_prd_rangoini;
    }

    function set_prd_rangofin($_prd_rangofin) {
        $this->_prd_rangofin = $_prd_rangofin;
    }

    function set_prd_estado($_prd_estado) {
        $this->_prd_estado = $_prd_estado;
    }

    public function loadData ( $lstParametros ){
     foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_prm_promocion($an_accion){
        try{
            $ls_sql="begin
                        pck_prm_promocion.sp_prm_promocion (:an_accion,
                        :acr_retorno,
                        :an_prm_codigo,
                        :an_plt_codigo,
                        :as_prm_denominacion,
                        :an_pai_codigo,
                        to_date(:ad_prm_fechai,'dd/mm/yyyy'),
                        to_date(:ad_prm_fechat,'dd/mm/yyyy'),
                        :an_pld_codigo,
                        :an_prd_codigo,
                        :an_prd_valor,
                        :an_prd_rangoini,
                        :an_prd_rangofin,
                        :an_prd_estado, 
                        :an_prm_usuario);
                    end;";
            
            $luo_con= new  Db();
            
           $luo_set = new clsReference();
            
           if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
           };
           
           if ($an_accion==3){
                $this->_pld_codigo=Array(0,1);
                $this->_prd_codigo=Array(0,1);
                $this->_prd_valor=Array(0,1);
                $this->_prd_rangoini=Array(0,1);
                $this->_prd_rangofin=Array(0,1);
                $this->_prd_estado=Array(0,1);
           }
            
           $ln_count = count($this->_prd_codigo);
           
            if ($ln_count<1){return clsViewData::showError(-1,'Array de datos sin elementos');}
            
           oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':an_prm_codigo',$this->_prm_codigo,10);
           oci_bind_by_name($stid,':an_plt_codigo',$this->_plt_codigo,10);
           oci_bind_by_name($stid,':as_prm_denominacion',$this->_prm_denominacion,120);
           oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
           oci_bind_by_name($stid,':ad_prm_fechai',$this->_prm_fechai,12);
           oci_bind_by_name($stid,':ad_prm_fechat',$this->_prm_fechat,12);
           oci_bind_array_by_name($stid,':an_pld_codigo',$this->_pld_codigo,$ln_count,-1,SQLT_INT);
           oci_bind_array_by_name($stid,':an_prd_codigo',$this->_prd_codigo,$ln_count,-1,SQLT_INT);
           oci_bind_array_by_name($stid,':an_prd_valor',$this->_prd_valor,$ln_count,-1,SQLT_FLT);
           oci_bind_array_by_name($stid,':an_prd_rangoini',$this->_prd_rangoini,$ln_count,-1,SQLT_FLT);
           oci_bind_array_by_name($stid,':an_prd_rangofin',$this->_prd_rangofin,$ln_count,-1,SQLT_FLT);
           oci_bind_array_by_name($stid,':an_prd_estado',$this->_prd_estado,$ln_count,-1,SQLT_INT);
           oci_bind_by_name($stid,':an_prm_usuario',$this->_prm_usuario,10);
           
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
    
    public function lst_listar($an_pai_codigo,$an_prm_activo,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_prm_promocion.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_pai_codigo,
                            :an_prm_activo,
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
             oci_bind_by_name($stid,':an_prm_activo',$an_prm_activo,10);
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
