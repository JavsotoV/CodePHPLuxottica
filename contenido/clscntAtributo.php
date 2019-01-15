<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clscntAtributo
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clscntAtributo {
    //put your code here
    
    public function lst_tiponodo(){
        try{
             $luo_con =new Db();
            
             $ls_sql = "select codigo,descripcion from table(varios.pck_cnt_atributo.fn_lst_tiponodo)";
        
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                          
             $rowdata= clsViewData::viewData(parsearcursor($stid),false);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;
           
        }
        catch(Exception $ex){
            clsViewData::showError($ex->getCode(), $ex->getMessage());            
        }
    }
}
