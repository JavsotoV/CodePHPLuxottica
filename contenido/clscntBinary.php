<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clscntBinary
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clscntBinary {
    private $_det_codigo;
    private $_bin_blob;
    private $_bin_bandera;
    private $_bin_filename;
    
    function __construct() {
        $this->_det_codigo=0;
        $this->_bin_blob=null;
        $this->_bin_bandera=0;
        $this->_bin_filename=null;
    }
    
    function set_det_codigo($_det_codigo) {
        $this->_det_codigo = $_det_codigo;
    }

    function set_bin_blob($_bin_blob) {
        $this->_bin_blob = $_bin_blob;
    }
    
    function set_bin_filename($_bin_filename) {
        $this->_bin_filename = $_bin_filename;
    }

  
    public function lst_get_blob($an_det_codigo){
        
        try{
            
            $ln_Retorno=1;
            
            $ls_mensaje=null;
            
            $luo_con = new Db();
     
           $ls_sql="select bin_blob from varios.cnt_binary where det_codigo=:an_det_codigo";
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
            $stid=$luo_con->ociparse($ls_sql); 
             
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
            oci_bind_by_name($stid,':an_det_codigo',$an_det_codigo,10);
            
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                
           while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS)){;           
                $rowdata=$row['BIN_BLOB'];                
           }
        
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
