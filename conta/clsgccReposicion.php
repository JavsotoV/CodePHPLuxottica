<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgccReposicion
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsgccReposicion {
    //put your code here
	private $_rpo_codigo;
	private $_ent_codigo;
	private $_rpo_fecha;
	private $_rpo_observacion;
	private $_mon_codigo;
	private $_rpo_importe;
	private $_rpo_usuario;

      function __construct($an_rpo_usuario) {
          $this->_rpo_usuario=$an_rpo_usuario;
          $this->_rpo_codigo=0;
      }  
      function set_rpo_codigo($_rpo_codigo) {
          $this->_rpo_codigo = $_rpo_codigo;
      }

      function set_ent_codigo($_ent_codigo) {
          $this->_ent_codigo = $_ent_codigo;
      }

      function set_rpo_fecha($_rpo_fecha) {
          $this->_rpo_fecha = $_rpo_fecha;
      }

      function set_rpo_observacion($_rpo_observacion) {
          $this->_rpo_observacion = mb_strtoupper($_rpo_observacion,'utf-8');
      }

      function set_mon_codigo($_mon_codigo) {
          $this->_mon_codigo = $_mon_codigo;
      }

      function set_rpo_importe($_rpo_importe) {
          $this->_rpo_importe = number_format(validaNull($_rpo_importe,0,'float'),2);
      }

      public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function sp_gcc_reposicion($an_accion){
        try{
            $ls_sql="begin
                            pck_gcc_reposicion.sp_gcc_reposicion (:an_accion,
                                :acr_retorno,
                                :acr_cursor,
                                :an_rpo_codigo,
                                :an_ent_codigo,
                                to_date(:ad_rpo_fecha,'dd/mm/yyyy'),
                                :as_rpo_observacion,
                                :an_mon_codigo,
                                to_number(:an_rpo_importe,'999,999,999,999.999'),
                                :an_rpo_usuario);
                      end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            };
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_rpo_codigo',$this->_rpo_codigo,10);
            oci_bind_by_name($stid,':an_ent_codigo',$this->_ent_codigo,10);
            oci_bind_by_name($stid,':ad_rpo_fecha',$this->_rpo_fecha,12);
            oci_bind_by_name($stid,':as_rpo_observacion',$this->_rpo_observacion,120);
            oci_bind_by_name($stid,':an_mon_codigo',$this->_mon_codigo,10);
            oci_bind_by_name($stid,':an_rpo_importe',$this->_rpo_importe,15);
            oci_bind_by_name($stid,':an_rpo_usuario',$this->_rpo_usuario,10);
            
             if(!$luo_set->ReadcrsMant($luo_con, $stid, $crto)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
            $luo_con->commitTransaction();
            
            $lstData = ( $an_accion != 3 ? parsearcursor($curs) : [] );
                
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                 
            oci_free_statement($crto);
            
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
    
    public function lst_listar($an_rpo_codigo,$an_rpo_periodo,$an_ent_codigo,$as_criterio,$an_start,$an_limit){
        try{
            
            $ln_rowcount=0;
            
            $ls_sql="begin
                        pck_gcc_reposicion.sp_lst_listar (  :acr_cursor,
                            :ln_rowcount,
                            :an_rpo_codigo,
                            :an_rpo_periodo,
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
             oci_bind_by_name($stid,':an_rpo_codigo',$an_rpo_codigo,10);
             oci_bind_by_name($stid,':an_rpo_periodo',$an_rpo_periodo,10);
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
            return clsViewData::showError($ex->getCode(),$ex->getMessage());
        }
        
    }

}
