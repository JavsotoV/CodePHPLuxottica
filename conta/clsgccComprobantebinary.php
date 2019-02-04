<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgccComprobantebinary
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsgccComprobantebinary {
    
    private $_cmp_codigo;
    private $_bin_codigo;
    private $_bin_descripcion;
    private $_bin_filename;
    private $_bin_blob;
    private $_bin_bandera;
    private $_bin_usuario;
    
    function __construct($an_bin_usuario) {
        $this->_bin_usuario=$an_bin_usuario;
        $this->_bin_bandera=0;
    }
    
    function set_cmp_codigo($_cmp_codigo) {
        $this->_cmp_codigo = $_cmp_codigo;
    }
    
    function set_bin_codigo($_bin_codigo) {
        $this->_bin_codigo = $_bin_codigo;
    }
    
    function set_bin_descripcion($_bin_descripcion) {
        $this->_bin_descripcion = $_bin_descripcion;
    }

    function set_bin_filename($_bin_filename) {
        $this->_bin_filename = $_bin_filename;
    }

    function set_bin_blob($_bin_blob) {
        
            $this->_bin_bandera=0;
        
            if ( !is_array($_bin_blob) ){throw new Exception( 'No ha adjuntando ningun documento' );}
        
            if ( $_bin_blob [ 'size' ] > 50948388608 )
                {throw new Exception( 'El peso maximo permitido es 20Mb', -10000 );}
      
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

    public function sp_gcc_comprobantebinary($an_accion){
        try{
            $ln_retorno=0;
            $ls_mensaje="";
            
            $ls_sql="begin
                        pck_gcc_comprobantebinary.sp_gcc_comprobantebinary(:an_accion,
                            :ln_retorno,
                            :ls_mensaje,
                            :ab_bin_blob,
                            :an_cmp_codigo,
                            :an_bin_codigo,
                            :as_bin_descripcion,
                            :as_bin_filename,
                            :an_bin_usuario) ;
                        end;";
            
            $luo_con = new Db();
            
            $blob=null;
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                
            $stid=oci_parse($luo_con->refConexion,$ls_sql);        
             
            if(!$stid){
                $error = oci_error($luo_con->refConexion);
                return clsViewData::showError($error['code'], $error['message']);}
            
            $blob=oci_new_descriptor($luo_con->refConexion, OCI_D_LOB);
            
            if(!$blob){
                $error = oci_error($luo_con->refConexion);                
                return clsViewData::showError($error['code'], $error['message']);}
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10);
            oci_bind_by_name($stid,':ln_retorno',$ln_retorno,10);
            oci_bind_by_name($stid,':ls_mensaje',$ls_mensaje,250);
            oci_bind_by_name($stid,':ab_bin_blob',$blob,-1,OCI_B_BLOB);                     
            oci_bind_by_name($stid,':an_cmp_codigo',$this->_cmp_codigo,10);
            oci_bind_by_name($stid,':an_bin_codigo',$this->_bin_codigo,10);
            oci_bind_by_name($stid,':as_bin_descripcion',$this->_bin_descripcion,120);            
            oci_bind_by_name($stid,':as_bin_filename',$this->_bin_filename,200);            
            oci_bind_by_name($stid,':an_bin_usuario',$this->_bin_usuario,10);
            
             $result=oci_execute($stid,OCI_NO_AUTO_COMMIT);
            
            if(!$result){
                $error = oci_error($luo_con->refConexion);                
                return clsViewData::showError($error['code'], $error['message']);}
            
            if ($ln_retorno!=='1'){
                    oci_rollback($luo_con->refConexion);
                    oci_close($luo_con->refConexion);
                    return clsViewData::showError($ln_retorno, ls_mensaje);
            }    
                
            if ($this->_bin_bandera===1){        
                if(!$blob->save($this->_bin_blob)){                
                    oci_rollback($luo_con->refConexion);
                    oci_close($luo_con->refConexion);
                    return clsViewData::showError('-1', 'Error registrando archivo blob');
                }            
            }
            
            $result=oci_commit($luo_con->refConexion);
            
            if(!$result) {
                $error = oci_error($luo_con->refConexion);                                
                oci_rollback($luo_con->refConexion);
                oci_close($luo_con->refConexion);
                return clsViewData::showError($error['code'], $error['message']);}
               
            $lstData = [];
                
            $rowdata = clsViewData::viewData($lstData, false, 1, $ls_mensaje);
                 
            oci_free_statement($stid);
            
            if ($blob!==null) {$blob->free();};
        
            $luo_con->closeConexion();
            
            unset($luo_con);
                   
            return $rowdata; 
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
        
    public function lst_listar($an_cmp_codigo){
        try{
            $ls_sql="begin
                        pck_gcc_comprobantebinary.sp_lst_listar (  :acr_cursor,
                            :an_cmp_codigo) ;
                     end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_cmp_codigo',$an_cmp_codigo,10);
             
             if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;       
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_get_blob($an_cmp_codigo,$an_bin_codigo){
        try{
            
           $luo_con = new Db();
     
           $ls_sql="select bin_blob from gcc_comprobantebinary where cmp_codigo=:an_cmp_codigo and bin_codigo=:an_bin_codigo";
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
            $stid=$luo_con->ociparse($ls_sql); 
             
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
            oci_bind_by_name($stid,':an_cmp_codigo',$an_cmp_codigo,10);
            oci_bind_by_name($stid,':an_bin_codigo',$an_bin_codigo,10);
            
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                
           while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS)){;           
                $rowdata=$row['BIN_BLOB'];                
           }
        
           oci_free_statement($stid);            
           
           $luo_con->closeConexion();
             
           unset($luo_con);   
           
           return $rowdata;
             
        }
        catch(Exception $ex){
            
            clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
}
