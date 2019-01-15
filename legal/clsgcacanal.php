<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgcacanal
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");



class clsgcacanal {
    //put your code here
    public function lst_listar($as_condicion){
          try{
         
             $ln_rowcount=0;
             $luo_con =new Db();
            
             if ($as_condicion!=='T'){ 
               $ls_sql = "begin pck_gca_canal.sp_lst_listar(:acr_cursor); end;";}
             else{
               $ls_sql = "begin pck_gca_canal.sp_lst_todos(:acr_cursor); end;";}
             
        
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
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
    }
}
