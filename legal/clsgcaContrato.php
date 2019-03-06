<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgcaContrato
 *
 * @author JAVSOTO
 * 
 * 
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("clsgcaEnviarEmail.php");

class clsgcaContrato {
    //put your code here
    private $_con_codigo;
    private $_tda_codigo;
    private $_pai_codigo;
    private $_imb_codigo;
    private $_con_direccion;
    private $_ubg_codigo;
    private $_con_codgestion;
    private $_sta_codigo;
    private $_org_codigo;
    private $_con_area;
    private $_con_valormetro;
    private $_con_fechaper;
    private $_con_fechafirma;
    private $_con_fechai;
    private $_con_fechat;
    private $_per_factura;
    private $_cna_codigo;
    private $_rja_codigo;
    private $_con_observacion;
    private $_con_licencia;
    private $_con_nropredio;
    private $_con_parent;
    private $_con_tipofondoprom;
    private $_con_basefondoprom;
    private $_con_porcfondoprom;
    private $_mon_fondoprom;
    private $_con_impfondopromo;
    private $_mon_ingresollave;
    private $_con_impingrllave;
    private $_con_flagclausalida;
    private $_con_plazominsalida;
    private $_con_flagrenovacionaut;
    private $_con_flagplazominrenov;
    private $_con_plazominrenov;
    private $_con_flagconremodelacion;
    private $_con_fecharemodelacion;
    private $_con_flagrentadiciembre;
    private $_con_imprentadiciembre;
    private $_mrc_codigo;
    private $_mon_codigorevision;
    private $_con_importerevision;
    private $_per_codigoarrendador;
    private $_con_sap;
    private $_gra_tipo;
    private $_gra_moncodigo;
    private $_gra_importe;
    private $_con_plazorenovacionaut;
    private $_con_undplazominrenov;
    private $_con_undplazominsalida;
    private $_con_undplazorenovacionaut;
    private $_fmp_codigo;
    private $_gto_tipo;
    private $_gto_moncodigo;
    private $_gto_importe;
    private $_rta_fechai;
    private $_rta_moncodigo;
    private $_rta_importeipc;
    private $_rta_porcentaje;
    private $_rta_puntop;
    private $_con_flaggarantia;
    private $_rja_plazo;

    function __construct() {
        $this->_con_codigo=0;
        $this->_con_basefondoprom=0;
        $this->_con_porcfondoprom=0;
        $this->_rta_moncodigo=0;
        $this->_rta_importeipc=0;
        $this->_rta_porcentaje=0;
        $this->_rta_puntop=0;
        $this->_rja_plazo=0;
        
    }
    
    function set_con_codigo($_con_codigo) {
        $this->_con_codigo = validaNull($_con_codigo,0,'int');
    }

    function set_tda_codigo($_tda_codigo) {        
        $this->_tda_codigo = validaNull($_tda_codigo,0,'int');
        
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = $_pai_codigo;
    }

    function set_imb_codigo($_imb_codigo) {
        $this->_imb_codigo = validaNull($_imb_codigo,0,'int');
    }

    function set_con_direccion($_con_direccion) {
        $this->_con_direccion = mb_strtoupper($_con_direccion,'utf-8');
    }

    function set_ubg_codigo($_ubg_codigo) {
        $this->_ubg_codigo = validaNull($_ubg_codigo,0,'int');
    }

    function set_con_codgestion($_con_codgestion) {
        $this->_con_codgestion = mb_strtoupper($_con_codgestion,'utf-8');
    }

    function set_sta_codigo($_sta_codigo) {
        $this->_sta_codigo = validaNull($_sta_codigo,0,'int');
    }

    function set_org_codigo($_org_codigo) {
        $this->_org_codigo = $_org_codigo;
    }

    function set_con_area($_con_area) {
        $this->_con_area =number_format(validaNull($_con_area,0,'float'),2);
    }

    function set_con_valormetro($_con_valormetro) {
        $this->_con_valormetro = number_format(validaNull($_con_valormetro,0,'float'),2);;
    }

