<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsprmPlantilladet
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsprmPlantilladet {
    private $_plt_codigo;
    private $_pld_codigo;
    private $_pld_grupo;
    private $_pld_valor;
    private $_pld_rangoini;
    private $_pld_rangofin;
    private $_pld_estado;
    private $_pld_usuario;
    
    function __construct($an_pld_usuario) {
        $this->_pld_usuario=$an_pld_usuario;
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
    
    public function sp_prm_plantilladet($an_accion){
        try{
            $ls_sql="begin
                        pck_prm_plantilladet.sp_prm_plantilladet (:an_accion,
                            :acr_retorno,
                            :an_plt_codigo,
                            :an_pld_codigo,
                            :an_pld_grupo,
                            :an_pld_valor,
                            :an_pld_rangoini,
                            :an_pld_rangofin,
                            :an_pld_estado,
                            :an_pld_usuario) ;
                    end;";
            
            $luo_con= new  Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            if ($an_accion==3){
                $this->_pld_grupo=Array(0,1);
                $this->_pld_valor=Array(0,1);
                $this->_pld_rangoini=Array(0,1);
                $this->_pld_rangofin=Array(0,1);
            }
            
            $ln_count = count($this->_pld_codigo);
            
            if ($ln_count<1){return clsViewData::showError(-1,'Array de datos sin elementos');}
            
           oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':an_plt_codigo',$this->_plt_codigo,10);
           oci_bind_array_by_name($stid,':an_pld_codigo',$this->_pld_codigo,$ln_count,-1,SQLT_INT);
           oci_bind_array_by_name($stid,':an_pld_grupo',$this->_pld_grupo,$ln_count,-1,SQLT_INT);
           oci_bind_array_by_name($stid,':an_pld_valor',$this->_pld_valor,$ln_count,-1,SQLT_FLT);
           oci_bind_array_by_name($stid,':an_pld_rangoini',$this->_pld_rangoini,$ln_count,-1,SQLT_FLT);
           oci_bind_array_by_name($stid,':an_pld_rangofin',$this->_pld_rangofin,$ln_count,-1,SQLT_FLT);
           oci_bind_array_by_name($stid,':an_pld_estado',$this->_pld_estado,$ln_count,-1,SQLT_FLT);
           oci_bind_by_name($stid,':an_pld_usuario',$this->_plt_usuario,10);
            
            if(!$luo_set->ReadcrsMant($luo_con, $stid, $crto)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
            $luo_con->commitTransaction();
            
            $lstData =[];
                
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
    
    public function lst_listar($an_plt_codigo){
        try{
            $ls_sql="begin
                        pck_prm_plantilladet.sp_lst_listar (:acr_cursor,:an_plt_codigo) ;
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_plt_codigo',$an_plt_codigo,10);
            
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
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
