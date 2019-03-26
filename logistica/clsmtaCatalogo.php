<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsmtaCatalogo
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsmtaCatalogo {
    private $_cta_codigo;
    private $_pai_codigo;
    private $_cdg;
    private $_codigobarras;
    private $_codsap;
    private $_descripcion;
    private $_descatalogado;
    private $_tipfamcod;
    private $_gfa_codigo;
    private $_alias;
    private $_ivacb;
    private $_priprov;
    private $_nomcom;
    private $_inventariar;
    private $_stock_minimo;
    private $_liquidacion;
    private $_etiquetar;
    private $_col_codigo;
    private $_cri_diametroini;
    private $_cri_diametrofin;
    private $_cri_cilindroini;
    private $_cri_cilindrofin;
    private $_cri_esferaini;
    private $_cri_esferafin;
    private $_col_codigoc;
    private $_col_codigom;
    private $_mta_codigo;
    private $_gfa_graduable;
    private $_gfa_cristal;
    private $_gfa_sexo;
    private $_gfa_diagonal;
    private $_gfa_horizontal;
    private $_gfa_altura;
    private $_gfa_curvabase;
    private $_gfa_puente;
    private $_gfa_largovarilla;
    private $_gfa_polarized;
    private $_len_marca;
    private $_len_zonaop;
    private $_len_eje;
    private $_len_radi;
    private $_len_diametro;
    private $_len_esfera;
    private $_len_cilindro;
    private $_len_curvabase;
    private $_len_esferah;
    private $_mon_altura;
    private $_mon_calibre;
    private $_mon_puente;
    private $_mon_diagonal;
    private $_mon_horizontal;
    private $_mon_curvabase;
    private $_mon_largovarilla;
    private $_cta_usuario;

function __construct($an_usuario) {
    $this->_cta_codigo=0;
    $this->_pai_codigo;
    $this->_cdg;
    $this->_codigobarras;
    $this->_codsap;
    $this->_descripcion;
    $this->_descatalogado;
    $this->_tipfamcod;
    $this->_gfa_codigo=0;
    $this->_alias;
    $this->_ivacb;
    $this->_priprov;
    $this->_nomcom;
    $this->_inventariar;
    $this->_stock_minimo;
    $this->_liquidacion;
    $this->_etiquetar;
    $this->_col_codigo=0;
    $this->_cri_diametroini=0;
    $this->_cri_diametrofin=0;
    $this->_cri_cilindroini=0;
    $this->_cri_cilindrofin=0;
    $this->_cri_esferaini=0;
    $this->_cri_esferafin=0;
    $this->_col_codigoc=0;
    $this->_col_codigom=0;
    $this->_mta_codigo=0;
    $this->_gfa_graduable='';
    $this->_gfa_cristal='';
    $this->_gfa_sexo='';
    $this->_gfa_diagonal=0;
    $this->_gfa_horizontal=0;
    $this->_gfa_altura=0;
    $this->_gfa_curvabase=0;
    $this->_gfa_puente=0;
    $this->_gfa_largovarilla=0;
    $this->_gfa_polarized='N';
    $this->_len_marca='';
    $this->_len_zonaop=0;
    $this->_len_eje=0;
    $this->_len_radi=0;
    $this->_len_diametro=0;
    $this->_len_esfera=0;
    $this->_len_cilindro=0;
    $this->_len_curvabase=0;
    $this->_len_esferah=0;
    $this->_mon_altura=0;
    $this->_mon_calibre=0;
    $this->_mon_puente=0;
    $this->_mon_diagonal=0;
    $this->_mon_horizontal=0;
    $this->_mon_curvabase=0;
    $this->_mon_largovarilla=0;
    $this->_cta_usuario=$an_usuario;
}
    
function set_cta_codigo($_cta_codigo) {
    $this->_cta_codigo = $_cta_codigo;
}

function set_pai_codigo($_pai_codigo) {
    $this->_pai_codigo = $_pai_codigo;
}

function set_cdg($_cdg) {
    $this->_cdg = $_cdg;
}

function set_codigobarras($_codigobarras) {
    $this->_codigobarras = $_codigobarras;
}

function set_codsap($_codsap) {
    $this->_codsap = $_codsap;
}

function set_descripcion($_descripcion) {
    $this->_descripcion = mb_strtoupper($_descripcion,'utf-8');
}

function set_descatalogado($_descatalogado) {
    $this->_descatalogado = $_descatalogado;
}

function set_tipfamcod($_tipfamcod) {
    $this->_tipfamcod = $_tipfamcod;
}

function set_gfa_codigo($_gfa_codigo) {
    $this->_gfa_codigo = validaNull($_gfa_codigo,0,'int');
}

function set_gfa_polarized($_gfa_polarized) {
    $this->_gfa_polarized = $_gfa_polarized;
}

function set_alias($_alias) {
    $this->_alias = mb_strtoupper($_alias,'utf-8');
}

function set_ivacb($_ivacb) {    
    $this->_ivacb = number_format(validaNull($_ivacb,0,'float'),2);
}

function set_priprov($_priprov) {
    $this->_priprov = number_format(validaNull($_priprov,0,'float'),2);
}

function set_nomcom($_nomcom) {
    $this->_nomcom = mb_strtoupper($_nomcom,'utf-8');
}

function set_inventariar($_inventariar) {
    $this->_inventariar = $_inventariar;
}

function set_stock_minimo($_stock_minimo) {
    $this->_stock_minimo = number_format(validaNull($_stock_minimo,0,'float'),2);
}

function set_liquidacion($_liquidacion) {
    $this->_liquidacion = $_liquidacion;
}

function set_etiquetar($_etiquetar) {
    $this->_etiquetar = $_etiquetar;
}

function set_col_codigo($_col_codigo) {
    $this->_col_codigo = validaNull($_col_codigo,0,'int');
}

function set_cri_diametroini($_cri_diametroini) {
    $this->_cri_diametroini = number_format(validaNull($_cri_diametroini,0,'float'),2);
}

function set_cri_diametrofin($_cri_diametrofin) {
    $this->_cri_diametrofin = number_format(validaNull($_cri_diametrofin,0,'float'),2);
}

function set_cri_cilindroini($_cri_cilindroini) {
    $this->_cri_cilindroini = number_format(validaNull($_cri_cilindroini,0,'float'),2);
}

function set_cri_cilindrofin($_cri_cilindrofin) {
    $this->_cri_cilindrofin = number_format(validaNull($_cri_cilindrofin,0,'float'),2);
}

function set_cri_esferaini($_cri_esferaini) {
    $this->_cri_esferaini = number_format(validaNull($_cri_esferaini,0,'float'),2);
}

function set_cri_esferafin($_cri_esferafin) {
    $this->_cri_esferafin = number_format(validaNull($_cri_esferafin,0,'float'),2);
}

function set_col_codigoc($_col_codigoc) {
    $this->_col_codigoc = validaNull($_col_codigoc,0,'int');
}

function set_col_codigom($_col_codigom) {
    $this->_col_codigom = validaNull($_col_codigom,0,'int');
}

function set_mta_codigo($_mta_codigo) {
    $this->_mta_codigo = validaNull($_mta_codigo,0,'int');
}

function set_gfa_graduable($_gfa_graduable) {
    $this->_gfa_graduable = $_gfa_graduable;
}

function set_gfa_cristal($_gfa_cristal) {
    $this->_gfa_cristal = $_gfa_cristal;
}

function set_gfa_sexo($_gfa_sexo) {
    $this->_gfa_sexo = $_gfa_sexo;
}

function set_gfa_diagonal($_gfa_diagonal) {
    $this->_gfa_diagonal = number_format(validaNull($_gfa_diagonal,0,'float'),2);
}

function set_gfa_horizontal($_gfa_horizontal) {
    $this->_gfa_horizontal = number_format(validaNull($_gfa_horizontal,0,'float'),2);
}

function set_gfa_altura($_gfa_altura) {
    $this->_gfa_altura = number_format(validaNull($_gfa_altura,0,'float'),2);
}

function set_gfa_curvabase($_gfa_curvabase) {
    $this->_gfa_curvabase = number_format(validaNull($_gfa_curvabase,0,'float'),2);
}

function set_gfa_puente($_gfa_puente) {
    $this->_gfa_puente = number_format(validaNull($_gfa_puente,0,'float'),2);
}

function set_gfa_largovarilla($_gfa_largovarilla) {
    $this->_gfa_largovarilla = number_format(validaNull($_gfa_largovarilla,0,'float'),2);
}

function set_len_marca($_len_marca) {
    $this->_len_marca = mb_strtoupper($_len_marca,'utf-8');
}

function set_len_zonaop($_len_zonaop) {
    $this->_len_zonaop = number_format(validaNull($_len_zonaop,0,'float'),2);
}

function set_len_eje($_len_eje) {
    $this->_len_eje = number_format(validaNull($_len_eje,0,'float'),2);
}

function set_len_radi($_len_radi) {
    $this->_len_radi = number_format(validaNull($_len_radi,0,'float'),2);
}

function set_len_diametro($_len_diametro) {
    $this->_len_diametro = number_format(validaNull($_len_diametro,0,'float'),2);
}

function set_len_esfera($_len_esfera) {
    $this->_len_esfera = number_format(validaNull($_len_esfera,0,'float'),2);
}

function set_len_cilindro($_len_cilindro) {
    $this->_len_cilindro = number_format(validaNull($_len_cilindro,0,'float'),2);
}

function set_len_curvabase($_len_curvabase) {
    $this->_len_curvabase = number_format(validaNull($_len_curvabase,0,'float'),2);
}

function set_len_esferah($_len_esferah) {
    $this->_len_esferah = number_format(validaNull($_len_esferah,0,'float'),2);
}

function set_mon_altura($_mon_altura) {
    $this->_mon_altura = number_format(validaNull($_mon_altura,0,'float'),2);
}

function set_mon_calibre($_mon_calibre) {
    $this->_mon_calibre = number_format(validaNull($_mon_calibre,0,'float'),2);
}

function set_mon_puente($_mon_puente) {
    $this->_mon_puente = number_format(validaNull($_mon_puente,0,'float'),2);
}

function set_mon_diagonal($_mon_diagonal) {
    $this->_mon_diagonal = number_format(validaNull($_mon_diagonal,0,'float'),2);
}

function set_mon_horizontal($_mon_horizontal) {
    $this->_mon_horizontal = number_format(validaNull($_mon_horizontal,0,'float'),2);
}

function set_mon_curvabase($_mon_curvabase) {
    $this->_mon_curvabase = number_format(validaNull($_mon_curvabase,0,'float'),2);
}

function set_mon_largovarilla($_mon_largovarilla) {
    $this->_mon_largovarilla = number_format(validaNull($_mon_largovarilla,0,'float'),2);
}

public function loadData ( $lstParametros ){
     foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }

public function sp_mta_catalogo($an_accion){
    try{
        
        $ls_sql="begin
                    pck_mta_catalogo.sp_mta_catalogo(:an_accion,
                :acr_retorno,
                :acr_cursor,
                :an_cta_codigo,
                :an_pai_codigo,
                :as_cdg,
                :as_codigobarras,
                :as_codsap,
                :as_descripcion,
                :as_descatalogado,
                :as_tipfamcod,
                :an_gfa_codigo,
                :as_alias,
                to_number(:an_ivacb,'999,999,999.999'),
                to_number(:an_priprov,'999,999,999.999'),
                :as_nomcom,
                :as_inventariar,
                to_number(:an_stock_minimo,'999,999,999.999'),
                :as_liquidacion,
                :as_etiquetar,
                :an_col_codigo,
                to_number(:an_cri_diametroini,'999,999,999.999'),
                to_number(:an_cri_diametrofin,'999,999,999.999'),
                to_number(:an_cri_cilindroini,'999,999,999.999'),
                to_number(:an_cri_cilindrofin,'999,999,999.999'),
                to_number(:an_cri_esferaini,'999,999,999.999'),
                to_number(:an_cri_esferafin,'999,999,999.999'),
                :an_col_codigoc,
                :an_col_codigom,
                :an_mta_codigo,
                :as_gfa_graduable,
                :as_gfa_cristal,
                :as_gfa_sexo,
                to_number(:an_gfa_diagonal,'999,999,999.999'),
                to_number(:an_gfa_horizontal,'999,999,999.999'),
                to_number(:an_gfa_altura,'999,999,999.999'),
                to_number(:an_gfa_curvabase,'999,999,999.999'),
                to_number(:an_gfa_puente,'999,999,999.999'),
                to_number(:an_gfa_largovarilla,'999,999,999.999'),
                :as_gfa_polarized,
                :as_len_marca,
                to_number(:an_len_zonaop,'999,999,999.999'),
                to_number(:an_len_eje,'999,999,999.999'),
                to_number(:an_len_radi,'999,999,999.999'),
                to_number(:an_len_diametro,'999,999,999.999'),
                to_number(:an_len_esfera,'999,999,999.999'),     
                to_number(:an_len_cilindro,'999,999,999.999'),
                to_number(:an_len_curvabase,'999,999,999.999'),
                to_number(:an_len_esferah,'999,999,999.999'),
                to_number(:an_mon_altura,'999,999,999.999'),
                to_number(:an_mon_calibre,'999,999,999.999'),
                to_number(:an_mon_puente,'999,999,999.999'),
                to_number(:an_mon_diagonal,'999,999,999.999'),
                to_number(:an_mon_horizontal,'999,999,999.999'),
                to_number(:an_mon_curvabase,'999,999,999.999'),
                to_number(:an_mon_largovarilla,'999,999,999.999'),
                :an_cta_usuario);
             end;";
        
           $luo_con= new  Db();
            
           $luo_set = new clsReference();
            
           if(!$luo_set->setcrsMant($luo_con, $ls_sql, $stid, $crto, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
           };
            
           oci_bind_by_name($stid,':an_accion',$an_accion,10) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':acr_retorno',$crto,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR) or die(oci_error($luo_con->refConexion));
           oci_bind_by_name($stid,':an_cta_codigo',$this->_cta_codigo,10);
           oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
           oci_bind_by_name($stid,':as_cdg',$this->_cdg,20);
           oci_bind_by_name($stid,':as_codigobarras',$this->_codigobarras,20);
           oci_bind_by_name($stid,':as_codsap',$this->_codsap,20);
           oci_bind_by_name($stid,':as_descripcion',$this->_descripcion,120);
           oci_bind_by_name($stid,':as_descatalogado',$this->_descatalogado,10);
           oci_bind_by_name($stid,':as_tipfamcod',$this->_tipfamcod,10);
           oci_bind_by_name($stid,':an_gfa_codigo',$this->_gfa_codigo,10);
           oci_bind_by_name($stid,':as_alias',$this->_alias,20);
           oci_bind_by_name($stid,':an_ivacb',$this->_ivacb,15);
           oci_bind_by_name($stid,':an_priprov',$this->_priprov,15);
           oci_bind_by_name($stid,':as_nomcom',$this->_nomcom,120);
           oci_bind_by_name($stid,':as_inventariar',$this->_inventariar,10);
           oci_bind_by_name($stid,':an_stock_minimo',$this->_stock_minimo,15);
           oci_bind_by_name($stid,':as_liquidacion',$this->_liquidacion,10);
           oci_bind_by_name($stid,':as_etiquetar',$this->_etiquetar,10);
           oci_bind_by_name($stid,':an_col_codigo',$this->_col_codigo,10);
           oci_bind_by_name($stid,':an_cri_diametroini',$this->_cri_diametroini,15);
           oci_bind_by_name($stid,':an_cri_diametrofin',$this->_cri_diametrofin,15);
           oci_bind_by_name($stid,':an_cri_cilindroini',$this->_cri_cilindroini,15);
           oci_bind_by_name($stid,':an_cri_cilindrofin',$this->_cri_cilindrofin,15);
           oci_bind_by_name($stid,':an_cri_esferaini',$this->_cri_esferaini,15);
           oci_bind_by_name($stid,':an_cri_esferafin',$this->_cri_esferafin,15);
           oci_bind_by_name($stid,':an_col_codigoc',$this->_col_codigoc,10);
           oci_bind_by_name($stid,':an_col_codigom',$this->_col_codigom,10);
           oci_bind_by_name($stid,':an_mta_codigo',$this->_mta_codigo,10);
           oci_bind_by_name($stid,':as_gfa_graduable',$this->_gfa_graduable,10);
           oci_bind_by_name($stid,':as_gfa_cristal',$this->_gfa_cristal,10);
           oci_bind_by_name($stid,':as_gfa_sexo',$this->_gfa_sexo,10);
           oci_bind_by_name($stid,':an_gfa_diagonal',$this->_gfa_diagonal,15);
           oci_bind_by_name($stid,':an_gfa_horizontal',$this->_gfa_horizontal,15);
           oci_bind_by_name($stid,':an_gfa_altura',$this->_gfa_altura,15);
           oci_bind_by_name($stid,':an_gfa_curvabase',$this->_gfa_curvabase,15);
           oci_bind_by_name($stid,':an_gfa_puente',$this->_gfa_puente,15);
           oci_bind_by_name($stid,':an_gfa_largovarilla',$this->_gfa_largovarilla,15);
           oci_bind_by_name($stid,':as_gfa_polarized',$this->_gfa_polarized,10);
           oci_bind_by_name($stid,':as_len_marca',$this->_len_marca,60);
           oci_bind_by_name($stid,':an_len_zonaop',$this->_len_zonaop,15);
           oci_bind_by_name($stid,':an_len_eje',$this->_len_eje,15);
           oci_bind_by_name($stid,':an_len_radi',$this->_len_radi,15);
           oci_bind_by_name($stid,':an_len_diametro',$this->_len_diametro,15);
           oci_bind_by_name($stid,':an_len_esfera',$this->_len_esfera,15);
           oci_bind_by_name($stid,':an_len_cilindro',$this->_len_cilindro,15);
           oci_bind_by_name($stid,':an_len_curvabase',$this->_len_curvabase,15);
           oci_bind_by_name($stid,':an_len_esferah',$this->_len_esferah,15);
           oci_bind_by_name($stid,':an_mon_altura',$this->_mon_altura,15);
           oci_bind_by_name($stid,':an_mon_calibre',$this->_mon_calibre,15);
           oci_bind_by_name($stid,':an_mon_puente',$this->_mon_puente,15);
           oci_bind_by_name($stid,':an_mon_diagonal',$this->_mon_diagonal,15);
           oci_bind_by_name($stid,':an_mon_horizontal',$this->_mon_horizontal,15);
           oci_bind_by_name($stid,':an_mon_curvabase',$this->_mon_curvabase,15);
           oci_bind_by_name($stid,':an_mon_largovarilla',$this->_mon_largovarilla,15);
           oci_bind_by_name($stid,':an_cta_usuario',$this->_cta_usuario,10);
           
            if(!$luo_set->ReadcrsMant($luo_con, $stid, $crto)){
                return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());
            }
            
            $luo_con->commitTransaction();
            
            $lstData = ( $an_accion != 3 ? parsearcursor($curs) : [] );
                
            $rowdata = clsViewData::viewData($lstData, false, 1,$luo_con->getMsgRetorno());
                 
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


    public function lst_listar($an_pai_codigo,$as_tipfamcod,$an_fam_codigo,$an_sfa_codigo,$an_gfa_codigo,$as_criterio,$an_esf_codigo,$an_cil_codigo,$as_descatalogado,$an_start,$an_limit){
        
        try{
             $ln_rowcount=0;
             
            $ls_sql="begin
                        pck_mta_catalogo.sp_lst_listar (:acr_cursor,
                            :ln_rowcount,
                            :an_pai_codigo,
                            :as_tipfamcod,
                            :an_fam_codigo,
                            :an_sfa_codigo,
                            :an_gfa_codigo,
                            :as_criterio,
                            :an_esf_codigo,
                            :an_cil_codigo,
                            :as_descatalogado,
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
             oci_bind_by_name($stid,':as_tipfamcod',$as_tipfamcod,10);
             oci_bind_by_name($stid,':an_fam_codigo',$an_fam_codigo,10);
             oci_bind_by_name($stid,':an_sfa_codigo',$an_sfa_codigo,10);
             oci_bind_by_name($stid,':an_gfa_codigo',$an_gfa_codigo,10);
             oci_bind_by_name($stid,':as_criterio',$as_criterio,120);
             oci_bind_by_name($stid,':an_esf_codigo',$an_esf_codigo,10);
             oci_bind_by_name($stid,':an_cil_codigo',$an_cil_codigo,10);
             oci_bind_by_name($stid,':as_descatalogado',$as_descatalogado,10);
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
    
    public function lst_catalogoatributo($an_cta_codigo){
        try{
            $ls_sql="begin
                        pck_mta_catalogo.sp_lst_catalogoatributo (:acr_cursor,
                        :an_cta_codigo) ;
                     end;";
          
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_cta_codigo',$an_cta_codigo,10);
            
              if(!$luo_con->ociExecute($stid)){return clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false);
             
             oci_free_statement($stid);
             
             $luo_con->closeConexion();
             
             unset($luo_con);
             
             return $rowdata;
        }
        catch(Exception $ex ){
            return clsViewData::showError($ex->getCode(), $ex->getMessage());
        }
    }
    
    public function lst_catalogoxid($an_cta_codigo){
        try{
            
            $ls_sql="begin
                        pck_mta_catalogo.sp_lst_catalogoxid (:acr_cursor,
                        :an_cta_codigo);
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_cta_codigo',$an_cta_codigo,10);
            
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
    
    public function lst_devolucion($an_pai_codigo,$as_criterio,$an_start,$an_limit){
        
        try{
             $ln_rowcount=0;
             
            $ls_sql="begin
                        pck_mta_catalogo.sp_lst_devolucion(:acr_cursor,
                            :ln_rowcount,
                            :an_pai_codigo,
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
