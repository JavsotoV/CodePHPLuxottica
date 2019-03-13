<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsprmPlantilla
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsprmPlantilla {
    //put your code here
    private $_plt_codigo;
    private $_plt_denominacion;
    private $_plt_descripcion;
    private $_ctg_codigo;
    private $_cpt_codigo;
    private $_plt_aplicacion;
    private $_plt_grupo;
    private $_plt_usuario;
    private $_pld_codigo;
    private $_pld_grupo;
    private $_pld_valor;
    private $_pld_rangoini;
    private $_pld_rangofin;
    private $_pld_estado;
    
    function __construct($an_plt_usuario) {        
        $this->_plt_usuario=$an_plt_usuario;
        $this->_plt_codigo=0;
        $this->_pld_codigo=[];
        $this->_pld_grupo=[];
        $this->_pld_valor=[];
        $this->_pld_rangoini=[];
        $this->_pld_rangofin=[];
        $this->_pld_estado=[];
    }
    
    function set_plt_codigo($_plt_codigo) {
        $this->_plt_codigo = $_plt_codigo;
    }

    function set_plt_denominacion($_plt_denominacion) {
        $this->_plt_denominacion = mb_strtoupper($_plt_denominacion,'utf-8');
    }

    function set_plt_descripcion($_plt_descripcion) {
        $this->_plt_descripcion = mb_strtoupper($_plt_descripcion,'utf-8');
    }

    function set_ctg_codigo($_ctg_codigo) {
        $this->_ctg_codigo = $_ctg_codigo;
    }

    function set_cpt_codigo($_cpt_codigo) {
        $this->_cpt_codigo = $_cpt_codigo;
    }

    function set_plt_aplicacion($_plt_aplicacion) {
        $this->_plt_aplicacion = $_plt_aplicacion;
    }

    function set_plt_grupo($_plt_grupo) {
        $this->_plt_grupo = $_plt_grupo;
    }

    function set_pld_codigo($_pld_codigo) {
        $this->_pld_codigo = $_pld_codigo;
    }

    function set_pld_grupo($_pld_grupo) {
        $this->_pld_grupo = $_pld_grupo;
    }

    function set_pld_valor($_pld_valor) {
        $this->_pld_valor = $_pld_valor;
    }

    function set_pld_rangoini($_pld_rangoini) {
        $this->_pld_rangoini = $_pld_rangoini;
    }

    function set_pld_rangofin($_pld_rangofin) {
        $this->_pld_rangofin = $_pld_rangofin;
    }
        
    function set_pld_estado($_pld_estado) {
        $this->_pld_estado = $_pld_estado;
    }

    public function loadData ( $lstParametros ){
     foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_prm_plantilla($an_accion){
        try{
            $ls_sql="begin
                        pck_prm_plantilla.sp_prm_plantilla (:an_accion,
                            :acr_retorno,
                            :an_plt_codigo,
                            :as_plt_denominacion,
                            :as_plt_descripcion,
                            :an_ctg_codigo,
                            :an_cpt_codigo,
                            :an_plt_aplicacion,
                            :an_plt_grupo,
                            :an_pld_codigo,
                            :an_pld_grupo,
                            :an_pld_valor,
                            :an_pld_rangoini,
                            :an_pld_rangofin,
                            :an_pld_estado,
                            :an_plt_usuario);
                    end;";
               
           $luo_con= new  Db();
            
           $luo_set = new clsReference();
            
           if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
           };
           
           if ($an_accion==3){
                $this->_pld_codigo=Array(0,1);
                $this->_pld_grupo=Array(0,1);
                $this->_pld_valor=Array(0,1);
                $this->_pld_rangoini=Array(0,1);
                $this->_pld_rangofin=Array(0,1);
                $this->_pld_estado=Array(0,1);
           }
            
           $ln_count = count($this->_pld_codigo);
           
            if ($ln_count<1){return clsViewData::showError(-1,'Array de datos sin elementos');}
            
           oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':an_plt_codigo',$this->_plt_codigo,10);
           oci_bind_by_name($stid,':as_plt_denominacion',$this->_plt_denominacion,120);
           oci_bind_by_name($stid,':as_plt_descripcion',$this->_plt_descripcion,250);
           oci_bind_by_name($stid,':an_ctg_codigo',$this->_ctg_codigo,10);
           oci_bind_by_name($stid,':an_cpt_codigo',$this->_cpt_codigo,10);
           oci_bind_by_name($stid,':an_plt_aplicacion',$this->_plt_aplicacion,10);
           oci_bind_by_name($stid,':an_plt_grupo',$this->_plt_grupo,10);
           oci_bind_array_by_name($stid,':an_pld_codigo',$this->_pld_codigo,$ln_count,-1,SQLT_INT);
           oci_bind_array_by_name($stid,':an_pld_grupo',$this->_pld_grupo,$ln_count,-1,SQLT_INT);
           oci_bind_array_by_name($stid,':an_pld_valor',$this->_pld_valor,$ln_count,-1,SQLT_FLT);
           oci_bind_array_by_name($stid,':an_pld_rangoini',$this->_pld_rangoini,$ln_count,-1,SQLT_FLT);
           oci_bind_array_by_name($stid,':an_pld_rangofin',$this->_pld_rangofin,$ln_count,-1,SQLT_FLT);
           oci_bind_array_by_name($stid,':an_pld_estado',$this->_pld_estado,$ln_count,-1,SQLT_FLT);
           oci_bind_by_name($stid,':an_plt_usuario',$this->_plt_usuario,10);
           
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
    
    public function lst_listar($as_criterio,$an_start,$an_limit){
        try{
            
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_prm_plantilla.sp_lst_listar (:acr_cursor,
                        :ln_rowcount,
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
