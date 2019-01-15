<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clssegRolPersona
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");


class clssegRolPersona {
    private $_rpe_codigo;
    private $_per_codigo;
    private $_rol_codigo;
    private $_rpe_fechai;
    private $_rpe_fechat;
    
    function set_rpe_codigo($_rpe_codigo) {
        $this->_rpe_codigo = ValidaNull($_rpe_codigo,0,'int');
    }

    function set_per_codigo($_per_codigo) {
        $this->_per_codigo = $_per_codigo;
    }

    function set_rol_codigo($_rol_codigo) {
        $this->_rol_codigo = $_rol_codigo;
    }

    function set_rpe_fechai($_rpe_fechai) {
        $this->_rpe_fechai = ValidaNull($_rpe_fechai,'01/01/1900','date');
    }

    function set_rpe_fechat($_rpe_fechat) {
        $this->_rpe_fechat = ValidaNull($_rpe_fechat,'01/01/1900','date');
    }

    function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));
            }
        }
    }
    
    public function lst_rolsegper($an_per_codigo,$an_rol_codigo){
        $ls_sql="begin pck_seg_rolpersona.sp_lst_rolsegper(
                       :acr_cursor,
                       :an_per_codigo,
                       :an_rol_codigo);
                 end;";
        
        try{
             $luo_con = new Db();
            
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_per_codigo',$an_per_codigo,10) or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_rol_codigo',$an_rol_codigo,10) or die(oci_error($luo_con->refConexion));
                      
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;               
        }
        catch(Exception $ex){
             $luo_con->rollBackTransaction();
             return clsViewData::showError($ex->getCode(), $ex->getMessage());   
        }
    }
    
    public function lst_sistemapersona($an_per_codigo){
    try{
            $ls_sql="begin
                        pck_seg_rolpersona.sp_lst_sistemapersona(:acr_cursor,
                            :an_per_codigo);
                     end;";
            
            $luo_con = new Db();
            
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_per_codigo',$an_per_codigo,10) or die(oci_error($luo_con->refConexion));
                      
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
