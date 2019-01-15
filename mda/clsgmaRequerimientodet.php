<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgmaRequerimientodet
 *
 * @author JAVSOTO
 */

require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");
require_once("../Base/clsReference.php");

class clsgmaRequerimientodet {
    //put your code here
    private $_rqd_usuario;
    
    public function __construct($an_usuario) {
        
        $this->_rqd_usuario=$an_usuario;
    }
    
    
    public function lst_listar($an_rqe_codigo){
        try{
            $ls_sql="begin
                        mda.pck_gma_requerimientodet.sp_lst_listar(:acr_cursor,
                        :an_rqe_codigo);
                    end;";
            
            $luo_con = new Db();
            
            $luo_set = new clsReference();
            
            if(!$luo_set->setcrsLst($luo_con, $ls_sql, $stid, $curs)){
                return clsViewData::showError($luo_con->getICodeError(),$luo_con->getSMsgError());
            }
            
             oci_bind_by_name($stid,':acr_cursor',$curs,-1,OCI_B_CURSOR)or die(oci_error($luo_con->refConexion));
             oci_bind_by_name($stid,':an_rqe_codigo',$an_rqe_codigo,10);
            
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
}
