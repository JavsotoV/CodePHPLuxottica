<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgcaMacro
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");


class clsgcaMacro {
    
    private $_pai_codigo;
    private $_sta_codigo;
    private $_mon_conversion;
    private $_tipocambiolocal;
    private $_tipocambiodolar;
    private $_tipocambioeuro;
    public $luo_con;
    
    
    function __construct() {
        $this->_pai_codigo = 0;
        $this->_sta_codigo = 0;
        $this->_mon_conversion = 0;
        $this->_tipocambiolocal = 1;
        $this->_tipocambiodolar = 1;
        $this->_tipocambioeuro = 1;
    }

    function set_pai_codigo($_pai_codigo) {
        $this->_pai_codigo = ValidaNull($_pai_codigo,0,'int');
    }

    function set_sta_codigo($_sta_codigo) {
        $this->_sta_codigo = ValidaNull($_sta_codigo,0,'int');
    }

    function set_mon_conversion($_mon_conversion) {
        $this->_mon_conversion = ValidaNull($_mon_conversion,0,'int');
    }

    function set_tipocambiolocal($_tipocambiolocal) {
        $this->_tipocambiolocal = ValidaNull($_tipocambiolocal,1,'float');
    }

    function set_tipocambiodolar($_tipocambiodolar) {
        $this->_tipocambiodolar = ValidaNull($_tipocambiodolar,1,'float');
    }

    function set_tipocambioeuro($_tipocambioeuro) {
        $this->_tipocambioeuro = ValidaNull($_tipocambioeuro,1,'float');
    }

    
 public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }
    
 private function lst_sql($an_tipo){
     
     switch ($an_tipo){
         //----contrato -------
         case 1:
                $ls_sql="begin
                            pck_gca_macro.sp_lst_contrato (:acr_cursor,
                                :ln_rowcount,
                                :an_pai_codigo,
                                :an_sta_codigo,
                                :an_mon_conversion,
                                :an_tipocambiolocal,
                                :an_tipocambiodolar,
                                :an_tipocambioeuro,
                                :an_start,
                                :an_limit);
                        end;";
             
             break;
        
        //----binary-------- 
         case 2:
             $ls_sql="begin
                            pck_gca_macro.sp_lst_binary (:acr_cursor,
                                :ln_rowcount,
                                :an_pai_codigo,
                                :an_sta_codigo,
                                :an_start,
                                :an_limit) ;
                        end;";
             break;
        
        //----renta ----------         
         case 3:
             $ls_sql="begin
                            pck_gca_macro.sp_lst_renta(:acr_cursor,
                                :ln_rowcount,
                                :an_pai_codigo,
                                :an_sta_codigo,
                                :an_mon_conversion,
                                :an_tipocambiolocal,
                                :an_tipocambiodolar,
                                :an_tipocambioeuro,
                                :an_start,
                                :an_limit);  
                        end;";
             break;
             
        
     }
     
     return $ls_sql;
 }   
 
    public function lst_conexion(){
        
        $this->luo_con= new Db();
        
        if (!$this->luo_con->createConexion()){return false;}         
        
        return true;
    }
    
    public function lst_desconexion(){
        
        $this->luo_con->closeConexion();
        
        unset($this->luo_con);
    }
    
    public function lst_recordSet($an_tipo,$an_start,$an_limit){
           try{
            
             $ls_sql=$this->lst_sql($an_tipo);
               
             $ln_rowcount=0;
               
             $stid=$this->luo_con->ociparse($ls_sql);             
             if(!$stid){return clsViewData::showError($this->luo_con->getICodeError(), $this->luo_con->getSMsgError());}
             
             $curs =$this->luo_con->ocinewcursor();             
             if(!$curs){return clsViewData::showError($this->luo_con->getICodeError(), $this->luo_con->getSMsgError());}
             
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($this->luo_con->refConexion));
             oci_bind_by_name($stid,':ln_rowcount',$ln_rowcount,10);
             oci_bind_by_name($stid,':an_pai_codigo',$this->_pai_codigo,10);
             oci_bind_by_name($stid,':an_sta_codigo',$this->_sta_codigo,10);
             
             if ($an_tipo!=2){
                oci_bind_by_name($stid,':an_mon_conversion',$this->_mon_conversion,10);
                oci_bind_by_name($stid,':an_tipocambiolocal',$this->_tipocambiolocal,10);
                oci_bind_by_name($stid,':an_tipocambiodolar',$this->_tipocambiodolar,10);
                oci_bind_by_name($stid,':an_tipocambioeuro',$this->_tipocambioeuro,10);             
             }
             
             oci_bind_by_name($stid,':an_start',$an_start,10);
             oci_bind_by_name($stid,':an_limit',$an_limit,10);             
             
             if(!$this->luo_con->ociExecute($stid)){return clsViewData::showError($this->luo_con->getICodeError(), $this->luo_con->getSMsgError());}
             
             $rowdata= clsViewData::viewData(parsearcursor($curs),false,$ln_rowcount);
             
             oci_free_statement($stid);
             
             unset($stid);
             
             return $rowdata;
           }
           catch(Exception $ex){
             return clsViewData::showError($ex->getCode(), $ex->getMessage());   
           }
    }     
}

