<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clscnvAtributo
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clscnvAtributo {
    //put your code here
    
    function lst_listar($an_atr_codigo,$an_reg_codigo,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            
            $ls_sql = "begin
                        varios.pck_cnv_atributo.sp_lst_atributo (:acr_cursor,
                            :ln_rowcount,
                            :an_atr_codigo,
                            :an_reg_codigo, 
                            :as_criterio,
                            :an_start,
                            :an_limit);
                        end;";
            
            $luo_con = new Db();            
                
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_atr_codigo',$an_atr_codigo,10);
             oci_bind_by_name($stid,':an_reg_codigo',$an_reg_codigo,10);
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
