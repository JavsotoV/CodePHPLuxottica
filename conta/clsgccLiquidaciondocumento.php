<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgccRepocomprobante
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsgccLiquidaciondocumento {
    //put your code here
private $_cmp_codigo;
private $_ent_codigo;
private $_pai_codigo;
private $_per_codigo;
private $_cmp_fecha;
private $_tpc_codigo;
private $_cmp_serie;
private $_cmp_numero;
private $_cmp_fechaven;
private $_mon_codigo;
private $_cmp_tipocambio;
private $_cmp_afectoimp;
private $_cmp_venta;
private $_imp_codigo;
private $_imp_porcentaje;
private $_cmp_impuesto;
private $_cmp_impnogravado;
private $_cmp_importe;
private $_cmp_uuid;
private $_trb_codigo;
private $_trb_porcentaje;
private $_trb_importe;
private $_lqd_codigo;
private $_cpt_codigo;
private $_lqd_observacion;
private $_lqd_importe;
private $_lqd_afectoimp;
private $_lqd_estado;
private $_bin_filename;
private $_bin_blob;
private $_bin_bandera;
private $_cmp_usuario;

    function __construct($an_cmp_usuario) {
        $this->_cmp_codigo=0;
        $this->_cmp_tipocambio=1;
        $this->_cmp_usuario=$an_cmp_usuario;
        $this->_lqd_codigo=[];
        $this->_cpt_codigo=[];
        $this->_lqd_observacion=[];
        $this->_lqd_importe=[];
        $this->_lqd_afectoimp=[];
        $this->_lqd_estado=[];    
        $this->_cmp_afectoimp=0;
        $this->_bin_blob=null;
        $this->_bin_bandera=0;
    }

    function set_cmp_codigo($_cmp_codigo) {
        $this->_cmp_codigo = $_cmp_codigo;
    }

    function set_ent_codigo($_ent_codigo) {
        $this->_ent_codigo = $_ent_codigo;
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = $_pai_codigo;
    }

    function set_per_codigo($_per_codigo) {
        $this->_per_codigo = $_per_codigo;
    }

    function set_cmp_fecha($_cmp_fecha) {
        $this->_cmp_fecha = $_cmp_fecha;
    }

    function set_tpc_codigo($_tpc_codigo) {
        $this->_tpc_codigo = $_tpc_codigo;
    }

    function set_cmp_serie($_cmp_serie) {
        $this->_cmp_serie = $_cmp_serie;
    }

    function set_cmp_numero($_cmp_numero) {
        $this->_cmp_numero = $_cmp_numero;
    }

    function set_cmp_fechaven($_cmp_fechaven) {
        $this->_cmp_fechaven = validaNull($_cmp_fechaven,'01/01/1900','date');
    }

    function set_mon_codigo($_mon_codigo) {
        $this->_mon_codigo = $_mon_codigo;
    }

    function set_cmp_tipocambio($_cmp_tipocambio) {
        $this->_cmp_tipocambio = number_format(validaNull($_cmp_tipocambio,1,'float'),2);
    }

    function set_cmp_venta($_cmp_venta) {
        $this->_cmp_venta = number_format(validaNull($_cmp_venta,0,'float'),2);
    }
    
    function set_imp_codigo($_imp_codigo) {
        
        $this->_imp_codigo = validaNull($_imp_codigo,0,'int');
        
        if ($this->_imp_codigo>0){$this->_cmp_afectoimp=1;}
        
    }

    function set_imp_porcentaje($_imp_porcentaje) {
        $this->_imp_porcentaje = number_format(validaNull($_imp_porcentaje,0,'float'),2);
    }

    function set_cmp_impuesto($_cmp_impuesto) {
        $this->_cmp_impuesto = number_format(validaNull($_cmp_impuesto,0,'float'),2);
    }

    function set_cmp_impnogravado($_cmp_impnogravado) {
        $this->_cmp_impnogravado = number_format(validaNull($_cmp_impnogravado,0,'float'),2);
    }

    function set_cmp_importe($_cmp_importe) {
        $this->_cmp_importe = number_format(validaNull($_cmp_importe,0,'float'),2);
    }
    
    function set_cmp_uuid($_cmp_uuid) {
        $this->_cmp_uuid = $_cmp_uuid;
    }
    
    function set_trb_codigo($_trb_codigo) {
        $this->_trb_codigo = validaNull($_trb_codigo,0,'int');
    }

    function set_trb_porcentaje($_trb_porcentaje) {
        $this->_trb_porcentaje = number_format(validaNull($_trb_porcentaje,0,'float'),2);
    }

    function set_trb_importe($_trb_importe) {
        $this->_trb_importe = number_format(validaNull($_trb_importe,0,'float'),2);
    }

    function set_lqd_codigo($_lqd_codigo) {
        $this->_lqd_codigo = $_lqd_codigo;
    }

    function set_cpt_codigo($_cpt_codigo) {
        $this->_cpt_codigo = $_cpt_codigo;
    }

    function set_lqd_observacion($_lqd_observacion) {
        $this->_lqd_observacion = $_lqd_observacion;
    }

    function set_lqd_importe($_lqd_importe) {        
        $this->_lqd_importe = $_lqd_importe;
    }

    function set_lqd_afectoimp($_lqd_afectoimp) {
        $this->_lqd_afectoimp = $_lqd_afectoimp;
    }

    function set_lqd_estado($_lqd_estado) {
        $this->_lqd_estado = $_lqd_estado;
    }
    
    function set_bin_blob($_bin_blob) {
       
            $this->_bin_bandera=0;
        
            if ( !is_array($_bin_blob) ){throw new Exception( 'No ha adjuntando ningun documento' );}
        
     //      if (( $_bin_blob [ 'type' ] !== 'application/pdf' ) && ($_bin_blob [ 'type' ] !== 'image/jpeg' ) ){
      //          throw new Exception( 'Solo se permite archivos PDF o JPG' );            
            if ( $_bin_blob [ 'size' ] > 50948388608 )
                {throw new Exception( 'El peso maximo permitido es 20Mb', -10000 );}
      
                $this->_bin_blob=file_get_contents($_bin_blob['tmp_name']); 
        
                $this->_bin_filename=$_bin_blob['name'];
        
                $this->_bin_bandera=1;
         //}
     }
    
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_gcc_liquidacion($an_accion){
        try{
            $ls_sql="begin
                        pck_gcc_liquidaciondocumento.sp_gcc_liquidacion (:an_accion,
                            :acr_retorno,
                            :acr_cursor,
                            :an_cmp_codigo,
                            :an_ent_codigo,
                            :an_pai_codigo,
                            :an_per_codigo,
                            to_date(:ad_cmp_fecha,'dd/mm/yyyy'),
                            :an_tpc_codigo,
                            :as_cmp_serie,  
                            :as_cmp_numero,
                            to_date(:ad_cmp_fechaven,'dd/mm/yyyy'),
                            :an_mon_codigo,
                            to_number(:an_cmp_tipocambio,'999,999,999,999.999'),
                            :an_cmp_afectoimp,
                            to_number(:an_cmp_venta,'999,999,999,999.999'),
                            :an_imp_codigo,
                            to_number(:an_imp_porcentaje,'999,999,999,999.999'),
                            to_number(:an_cmp_impuesto,'999,999,999,999.999'),
                            to_number(:an_cmp_impnogravado,'999,999,999,999.999'),
                            to_number(:an_cmp_importe,'999,999,999,999.999'),
                            :an_trb_codigo,
                            to_number(:an_trb_porcentaje,'999,999,999,999.999'),
                            to_number(:an_trb_importe,'999,999,999,999.999'),
                            :an_lqd_codigo,
                            :an_cpt_codigo,
                            :as_lqd_observacion,
                            :an_lqd_importe,
                            :an_lqd_afectoimp,
                            :an_lqd_estado,
                            :ab_bin_blob,
                            :as_bin_filename,
                            :as_cmp_uuid,
                            :an_cmp_usuario);
                    end;";
          
            if ($an_accion!==3){
                if ($this->_cmp_importe<=0){                
                    return clsViewData::showError(-1, 'No es posible registrar documento con importe en menor o igual a cero(0)');
                }
            }
            
            if ($an_accion===3)
            {
                $this->_lqd_codigo=Array(0);
                $this->_cpt_codigo=Array(0);
                $this->_lqd_observacion=Array('');
                $this->_lqd_importe=Array(0);
                $this->_lqd_afectoimp=Array(0);
                $this->_lqd_estado=Array(0);
            }
            
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
                
            $ln_count = count($this->_lqd_codigo);
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10);
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR);
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR);
            oci_bind_by_name($stid,':an_cmp_codigo',$this->_cmp_codigo,10);
            oci_bind_by_name($stid,':an_ent_codigo',$this->_ent_codigo,10);
            oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
            oci_bind_by_name($stid,':an_per_codigo',$this->_per_codigo,10);
            oci_bind_by_name($stid,':ad_cmp_fecha',$this->_cmp_fecha,12);
            oci_bind_by_name($stid,':an_tpc_codigo',$this->_tpc_codigo,10);
            oci_bind_by_name($stid,':as_cmp_serie',$this->_cmp_serie,20);
            oci_bind_by_name($stid,':as_cmp_numero',$this->_cmp_numero,20);
            oci_bind_by_name($stid,':ad_cmp_fechaven',$this->_cmp_fechaven,12);
            oci_bind_by_name($stid,':an_mon_codigo',$this->_mon_codigo,10);
            oci_bind_by_name($stid,':an_cmp_tipocambio',$this->_cmp_tipocambio,15);
            oci_bind_by_name($stid,':an_cmp_afectoimp',$this->_cmp_afectoimp,1);
            oci_bind_by_name($stid,':an_cmp_venta',$this->_cmp_venta,15);
            oci_bind_by_name($stid,':an_imp_codigo',$this->_imp_codigo,10);
            oci_bind_by_name($stid,':an_imp_porcentaje',$this->_imp_porcentaje,15);
            oci_bind_by_name($stid,':an_cmp_impuesto',$this->_cmp_impuesto,15);
            oci_bind_by_name($stid,':an_cmp_impnogravado',$this->_cmp_impnogravado,15);
            oci_bind_by_name($stid,':an_cmp_importe',$this->_cmp_importe,15);
            oci_bind_by_name($stid,':an_trb_codigo',$this->_trb_codigo,10);
            oci_bind_by_name($stid,':an_trb_porcentaje',$this->_trb_porcentaje,15);
            oci_bind_by_name($stid,':an_trb_importe',$this->_trb_importe,15);
            oci_bind_array_by_name($stid,':an_lqd_codigo',$this->_lqd_codigo,$ln_count,-1,SQLT_INT);
            oci_bind_array_by_name($stid,':an_cpt_codigo',$this->_cpt_codigo,$ln_count,-1,SQLT_INT);
            oci_bind_array_by_name($stid,':as_lqd_observacion',$this->_lqd_observacion,$ln_count,-1,SQLT_CHR);
            oci_bind_array_by_name($stid,':an_lqd_importe',$this->_lqd_importe,$ln_count,-1,SQLT_FLT);
            oci_bind_array_by_name($stid,':an_lqd_afectoimp',$this->_lqd_afectoimp,$ln_count,-1,SQLT_INT);
            oci_bind_array_by_name($stid,':an_lqd_estado',$this->_lqd_estado,$ln_count,-1,SQLT_INT);            
            oci_bind_by_name($stid,':ab_bin_blob',$blob,-1,OCI_B_BLOB);                     
            oci_bind_by_name($stid,':as_bin_filename',$this->_bin_filename,200);            
            oci_bind_by_name($stid,':as_cmp_uuid',$this->_cmp_uuid,120);            
            oci_bind_by_name($stid,':an_cmp_usuario',$this->_cmp_usuario,10);
            
             $result= oci_execute($stid,OCI_NO_AUTO_COMMIT);
            
            if(!$result){
                $error = oci_error($luo_con->refConexion);                
                return clsViewData::showError($error['code'], $error['message']);}
            
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
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_listar($an_cmp_codigo,$an_ent_codigo,$as_criterio,$an_start,$an_limit){
        try{
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_gcc_liquidaciondocumento.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_cmp_codigo,
                            :an_ent_codigo,
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
             oci_bind_by_name($stid,':an_cmp_codigo',$an_cmp_codigo,10);
             oci_bind_by_name($stid,':an_ent_codigo',$an_ent_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,60);
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
