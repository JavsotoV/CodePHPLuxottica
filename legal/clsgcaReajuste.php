<?php

/**
 * Description of clsgcaReajuste
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");


class clsgcaReajuste {
    
    private $_rja_codigo=0;
    private $_rja_descripcion;
    
    function set_rja_codigo($_rja_codigo) {
        $this->_rja_codigo = $_rja_codigo;
    }

    function set_rja_descripcion($_rja_descripcion) {
        
        if (strlen(trim($_rja_descripcion))===0){            
            throw new Exception("Debe especificar descripcion de reajuste",-1);
        }
        
        $this->_rja_descripcion = mb_strtoupper($_rja_descripcion,'utf-8');
    }

    function get_rja_codigo() {
        return $this->_rja_codigo;
    }

    function get_rja_descripcion() {
        return $this->_rja_descripcion;
    }

    public function sp_gca_reajuste($an_accion){
        
        try{
            
            $luo_con =new Db();
            
            $ls_sql="begin pck_gca_reajuste.sp_gca_reajuste(:an_accion,:acr_retorno,:acr_cursor,:an_rja_codigo,:as_rja_descripcion); end;";
        
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
            oci_bind_by_name($stid,':an_rja_codigo',$this->_rja_codigo,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':as_rja_descripcion',$this->_rja_descripcion,120) or die(oci_error($luo_con->refConexion));
        
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
         
         $luo_con->rollBackTransaction();
         
         $luo_con->closeConexion();
             
         return clsViewData::showError($ex->getCode(), $ex->getMessage());
     }
   
    }
    
    public function lst_listar($an_rja_codigo=0){
        
         try{
         
             $ln_rowcount=0;
             $luo_con =new Db();
            
             $ls_sql = "begin pck_gca_reajuste.sp_lst_listar(:an_rja_codigo,:acr_cursor); end;";
        
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':an_rja_codigo',$an_rja_codigo,10) or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
       
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                          
             $rowdata= clsViewData::viewData(parsearcursor($curs),false,$ln_rowcount);
             
             oci_free_statement($stid);
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;
         }
         catch(Exception $ex){
             
             $luo_con->rollBackTransaction();
             return clsViewData::showError($ex->getCode(), $ex->getMessage());             
         }
       /*  finally{
             
             oci_free_statement($scurs);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
         }*/
    }
}  
