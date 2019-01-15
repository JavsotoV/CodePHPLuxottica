<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgcaBinary
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");


class clsgcaBinary {
    //put your code here
    private $_con_codigo;
    private $_bin_codigo;
    private $_bin_descripcion;
    private $_bin_filename;
    private $_bin_blob;
    private $_bin_bandera;
    
    function __construct() {
        $this->_bin_codigo=0;
        $this->_bin_blob=null;
        $this->_bin_bandera=0;
    }

    function set_con_codigo($_con_codigo) {
        $this->_con_codigo = $_con_codigo;
    }

    function set_bin_codigo($_bin_codigo) {
        $this->_bin_codigo = $_bin_codigo;
    }

    function set_bin_descripcion($_bin_descripcion) {
        $this->_bin_descripcion = strtoupper($_bin_descripcion);
    }
    
    function set_bin_filename($_bin_filename) {
        $this->_bin_filename = $_bin_filename;
    }

    function get_bin_bandera() {
        return $this->_bin_bandera;
    }
            
    function set_bin_blob($_bin_blob) {
        
        $this->_bin_bandera=0;
        
        if ( !is_array($_bin_blob) ){throw new Exception( 'No ha adjuntando ningun documento' );}
        
        if ( $_bin_blob [ 'type' ] !== 'application/pdf' ){
            throw new Exception( 'Solo se permite archivos PDF' );}
        else if ( $_bin_blob [ 'size' ] > 99948388608 )
            {throw new Exception( 'El peso maximo permitido es 99Mb', -10000 );}
      
        $this->_bin_blob=file_get_contents($_bin_blob['tmp_name']); 
        
        $this->_bin_filename=$_bin_blob['name'];        
        
        $this->_bin_bandera=1;
    
    }

    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_gca_binary($an_accion,$an_usuario){
        try{
            $luo_con=new Db();
            $blob=null;
            
            $ls_sql="begin
                     pck_gca_binary.sp_gca_binary (
                     :an_accion,
                     :acr_retorno,
                     :acr_cursor,
                     :ab_bin_blob,
                     :an_con_codigo,
                     :an_bin_codigo,                     
                     :as_bin_descripcion,
                     :as_bin_filename,
                     :an_bin_usuario);  
                     end;";
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                
            $stid=oci_parse($luo_con->refConexion,$ls_sql);        
             
            if(!$stid){
                $error = oci_error($luo_con->refConexion);
                return clsViewData::showError($error['code'], $error['message']);}
            
            $blob=oci_new_descriptor($luo_con->refConexion, OCI_D_LOB);
            
            if(!$blob){
                $error = oci_error($luo_con->refConexion);                
                return clsViewData::showError($error['code'], $error['message']);}
                
            $crto = oci_new_cursor($luo_con->refConexion);
            if(!$crto){
                $error = oci_error($luo_con->refConexion);                
                return clsViewData::showError($error['code'], $error['message']);}
           
            
            $curs = oci_new_cursor($luo_con->refConexion);
            if(!$curs){$error = oci_error($luo_con->refConexion);                
                return clsViewData::showError($error['code'], $error['message']);}
           
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':ab_bin_blob',$blob,-1,OCI_B_BLOB);            
            oci_bind_by_name($stid,':an_con_codigo',$this->_con_codigo,10);
            oci_bind_by_name($stid,':an_bin_codigo',$this->_bin_codigo,10);
            oci_bind_by_name($stid,':as_bin_descripcion',$this->_bin_descripcion,400);
            oci_bind_by_name($stid,':as_bin_filename',$this->_bin_filename,200);
            oci_bind_by_name($stid,':an_bin_usuario',$an_usuario,10);           
            
            $result= oci_execute($stid,OCI_NO_AUTO_COMMIT);
            
            if(!$result){
                $error = oci_error($luo_con->refConexion);                
                return clsViewData::showError($error['code'], $error['message']);}
                       
            if ($this->_bin_bandera===1){        
                if(!$blob->save($this->_bin_blob)){                
                    oci_rollback($luo_con->refConexion);
                    oci_close($luo_con->refConexion);
                    return clsViewData::showError('-1', 'Error registrando archivo blob');
                }            
            }
            
            if(!oci_execute($crto)){
                $error = oci_error($luo_con->refConexion);                
                return clsViewData::showError($error['code'], $error['message']);
            }
            
            if (!$luo_con->ocifetchRetorno($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}   
        
            $result=oci_commit($luo_con->refConexion);
            
            if(!$result) {
                $error = oci_error($luo_con->refConexion);                                
                oci_rollback($luo_con->refConexion);
                oci_close($luo_con->refConexion);
                return clsViewData::showError($error['code'], $error['message']);}
                
               
            $lstData = ( $an_accion != 3 ? parsearcursor($curs) : [] );
                
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                 
            oci_free_statement($crto);
            
            oci_free_statement($stid);
            
        if ($blob!==null) {$blob->free();};
            
            unset($luo_con);
            
            return $rowdata;
        }
        catch(Exception $ex){
            clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_listar($an_con_codigo){
        
        try{
            
            $luo_con=new Db();
            
            $ln_bin_codigo=0;
            
            $ls_sql="begin
                     pck_gca_binary.sp_lst_listar(
                     :acr_cursor,
                     :an_con_codigo,
                     :an_bin_codigo);
                     end;";
            
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
          
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_con_codigo',$an_con_codigo,10);
             oci_bind_by_name($stid,':an_bin_codigo',$ln_bin_codigo,10);
           
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
             oci_free_statement($stid);
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;
        }
        catch(Exception $ex){
            clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_get_blob($an_con_codigo,$an_bin_codigo){
        
        try{
            
            $ln_Retorno=1;
            
            $ls_mensaje=null;
            
            $luo_con = new Db();
     
           $ls_sql="select bin_blob from gca_binary where con_codigo=:an_con_codigo and bin_codigo=:an_bin_codigo";
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
            $stid=$luo_con->ociparse($ls_sql); 
             
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
            oci_bind_by_name($stid,':an_con_codigo',$an_con_codigo,10);
            oci_bind_by_name($stid,':an_bin_codigo',$an_bin_codigo,10);
            
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                
           while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS)){;           
                $rowdata=$row['BIN_BLOB'];                
           }
        
           oci_free_statement($stid);            
           
           $luo_con->closeConexion();
             
           unset($luo_con);   
           
          // if ($ln_retorno!==1){return null;}
           
           return $rowdata;
             
        }
        catch(Exception $ex){
            
            clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
}