    function set_con_fechaper($_con_fechaper) {
        $this->_con_fechaper = validaNull($_con_fechaper,'01/01/1900','date');
    }

    function set_con_fechafirma($_con_fechafirma) {
        $this->_con_fechafirma = validaNull($_con_fechafirma,'01/01/1900','date');
    }

    function set_con_fechai($_con_fechai) {
        $this->_con_fechai = validaNull($_con_fechai,'01/01/1900','date');
    }

    function set_con_fechat($_con_fechat) {
        $this->_con_fechat = validaNull($_con_fechat,'01/01/1900','date');
    }

    function set_per_factura($_per_factura) {
        $this->_per_factura = $_per_factura;
    }

    function set_cna_codigo($_cna_codigo) {
        $this->_cna_codigo = validaNull($_cna_codigo,0,'int');
    }

    function set_rja_codigo($_rja_codigo) {
        $this->_rja_codigo = validaNull($_rja_codigo,0,'int');
    }

    function set_con_observacion($_con_observacion) {
        $this->_con_observacion = mb_strtoupper($_con_observacion,'utf-8');
    }

    function set_con_licencia($_con_licencia) {
        $this->_con_licencia = mb_strtoupper($_con_licencia,'utf-8');
    }

    function set_con_nropredio($_con_nropredio) {
        $this->_con_nropredio = mb_strtoupper($_con_nropredio,'utf-8');
    }

    function set_con_parent($_con_parent) {
        $this->_con_parent = $_con_parent;
    }

    function set_con_tipofondoprom($_con_tipofondoprom) {
        $this->_con_tipofondoprom =validaNull($_con_tipofondoprom,0,'int');
    }

    function set_con_basefondoprom($_con_basefondoprom) {
        $this->_con_basefondoprom = validaNull($_con_basefondoprom,0,'int');
    }

    function set_con_porcfondoprom($_con_porcfondoprom) {
        $this->_con_porcfondoprom = number_format(validaNull($_con_porcfondoprom,0,'float'),2);
    }

    function set_mon_fondoprom($_mon_fondoprom) {
        $this->_mon_fondoprom = validaNull($_mon_fondoprom,0,'int');
    }

    function set_con_impfondopromo($_con_impfondopromo) {
        $this->_con_impfondopromo = number_format(validaNull($_con_impfondopromo,0,'float'),2);
    }

    function set_mon_ingresollave($_mon_ingresollave) {
        $this->_mon_ingresollave = validaNull($_mon_ingresollave,0,'int');
    }

    function set_con_impingrllave($_con_impingrllave) {
        $this->_con_impingrllave = number_format(validaNull($_con_impingrllave,0,'float'),2);
    }
    
    function set_con_flagclausalida($_con_flagclausalida) {
        $this->_con_flagclausalida = validaNull($_con_flagclausalida,0,'int');
    }

    function set_con_plazominsalida($_con_plazominsalida) {
        $this->_con_plazominsalida = validaNull($_con_plazominsalida,0,'int');
    }

    function set_con_flagrenovacionaut($_con_flagrenovacionaut) {
        $this->_con_flagrenovacionaut = validaNull($_con_flagrenovacionaut,0,'int');
    }

    function set_con_flagplazominrenov($_con_flagplazominrenov) {
        $this->_con_flagplazominrenov = validaNull($_con_flagplazominrenov,0,'int');
    }

    function set_con_plazominrenov($_con_plazominrenov) {
        $this->_con_plazominrenov = validaNull($_con_plazominrenov,0,'int');
    }

    function set_con_flagconremodelacion($_con_flagconremodelacion) {
        $this->_con_flagconremodelacion = validaNull($_con_flagconremodelacion,0,'int');
    }

    function set_con_fecharemodelacion($_con_fecharemodelacion) {
        $this->_con_fecharemodelacion = validaNull($_con_fecharemodelacion,'01/01/1900','date');
    }

    function set_con_flagrentadiciembre($_con_flagrentadiciembre) {
        $this->_con_flagrentadiciembre = $_con_flagrentadiciembre;
    }

