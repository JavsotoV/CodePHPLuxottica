<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsglbProvincia
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/clsViewData.php");

class clsglbProvincia {
    //put your code here
    public function lst_listar($an_dpt_codigo,$as_criterio){
        try{
            
            $ls_sql="begin 
                        pck_glb_provincia.sp_lst_listar(:acr_cursor,
                        :an_dpt_codigo,
                        :as_criterio);
                        end;";
            
            $luo_con = new Db();
            
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError()) ;}
           
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_dpt_codigo',$an_dpt_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,60);
                      
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
