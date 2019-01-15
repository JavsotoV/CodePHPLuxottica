<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clssegAlcance
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clssegAlcance {
    //put your code here
    
    public function lst_alcanceuser($an_per_codigo,$an_men_codigo){
        try{
            $luo_con= new Db();
            
            $ls_sql="begin
                        pck_seg_alcance.sp_lst_alcuser(
                        :acr_cursor,
                        :an_men_codigo,
                        :an_per_codigo);
                     end;";
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError()) ;}
          
            $stid=$luo_con->ociparse($ls_sql);
            
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $curs=$luo_con->ocinewcursor();
            if (!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}

            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR);
            oci_bind_by_name($stid,':an_men_codigo',$an_men_codigo,10);
            oci_bind_by_name($stid,':an_per_codigo',$an_per_codigo,10);

            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());};            
           
            $lstData = parsearcursor($curs);
                
            $rowdata = clsViewData::viewData($lstData, false);
                 
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