    function set_con_imprentadiciembre($_con_imprentadiciembre) {
        $this->_con_imprentadiciembre = number_format(validaNull($_con_imprentadiciembre,0,'float'),2);
    }

    function set_mrc_codigo($_mrc_codigo) {
        $this->_mrc_codigo = validaNull($_mrc_codigo,0,'int');
    }

    function set_mon_codigorevision($_mon_codigorevision) {
        $this->_mon_codigorevision = validaNull($_mon_codigorevision,0,'int');
    }

    function set_con_importerevision($_con_importerevision) {
        $this->_con_importerevision = number_format(validaNull($_con_importerevision,0,'float'),2);
    }
    
    function set_per_codigoarrendador($_per_codigoarrendador) {
        $this->_per_codigoarrendador = validaNull($_per_codigoarrendador,0,'int');
    }

    function set_con_sap($_con_sap) {
        $this->_con_sap = $_con_sap;
    }

    function set_gra_tipo($_gra_tipo) {
        $this->_gra_tipo = validaNull($_gra_tipo,0,'int');
    }

    function set_gra_moncodigo($_gra_moncodigo) {
        $this->_gra_moncodigo = ValidaNull($_gra_moncodigo,0,'int');
    }

    function set_gra_importe($_gra_importe) {
        $this->_gra_importe = number_format(ValidaNull($_gra_importe,0,'float'),2);
    }

    function set_con_plazorenovacionaut($_con_plazorenovacionaut) {
        $this->_con_plazorenovacionaut = ValidaNull($_con_plazorenovacionaut,0,'int');
    }
    
    function set_con_undplazominrenov($_con_undplazominrenov) {
        $this->_con_undplazominrenov = ValidaNull($_con_undplazominrenov,0,'int');
    }

    function set_con_undplazominsalida($_con_undplazominsalida) {
        $this->_con_undplazominsalida = ValidaNull($_con_undplazominsalida ,0,'int');
    }

    function set_con_undplazorenovacionaut($_con_undplazorenovacionaut) {
        $this->_con_undplazorenovacionaut = ValidaNull($_con_undplazorenovacionaut,0,'int');
    }

    function set_fmp_codigo($_fmp_codigo) {
        $this->_fmp_codigo = ValidaNull($_fmp_codigo,0,'int');
    }
        
    function set_gto_tipo($_gto_tipo) {
        $this->_gto_tipo = ValidaNull($_gto_tipo,0,'int');
    }

    function set_gto_moncodigo($_gto_moncodigo) {
        $this->_gto_moncodigo = ValidaNull($_gto_moncodigo,0,'int');
    }

    function set_gto_importe($_gto_importe) {
        $this->_gto_importe = number_format(ValidaNull($_gto_importe,0,'float'),2);
    }

    function set_rta_fechai($_rta_fechai) {
        $this->_rta_fechai = ValidaNull($_rta_fechai,'01/01/1900','date');
    }

    function set_rta_moncodigo($_rta_moncodigo) {
        $this->_rta_moncodigo = ValidaNull($_rta_moncodigo,0,'int');
    }

    function set_rta_importeipc($_rta_importeipc) {
        $this->_rta_importeipc = number_format(ValidaNull($_rta_importeipc,0,'float'),2);
    }

    function set_rta_porcentaje($_rta_porcentaje) {
        $this->_rta_porcentaje = number_format(ValidaNull($_rta_porcentaje,0,'float'),2);
    }

    function set_rta_puntop($_rta_puntop) {
        $this->_rta_puntop = number_format(ValidaNull($_rta_puntop,0,'float'),2);
    }

    function set_con_flaggarantia($_con_flaggarantia) {
        $this->_con_flaggarantia = ValidaNull($_con_flaggarantia,0,'int');
    }

