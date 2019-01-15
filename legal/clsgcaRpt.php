<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgcaRpt
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clsgcaRpt {
    //put your code here
    private $_pai_codigo;
    private $_dpt_codigo;
    private $_prv_codigo;
    private $_ubg_codigo;
    private $_imb_codigo;
    private $_cna_codigo;
    private $_cda_codigo;
    private $_sta_codigo;
    private $_con_flagrenovacionaut;
    private $_con_fechaperini;
    private $_con_fechaperter;
    private $_con_fechafirmaini;
    private $_con_fechafirmater;
    private $_con_fechaiini;
    private $_con_fechaiter;
    private $_con_fechatini;
    private $_con_fechatter;
    private $_gra_fechatini;
    private $_gra_fechatter;
    private $_rta_fechai;
    private $_rta_fechat;
    private $_mon_codigo;
    private $_tipocambio;
    private $_con_valormetroini;
    private $_con_valormetroter;
    private $_mon_conversion;
    private $_tipocambiolocal;
    private $_tipocambiodolar;
    private $_tipocambioeuro;
    
    function __construct() {
        $this->_pai_codigo=0;
        $this->_dpt_codigo=0;
        $this->_prv_codigo=0;
        $this->_ubg_codigo=0;
        $this->_imb_codigo=0;
        $this->_cna_codigo=0;
        $this->_tda_codigo=0;
        $this->_sta_codigo=0;
        $this->_con_flagrenovacionaut='01/01/1900';
        $this->_con_fechaperini='01/01/1900';
        $this->_con_fechaperter='01/01/1900';
        $this->_con_fechafirmaini='01/01/1900';
        $this->_con_fechafirmater='01/01/1900';
        $this->_con_fechaiini='01/01/1900';
        $this->_con_fechaiter='01/01/1900';
        $this->_con_fechatini='01/01/1900';
        $this->_con_fechatter='01/01/1900';
        $this->_gra_fechatini='01/01/1900';
        $this->_gra_fechatter='01/01/1900';
        $this->_rta_fechai='01/01/1900';
        $this->_rta_fechat='01/01/1900';
        $this->_mon_codigo=0;
        $this->_tipocambio=0;
        $this->_con_valormetroini=0;
        $this->_con_valormetroter=0;
        $this->_mon_conversion=0;
        $this->_tipocambiolocal=1;
        $this->_tipocambiodolar=1;
        $this->_tipocambioeuro=1;
    }
    
    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = ValidaNull($_pai_codigo,0,'int');
    }

    function set_dpt_codigo($_dpt_codigo) {
        $this->_dpt_codigo = ValidaNull($_dpt_codigo,0,'int');
    }

    function set_prv_codigo($_prv_codigo) {
        $this->_prv_codigo = ValidaNull($_prv_codigo,0,'int');
    }

    function set_ubg_codigo($_ubg_codigo) {
        $this->_ubg_codigo = ValidaNull($_ubg_codigo,0,'int');
    }

    function set_imb_codigo($_imb_codigo) {
        $this->_imb_codigo = ValidaNull($_imb_codigo,0,'int');
    }

    function set_cna_codigo($_cna_codigo) {
        $this->_cna_codigo = ValidaNull($_cna_codigo,0,'int');
    }

    function set_cda_codigo($_cda_codigo) {
        $this->_cda_codigo = ValidaNull($_cda_codigo,0,'int');
    }

    function set_sta_codigo($_sta_codigo) {
        $this->_sta_codigo = ValidaNull($_sta_codigo,0,'int');
    }

    function set_con_flagrenovacionaut($_con_flagrenovacionaut) {
        $this->_con_flagrenovacionaut = ValidaNull($_con_flagrenovacionaut,0,'int');
    }

    function set_con_fechaperini($_con_fechaperini) {
        $this->_con_fechaperini = ValidaNull($_con_fechaperini,'01/01/1900','date');
    }

    function set_con_fechaperter($_con_fechaperter) {
        $this->_con_fechaperter = ValidaNull($_con_fechaperter,'01/01/1900','date');
    }

    function set_con_fechafirmaini($_con_fechafirmaini) {
        $this->_con_fechafirmaini = ValidaNull($_con_fechafirmaini,'01/01/1900','date');
    }

    function set_con_fechafirmater($_con_fechafirmater) {
        $this->_con_fechafirmater = ValidaNull($_con_fechafirmater,'01/01/1900','date');
    }

    function set_con_fechaiini($_con_fechaiini) {
        $this->_con_fechaiini = ValidaNull($_con_fechaiini,'01/01/1900','date');
    }

    function set_con_fechaiter($_con_fechaiter) {
        $this->_con_fechaiter = ValidaNull($_con_fechaiter,'01/01/1900','date');
    }

    function set_con_fechatini($_con_fechatini) {
        $this->_con_fechatini = ValidaNull($_con_fechatini,'01/01/1900','date');
    }

    function set_con_fechatter($_con_fechatter) {
        $this->_con_fechatter = ValidaNull($_con_fechatter,'01/01/1900','date');
    }

    function set_gra_fechatini($_gra_fechatini) {
        $this->_gra_fechatini = ValidaNull($_gra_fechatini,'01/01/1900','date');
    }

    function set_gra_fechatter($_gra_fechatter) {
        $this->_gra_fechatter = ValidaNull($_gra_fechatter,'01/01/1900','date');
    }

    function set_mon_codigo($_mon_codigo) {
        $this->_mon_codigo = ValidaNull($_mon_codigo,0,'int');
    }

    function set_tipocambio($_tipocambio) {
        $this->_tipocambio = number_format(ValidaNull($_tipocambio,0,'float'),2);
    }

    function set_con_valormetroini($_con_valormetroini) {
        $this->_con_valormetroini = number_format(ValidaNull($_con_valormetroini,0,'float'),2);
    }

    function set_con_valormetroter($_con_valormetroter) {
        $this->_con_valormetroter = number_format(ValidaNull($_con_valormetroter,0,'float'),2);
    }

    function set_mon_conversion($_mon_conversion) {
        $this->_mon_conversion = ValidaNull($_mon_conversion,0,'int');
    }

    function set_tipocambiolocal($_tipocambiolocal) {
        $this->_tipocambiolocal = number_format(ValidaNull($_tipocambiolocal,1,'float'),2);
    }

    function set_tipocambiodolar($_tipocambiodolar) {
        $this->_tipocambiodolar = number_format(ValidaNull($_tipocambiodolar,1,'float'),2);
    }

    function set_rta_fechai($_rta_fechai) {
        $this->_rta_fechai = ValidaNull($_rta_fechai,'01/01/1900','date');
    }

    function set_rta_fechat($_rta_fechat) {
        $this->_rta_fechat = ValidaNull($_rta_fechat,'01/01/1900','date');
    }

    function set_tipocambioeuro($_tipocambioeuro) {
        $this->_tipocambioeuro = number_format(ValidaNull($_tipocambioeuro,1,'float'),2);
    }
        
    public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
    public function lst_listar($an_start,$an_limit){
        try{
            $ls_sql="begin
                        pck_gca_rpt.sp_lst_contrato(
                            :acr_cursor,
                            :ln_rowcount,
                            :an_pai_codigo,
                            :an_dpt_codigo,
                            :an_prv_codigo,
                            :an_ubg_codigo,
                            :an_imb_codigo,
                            :an_cna_codigo,
                            :an_cda_codigo,
                            :an_sta_codigo,
                            :an_con_flagrenovacionaut,
                            to_date(:ad_con_fechaperini,'dd/mm/yyyy'),
                            to_date(:ad_con_fechaperter,'dd/mm/yyyy'),
                            to_date(:ad_con_fechafirmaini,'dd/mm/yyyy'),
                            to_date(:ad_con_fechafirmater,'dd/mm/yyyy'),
                            to_date(:ad_con_fechaiini,'dd/mm/yyyy'),
                            to_date(:ad_con_fechaiter,'dd/mm/yyyy'),
                            to_date(:ad_con_fechatini,'dd/mm/yyyy'),
                            to_date(:ad_con_fechatter,'dd/mm/yyyy'),
                            to_date(:ad_gra_fechatini,'dd/mm/yyyy'),
                            to_date(:ad_gra_fechatter,'dd/mm/yyyy'),
                            :an_mon_conversion,
                            to_number(:an_tipocambiolocal,'999,999,999,999.999'),
                            to_number(:an_tipocambiodolar,'999,999,999,999.999'),
                            to_number(:an_tipocambioeuro,'999,999,999,999.999'),
                            :an_start,
                            :an_limit);  
                        end;";
            
            $ln_rowcount=0;
            
            $luo_con = new Db();
            
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
             oci_bind_by_name($stid,':an_dpt_codigo',$this->_dpt_codigo,10);
             oci_bind_by_name($stid,':an_prv_codigo',$this->_prv_codigo,10);
             oci_bind_by_name($stid,':an_ubg_codigo',$this->_ubg_codigo,10);
             oci_bind_by_name($stid,':an_imb_codigo',$this->_imb_codigo,10);
             oci_bind_by_name($stid,':an_cna_codigo',$this->_cna_codigo,10);
             oci_bind_by_name($stid,':an_cda_codigo',$this->_cda_codigo,10);             
             oci_bind_by_name($stid,':an_sta_codigo',$this->_sta_codigo,10);
             oci_bind_by_name($stid,':an_con_flagrenovacionaut',$this->_con_flagrenovacionaut,10);             
             oci_bind_by_name($stid,':ad_con_fechaperini',$this->_con_fechaperini,12);
             oci_bind_by_name($stid,':ad_con_fechaperter',$this->_con_fechaperter,12);
             oci_bind_by_name($stid,':ad_con_fechafirmaini',$this->_con_fechafirmaini,12);
             oci_bind_by_name($stid,':ad_con_fechafirmater',$this->_con_fechafirmater,12);
             oci_bind_by_name($stid,':ad_con_fechaiini',$this->_con_fechaiini,12);
             oci_bind_by_name($stid,':ad_con_fechaiter',$this->_con_fechaiter,12);
             oci_bind_by_name($stid,':ad_con_fechatini',$this->_con_fechatini,12);            
             oci_bind_by_name($stid,':ad_con_fechatter',$this->_con_fechatter,12);
             oci_bind_by_name($stid,':ad_gra_fechatini',$this->_gra_fechatini,12);
             oci_bind_by_name($stid,':ad_gra_fechatter',$this->_gra_fechatter,12);
             oci_bind_by_name($stid,':an_mon_conversion',$this->_mon_conversion,10);
             oci_bind_by_name($stid,':an_tipocambiolocal',$this->_tipocambiolocal,32);
             oci_bind_by_name($stid,':an_tipocambiodolar',$this->_tipocambiodolar,32);
             oci_bind_by_name($stid,':an_tipocambioeuro',$this->_tipocambioeuro,32);
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

public function lst_listarenta($an_start,$an_limit){
        try{
            $ls_sql="begin
                        pck_gca_rpt.sp_lst_renta(
                            :acr_cursor,
                            :ln_rowcount,
                            :an_pai_codigo,
                            :an_dpt_codigo,
                            :an_prv_codigo,
                            :an_ubg_codigo,
                            :an_imb_codigo,
                            :an_cna_codigo,
                            :an_cda_codigo,
                            :an_sta_codigo,
                            to_date(:ad_rta_fechai,'dd/mm/yyyy'),
                            to_date(:ad_rta_fechat,'dd/mm/yyyy'),
                            :an_mon_conversion,
                            to_number(:an_tipocambiolocal,'999,999,999,999.999'),
                            to_number(:an_tipocambiodolar,'999,999,999,999.999'),
                            to_number(:an_tipocambioeuro,'999,999,999,999.999'),
                            :an_start,
                            :an_limit);  
                        end;";
            
            $ln_rowcount=0;
            
            $luo_con = new Db();
            
             if (!$luo_con->createConexion()){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
         
             $stid=$luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $curs = $luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
             oci_bind_by_name($stid,':an_dpt_codigo',$this->_dpt_codigo,10);
             oci_bind_by_name($stid,':an_prv_codigo',$this->_prv_codigo,10);
             oci_bind_by_name($stid,':an_ubg_codigo',$this->_ubg_codigo,10);
             oci_bind_by_name($stid,':an_imb_codigo',$this->_imb_codigo,10);
             oci_bind_by_name($stid,':an_cna_codigo',$this->_cna_codigo,10);
             oci_bind_by_name($stid,':an_cda_codigo',$this->_cda_codigo,10);             
             oci_bind_by_name($stid,':an_sta_codigo',$this->_sta_codigo,10);
             oci_bind_by_name($stid,':ad_rta_fechai',$this->_rta_fechai,12);
             oci_bind_by_name($stid,':ad_rta_fechat',$this->_rta_fechat,12);
             oci_bind_by_name($stid,':an_mon_conversion',$this->_mon_conversion,10);
             oci_bind_by_name($stid,':an_tipocambiolocal',$this->_tipocambiolocal,32);
             oci_bind_by_name($stid,':an_tipocambiodolar',$this->_tipocambiodolar,32);
             oci_bind_by_name($stid,':an_tipocambioeuro',$this->_tipocambioeuro,32);
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
