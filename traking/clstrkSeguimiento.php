<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clstrkSeguimiento
 *
 * @author JAVSOTO
 */
require_once("../Base/DbSql.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");


class clstrkSeguimiento {
 
    public function lst_listar($an_enc_codigo){
        try{
             $luo_con = new DbSql();
            
            $ls_sql="sp_trk_lst_seguimiento";
            
            if(!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $stmt=mssql_init($ls_sql,$luo_con->refConexion);
            
            if (!$stmt){
                
                $luo_con->closeConexion();
                
                return clsViewData::showError(-1, 'Error iniciando procedimiento sp_trk_lst_seguimiento');
            }
            
            $rstpar = mssql_bind($stmt,'@an_enc_codigo',$an_enc_codigo,SQLINT4,false,false,10);
            
            $result = $luo_con->sqlsrvExecute($stmt);
            
            if (!$result){return clsViewData::showError(-1, 'error ejecutanndo procedimiento sp_trk_lst_seguimiento');}
            
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
    
    public function lst_estatusxencargo($an_pai_codigo,$as_encargo){
        try{
             $luo_con = new DbSql();
            
            $ls_sql="sp_trk_lst_statusxencargo";
            
            if(!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $stmt=mssql_init($ls_sql,$luo_con->refConexion);
            
            if (!$stmt){
                
                $luo_con->closeConexion();
                
                return clsViewData::showError(-1, 'Error iniciando procedimiento sp_trk_lst_statusxencargo');
            }
            
            $rstpar = mssql_bind($stmt,'@an_pai_codigo',$an_pai_codigo,SQLINT4,false,false,10);
            
            $rstpar = mssql_bind($stmt,'@as_encargo',$as_encargo,SQLVARCHAR,false,false,20);
            
            $result = $luo_con->sqlsrvExecute($stmt);
            
            if (!$result){return clsViewData::showError(-1, 'error ejecutanndo procedimiento sp_trk_lst_statusxencargo');}
            
            $rowdata= clsViewData::viewData( mssqlparsear($result),false);
            
            mssql_free_statement($stmt);
            
            $luo_con->closeConexion();
             
            unset($luo_con);
             
            return $rowdata;
            
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(),$ex->getMessage());
        }
    }
}
