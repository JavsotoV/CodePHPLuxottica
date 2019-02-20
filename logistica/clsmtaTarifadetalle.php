<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsmtaTarifadetalle
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsmtaTarifadetalle {
    
    private $_trf_codigo;
    private $_trd_codigo;
    private $_cta_codigo;
    private $_trd_precio;
    private $_trd_precioiva;
    private $_trd_usuario;
    
    function __construct($an_trd_usuario) {
        $this->_trd_usuario=$an_trd_usuario;
    }
    
    function set_trf_codigo($_trf_codigo) {
        $this->_trf_codigo = $_trf_codigo;
    }

    function set_trd_codigo($_trd_codigo) {
        $this->_trd_codigo = validaNull($_trd_codigo,0,'int');
    }

    function set_cta_codigo($_cta_codigo) {
        $this->_cta_codigo = $_cta_codigo;
    }

    function set_trd_precio($_trd_precio) {
        $this->_trd_precio = number_format(validaNull($_trd_precio,0,'float'),2);
    }

    function set_trd_precioiva($_trd_precioiva) {
        $this->_trd_precioiva = number_format(validaNull($_trd_precioiva,0,'float'),2);
    }
    
    public function loadData ( $lstParametros ){
     foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_mta_tarifadetalle($an_accion){
        try{
            $ls_sql="begin
                        pck_mta_tarifadetalle.sp_mta_tarifadetalle (:an_accion,
                            :acr_retorno,
                            :an_trf_codigo,
                            :an_trd_codigo,
                            :an_cta_codigo,
                            to_number(:an_trd_precio,'999,999,999,999.999'),
                            to_number(:an_trd_precioiva,'999,999,999,999.999'),
                            :an_trd_usuario);
                        end;";
            
           $luo_con= new  Db();
            
           $luo_set = new clsReference();
            
           if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
           };
            
           oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':an_trf_codigo',$this->_trf_codigo,10);
           oci_bind_by_name($stid,':an_trd_codigo',$this->_trd_codigo,10);
           oci_bind_by_name($stid,':an_cta_codigo',$this->_cta_codigo,10);
           oci_bind_by_name($stid,':an_trd_precio',$this->_trd_precio,15);
           oci_bind_by_name($stid,':an_trd_precioiva',$this->_trd_precioiva,15);
           oci_bind_by_name($stid,':an_trd_usuario',$this->_trd_usuario,10);
         
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

    public function lst_listar($an_trf_codigo,$as_tipfamcod,$an_fam_codigo,$an_sfa_codigo,$an_gfa_codigo,$as_criterio,$an_start,$an_limit) {
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_mta_tarifadetalle.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_trf_codigo,
                            :as_tipfamcod,
                            :an_fam_codigo,
                            :an_sfa_codigo,
                            :an_gfa_codigo,
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
             oci_bind_by_name($stid,':an_trf_codigo',$an_trf_codigo,10);
             oci_bind_by_name($stid,':as_tipfamcod',$as_tipfamcod,10);
             oci_bind_by_name($stid,':an_fam_codigo',$an_fam_codigo,10);
             oci_bind_by_name($stid,':an_sfa_codigo',$an_sfa_codigo,10);
             oci_bind_by_name($stid,':an_gfa_codigo',$an_gfa_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,60);
             oci_bind_by_name($stid,':an_start',$an_start,10);
             oci_bind_by_name($stid,':an_limit',$an_limit,10);
             
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false,$ln_rowcount);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;
            
        }catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }   
    
    
    public function lst_precioarticulo($an_cta_codigo){
        try{
            $ls_sql="begin
                        pck_mta_tarifadetalle.sp_lst_articulotarifa (  :acr_cursor,
                        :an_cta_codigo) ;
                     end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_cta_codigo',$an_cta_codigo,10);
             
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
    
    public function lst_catalogoatributo($an_cta_codigo){
        try{
            $ls_sql="begin
                        pck_mta_catalogo.sp_lst_catalogoatributo (:acr_cursor,
                        :an_cta_codigo) ;
                     end;";
          
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_cta_codigo',$an_cta_codigo,10);
            
              if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;
        }
        catch(Exception $ex){
            
        }
    }
}
