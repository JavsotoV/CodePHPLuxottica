<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgccIncidencia
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");
require_once("clsgccEnviarEmail.php");

class clsgccIncidencia {
    //put your code here
    private $_ren_codigo;
    private $_red_codigo;
    private $_inc_observacion;
    private $_inc_estado;
    private $_inc_usuario;
    
    function __construct($an_inc_usuario) {
        $this->_inc_usuario=$an_inc_usuario;
        $this->_red_codigo=0;
    }
    
    function set_ren_codigo($_ren_codigo) {
        $this->_ren_codigo = $_ren_codigo;
    }

    function set_red_codigo($_red_codigo) {
        $this->_red_codigo = validaNull($_red_codigo,0,'int');
    }

    function set_inc_observacion($_inc_observacion) {
        $this->_inc_observacion = $_inc_observacion;
    }
    
    function set_inc_estado($_inc_estado) {
        $this->_inc_estado = $_inc_estado;
    }
    
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_gcc_incidencia($an_accion){
        try{
            $ls_sql="begin
                        pck_gcc_incidencia.sp_gcc_incidencia (:an_accion,
                            :acr_retorno,
                            :acr_cursor,
                            :an_ren_codigo,
                            :an_red_codigo,
                            :as_inc_observacion,
                            :an_inc_estado,
                            :an_inc_usuario);
                     end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_ren_codigo',$this->_ren_codigo,10);
            oci_bind_by_name($stid,':an_red_codigo',$this->_red_codigo,10);
            oci_bind_by_name($stid,':as_inc_observacion',$this->_inc_observacion,120);
            oci_bind_by_name($stid,':an_inc_estado',$this->_inc_estado,10);
            oci_bind_by_name($stid,':an_inc_usuario',$this->_inc_usuario,10);
            
             if(!$luo_set->ReadcrsMant($luo_con, $stid, $crto)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
            $luo_con->commitTransaction();
            
            $lstData =( $this->_red_codigo == 0 ? parsearcursor($curs) : [] );
                
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                 
            oci_free_statement($crto);
            
            oci_free_statement($stid);
            
            $luo_con->closeConexion();
            
            // --- enviar email ------
          /*  if ($this->_red_codigo==0){
               
                $luo_email = new clsgccEnviarEmail($rowdata);
                
                $luo_email->RendicionNotificacion();
                
                unset($luo_email);
            }*/
            
            unset($luo_con);
            
            unset($luo_set);
                   
            return $rowdata;           
            
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_listar($an_ren_codigo){
        try{
            $ls_sql="begin
                        pck_gcc_incidencia.sp_lst_listar (:acr_cursor,
                            :an_ren_codigo);
                      end;";
            
             $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_ren_codigo',$an_ren_codigo,10);
             
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
    
     public function lst_comprobanteincidencia($an_cmp_codigo){
        try{
            $ls_sql="begin
                        pck_gcc_incidencia.sp_lst_comprobanteincidencia (:acr_cursor,
                            :an_cmp_codigo);
                      end;";
            
             $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_cmp_codigo',$an_cmp_codigo,10);
             
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
