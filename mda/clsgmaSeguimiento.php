<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgmaSeguimiento
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");
require_once("clsEnviarEmail.php");

class clsgmaSeguimiento {
    //put your code here
    private $_tck_codigo;
    private $_sga_observacion;
    private $_sga_estado;
    private $_bin_filename;
    private $_bin_blob;
    private $_bin_bandera;
    private $_tck_evaluacion;
    private $_sga_usuario;
    private $_flag_emisor;
    
    function __construct($an_sga_usuario) {
        $this->_bin_blob=null;
        $this->_sga_usuario=$an_sga_usuario;
        $this->_bin_bandera=0;
        $this->_tck_evaluacion=0;
        $this->_flag_emisor='T';                
    }

    function set_tck_codigo($_tck_codigo) {
        $this->_tck_codigo = $_tck_codigo;
    }

    function set_sga_observacion($_sga_observacion) {
        $this->_sga_observacion = $_sga_observacion;
    }

    function set_sga_estado($_sga_estado) {
        $this->_sga_estado = $_sga_estado;
    }

    function set_bin_filename($_bin_filename) {
        $this->_bin_filename = $_bin_filename;
    }

    function set_tck_evaluacion($_tck_evaluacion) {
        $this->_tck_evaluacion = $_tck_evaluacion;
    }
    
    function set_flag_emisor($_flag_emisor) {
        $this->_flag_emisor = $_flag_emisor;
    }

    
        function set_bin_blob($_bin_blob) {
        
        $this->_bin_bandera=0;
        
        if ( !is_array($_bin_blob) ){throw new Exception( 'No ha adjuntando ningun documento' );}
        
    //    if ( $_bin_blob [ 'type' ] !== 'application/pdf' ){
     //       throw new Exception( 'Solo se permite archivos PDF' );            
        if ( $_bin_blob [ 'size' ] > 99948388608 )
            {throw new Exception( 'El peso maximo permitido es 48Mb', -10000 );}
      
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

    public function sp_gma_seguimiento($an_accion){
        try{
             $ls_sql="begin
                        mda.pck_gma_seguimiento.sp_gma_seguimiento (:an_accion,
                        :acr_retorno,
                        :acr_cursor,
                        :an_tck_codigo, 
                        :as_sga_observacion, 
                        :an_sga_estado,
                        :as_bin_filename,
                        :ab_bin_blob,
                        :an_tck_evaluacion,
                        :as_flag_emisor,
                        :an_sga_usuario);
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
            oci_bind_by_name($stid,':an_tck_codigo',$this->_tck_codigo,10);
            oci_bind_by_name($stid,':as_sga_observacion',$this->_sga_observacion,10000);
            oci_bind_by_name($stid,':an_sga_estado',$this->_sga_estado,10);
            oci_bind_by_name($stid,':as_bin_filename',$this->_bin_filename,200);
            oci_bind_by_name($stid,':ab_bin_blob',$blob,-1,OCI_B_BLOB); 
            oci_bind_by_name($stid,':an_tck_evaluacion',$this->_tck_evaluacion,10);            
            oci_bind_by_name($stid,':as_flag_emisor',$this->_flag_emisor,1);
            oci_bind_by_name($stid,':an_sga_usuario',$this->_sga_usuario,10);
            
           $result= oci_execute($stid,OCI_NO_AUTO_COMMIT);
            
            if(!$result){
                $error = oci_error($luo_con->refConexion);                
                return clsViewData::showError('-1','result');}
                       
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
            
            $luo_con->closeConexion();
             
            unset($luo_con);
            
      /*      if ($an_accion!=3){
                
                $luo_email = new clsEnviarEmail($rowdata);
                
                $lb_retorno=$luo_email->Newticket();
                
                unset($luo_email);
            }*/
           
            return $rowdata; 
        }
        
        
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_listar($an_tck_codigo,$an_sga_codigo,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        mda.pck_gma_seguimiento.sp_lst_listar ( :acr_cursor,
                            :ln_rowcount,
                            :an_tck_codigo,
                            :an_sga_codigo,
                            :as_criterio,
                            :an_start,
                            :an_limit);
                     end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_tck_codigo',$an_tck_codigo,10);
             oci_bind_by_name($stid,':an_sga_codigo',$an_sga_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,120);
             oci_bind_by_name($stid,':an_start',$an_start,10);
             oci_bind_by_name($stid,':an_limit',$an_limit,10);
            
              if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false,$ln_rowcount);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;
            
        }
        catch(Exception $ex){
            
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
            
        }
    }

}
