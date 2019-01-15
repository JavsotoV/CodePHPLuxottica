<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsglbAtributo
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");


class clsglbAtributo {
    
    private function lst_sql($an_operacion){
        if ($an_operacion==='1') { $ls_sql="select codigo,descripcion from table(pck_glb_atributo.fn_lst_tiempo)";}
        
        if ($an_operacion==='2') { $ls_sql="select codigo,descripcion from table(pck_glb_atributo.fn_lst_tipotienda)";}
      
        return $ls_sql;
    }
    
    public function lst_listar($an_operacion){
        
          try{
           
             $luo_con= new Db();
             
             $ls_sql=$this->lst_sql($an_operacion);
        
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                          
             $rowdata= clsViewData::viewData(parsearcursor($stid),false);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;
             
          } catch (Exception $ex) {
            
              return clsViewData::showError($ex->getCode(), $ex->getMessage());
          }  
           
    }
}
