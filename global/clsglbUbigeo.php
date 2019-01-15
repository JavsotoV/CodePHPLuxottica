<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsglbUbigeo
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clsglbUbigeo {
    //put your code here
    
    public function lst_listar($an_prv_codigo,$as_criterio){
        try{
            $ls_sql="begin 
                        pck_glb_ubigeo.sp_lst_listar(
                            :acr_cursor,
                            :an_prv_codigo,
                            :as_criterio); 
                        end;";
            
            $luo_con = new Db();
            
              if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_prv_codigo',$an_prv_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,120);
             
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata=clsViewData::viewData(parsearcursor($curs),false);  
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             return $rowdata;            
            
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_ubigeoxpais($an_pai_codigo,$as_criterio='%',$an_start=1,$an_limit=30){
        
        $ln_rowcount=0;
        $luo_con= new Db();
        
        try{
             $ls_sql="begin 
                        pck_glb_ubigeo.sp_lst_ubigeopais(
                     :acr_cursor,
                     :ln_rowcount,
                     :an_pai_codigo,
                     :as_criterio,
                     :an_start,
                     :an_limit); 
                     end;";
        
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,120);
             oci_bind_by_name($stid,':an_start',$an_start,10);
             oci_bind_by_name($stid,':an_limit',$an_limit,10);
             
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata=clsViewData::viewData(parsearcursor($curs),false,$ln_rowcount);  
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             return $rowdata;            
             
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(),$ex->getMessage());             
        }        
    }
}
