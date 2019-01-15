<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgcaArrendador
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");


class clsgcaArrendador {
    
    private $_con_codigo;
    private $_ard_codigo;
    private $_per_codigo;
    
    function set_con_codigo($_con_codigo) {
        $this->_con_codigo = $_con_codigo;
    }

    function set_ard_codigo($_ard_codigo) {
        $this->_ard_codigo = validaNull($_ard_codigo,0,'int');        
    }

    function set_per_codigo($_per_codigo) {
        $this->_per_codigo = $_per_codigo;
    }

    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }   
    
    public function sp_gca_arrendador($an_accion,$an_usuario){
    try
        {
            $luo_con=new Db();
            
            $ls_sql="begin pck_gca_arrendador.sp_gca_arrendador(
                :an_accion,
                :acr_retorno,
                :acr_cursor,
                :an_con_codigo,
                :an_ard_codigo,
                :an_per_codigo,
                :an_ard_usuario);
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
            oci_bind_by_name($stid,':an_ard_codigo',$this->_ard_codigo,10);
            oci_bind_by_name($stid,':an_per_codigo',$this->_per_codigo,10);
            oci_bind_by_name($stid,':an_ard_usuario',$an_usuario,10);

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
    clsViewData::showError($ex->getCode(), $ex->getMessage());}    
    }
    
    
    public function lst_listar($an_con_codigo){
        try{
            
            $luo_con = new Db();
            
            $ln_ard_codigo=0;
            
            $ls_sql="begin pck_gca_arrendador.sp_lst_listar(
                    :acr_cursor,
                    :an_con_codigo,
                    :an_ard_codigo); end;";
                        
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_con_codigo',$an_con_codigo,10);
             oci_bind_by_name($stid,':an_ard_codigo',$ln_ard_codigo,10);
            
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
