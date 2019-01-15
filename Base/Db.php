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
require_once("Conf.php");

class Db {
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
        $conf = Conf::getInstance();
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
        
        if (!$this->bIsConected){$this->refConexion= @oci_connect($this->usuario, $this->password,$this->servidor,'AL32UTF8');}
                
        if (!($this->refConexion)){
            $this->ociError();
            $this->bIsConected=false;
            return false;
        }
        else{
            $this->bIsConected=true;
            return true;            
        }
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
            
            $result = @oci_close($this->refConexion);
            
            $this->bIsConected=false;
        }
         
        return $result;
    }
    
    public function rollBackTransaction(){
        
        $result=null;        
        if ($this->bIsConected && $this->bIsTransacc){
            $this->bIsTransacc=false;
            $result = @oci_rollback($this->refConexion); 
        }        
        return $result;
    }
    
    public function commitTransaction(){
        
        if ($this->bIsConected && $this->bIsTransacc){
            
            $this->bIsTransacc=false;
            
            $result = @oci_commit($this->refConexion);
            
            if (!$result){
                $this->rollBackTransaction();
                $this->ociError();}
            
            return $result;
        }        
        return false;
    }
    
    private function ociError(){
        $error = @oci_error($this->refConexion);
        $this->iCodeError=$error['code'];
        $this->sMsgError=$error['message'];        
    }
    
    public function ociparse($as_sql){               
        $stid=@oci_parse($this->refConexion,$as_sql);        
        if (!$stid){            
          $this->ociError();  
          return false;
        }            
        return $stid;
    }
    
    public function ocinewcursor(){
        $curs= @oci_new_cursor($this->refConexion);
        
        if(!$curs){
            $this->ociError();            
            return false;
        }
        return $curs;
   }
   
   public function ocinewdescriptor(){
        $blob= @oci_new_descriptor($this->refConexion,OCI_D_LOB);
        if(!$blob){
            $this->ociError();            
            return false;
        }
        return $blob;
   }
   
   public function ociExecute($stid){
            $Result = @oci_execute($stid);        
            if (!$Result){
                $this->ociError(); 
                $this->closeConexion();
                return false;
            }
            return $Result;
   }
   
   public function ociExecuteNoAutoCommit($stid){
            $Result = @oci_execute($stid,OCI_NO_AUTO_COMMIT);        
            if (!$Result){
                $this->ociError(); 
                $this->rollBackTransaction();
                $this->closeConexion();
                return false;
            }
            return $Result;
   }
   
    /*--------libera recursos de asociados a un cursor en oracle --------------*/
    public function freePrepareQuery() {
        
        if ($this->refPrepareQuery != null) {
        
            @oci_free_statement($this->refPrepareQuery);
            
            $this->refPrepareQuery = null;
        }
    }

    public function RowData($acr_cursor){
            
            $rowdata=array();            
            $fila=0;
            
           try{ 
                while (($row = @oci_fetch_array($acr_cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                       $rowdata[$fila]=$row;
                        $fila++;
                }
            
                return $rowdata; 
           } 
            catch(Exception $ex){return false;}    
    }
    
    public function ocifetchRetorno($curs){
       
        $row = @oci_fetch_array($curs);
       
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

