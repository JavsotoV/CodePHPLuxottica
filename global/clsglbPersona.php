<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsGlbPersona
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clsglbPersona {
    
    private $_per_codigo;
    private $_per_tipo;
    private $_per_apaterno;
    private $_per_amaterno;
    private $_per_pnombre;
    private $_per_snombre;
    private $_per_razonsocial;
    private $_tpo_codigo;
    private $_per_nrodocidentidad;
    private $_per_genero;
    private $_per_fechanac;
    private $_pai_codigo;
    private $_dom_codigo;
    private $_dom_descripcion;
    private $_ubg_codigo;
    private $_per_representante;
    private $_ema_denominacion;

    function __construct() {
        $this->per_codigo=0;
        $this->_per_apaterno='';
        $this->_per_amaterno='';
        $this->_per_pnombre='';
        $this->_per_snombre='';
        $this->_per_fechanac='01/01/1900';
        $this->_per_genero=1;
    }
    
    function set_per_codigo($_per_codigo) {
        $this->_per_codigo = $_per_codigo;
    }

    function set_per_tipo($_per_tipo) {
        $this->_per_tipo = $_per_tipo;
    }

    function set_per_apaterno($_per_apaterno) {            
        $this->_per_apaterno = validaNull(mb_strtoupper($_per_apaterno,'utf-8'));
    }

    function set_per_amaterno($_per_amaterno) {
        $this->_per_amaterno = validaNull(mb_strtoupper($_per_amaterno,'utf-8'));
    }

    function set_per_pnombre($_per_pnombre) {
        $this->_per_pnombre = validaNull(mb_strtoupper($_per_pnombre,'utf-8'));
    }

    function set_per_snombre($_per_snombre) {
        $this->_per_snombre = validaNull(mb_strtoupper($_per_snombre,'utf-8'));
    }

    function set_per_razonsocial($_per_razonsocial) {
        $this->_per_razonsocial = mb_strtoupper($_per_razonsocial,'utf-8');
    }

    function set_tpo_codigo($_tpo_codigo) {
        $this->_tpo_codigo = $_tpo_codigo;
    }

    function set_per_nrodocidentidad($_per_nrodocidentidad) {
        $this->_per_nrodocidentidad = $_per_nrodocidentidad;
    }

    function set_per_genero($_per_genero) {
        $this->_per_genero = validaNull($_per_genero,1,'int');
    }

    function set_per_fechanac($_per_fechanac) {
        $this->_per_fechanac = validaNull($_per_fechanac,'01/01/1900','date');
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = $_pai_codigo;
    }

    function set_dom_codigo($_dom_codigo) {
        $this->_dom_codigo = validaNull($_dom_codigo,0, 'int');
    }

    function set_dom_descripcion($_dom_descripcion) {
        $this->_dom_descripcion = mb_strtoupper($_dom_descripcion,'utf-8');
    }

    function set_ubg_codigo($_ubg_codigo) {
        $this->_ubg_codigo = validaNull($_ubg_codigo,0,'int');
    }

    function set_per_representante($_per_representante) {
        $this->_per_representante = validaNull($_per_representante,0,'int');
    }

    function set_ema_denominacion($_ema_denominacion) {
        $this->_ema_denominacion = mb_strtolower($_ema_denominacion,'utf-8');
    }
        
    function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));
            }
        }
    }
    
    public function glb_persona($an_accion,$an_usuario){
        
        try{
            $luo_con = new Db();
            
            if ($this->_per_tipo!='J')
                {$this->_per_razonsocial='';                 
                }
            else{
                $this->_per_apaterno='';
                $this->_per_amaterno='';
                $this->_per_pnombre='';
                $this->_per_snombre='';
                $this->_per_fechanac='01/01/1900';
                $this->_per_genero=1;
            }
            
            if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $ls_sql="begin
                    pck_glb_persona.sp_glb_persona (:an_accion,
                    :acr_retorno,
                    :acr_cursor,
                    :an_per_codigo,
                    :as_per_tipo,
                    :as_per_apaterno,
                    :as_per_amaterno,
                    :as_per_pnombre,
                    :as_per_snombre,
                    :as_per_razonsocial,
                    :an_tpo_codigo,
                    :as_per_nrodocidentidad,
                    :an_per_genero,
                    to_date(:ad_per_fechanac,'dd/mm/yyyy'),
                    :an_pai_codigo,
                    :an_dom_codigo,
                    :as_dom_descripcion,
                    :an_ubg_codigo,
                    :an_per_representante,
                    :as_ema_denominacion,
                    :an_per_usuario);
                    end;";
            
            $stid=$luo_con->ociparse($ls_sql);            
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $crto = $luo_con->ocinewcursor();            
            if(!$crto){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $curs = $luo_con->ocinewcursor();            
            if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
          
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_per_codigo',$this->_per_codigo,10);
            oci_bind_by_name($stid,':as_per_tipo',$this->_per_tipo,1);
            oci_bind_by_name($stid,':as_per_apaterno',$this->_per_apaterno,40);
            oci_bind_by_name($stid,':as_per_amaterno',$this->_per_amaterno,40);
            oci_bind_by_name($stid,':as_per_pnombre',$this->_per_pnombre,40);
            oci_bind_by_name($stid,':as_per_snombre',$this->_per_snombre,40);
            oci_bind_by_name($stid,':as_per_razonsocial',$this->_per_razonsocial,120);
            oci_bind_by_name($stid,':an_tpo_codigo',$this->_tpo_codigo,10);
            oci_bind_by_name($stid,':as_per_nrodocidentidad',$this->_per_nrodocidentidad,20);
            oci_bind_by_name($stid,':an_per_genero',$this->_per_genero,10);
            oci_bind_by_name($stid,':ad_per_fechanac',$this->_per_fechanac,24);
            oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
            oci_bind_by_name($stid,':an_dom_codigo',$this->_dom_codigo,10);
            oci_bind_by_name($stid,':as_dom_descripcion',$this->_dom_descripcion,120);
            oci_bind_by_name($stid,':an_ubg_codigo',$this->_ubg_codigo,10);
            oci_bind_by_name($stid,':an_per_representante',$this->_per_representante,10);
            oci_bind_by_name($stid,':as_ema_denominacion',$this->_ema_denominacion,120);
            oci_bind_by_name($stid,':an_per_usuario',$an_usuario,10);
            
            if(!$luo_con->ociExecute($stid)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());                
            };            
            if(!$luo_con->ociExecute($crto)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());                
            };
            
            if (!$luo_con->ocifetchRetorno($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}   
            
            $luo_con->commitTransaction();
            
            $lstData = ( $an_accion != 3 ? parsearcursor($curs) : [] );
                
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                 
            oci_free_statement($crto);
            oci_free_statement($stid);
            
            $luo_con->closeConexion();
            
            unset($luo_con);
                   
            return $rowdata;               
                    
        }
        
        catch(Exception $ex){
            
            return clsViewData::showError($ex->getCode(), $ex->getMessage());            
        }
    }
    
    public function lst_listar($an_pai_codigo,$as_criterio,$an_start=0,$an_limit=30){
        
            $ln_per_codigo=0;
            $ln_rowcount=0;
            
      try{
            $luo_con =new Db();
            
             $ls_sql = "begin pck_glb_persona.sp_lst_listar(
                        :acr_cursor,
                        :ln_rowcount,
                        :as_criterio,
                        :an_per_codigo,
                        :an_pai_codigo,
                        :an_start,
                        :an_limit); 
                        end;";
         
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,60);
             oci_bind_by_name($stid,':an_per_codigo',$ln_per_codigo,10);
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
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
    
    public function lst_personaregion($an_pai_codigo,$an_prc_codigo,$an_org_codigo,$as_criterio,$an_start,$an_limit){
            
      try{
          $ln_rowcount=0;
          
          $luo_con =new Db();
            
             $ls_sql = "begin pck_glb_persona.sp_lst_personaregion(
                        :acr_cursor,
                        :ln_rowcount,
                        :an_pai_codigo,
                        :an_prc_codigo,
                        :an_org_codigo,
                        :as_criterio,
                        :an_start,
                        :an_limit); 
                        end;";
         
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_pai_codigo',$an_pai_codigo,10);
             oci_bind_by_name($stid,':an_prc_codigo',$an_prc_codigo,10);
             oci_bind_by_name($stid,':an_org_codigo',$an_org_codigo,10);
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
            clsViewData::showError($ex->getCode(), $ex->getMessage());
        }   
      
    }
}
