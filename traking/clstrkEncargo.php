<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clstrkEncargo
 *
 * @author JAVSOTO
 */

require_once("../Base/DbSql.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clstrkEncargo {
    
    public function lst_listar($as_encargo){
        try{
            $luo_con = new DbSql();
            
            $ls_sql='sp_trk_lst_encargo';
            
            if(!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $stmt=mssql_init($ls_sql,$luo_con->refConexion);
            
            if (!$stmt){
                
                $luo_con->closeConexion();
                
                return clsViewData::showError(-1, 'Error iniciando procedimiento sp_trk_lst_encargo');
            }
                    
            $rstpar = mssql_bind($stmt,'@as_enc_numero',$as_encargo,SQLVARCHAR,false,false,20);
            
            if(!$rstpar){return clsViewData::showError(-1, 'Error asignando parametro'); }  
            
            $result = $luo_con->sqlsrvExecute($stmt);
            
            if (!$result){return clsViewData::showError(-1, 'error ejecutanndo procedimiento');}
            
            $rowdata= clsViewData::viewData( mssqlparsear($result),false);
            
            mssql_free_statement($stmt);
            
            $luo_con->closeConexion();
             
            unset($luo_con);
             
            return $rowdata;
            
        }catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }        
    }
    
    public function lst_encargodetalle($an_pai_codigo,$as_encargo){
        try{
            $luo_con = new DbSql();
            
            $ls_sql="sp_trk_lst_encargodetalle";
            
            $ls_sqldet="sp_trk_find_fechaprogramada";
            
            if(!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $stmt=mssql_init($ls_sql,$luo_con->refConexion);
            
            if (!$stmt){
                
                $luo_con->closeConexion();
                
                return clsViewData::showError(-1, 'Error iniciando procedimiento sp_trk_lst_encargodetalle');
            }
            
            mssql_bind($stmt,'@an_pai_codigo',$an_pai_codigo,SQLINT1,false,false,10);
            
            mssql_bind($stmt,'@as_encargo',$as_encargo,SQLVARCHAR,false,false,20);
            
            $result = $luo_con->sqlsrvExecute($stmt);
            
            mssql_free_statement($stmt);
            
            if (!$result){return clsViewData::showError(-1, 'error ejecutanndo procedimiento sp_trk_lst_encargodetalle');}
            
            /*------tenemos que colocar la fecha programada para entrega -------*/
            if (($an_pai_codigo==1) || ($an_pai_codigo==4)){
                
                $ls_grupo='';
                $ld_fechaprogramada=null;
                
                $stmtdet=mssql_init($ls_sqldet,$luo_con->refConexion);
                
                while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) 
                {
                    
                    if ($ls_grupo!=$row['grupo']){
                        
                        $ls_grupo=$row['grupo'];
                        
                        $ld_fechaprogramada=null;
                        
                        mssql_bind($stmtdet,'@as_encargo', $as_encargo, SQLVARCHAR, false, false, 20);
                    
                        mssql_bind($stmtdet,'@as_grupo', $ls_grupo, SQLVARCHAR, false, false, 10);
                    
                        $resultdet=mssql_execute($stmtdet);
                    
                        if (!$resultdet){
                            return clsViewData::showError(-1, 'Error obteniendo detalle de encargo '.$ls_grupo);
                        }
                    
                        while ($rowdet = mssql_fetch_array($resultdet, MSSQL_ASSOC)) {
                            $ld_fechaprogramada= $rowdet['fechaprogramada'];                    
                        }
                    }
                    
                    $row['fechaprogramada']=$ld_fechaprogramada;
                    
                    $lstArray[] = $row;
                }            
            }else{
                while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) 
                {
                    $lstArray[] = $row;
                }
            }
            
            $rowdata= clsViewData::viewData($lstArray,false);
           
            mssql_free_statement($stmtdet);
            
            $luo_con->closeConexion();
             
            unset($luo_con);
            
            return $rowdata;
            
        }catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }        
    }
    
    public function lst_encargoxcliente($an_condicion,$an_pai_codigo,$as_criterio,$as_json=true){
        try{
        
            $rowdata=null;
            
            $luo_con = new DbSql();
            
            $lstArray=array();
             
            $ls_sql="sp_trk_lst_encargoxcliente";
            
            $ls_sqldet = "sp_trk_find_estatusencargo";
            
            if(!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $stmt=mssql_init($ls_sql,$luo_con->refConexion);
            
            if (!$stmt){
                
                $luo_con->closeConexion();
                
                return clsViewData::showError(-1, 'Error iniciando procedimiento sp_trk_lst_encargoxcliente ');
            }
            
            mssql_bind($stmt,'@an_condicion',$an_condicion,SQLINT1,false,false,10);            
            mssql_bind($stmt,'@an_pai_codigo',$an_pai_codigo,SQLINT1,false,false,10);            
            mssql_bind($stmt,'@as_criterio',$as_criterio,SQLVARCHAR,false,false,20);
            
            $result = $luo_con->sqlsrvExecute($stmt);
            
            mssql_free_statement($stmt);
            
            if (!$result){return clsViewData::showError(-1, 'error ejecutando procedimiento sp_trk_lst_encargoxcliente');}
            
            if (($an_pai_codigo==1) || ($an_pai_codigo==4)){
                
                $stmtdet=mssql_init($ls_sqldet,$luo_con->refConexion);
                
                while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) 
                {
                    mssql_bind($stmtdet,'@an_pai_codigo', $an_pai_codigo, SQLINT1, false, false, 20);
                    
                    mssql_bind($stmtdet,'@as_nro_encargo', $row['encargo'], SQLVARCHAR, false, false, 20);
                    
                    $resultdet=mssql_execute($stmtdet);
                    
                    if (!$resultdet){
			return clsViewData::showError(-1, 'Error obteniendo informacion de status de encargo');
                    }
                    
                    while ($rowdet = mssql_fetch_array($resultdet, MSSQL_ASSOC)) {
                            $row['fechaprogramada']= $rowdet['fechaprogramada'];
                            if (strtotime($rowdet['fecha_actual'])>=strtotime($row['fechaentrega'])){   
                                if ($rowdet['status_estado']<1){$row['retrazado']= 'RETRAZADO';}
                            }                            
                    }
                    
                    $lstArray[] = $row;
                }                
            }else{
                while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) 
                {
                    $lstArray[] = $row;
                }
            }
                        
            if ($as_json){
                $rowdata= clsViewData::viewData($lstArray,false);}
                else 
                {$rowdata=$lstArray;}
            
            mssql_free_statement($stmtdet);
            
            $luo_con->closeConexion();
             
            unset($luo_con);
            
            return $rowdata;
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
}
