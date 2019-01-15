<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgmaBinary
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clsgmaBinary {
    //put your code here
    
    public function lst_get_blob($an_tck_codigo,$an_sga_codigo){
           try{
            
           $luo_con = new Db();
     
           $ls_sql="select bin_blob from mda.gma_binary where tck_codigo=:an_tck_codigo and sga_codigo=:an_sga_codigo";
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
            $stid=$luo_con->ociparse($ls_sql); 
             
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
            oci_bind_by_name($stid,':an_tck_codigo',$an_tck_codigo,10);
            oci_bind_by_name($stid,':an_sga_codigo',$an_sga_codigo,10);
            
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
