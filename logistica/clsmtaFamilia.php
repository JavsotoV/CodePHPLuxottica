<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsmtaFamilia
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsmtaFamilia {
    //put your code here
    private $_fam_codigo;
    private $_pai_codigo;
    private $_fam_cdg;
    private $_tipfamcod;
    private $_fam_descripcion;
    private $_fam_mostrar;
    private $_fam_usuario;
    
    function __construct($an_fam_usuario) {
        $this->_fam_codigo=0;
        $this->_fam_usuario=$an_fam_usuario;
    }
    
    function set_fam_codigo($_fam_codigo) {
        $this->_fam_codigo = $_fam_codigo;
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = $_pai_codigo;
    }

    function set_fam_cdg($_fam_cdg) {
        $this->_fam_cdg = $_fam_cdg;
    }

    function set_tipfamcod($_tipfamcod) {
        $this->_tipfamcod = $_tipfamcod;
    }

    function set_fam_descripcion($_fam_descripcion) {
        $this->_fam_descripcion = $_fam_descripcion;
    }

    function set_fam_mostrar($_fam_mostrar) {
        $this->_fam_mostrar = $_fam_mostrar;
    }

    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }    
    
     public function sp_mta_familia($an_accion){
         
         try{
             $ls_sql="";
             
         }
         catch(exception $ex){
             return clsViewData::showError($ex->getCode(), $ex->getMessage());
         }
     }
    
    public function lst_listar($an_pai_codigo,$as_tipfamcod, $as_criterio, $an_start,$an_limit){
        
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_mta_familia.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_pai_codigo,
                            :as_tipfamcod,
                            :as_criterio,
                            :an_start,
                            :an_limit) ;
                      end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
             oci_bind_by_name($stid,':as_tipfamcod',$as_tipfamcod,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,120);
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
