<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clstrkimportardet
 *
 * @author JAVSOTO
 */
require_once("../Base/DbSql.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clstrkimportardet {
    //put your code here
    
    public function lst_listar($an_imp_codigo){
        try{
             $luo_con = new DbSql();
            
            $ls_sql="sp_trk_lst_importardet";
            
            if(!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $stmt=mssql_init($ls_sql,$luo_con->refConexion);
            
            if (!$stmt){
                
                $luo_con->closeConexion();
                
                return clsViewData::showError(-1, 'Error iniciando procedimiento [sp_trk_lst_importardet]');
            }
            
            $rstpar = mssql_bind($stmt,'@an_imp_codigo',$an_imp_codigo,SQLINT1,false,false,10);
         
            $result = $luo_con->sqlsrvExecute($stmt);
            
            if (!$result){return clsViewData::showError(-1, 'error ejecutando procedimiento [sp_trk_lst_importardet]');}
            
            $rowdata= clsViewData::viewData( mssqlparsear($result),false);
            
            mssql_free_statement($stmt);
            
            $luo_con->closeConexion();
             
            unset($luo_con);
             
            return $rowdata;
            
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
        
    }
}
