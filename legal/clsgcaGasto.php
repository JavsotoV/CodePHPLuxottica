<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgcaGasto
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clsgcaGasto {
    //put your code here
    
    private $_con_codigo;
    private $_gto_codigo;
    private $_gto_fechai;
    private $_gto_fechat;
    private $_gto_tipo;
    private $_mon_codigo;
    private $_gto_importe;

    function __construct() {
        $this->_gto_codigo=0;
        $this->_mon_codigo=0;
        $this->_gto_importe=0;
    }
    
    function set_con_codigo($_con_codigo) {
        $this->_con_codigo = $_con_codigo;
    }

    function set_gto_codigo($_gto_codigo) {
        $this->_gto_codigo = $_gto_codigo;
    }

    function set_gto_fechai($_gto_fechai) {
        $this->_gto_fechai = validaNull($_gto_fechai,'01/01/1900','date');
    }

    function set_gto_fechat($_gto_fechat) {
        $this->_gto_fechat = validaNull($_gto_fechat,'01/01/1900','date');
    }

    function set_gto_tipo($_gto_tipo) {
        $this->_gto_tipo = validaNull($_gto_tipo,0,'int');
    }

    function set_mon_codigo($_mon_codigo) {
        $this->_mon_codigo = validaNull($_mon_codigo,0,'int');
    }

    function set_gto_importe($_gto_importe) {
        $this->_gto_importe = number_format(validaNull($_gto_importe,0,'float'),2);
    }

    
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_gca_gasto($an_accion,$an_usuario){
        
        try{
            $luo_con=new Db();
            
            $ls_sql="begin
                        pck_gca_gasto.sp_gca_gasto (
                            :an_accion,
                            :acr_retorno,
                            :acr_cursor,
                            :an_con_codigo,
                            :an_gto_codigo,
                            to_date(:ad_gto_fechai,'dd/mm/yyyy'),
                            to_date(:ad_gto_fechat,'dd/mm/yyyy'),
                            :an_gto_tipo,
                            :an_mon_codigo,
                            to_number(:an_gto_importe,'999,999,999,999.999'),
                            :an_gto_usuario);
                            end;";
            
            if($luo_con->createConexion()==false){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
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
            oci_bind_by_name($stid,':an_gto_codigo',$this->_gto_codigo,10);          
            oci_bind_by_name($stid,':ad_gto_fechai',$this->_gto_fechai,24);          
            oci_bind_by_name($stid,':ad_gto_fechat',$this->_gto_fechat,24);          
            oci_bind_by_name($stid,':an_gto_tipo',$this->_gto_tipo,10);          
            oci_bind_by_name($stid,':an_mon_codigo',$this->_mon_codigo,10);          
            oci_bind_by_name($stid,':an_gto_importe',$this->_gto_importe,18);          
            oci_bind_by_name($stid,':an_gto_usuario',$this->_gto_usuario,10);  
            
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
    
    public function lst_listar($an_con_codigo){
        
        try{
            
            $ln_gto_codigo=0;
            
            $luo_con=new Db();
            
            $ls_sql="begin
                        pck_gca_gasto.sp_lst_listar(
                            :acr_cursor,
                            :an_con_codigo,
                            :an_gto_codigo);
                        end;";
            
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_con_codigo',$an_con_codigo,10);
             oci_bind_by_name($stid,':an_gto_codigo',$ln_gto_codigo,10);
            
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
