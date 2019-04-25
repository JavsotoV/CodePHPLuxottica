<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgcaGarantia
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("clsgcaEnviarEmail.php");


class clsgcaGarantia {
    //put your code here
    private $_con_codigo;
    private $_gra_codigo;
    private $_tpc_codigo;
    private $_gra_tipo;
    private $_gra_banco;
    private $_gra_operacion;
    private $_mon_codigo;
    private $_gra_importe;
    private $_gra_fechai;
    private $_gra_fechat;
    
    function set_con_codigo($_con_codigo) {
        $this->_con_codigo = $_con_codigo;
    }

    function set_gra_codigo($_gra_codigo) {
        $this->_gra_codigo = $_gra_codigo;
    }

    function set_tpc_codigo($_tpc_codigo) {
        $this->_tpc_codigo = $_tpc_codigo;
    }

    function set_gra_tipo($_gra_tipo) {
        $this->_gra_tipo = $_gra_tipo;
    }

    function set_gra_banco($_gra_banco) {
        $this->_gra_banco = mb_strtoupper($_gra_banco,'utf-8');
    }

    function set_gra_operacion($_gra_operacion) {
        $this->_gra_operacion = mb_strtoupper($_gra_operacion,'utf-8');
    }

    function set_mon_codigo($_mon_codigo) {
        $this->_mon_codigo = $_mon_codigo;
    }

    function set_gra_importe($_gra_importe) {
        $this->_gra_importe =number_format(validaNull($_gra_importe,0,'float'),2);
    }

    function set_gra_fechai($_gra_fechai) {
        
        $this->_gra_fechai = validaNull($_gra_fechai,'01/01/1900','date');
    }

    function set_gra_fechat($_gra_fechat) {
        $this->_gra_fechat = validaNull($_gra_fechat,'01/01/1900','date');
    }

    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }   
    
    public function sp_gca_garantia($an_accion,$an_usuario){
        try{
            $luo_con=new Db();
            
            $ls_sql="begin
            	pck_gca_garantia.sp_gca_garantia (
                    :an_accion,
                    :acr_retorno,
                    :acr_cursor,
                    :an_con_codigo,
                    :an_gra_codigo,
                    :an_tpc_codigo,
                    :as_gra_banco,
                    :as_gra_operacion,
                    :an_mon_codigo,
                    :an_gra_tipo,
                    to_number(:an_gra_importe,'999,999,999,999.999'),
                    to_date(:ad_gra_fechai,'dd/mm/yyyy'),
                    to_date(:ad_gra_fechat,'dd/mm/yyyy'),
                    :an_gra_usuario);  
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
            oci_bind_by_name($stid,':an_gra_codigo',$this->_gra_codigo,10);
            oci_bind_by_name($stid,':an_tpc_codigo',$this->_tpc_codigo,10);
            oci_bind_by_name($stid,':as_gra_banco',$this->_gra_banco,60);
            oci_bind_by_name($stid,':as_gra_operacion',$this->_gra_operacion,60);
            oci_bind_by_name($stid,':an_mon_codigo',$this->_mon_codigo,10);
            oci_bind_by_name($stid,':an_gra_tipo',$this->_gra_tipo,10);
            oci_bind_by_name($stid,':an_gra_importe',$this->_gra_importe,32);
            oci_bind_by_name($stid,':ad_gra_fechai',$this->_gra_fechai,12);
            oci_bind_by_name($stid,':ad_gra_fechat',$this->_gra_fechat,12);
            oci_bind_by_name($stid,':an_gra_usuario',$an_usuario,10);
            
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            if(!$luo_con->ociExecute($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            if (!$luo_con->ocifetchRetorno($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             $luo_con->commitTransaction();
            
            $lstData = ( $an_accion != 3 ? parsearcursor($curs) : [] );
                
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                 
            oci_free_statement($crto);
            oci_free_statement($stid);
            
            $luo_con->closeConexion();
            
          /*  if ($an_accion==2){
                
                $luo_email = new clsgcaEnviarEmail($rowdata);
                
                $luo_email->EditContrato();  
                
                unset($luo_email);
            }*/
            
            unset($luo_con);
                   
            return $rowdata;
            
        }
        catch(Exception $ex){
            clsViewData::showError($ex->getCode(),$ex->getMessage());
        }
        
    }
    
    public function lst_listar($an_con_codigo){
        
        try{
            
            $luo_con=new Db();
            
            $ln_gra_codigo=0;
            
            $ls_sql="begin
                        pck_gca_garantia.sp_lst_listar(
                        :acr_cursor,
                        :an_con_codigo,
                        :an_gra_codigo); 
                        end;";
            
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_con_codigo',$an_con_codigo,10);
             oci_bind_by_name($stid,':an_gra_codigo',$ln_gra_codigo,10);
            
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
