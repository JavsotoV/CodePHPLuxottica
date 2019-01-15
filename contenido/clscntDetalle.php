<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clscntDetalle
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../utiles/fnUtiles.php");

class clscntDetalle {
    //put your code here
    private $_det_codigo;
    private $_cnt_codigo;
    private $_det_tiponodo;
    private $_det_fechapub;
    private $_det_orden;
    private $_det_parent;
    private $_det_denominacion;
    private $_det_resumen;
    private $_det_referencia;
    private $_bin_blob;
    private $_bin_filename;
    private $_bin_bandera;
    
    function __construct() {
        $this->_bin_blob=null;
        $this->_bin_filename=null;
        $this->_bin_bandera=0;
    }
    
    function set_det_codigo($_det_codigo) {
        $this->_det_codigo = $_det_codigo;     
    }

    function set_cnt_codigo($_cnt_codigo) {
        $this->_cnt_codigo = $_cnt_codigo;
    }

    function set_det_tiponodo($_det_tiponodo) {
        $this->_det_tiponodo = $_det_tiponodo;
    }

    function set_det_fechapub($_det_fechapub) {
        $this->_det_fechapub =ValidaNull($_det_fechapub,'01/01/1900','date');
         
    }

    function set_det_orden($_det_orden) {
        $this->_det_orden = $_det_orden;
    }

    function set_det_parent($_det_parent) {
        $this->_det_parent = ValidaNull($_det_parent,0,'int');
    }

    function set_det_denominacion($_det_denominacion) {
        $this->_det_denominacion = $_det_denominacion;
    }

    function set_det_resumen($_det_resumen) {
        $this->_det_resumen = $_det_resumen;
    }

    function set_det_referencia($_det_referencia) {
        $this->_det_referencia = $_det_referencia;
    }
    

     function set_bin_blob($_bin_blob) {
        
        $this->_bin_bandera=0;
        
        if ( !is_array($_bin_blob) ){throw new Exception( 'No ha adjuntando ningun documento' );}
        
     //   if (( $_bin_blob [ 'type' ] !== 'application/pdf' ) && ($_bin_blob['type']!=='application/excel')) {
     //       throw new Exception( 'Solo se permite archivos PDF y Excel' );            
      //  }
        else if ( $_bin_blob [ 'size' ] > 99948388608 )
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
    
    public function sp_cnt_detalle($an_accion,$an_usuario){
        try{
            $luo_con = new Db();
            $blob=null;
            
            $ls_sql="begin
                        varios.pck_cnt_detalle.sp_cnt_detalle(:an_accion,
                            :acr_retorno,
                            :acr_cursor,
                            :ab_bin_blob,
                            :an_det_codigo,
                            :an_cnt_codigo,
                            :an_det_tiponodo,
                            to_date(:ad_det_fechapub,'dd/mm/yyyy'),
                            :an_det_orden,
                            :an_det_parent,
                            :as_det_denominacion,
                            :as_det_resumen,
                            :as_det_referencia,
                            :as_bin_filename,
                            :an_det_usuario);   
                     end;";
            
            if($luo_con->createConexion()==false){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
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
            oci_bind_by_name($stid,':an_det_codigo',$this->_det_codigo,10);
            oci_bind_by_name($stid,':an_cnt_codigo',$this->_cnt_codigo,10);
            oci_bind_by_name($stid,':an_det_tiponodo',$this->_det_tiponodo,10);
            oci_bind_by_name($stid,':ad_det_fechapub',$this->_det_fechapub,12);
            oci_bind_by_name($stid,':an_det_orden',$this->_det_orden,10);
            oci_bind_by_name($stid,':an_det_parent',$this->_det_parent,10);
            oci_bind_by_name($stid,':as_det_denominacion',$this->_det_denominacion,500);
            oci_bind_by_name($stid,':as_det_resumen',$this->_det_resumen,1000);
            oci_bind_by_name($stid,':as_det_referencia',$this->_det_referencia,300);
            oci_bind_by_name($stid,':as_bin_filename',$this->_bin_filename,250);
            oci_bind_by_name($stid,':an_det_usuario',$an_usuario,10);
           
            $result=oci_execute($stid,OCI_NO_AUTO_COMMIT);
            
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
             
            return $rowdata;
                    
        }
        catch(Exception $ex){
          clsViewData::showError($ex->getCode(), $ex->getMessage());                
        }
    }
    
    public function lst_listar($an_det_codigo,$an_cnt_codigo,$as_criterio,$an_start,$an_limit){
        try{
            
            $ln_rowcount=0;
            
            $ls_sql="begin
                     varios.pck_cnt_detalle.sp_lst_listar(:acr_cursor,
                     :ln_rowcount,
                     :an_det_codigo,
                     :an_cnt_codigo,
                     :as_criterio,
                     :an_start,
                     :an_limit);
                     end;";
            
            $luo_con = new Db();
            
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_det_codigo',$an_det_codigo,10);
             oci_bind_by_name($stid,':an_cnt_codigo',$an_cnt_codigo,10);
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
           clsViewData::showError($ex->getCode(), $ex->getMessage());                 
        }
    }
    
    public function lst_carpeta($an_cnt_codigo){
        try{
            $ls_sql="begin
                        varios.pck_cnt_detalle.sp_lst_carpeta(:acr_cursor,
                        :an_cnt_codigo);
                     end;";
            
            $luo_con = new Db();
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
            $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
            $curs = $luo_con->ocinewcursor();             
            if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_cnt_codigo',$an_cnt_codigo,10);
           
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
            $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
            oci_free_statement($stid);
            $luo_con->closeConexion();
             
            unset($luo_con);
             
            return $rowdata; 
            
        }
        catch(Exception $ex){
            
        }
    }
    
    public function lst_orden($an_cnt_codigo,$an_det_parent){
        try{
             $ls_sql="begin
                        varios.pck_cnt_detalle.sp_lst_orden(:acr_cursor,
                        :an_cnt_codigo,
                        :an_det_parent);
                     end;";
            
            $luo_con = new Db();
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
            $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
            $curs = $luo_con->ocinewcursor();             
            if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_cnt_codigo',$an_cnt_codigo,10);
            oci_bind_by_name($stid,':an_det_parent',$an_det_parent,10);
           
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
            $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
            oci_free_statement($stid);
            $luo_con->closeConexion();
             
            unset($luo_con);
             
            return $rowdata; 
        }
        catch(Exception $ex){
            
        }
    }
    
    public function lst_lista_nodo($an_cnt_codigo,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            $ln_det_codigo=0;       
            
             $ls_sql="begin
                     varios.pck_cnt_detalle.sp_lst_listar(:acr_cursor,
                     :ln_rowcount,
                     :an_det_codigo,
                     :an_cnt_codigo,
                     :as_criterio,
                     :an_start,
                     :an_limit);
                     end;";
            
            $luo_con = new Db();
            
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_det_codigo',$ln_det_codigo,10);
             oci_bind_by_name($stid,':an_cnt_codigo',$an_cnt_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,120);
             oci_bind_by_name($stid,':an_start',$an_start,10);
             oci_bind_by_name($stid,':an_limit',$an_limit,10);
             
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
                         
            $dataperseada=parsearcursor($curs);

            oci_free_statement($stid);
             
            $luo_con->closeConexion();
            
            $lstItems = fn_formattree($dataperseada);
          
            $rowdata = '['.fn_printListItem( $lstItems, 0, null, '/',false ).']';
                      
             unset($luo_con);
             
             return $rowdata;
        }
        catch(Exception $ex){
            
        }
    }
}
