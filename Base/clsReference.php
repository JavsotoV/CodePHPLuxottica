<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsReference
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");

class clsReference {
    //put your code here
    
    public function setcrsMant(&$atr_conexion,$as_sql, &$acr_stid, &$acr_retorno,&$acr_cursor){
        
        if($atr_conexion->createConexion()==false){return false;}
            
        $acr_stid=$atr_conexion->ociparse($as_sql);            
        if(!$acr_stid){return false;}
            
        $acr_retorno = $atr_conexion->ocinewcursor();            
        if(!$acr_retorno){return false;}
        
        $acr_cursor = $atr_conexion->ocinewcursor();            
        if(!$acr_cursor){return false;}
        
        return true;
    }
    
    public function setcrsLst(&$atr_conexion,$as_sql, &$acr_stid, &$acr_cursor){
        
        if($atr_conexion->createConexion()==false){return false;}
            
        $acr_stid=$atr_conexion->ociparse($as_sql);            
        if(!$acr_stid){return false;}
            
        $acr_cursor = $atr_conexion->ocinewcursor();            
        if(!$acr_cursor){return false;}
        
        return true;
    }
    
    public function ReadcrsMant(&$atr_conexion,&$acr_stid, &$acr_retorno){
        
          if(!$atr_conexion->ociExecute($acr_stid)){return false;}
                    
          if(!$atr_conexion->ociExecute($acr_retorno)){return false;}
            
          if (!$atr_conexion->ocifetchRetorno($acr_retorno)){return false;}
          
          return true;
    }
}
