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
    private $_imp_codigo;
    private $_imd_codigo;
    private $_imd_usuario;
    
    function __construct($an_imd_usuario) {
        $this->_imd_usuario=$an_imd_usuario;
    }
    
    function set_imp_codigo($_imp_codigo) {
        $this->_imp_codigo = $_imp_codigo;
    }

    function set_imd_codigo($_imd_codigo) {
        $this->_imd_codigo = $_imd_codigo;
    }
    
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }

    public function proc_mant_trk_importardet($an_accion){
        try{  
                $ls_sql="proc_mant_trk_importardet";
            
                $luo_con = new DbSql();
            
                if(!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                
                $stmt=mssql_init($ls_sql,$luo_con->refConexion);
            
                if (!$stmt){
                
                    $luo_con->closeConexion();
                
                    return clsViewData::showError(-1, 'Error iniciando procedimiento sp_trk_lst_encargo');
                }
                
                 mssql_bind($stmt,'@an_accion',$an_accion,SQLINT1,false,false,10);
                 mssql_bind($stmt,'@an_imp_codigo',$this->_imp_codigo,SQLINT4,false,false,10);
                 mssql_bind($stmt,'@an_imd_codigo',$this->_imd_codigo,SQLINT4,false,false,10);
                 mssql_bind($stmt,'@an_imd_usuario',$this->_imd_usuario,SQLVARCHAR,false,false,40);
                
                $result = $luo_con->sqlsrvExecute($stmt);
            
                if (!$result){return clsViewData::showError(-1, 'error ejecutanndo procedimiento');}
            
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
    
    
    public function lst_listar($an_imp_codigo,$as_criterio,$an_start,$an_limit){
        try{
             $ln_rowcount=0;
             
             $luo_con = new DbSql();
            
            $ls_sql="sp_trk_lst_importardet";
            
            if (strlen($as_criterio)<1) {$as_criterio='%';}                
            
            if ($as_criterio!='%') {$as_criterio='%'.$as_criterio.'%';}
                
            if(!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $stmt=mssql_init($ls_sql,$luo_con->refConexion);
            
            if (!$stmt){
                
                $luo_con->closeConexion();
                
                return clsViewData::showError(-1, 'Error iniciando procedimiento [sp_trk_lst_importardet]');
            }
            
            mssql_bind($stmt,'@an_imp_codigo',$an_imp_codigo,SQLINT1,false,false,10);
            mssql_bind($stmt,'@as_criterio',$as_criterio,SQLVARCHAR,false,false,60);
            mssql_bind($stmt,'@an_start',$an_start,SQLINT1,false,false,10);
            mssql_bind($stmt,'@an_limit',$an_limit,SQLINT1,false,false,10);            
            mssql_bind($stmt,'RETVAL',$ln_rowcount,SQLINT4,true); 
         
            $result = $luo_con->sqlsrvExecute($stmt);
            
            if (!$result){return clsViewData::showError(-1, 'error ejecutando procedimiento [sp_trk_lst_importardet]');}
            
            $rowdata= clsViewData::viewData( mssqlparsear($result),false,$ln_rowcount);
            
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
