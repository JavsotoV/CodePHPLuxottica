<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clstrkimportar
 *
 * @author JAVSOTO
 */
require_once("../Base/DbSql.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clstrkimportar {
    private $_encargo;
    private $_fecha;
    private $_imd_usuario;
    
    function __construct($an_imd_usuario) {
        $this->_imd_usuario=$an_imd_usuario;
        $this->_encargo=[];
        $this->_fecha=[];
    }
    
    function set_encargo($_encargo) {
        $this->_encargo = $_encargo;
    }

    function set_fecha($_fecha) {
        $this->_fecha = $_fecha;
    }

    public function loadData ( $lstParametros ){
      foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
        
    public function sp_trk_importar($an_accion){
        try{
            $luo_con = new DbSql();
            
            $ls_sql="sp_trk_impencargoreprogramacion";
            
            if(!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $stmt=mssql_init($ls_sql,$luo_con->refConexion);
            
            if (!$stmt){
                
                $luo_con->closeConexion();
                
                return clsViewData::showError(-1, 'Error iniciando procedimiento sp_trk_impencargoreprogramacion');
            }
            
            $ln_fila=0;
            
            foreach ($this->_encargo as $valor){
                
                $ln_retorno=0;
                
                mssql_bind($stmt,'@as_imd_encargo',$valor,SQLVARCHAR,false,false,60);
                mssql_bind($stmt,'@as_imd_fecha',$this->_fecha[$ln_fila],SQLVARCHAR,false,false,20);
                mssql_bind($stmt,'@an_imd_usuario',$this->_imd_usuario,SQLINT1,false,false,10);
         
                $result = $luo_con->sqlsrvExecute($stmt);
                    
                if (!$result){return clsViewData::showError(-1, 'Error ejecutando procedimiento sp_trk_impencargoreprogramacion '.$ln_retorno.'*'.$ln_fila);}    
                
                $ln_fila++;
                
                mssql_free_statement($stmt);
                
                $stmt=mssql_init($ls_sql,$luo_con->refConexion);
            }
            
            $rowdata= clsViewData::viewData( mssqlparsear($result),false);
            
            $luo_con->closeConexion();
             
            unset($luo_con);
             
            return $rowdata;
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
        
    }
    
    public function lst_listar($ad_fechai,$ad_fechat,$an_start,$an_limit){
        try{
            
            $ln_rowcount=0;
            
            $luo_con = new DbSql();
            
            $ls_sql="sp_trk_lst_importar";
            
            if(!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $stmt=mssql_init($ls_sql,$luo_con->refConexion);
            
            if (!$stmt){
                
                $luo_con->closeConexion();
                
                return clsViewData::showError(-1, 'Error iniciando procedimiento sp_trk_lst_importar');
            }
            
            mssql_bind($stmt,'@ad_fechai',$ad_fechai,SQLVARCHAR,false,false,12);
            mssql_bind($stmt,'@ad_fechat',$ad_fechat,SQLVARCHAR,false,false,12);
            mssql_bind($stmt,'@an_start',$an_start,SQLINT1,false,false,10);
            mssql_bind($stmt,'@an_limit',$an_limit,SQLINT1,false,false,10);
            mssql_bind($stmt,'RETVAL',$ln_rowcount,SQLINT1,true,false,10);
         
            $result = $luo_con->sqlsrvExecute($stmt);
            
            if (!$result){return clsViewData::showError(-1, 'error ejecutanndo procedimiento sp_trk_lst_importar');}
            
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
