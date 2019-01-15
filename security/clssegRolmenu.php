<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clssegRolmenu
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../utiles/fnUtiles.php");

class clssegRolmenu {
  
    private $_men_codigo;
    private $_rse_codigo;
    private $_rmn_acceso;
    private $_rmn_usuario;
    
    function __construct($an_rmn_usuario) {
        $this->_men_codigo=[];
        $this->_rmn_acceso=[];
        $this->_rmn_usuario=$an_rmn_usuario;
    }
    
    function set_men_codigo($_men_codigo) {
        $this->_men_codigo = $_men_codigo;
    }

    function set_rse_codigo($_rse_codigo) {
        $this->_rse_codigo = $_rse_codigo;
    }

    function set_rmn_acceso($_rmn_acceso) {
        $this->_rmn_acceso = $_rmn_acceso;
    }

    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    
    
    public function lst_rolmenu($an_rse_codigo){
         try{
            
             $ln_rowcount=0;
            
            $luo_con=new Db();
            
            $ls_sql="begin pck_seg_rolmenu.sp_lst_rolmenu(
                           :acr_cursor, 
                           :an_rse_codigo); 
                    end;";
            
           if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError()) ;}
          
            $stid=$luo_con->ociparse($ls_sql);
            
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $curs=$luo_con->ocinewcursor();
            if (!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}

            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR);
            oci_bind_by_name($stid,':an_rse_codigo',$an_rse_codigo,10);
            
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());};            
           
            $lstData = parsearcursor($curs);
                              
            $lstItems=fn_formattree($lstData);
            
            $rowdata = '['.fn_printListItem( $lstItems, 0, null, '/' ).']';
                      
            oci_free_statement($stid);
            
            $luo_con->closeConexion();
            
            unset($luo_con);
            
            return $rowdata;      
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_menuxusuario($an_per_codigo,$an_seg_codigo){
         try{
            
            $luo_con=new Db();
            
            $ls_sql="begin pck_seg_rolmenu.sp_lst_menuxsegxper(
                           :acr_cursor, 
                           :an_per_codigo,
                           :an_seg_codigo); 
                    end;";
            
           if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError()) ;}
          
            $stid=$luo_con->ociparse($ls_sql);
            
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $curs=$luo_con->ocinewcursor();
            if (!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}

            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR);
            oci_bind_by_name($stid,':an_per_codigo',$an_per_codigo,10);
            oci_bind_by_name($stid,':an_seg_codigo',$an_seg_codigo,10);
            
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());};            
           
            $lstData = parsearcursor($curs);
                              
            $lstItems=fn_formattree($lstData);
            
            $rowdata = '['.fn_printListItem( $lstItems, 0, null, '/' ).']';
                      
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
