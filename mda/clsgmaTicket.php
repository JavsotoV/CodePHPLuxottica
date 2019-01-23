<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgmaTicket
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");
require_once("clsEnviarEmail.php");

class clsgmaTicket {
    private $_tck_codigo;
    private $_pai_codigo;
    private $_per_codigo;    
    private $_rqe_codigo;
    private $_tck_detalle;
    private $_rpe_codigo;
    private $_tck_ip;
    private $_bin_filename;
    private $_bin_blob;
    private $_bin_filename1;
    private $_bin_blob1;
    private $_bin_filename2;
    private $_bin_blob2;

    private $_bin_bandera;
    private $_tck_emisor;
    private $_per_destinatario;
    private $_rse_nivel;
    private $_tck_usuario;
    
    function __construct($an_usuario) {
        $this->_tck_codigo=0;
        $this->_bin_blob=null;
        $this->_bin_blob1=null;
        $this->_bin_blob2=null;
        $this->_bin_bandera=0;
        $this->_bin_bandera1=0;
        $this->_bin_bandera2=0;
        $this->_rpe_codigo=0;
        $this->_rse_nivel=1;
        $this->_per_destinatario=[];
        $this->_tck_usuario=$an_usuario;
    }
    
    function set_tck_codigo($_tck_codigo) {
        $this->_tck_codigo = $_tck_codigo;
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = $_pai_codigo;
    }

    function set_per_codigo($_per_codigo) {
        $this->_per_codigo = $_per_codigo;
    }

    function set_rqe_codigo($_rqe_codigo) {
        $this->_rqe_codigo = $_rqe_codigo;
    }
    
    function set_tck_detalle($_tck_detalle) {
        $this->_tck_detalle = $_tck_detalle;
    }

    function set_rpe_codigo($_rpe_codigo) {
        $this->_rpe_codigo = validaNull($_rpe_codigo,'0','int');
    }

    function set_tck_ip($_tck_ip) {
        $this->_tck_ip = validaNull($_tck_ip,'','string');
    }
    
    function set_bin_filename($_bin_filename) {
        $this->_bin_filename = $_bin_filename;
    }
    
    function set_tck_emisor($_tck_emisor) {
        $this->_tck_emisor = mb_strtoupper($_tck_emisor,'utf-8');
    }
     
    function set_per_destinatario($_per_destinatario) {
        $this->_per_destinatario = $_per_destinatario;
    }
        
    function set_rse_nivel($_rse_nivel) {
        $this->_rse_nivel = $_rse_nivel;
    }

    function set_bin_blob($_bin_blob) {
       
        $this->_bin_bandera=0;
        
        if ( !is_array($_bin_blob) ){throw new Exception( 'No ha adjuntando ningun documento' );}
        
         if ( $_bin_blob [ 'size' ] > 99948388608 )
            {throw new Exception( 'El peso maximo permitido es 48Mb', -10000 );}
      
        $this->_bin_blob=file_get_contents($_bin_blob['tmp_name']); 
        
        $this->_bin_filename=$_bin_blob['name'];
        
        $this->_bin_bandera=1;
    }
        
    function set_bin_blob1($_bin_blob) {
       
        $this->_bin_bandera1=0;
        
        if ( !is_array($_bin_blob) ){throw new Exception( 'No ha adjuntando ningun documento' );}
        
         if ( $_bin_blob [ 'size' ] > 99948388608 )
            {throw new Exception( 'El peso maximo permitido es 48Mb', -10000 );}
      
        $this->_bin_blob1=file_get_contents($_bin_blob['tmp_name']); 
        
        $this->_bin_filename1=$_bin_blob['name'];
        
        $this->_bin_bandera1=1;
    }
    
    function set_bin_blob2($_bin_blob) {
       
        $this->_bin_bandera2=0;
        
        if ( !is_array($_bin_blob) ){throw new Exception( 'No ha adjuntando ningun documento' );}
        
         if ( $_bin_blob [ 'size' ] > 99948388608 )
            {throw new Exception( 'El peso maximo permitido es 48Mb', -10000 );}
      
        $this->_bin_blob2=file_get_contents($_bin_blob['tmp_name']); 
        
        $this->_bin_filename2=$_bin_blob['name'];
        
        $this->_bin_bandera2=1;
    }
    
