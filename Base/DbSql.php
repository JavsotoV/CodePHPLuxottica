<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Db
 *
 * @author jvelasquez
 * clase de conexion oracle 
 */
require_once("ConfSql.php");

class DbSql {
    //put your code here
    public $refConexion;    
    private $servidor;
    private $usuario;
    private $password;
    private $base_datos;
    private $charset;
    private $refPrepareQuery;    
    private $bIsPrepare    = false;
    private $bIsConected   = false; 
    private $bIsTransacc   = false; 
    private $iCodeError    = 0;
    private $sMsgError     = '';
    private $MsgRetorno     = ''; 
    private $iCodRetorno =0;
        
    static $_instance;
    
    public function __construct() {
        
        $this->setConexion();
    }
    
    public function __destruct(){
        
        if ($this->refPrepareQuery!== null){$this->freePrepareQuery();}        
        
        if ($this->bIsTransacc){$this->rollBackTransaction();}
        
        if ($this->bIsConected){
            oci_close($this->refConexion);
            $this->bIsConected=false;            
        }
    }
         
    public function getICodeError() {
        return $this->iCodeError;
    }

    public function getSMsgError() {
        return $this->sMsgError;
    }
    
    function setICodeError($iCodeError) {
        $this->iCodeError = $iCodeError;
    }

    function setSMsgError($sMsgError) {
        $this->sMsgError = $sMsgError;
    }
    function getMsgRetorno() {
        return $this->MsgRetorno;
    }

    function setMsgRetorno($MsgRetorno) {
        $this->MsgRetorno = $MsgRetorno;
    }
    function getICodRetorno() {
        return $this->iCodRetorno;
    }

    function setICodRetorno($iCodRetorno) {
        $this->iCodRetorno = $iCodRetorno;
    }

    
    private function setConexion(){
        $conf = ConfSql::getInstance();
        $this->servidor=$conf->getHostDB();
        $this->base_datos=$conf->getDB();        
        $this->usuario=$conf->getUserDB();
        $this->password=$conf->getPassDB();
        $this->charset=$conf->getCharsetDB();   
        $this->refPrepareQuery=null;
        $this->refConexion=null;
        $this->bIsPrepare    = false;
        $this->bIsConected   = false; 
        $this->bIsTransacc   = false;     
     }
    
    private function _closeNoCommitByError( $paramError, $paramStatusConexion ) {
        
        $this->iCodeError = $paramError['code'];
        
        $this->sMsgError = $paramError['message'];
        
        if ( !$paramStatusConexion) {$this->closeConexion();}
    }
    
    private function _closeWithCommitByError( $paramError, $paramStatusTransac, $paramStatusConexion ) {
        
        $this->iCodeError = $paramError['code'];
        
        $this->sMsgError = $paramError['message'];
        
        if ( !$paramStatusTransac ) {$this->rollBackTransaction();}
        
        if ( !$paramStatusConexion ) {$this->closeConexion();}
    }

    public static function getInstance(){
        if (!(self::$_instance instanceof self)){self::$_instance=new self();}
        
        return self::$_instance;   
    }
    
    // creando una conexion a la base de datos ---------------------------------
    public function createConexion(){        
        
        if (!$this->bIsConected){
            $this->refConexion= @mssql_connect($this->servidor,$this->usuario,$this->password);            
        }
                
        if (!($this->refConexion)){
            $this->sqlsrvError();
            $this->bIsConected=false;
            return false;
        }
        else{
            
            if(!$this->SelectDb()){return false;};
            
            $this->bIsConected=true;
            return true;            
        }
    }
    
    //---seleccionar base de datos al cual conectarse 
    public function SelectDb($as_namedb=null){        
        
        $result=false;
        
        if (empty($as_namedb)){
            $result=@mssql_select_db($this->base_datos,$this->refConexion);
        }else{
        $result = @mssql_select_db($as_namedb,$this->refConexion);}
        
        return $result;
    }
    
    //---verifica el estado de la conexion para iniciar una nueva transaccion---
    public function createTransacc(){
        if ($this->bIsConected){
            $this->bIsTransacc=true;
        }
        else
        {$this->bIsTransacc=false;}
    }
    
    //---- desconectando base de datos
    public function closeConexion(){
        
        $result=true;
        
        if($this->bIsTransacc){$this->rollBackTransaction;}
        
        if ($this->refPrepareQuery!=null) {$this->freePrepareQuery();}
        
        if($this->bIsConected) { 
            
            $result = @mssql_close($this->refConexion);
            
            $this->bIsConected=false;
        }
         
        return $result;
    }
    
    
    private function sqlsrvError(){
        $error =  @mssql_get_last_message();
        $this->iCodeError=-1;
        $this->sMsgError=$error;        
    }
    
     
    public function sqlsrvQuery($as_sql,$as_parametro=null){
        
        $stid=@mssql_query($this->refConexion,$as_sql,$as_parametro);        
        
        if (!$stid){            
          $this->sqlsrvError();  
          return false;
        }            
        return $stid;
    }
      
   public function sqlsrvExecute($stid){
            $Result = @mssql_execute($stid);        
            if (!$Result){
                $this->sqlsrvError(); 
                $this->closeConexion();
                return false;
            }
            return $Result;
   }
   
   public function sqlsrvExecuteNoAutoCommit($stid){
            $Result = @mssql_execute($stid);        
            if (!$Result){
                $this->sqlsrvError(); 
                $this->rollBackTransaction();
                $this->closeConexion();
                return false;
            }
            return $Result;
   }
   
    /*--------libera recursos de asociados a un cursor en oracle --------------*/
    public function freePrepareQuery() {
        
        if ($this->refPrepareQuery != null) {
        
            @mssql_free_statement($this->refPrepareQuery);
            
            $this->refPrepareQuery = null;
        }
    }

    public function RowData($acr_cursor){
            
            $rowdata=array();            
            $fila=0;
            
           try{ 
                while (($row = @mssql_fetch_array($acr_cursor,MSSQL_ASSOC)) != false) {
                       $rowdata[$fila]=$row;
                        $fila++;
                }
            
                return $rowdata; 
           } 
            catch(Exception $ex){return false;}    
    }
    
    public function sqlsrvfetchRetorno($curs){
       
        $row = @mssql_fetch_array($curs);
       
       if ($row['LN_RETORNO']<>1){ 
            $this->setICodeError($row['LN_RETORNO']);
            $this->setSMsgError($row['LS_MENSAJE']);
            return false;
       }
       
       $this->setMsgRetorno($row['LS_MENSAJE']);
       $this->setICodRetorno($row['LN_RETORNO']);
       
       return true;
    }   
    
}

