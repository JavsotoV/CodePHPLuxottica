<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgcaRenta
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clsgcaRenta {
    //put your code here
    private $_con_codigo;
    private $_rta_codigo;
    private $_rta_fechai;
    private $_rta_fechat;
    private $_rta_tipo;
    private $_mon_codigo;
    private $_rta_importe;
    private $_rta_tipoipc;
    private $_rta_porcentajeipc;
    private $_rta_porcentaje;
    private $_rta_puntop;
    
    public function __construct() {
        $this->_rta_codigo=0;
        $this->_rta_importe=0;
        $this->_rta_tipoipc=0;
        $this->_rta_porcentajeipc=0;
        $this->_rta_porcentaje=0;   
        $this->_rta_puntop=0;
    }
    
    function set_con_codigo($_con_codigo) {
        $this->_con_codigo = $_con_codigo;
    }

    function set_rta_codigo($_rta_codigo) {
        $this->_rta_codigo = validaNull($_rta_codigo,0,'int');
    }

    function set_rta_fechai($_rta_fechai) {
        $this->_rta_fechai = validaNull($_rta_fechai,'01/01/1900','date');
    }

    function set_rta_fechat($_rta_fechat) {
        $this->_rta_fechat = validaNull($_rta_fechat,'01/01/1900','date');
    }

    function set_rta_tipo($_rta_tipo) {
        $this->_rta_tipo = $_rta_tipo;
    }

    function set_mon_codigo($_mon_codigo) {
        $this->_mon_codigo = $_mon_codigo;
    }

    function set_rta_importe($_rta_importe) {
        $this->_rta_importe = number_format(validaNull($_rta_importe,0,'float'),2);
    }

    function set_rta_tipoipc($_rta_tipoipc) {
        $this->_rta_tipoipc = $_rta_tipoipc;
    }

    function set_rta_porcentajeipc($_rta_porcentajeipc) {
        $this->_rta_porcentajeipc = number_format(validaNull($_rta_porcentajeipc,0,'float'),2);
    }
    
    function set_rta_porcentaje($_rta_porcentaje) {
        $this->_rta_porcentaje = number_format(validaNull($_rta_porcentaje,0,'float'),2);
    }

    function set_rta_puntop($_rta_puntop) {
        $this->_rta_puntop = number_format(validaNull($_rta_puntop,0,'float'),2);
    }

        
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
     public function sp_gca_renta($an_accion,$an_usuario){
         
         try{
             $luo_con=new Db();
             
             $ls_sql="begin
                        pck_gca_renta.sp_gca_renta(
                        :an_accion,
                        :acr_retorno,
                        :acr_cursor,
                        :an_con_codigo,
                        :an_rta_codigo,
                        to_date(:ad_rta_fechai,'dd/mm/yyyy'),
                        to_date(:ad_rta_fechat,'dd/mm/yyyy'),
                        :an_rta_tipo,
                        :an_mon_codigo,
                        to_number(:an_rta_importe,'999,999,999,999.999'),
                        :an_rta_tipoipc,
                        to_number(:an_rta_porcentajeipc,'999,999,999,999.999'),
                        to_number(:an_rta_porcentaje,'999,999,999,999.999'),
                        to_number(:an_rta_puntop,'999,999,999,999.999'),
                        :an_rta_usuario);  
                        end;";
             
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                
            $stid=$luo_con->ociparse($ls_sql);            
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $crto = $luo_con->ocinewcursor();            
            if(!$crto){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $curs = $luo_con->ocinewcursor();            
            if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_con_codigo',$this->_con_codigo,10);
            oci_bind_by_name($stid,':an_rta_codigo',$this->_rta_codigo,10);
            oci_bind_by_name($stid,':ad_rta_fechai',$this->_rta_fechai,12);
            oci_bind_by_name($stid,':ad_rta_fechat',$this->_rta_fechat,12);
            oci_bind_by_name($stid,':an_rta_tipo',$this->_rta_tipo,10);
            oci_bind_by_name($stid,':an_mon_codigo',$this->_mon_codigo,10);
            oci_bind_by_name($stid,':an_rta_importe',$this->_rta_importe,32);
            oci_bind_by_name($stid,':an_rta_tipoipc',$this->_rta_tipoipc,10);
            oci_bind_by_name($stid,':an_rta_porcentajeipc',$this->_rta_porcentajeipc,32);
            oci_bind_by_name($stid,':an_rta_porcentaje',$this->_rta_porcentaje,32);
            oci_bind_by_name($stid,':an_rta_puntop',$this->_rta_puntop,32);
            oci_bind_by_name($stid,':an_rta_usuario',$an_usuario,10); 
            
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            if(!$luo_con->ociExecute($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            if (!$luo_con->ocifetchRetorno($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $luo_con->commitTransaction();
            
            $lstData = ( $an_accion != 3 ? parsearcursor($curs) : [] );
                
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                 
            oci_free_statement($crto);
            oci_free_statement($stid);
            
            $luo_con->closeConexion();
            
            unset($luo_con);
                   
            return $rowdata;         
            
         }
         catch(Exception $ex){
             clsViewData::showError($ex->getCode(), $ex->getMessage());
         }
     }
     
     public function lst_listar($an_con_codigo,$an_rta_tipo){
         
         try{
             
             $luo_con=new Db();
             
             $ln_rta_codigo=0;
             
             $ls_sql="begin  pck_gca_renta.sp_lst_listar(
                                :acr_cursor,
                                :an_con_codigo,
                                :an_rta_tipo,
                                :an_rta_codigo); end;";
             
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_con_codigo',$an_con_codigo,10);
             oci_bind_by_name($stid,':an_rta_tipo',$an_rta_tipo,10);
             oci_bind_by_name($stid,':an_rta_codigo',$ln_rta_codigo,10);
            
              if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
             oci_free_statement($stid);
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;
             
         }
         catch(Exception $ex){
            clsViewData::showError($ex->getCode(), $ex->getMessage());
         }
         
     }
     
}
