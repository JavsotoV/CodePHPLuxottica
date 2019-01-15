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

class clstrkReprogramacion {
    //put your code here
    private $_enc_codigo;
    private $_mtv_codigo;
    private $_prg_fechaentrega;
    private $_prg_observacion;
    private $_prg_usuario;
    
    function __construct($as_nom_user) {        
        $this->_prg_usuario=$as_nom_user;        
    }
    function set_enc_codigo($_enc_codigo) {
        $this->_enc_codigo = $_enc_codigo;
    }

    function set_mtv_codigo($_mtv_codigo) {
        $this->_mtv_codigo = $_mtv_codigo;
    }

    function set_prg_fechaentrega($_prg_fechaentrega) {
        $this->_prg_fechaentrega = $_prg_fechaentrega;
    }
    
    function set_prg_observacion($_prg_observacion) {
        $this->_prg_observacion = $_prg_observacion;
    }
    
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function proc_mant_trk_reprogramacion($an_accion){
        try{
                $ls_sql="proc_mant_trk_reprogramacion";
            
                $luo_con = new DbSql();
            
                if(!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                
                $stmt=mssql_init($ls_sql,$luo_con->refConexion);
            
                if (!$stmt){
                
                    $luo_con->closeConexion();
                
                    return clsViewData::showError(-1, 'Error iniciando procedimiento sp_trk_lst_encargo');
                }
                
                 mssql_bind($stmt,'@an_accion',$an_accion,SQLINT1,false,false,10);
                 mssql_bind($stmt,'@an_enc_codigo',$this->_enc_codigo,SQLINT4,false,false,10);
                 mssql_bind($stmt,'@an_mtv_codigo',$this->_mtv_codigo,SQLINT1,false,false,10);
                 mssql_bind($stmt,'@ad_prg_fechaentrega',$this->_prg_fechaentrega,SQLVARCHAR,false,false,20);
                 mssql_bind($stmt,'@as_prg_observacion',$this->_prg_observacion,SQLVARCHAR,false,false,250);
                 mssql_bind($stmt,'@as_prg_usuario',$this->_prg_usuario,SQLVARCHAR,false,false,40);
                
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
    
    public function lst_listar($an_enc_codigo){
        try{
             $luo_con = new DbSql();
            
            $ls_sql="sp_trk_lst_reprogramacion";
            
            if(!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
           $stmt=mssql_init($ls_sql,$luo_con->refConexion);
            
            if (!$stmt){
                
                $luo_con->closeConexion();
                
                return clsViewData::showError(-1, 'Error iniciando procedimiento sp_trk_lst_reprogramacion');
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
    
    
     public function lst_listarxencargo($as_nro_encargo){
        try{
             $luo_con = new DbSql();
            
            $ls_sql="sp_trk_lst_reprogramacionxencargo";
            
            if(!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
           $stmt=mssql_init($ls_sql,$luo_con->refConexion);
            
            if (!$stmt){
                
                $luo_con->closeConexion();
                
                return clsViewData::showError(-1, 'Error iniciando procedimiento sp_trk_lst_reprogramacion');
            }
            
            $rstpar = mssql_bind($stmt,'@as_nro_encargo',$as_nro_encargo,SQLVARCHAR,false,false,20);
            
            $result = $luo_con->sqlsrvExecute($stmt);
            
            if (!$result){return clsViewData::showError(-1, 'error ejecutanndo procedimiento sp_trk_lst_reprogramacionxencargo');}
            
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