     public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_gma_ticket($an_accion){
        try{
            $ls_sql="begin
                        mda.pck_gma_ticket.sp_gma_ticket (:an_accion,
                        :acr_retorno,
                        :acr_cursor,
                        :an_tck_codigo, 
                        :an_pai_codigo, 
                        :an_per_codigo,
                        :an_rqe_codigo,
                        :as_tck_detalle,
                        :an_rpe_codigo,
                        :as_tck_ip,
                        :as_bin_filename,
                        :ab_bin_blob, 
                        :as_bin_filename1,
                        :ab_bin_blob1, 
                        :as_bin_filename2,
                        :ab_bin_blob2, 
                        :as_tck_emisor,
                        :an_rse_nivel,
                        :an_tck_usuario);
                    end;";
            
            $luo_con = new Db();
            $blob=null;
            $blob1=null;
            $blob2=null;
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                
            $stid=oci_parse($luo_con->refConexion,$ls_sql);        
             
            if(!$stid){
                $error = oci_error($luo_con->refConexion);
                return clsViewData::showError($error['code'], $error['message']);}
            
            $blob=oci_new_descriptor($luo_con->refConexion, OCI_D_LOB);
            
            if(!$blob){
                $error = oci_error($luo_con->refConexion);                
                return clsViewData::showError($error['code'], $error['message']);}
            
            $blob1=oci_new_descriptor($luo_con->refConexion, OCI_D_LOB);
            
            if(!$blob1){
                $error = oci_error($luo_con->refConexion);                
                return clsViewData::showError($error['code'], $error['message']);}
                
            $blob2=oci_new_descriptor($luo_con->refConexion, OCI_D_LOB);
            
            if(!$blob2){
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
            oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
            oci_bind_by_name($stid,':an_per_codigo',$this->_per_codigo,10);
            oci_bind_by_name($stid,':an_rqe_codigo',$this->_rqe_codigo,10);
            oci_bind_by_name($stid,':as_tck_detalle',$this->_tck_detalle,10000);
            oci_bind_by_name($stid,':an_rpe_codigo',$this->_rpe_codigo,10);
            oci_bind_by_name($stid,':as_tck_ip',$this->_tck_ip,64);
            oci_bind_by_name($stid,':as_bin_filename',$this->_bin_filename,200);
            oci_bind_by_name($stid,':ab_bin_blob',$blob,-1,OCI_B_BLOB);
            oci_bind_by_name($stid,':as_bin_filename1',$this->_bin_filename1,200);
            oci_bind_by_name($stid,':ab_bin_blob1',$blob1,-1,OCI_B_BLOB);
            oci_bind_by_name($stid,':as_bin_filename2',$this->_bin_filename2,200);
            oci_bind_by_name($stid,':ab_bin_blob2',$blob2,-1,OCI_B_BLOB);
            oci_bind_by_name($stid,':as_tck_emisor',$this->_tck_emisor,20);
            oci_bind_by_name($stid,':an_rse_nivel',$this->_rse_nivel,10);
            oci_bind_by_name($stid,':an_tck_usuario',$this->_tck_usuario,10);
            
           $result= oci_execute($stid,OCI_NO_AUTO_COMMIT);
            
            if(!$result){
                $error = oci_error($luo_con->refConexion);                
                return clsViewData::showError(-1, 'Error ejecutando procedimiento ticket');}
                       
            if(!oci_execute($crto)){
                $error = oci_error($luo_con->refConexion);                
                return clsViewData::showError($error['code'], $error['message']);
            }
            
            if (!$luo_con->ocifetchRetorno($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}   
  
           if ($this->_bin_bandera===1){        
                if(!$blob->save($this->_bin_blob)){                
                    oci_rollback($luo_con->refConexion);
                    oci_close($luo_con->refConexion);
                    return clsViewData::showError('-1', 'Error registrando archivo blob');
                }            
            }
            
            if ($this->_bin_bandera1===1){        
                if(!$blob1->save($this->_bin_blob1)){                
                    oci_rollback($luo_con->refConexion);
                    oci_close($luo_con->refConexion);
                    return clsViewData::showError('-1', 'Error registrando archivo blob1');
                }            
            }
            
            if ($this->_bin_bandera2===1){        
                if(!$blob2->save($this->_bin_blob2)){                
                    oci_rollback($luo_con->refConexion);
                    oci_close($luo_con->refConexion);
                    return clsViewData::showError('-1', 'Error registrando archivo blob2');
                }            
            }
        
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
            
            if ($blob1!==null) {$blob1->free();};
            
            if ($blob2!==null) {$blob2->free();};
        
            $luo_con->closeConexion();
            
            unset($luo_con);            
            
         /*   if ($an_accion!=3) { 
                
                $luo_email = new clsEnviarEmail($rowdata);
                
                $lb_retorno= $luo_email->Newticket();
           
                unset($luo_email);
                
            }*/
            
            return $rowdata;       
            
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function sp_gma_message($an_accion){
        try{
            $ls_sql="begin
                        mda.pck_gma_ticket.sp_gma_message(:an_accion,
                        :acr_retorno,
                        :acr_cursor,
                        :an_tck_codigo, 
                        :an_pai_codigo, 
                        :an_per_codigo,
                        :an_rqe_codigo,
                        :as_tck_detalle,
                        :an_per_destinatario,
                        :as_tck_ip,
                        :as_bin_filename,
                        :ab_bin_blob, 
                        :as_tck_emisor,
                        :an_tck_usuario);
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
            
            $ln_count = count($this->_per_destinatario);    
                
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_tck_codigo',$this->_tck_codigo,10);
            oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
            oci_bind_by_name($stid,':an_per_codigo',$this->_per_codigo,10);
            oci_bind_by_name($stid,':an_rqe_codigo',$this->_rqe_codigo,10);
            oci_bind_by_name($stid,':as_tck_detalle',$this->_tck_detalle,10000);
            oci_bind_array_by_name($stid,':an_per_destinatario',$this->_per_destinatario,$ln_count,-1,SQLT_INT);
            oci_bind_by_name($stid,':as_tck_ip',$this->_tck_ip,64);
            oci_bind_by_name($stid,':ab_bin_blob',$blob,-1,OCI_B_BLOB); 
            oci_bind_by_name($stid,':as_bin_filename',$this->_bin_filename,200);
            oci_bind_by_name($stid,':as_tck_emisor',$this->_tck_emisor,20);
            oci_bind_by_name($stid,':an_tck_usuario',$this->_tck_usuario,10);
            
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
        
            $luo_con->closeConexion();
            
            unset($luo_con);            
            
            if ($an_accion!=3) { 
                
                $luo_email = new clsEnviarEmail($rowdata);
                
                $lb_retorno= $luo_email->Newticket();
           
                unset($luo_email);
                
            }
            
            return $rowdata;       
            
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_listar_rst($an_tck_codigo,$an_per_codigo,$an_tck_estado,$ad_fechai,$ad_fechat,$as_criterio,$an_start,$an_limit){
       try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        mda.pck_gma_ticket.sp_lst_listar_rst (  :acr_cursor,
                            :ln_rowcount,
                            :an_tck_codigo,
                            :an_per_codigo,
                            :an_tck_estado,
                            to_date(:ad_fechai,'dd/mm/yyyy'),
                            to_date(:ad_fechat,'dd/mm/yyyy'),
                            :as_criterio,
                            :an_start,
                            :an_limit) ;
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_tck_codigo',$an_tck_codigo,10);
             oci_bind_by_name($stid,':an_per_codigo',$an_per_codigo,10);
             oci_bind_by_name($stid,':an_tck_estado',$an_tck_estado,10);
             oci_bind_by_name($stid,':ad_fechai',$ad_fechai,12);
             oci_bind_by_name($stid,':ad_Fechat',$ad_fechat,12);
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
    
    
    public function lst_listar_rge($an_pai_codigo,$ad_fechai,$ad_fechat,$as_criterio,$an_start,$an_limit){
       try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        mda.pck_gma_ticket.sp_lst_listar_rge (  :acr_cursor,
                            :ln_rowcount,
                            :an_pai_codigo,
                            to_date(:ad_fechai,'dd/mm/yyyy'),
                            to_date(:ad_fechat,'dd/mm/yyyy'),
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
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
             oci_bind_by_name($stid,':ad_fechai',$ad_fechai,12);
             oci_bind_by_name($stid,':ad_Fechat',$ad_fechat,12);
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
    
     
    public function lst_listar($an_tck_codigo,$an_per_codigo,$an_tck_estado,$ad_fechai,$ad_fechat,$as_criterio,$an_tck_origen,$an_start,$an_limit){
       try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        mda.pck_gma_ticket.sp_lst_listar (  :acr_cursor,
                            :ln_rowcount,
                            :an_tck_codigo,
                            :an_per_codigo,
                            :an_tck_estado,
                            to_date(:ad_fechai,'dd/mm/yyyy'),
                            to_date(:ad_fechat,'dd/mm/yyyy'),
                            :as_criterio,
                            :an_tck_origen,
                            :an_start,
                            :an_limit) ;
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_tck_codigo',$an_tck_codigo,10);
             oci_bind_by_name($stid,':an_per_codigo',$an_per_codigo,10);
             oci_bind_by_name($stid,':an_tck_estado',$an_tck_estado,10);
             oci_bind_by_name($stid,':ad_fechai',$ad_fechai,12);
             oci_bind_by_name($stid,':ad_Fechat',$ad_fechat,12);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,120);
             oci_bind_by_name($stid,':an_tck_origen',$an_tck_origen,10);
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
    
    public function lst_listar_msg($an_per_codigo,$an_tck_estado,$ad_fechai,$ad_fechat,$as_criterio,$an_start,$an_limit){
       try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        mda.pck_gma_ticket.sp_lst_listar_msg (  :acr_cursor,
                            :ln_rowcount,
                            :an_per_codigo,
                            :an_tck_estado,
                            to_date(:ad_fechai,'dd/mm/yyyy'),
                            to_date(:ad_fechat,'dd/mm/yyyy'),
                            :as_criterio,
                            :an_start,
                            :an_limit) ;
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_per_codigo',$an_per_codigo,10);
             oci_bind_by_name($stid,':an_tck_estado',$an_tck_estado,10);
             oci_bind_by_name($stid,':ad_fechai',$ad_fechai,12);
             oci_bind_by_name($stid,':ad_Fechat',$ad_fechat,12);
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
    
    
    public function lst_email($an_tck_codigo){
          try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        mda.pck_gma_ticket.sp_lst_email (:acr_cursor,
                            :an_tck_codigo) ;
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_tck_codigo',$an_tck_codigo,10);
             
              if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false,$ln_rowcount);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             unset($luo_set);
             
             return $rowdata;
            
        }
        catch(Exception $ex){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }    
    }
}