    function set_rja_plazo($_rja_plazo) {
        $this->_rja_plazo = ValidaNull($_rja_plazo,0,'int');
    }

        
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }

    public function sp_gca_contrato($an_accion,$an_usuario){
        
        $luo_con= new Db();
        
        try{
            
            $ls_sql="begin pck_gca_contrato.sp_gca_contrato(
                    :an_accion,
                    :acr_retorno,
                    :acr_cursor,
                    :an_con_codigo,
                    :an_tda_codigo,
                    :an_pai_codigo,
                    :an_imb_codigo,
                    :as_con_direccion,
                    :an_ubg_codigo,
                    :an_con_codgestion,
                    :an_sta_codigo,
                    :an_org_codigo,
                    to_number(:an_con_area,'999,999,999,999.999'),
                    to_number(:an_con_valormetro,'999,999,999,999.999'),
                    to_date(:ad_con_fechaper,'dd/mm/yyyy'),
                    to_date(:ad_con_fechafirma,'dd/mm/yyyy'),
                    to_date(:ad_con_fechai,'dd/mm/yyyy'),
                    to_date(:ad_con_fechat,'dd/mm/yyyy'),
                    :an_per_factura,
                    :an_cna_codigo,
                    :an_rja_codigo,
                    :as_con_observacion,
                    :as_con_licencia,
                    :as_con_nropredio,
                    :an_con_parent,
                    :an_con_tipofondoprom,
                    :an_con_basefondoprom,
                    to_number(:an_con_porcfondoprom,'999,999,999,999.999'),
                    :an_mon_fondoprom,
                    to_number(:an_con_impfondopromo,'999,999,999,999.999'),
                    :an_mon_ingresollave,
                    to_number(:an_con_impingrllave,'999,999,999,999.999'),
                    :an_con_flagclausalida,
                    :an_con_plazominsalida,
                    :an_con_flagrenovacionaut,
                    :an_con_flagplazominrenov,
                    :an_con_plazominrenov,
                    :an_con_flagconremodelacion,
                    to_date(:ad_con_fecharemodelacion,'dd/mm/yyyy'),
                    :an_con_flagrentadiciembre,
                    to_number(:an_con_imprentadiciembre,'999,999,999,999.999'),
                    :an_mrc_codigo,
                    :an_mon_codigorevision,
                    to_number(:an_con_importerevision,'999,999,999,999.999'),
                    :an_per_codigoarrendador,
                    :as_con_sap,
                    :an_gra_tipo,
                    :an_gra_moncodigo,
                    to_number(:an_gra_importe,'999,999,999,999.999'),
                    :an_con_plazorenovacionaut,
                    :an_con_undplazominrenov,
                    :an_con_undplazominsalida,
                    :an_con_undplazorenovacionaut,
                    :an_fmp_codigo,
                    :an_gto_tipo,
                    :an_gto_moncodigo,
                    to_number(:an_gto_importe,'999,999,999,999.999'),
                    to_date(:ad_rta_fechai,'dd/mm/yyyy'),
                    :an_rta_moncodigo,
                    to_number(:an_rta_importeipc,'999,999,999,999.999'),
                    to_number(:an_rta_porcentaje,'999,999,999,999.999'),
                    to_number(:an_rta_puntop,'999,999,999,999.999'),
                    :an_con_flaggarantia,
                    :an_rja_plazo,
                    :an_con_usuario);
                    end;";
            
            if($luo_con->createConexion()==false){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $stid=$luo_con->ociparse($ls_sql);            
            if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $crto = $luo_con->ocinewcursor();            
            if(!$crto){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $curs = $luo_con->ocinewcursor();            
            if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
            oci_bind_by_name($stid,':an_con_codigo',$this->_con_codigo,10);
            oci_bind_by_name($stid,':an_tda_codigo',$this->_tda_codigo,10);
            oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
            oci_bind_by_name($stid,':an_imb_codigo',$this->_imb_codigo);
            oci_bind_by_name($stid,':as_con_direccion',$this->_con_direccion,250);
            oci_bind_by_name($stid,':an_ubg_codigo',$this->_ubg_codigo);
            oci_bind_by_name($stid,':an_con_codgestion',$this->_con_codgestion,10);
            oci_bind_by_name($stid,':an_sta_codigo',$this->_sta_codigo,10);
            oci_bind_by_name($stid,':an_org_codigo',$this->_org_codigo,10);
            oci_bind_by_name($stid,':an_con_area',$this->_con_area,32);
            oci_bind_by_name($stid,':an_con_valormetro',$this->_con_valormetro,32);
            oci_bind_by_name($stid,':ad_con_fechaper',$this->_con_fechaper,24);
            oci_bind_by_name($stid,':ad_con_fechafirma',$this->_con_fechafirma,24);
            oci_bind_by_name($stid,':ad_con_fechai',$this->_con_fechai,24);
            oci_bind_by_name($stid,':ad_con_fechat',$this->_con_fechat,24);
            oci_bind_by_name($stid,':an_per_factura',$this->_per_factura,10);
            oci_bind_by_name($stid,':an_cna_codigo',$this->_cna_codigo,10);
            oci_bind_by_name($stid,':an_rja_codigo',$this->_rja_codigo,10);
            oci_bind_by_name($stid,':as_con_observacion',$this->_con_observacion,580);
            oci_bind_by_name($stid,':as_con_licencia',$this->_con_licencia,120);
            oci_bind_by_name($stid,':as_con_nropredio',$this->_con_nropredio,120);
            oci_bind_by_name($stid,':an_con_parent',$this->_con_parent,10);
            oci_bind_by_name($stid,':an_con_tipofondoprom',$this->_con_tipofondoprom,10);
            oci_bind_by_name($stid,':an_con_basefondoprom',$this->_con_basefondoprom,10);
            oci_bind_by_name($stid,':an_con_porcfondoprom',$this->_con_porcfondoprom,32);
            oci_bind_by_name($stid,':an_mon_fondoprom',$this->_mon_fondoprom,10);
            oci_bind_by_name($stid,':an_con_impfondopromo',$this->_con_impfondopromo,15);
            oci_bind_by_name($stid,':an_mon_ingresollave',$this->_mon_ingresollave,10);
            oci_bind_by_name($stid,':an_con_impingrllave',$this->_con_impingrllave,32);
            oci_bind_by_name($stid,':an_con_flagclausalida',$this->_con_flagclausalida,10);
            oci_bind_by_name($stid,':an_con_plazominsalida',$this->_con_plazominsalida,10);
            oci_bind_by_name($stid,':an_con_flagrenovacionaut',$this->_con_flagrenovacionaut,10);
            oci_bind_by_name($stid,':an_con_flagplazominrenov',$this->_con_flagplazominrenov,10);
            oci_bind_by_name($stid,':an_con_plazominrenov',$this->_con_plazominrenov,10);
            oci_bind_by_name($stid,':an_con_flagconremodelacion',$this->_con_flagconremodelacion,10);
            oci_bind_by_name($stid,':ad_con_fecharemodelacion',$this->_con_fecharemodelacion,24);
            oci_bind_by_name($stid,':an_con_flagrentadiciembre',$this->_con_flagrentadiciembre,10);
            oci_bind_by_name($stid,':an_con_imprentadiciembre',$this->_con_imprentadiciembre,15);
            oci_bind_by_name($stid,':an_mrc_codigo',$this->_mrc_codigo,10);
            oci_bind_by_name($stid,':an_mon_codigorevision',$this->_mon_codigorevision,10);
            oci_bind_by_name($stid,':an_con_importerevision',$this->_con_importerevision,15);
            oci_bind_by_name($stid,':an_per_codigoarrendador',$this->_per_codigoarrendador,10);
            oci_bind_by_name($stid,':as_con_sap',$this->_con_sap,20);
            oci_bind_by_name($stid,':an_gra_tipo',$this->_gra_tipo,10);
            oci_bind_by_name($stid,':an_gra_moncodigo',$this->_gra_moncodigo,10);
            oci_bind_by_name($stid,':an_gra_importe',$this->_gra_importe,32);
            oci_bind_by_name($stid,':an_con_plazorenovacionaut',$this->_con_plazorenovacionaut,10);
            oci_bind_by_name($stid,':an_con_undplazominrenov', $this->_con_undplazominrenov,10);
            oci_bind_by_name($stid,':an_con_undplazominsalida',$this->_con_undplazominsalida,10);
            oci_bind_by_name($stid,':an_con_undplazorenovacionaut',$this->_con_undplazorenovacionaut,10);    
            oci_bind_by_name($stid,':an_fmp_codigo',$this->_fmp_codigo,10);    
            oci_bind_by_name($stid,':an_gto_tipo',$this->_gto_tipo,10);    
            oci_bind_by_name($stid,':an_gto_moncodigo',$this->_gto_moncodigo,10);    
            oci_bind_by_name($stid,':an_gto_importe',$this->_gto_importe,32);   
            oci_bind_by_name($stid,':ad_rta_fechai',$this->_rta_fechai,12);
            oci_bind_by_name($stid,':an_rta_moncodigo',$this->_rta_moncodigo,10);
            oci_bind_by_name($stid,':an_rta_importeipc',$this->_rta_importeipc,32);
            oci_bind_by_name($stid,':an_rta_porcentaje',$this->_rta_porcentaje,32);
            oci_bind_by_name($stid,':an_rta_puntop',$this->_rta_puntop,32);
            oci_bind_by_name($stid,':an_con_flaggarantia',$this->_con_flaggarantia,10);
            oci_bind_by_name($stid,':an_rja_plazo',$this->_rja_plazo,10);
            oci_bind_by_name($stid,':an_con_usuario',$an_usuario,10);

            
            if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError().' $stid');}
            if(!$luo_con->ociExecute($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            if (!$luo_con->ocifetchRetorno($crto)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
            
            $luo_con->commitTransaction();
            
            $lstData = ( $an_accion != 3 ? parsearcursor($curs) : [] );
                
            $rowdata = clsViewData::viewData($lstData, false, 1, $luo_con->getMsgRetorno());
                 
            oci_free_statement($crto);
            oci_free_statement($stid);
            
            $luo_con->closeConexion();
            
            unset($luo_con);
            
           /* if ($an_accion==2){
                
                $luo_email = new clsgcaEnviarEmail($rowdata);
                
                $luo_email->EditContrato();  
                
                unset($luo_email);
            }*/
                   
            return $rowdata;           
            
        }
        catch(Exception $ex){
            
            clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_listar($an_pai_codigo,$an_sta_codigo,$an_cda_codigo, $as_criterio,$an_con_codigo,$an_start,$an_limit){
        
            $ln_rowcount=0;
            
        try{
            $luo_con =new Db();
            
             $ls_sql = "begin pck_gca_contrato.sp_lst_listar(
                        :acr_cursor,
                        :ln_rowcount,
                        :an_pai_codigo,
                        :as_criterio,
                        :an_con_codigo,
                        :an_sta_codigo,
                        :an_cda_codigo,
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
             oci_bind_by_name($stid,':as_criterio',$as_criterio,60);
             oci_bind_by_name($stid,':an_con_codigo',$an_con_codigo,10);
             oci_bind_by_name($stid,':an_sta_codigo',$an_sta_codigo,10);
             oci_bind_by_name($stid,':an_cda_codigo',$an_cda_codigo,10);
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
    
    public function lst_fecha_apertura($an_pai_codigo,$ad_fecha_ini,$ad_fecha_ter,$as_criterio,$an_start,$an_limit){
        
            $ln_rowcount=0;
   
        try{
            $luo_con =new Db();
            
             $ls_sql = "begin pck_gca_contrato.sp_lst_fechapertura(
                        :acr_cursor,
                        :ln_rowcount,
                        :an_pai_codigo,
                        to_date(:ad_fechaini,'dd/mm/yyyy'),
                        to_date(:ad_fechat,'dd/mm/yyyy'),
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
             oci_bind_by_name($stid,':ad_fechaini',$ad_fecha_ini,12);
             oci_bind_by_name($stid,':ad_fechat',$ad_fecha_ter,12);
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
