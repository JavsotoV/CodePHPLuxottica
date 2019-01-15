<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsEnviarEmail
 *
 * @author JAVSOTO
 */
require_once("../utiles/fnUtiles.php");

class clsEnviarEmail {
    //put your code here
    private $_rowdata;
    
    function __construct($rowdata) {
        $this->_rowdata= json_decode($rowdata,true) ;
    }
    
    public function Newticket(){
        
        $lb_retorno=true;
        
        if($this->_rowdata){
            
            if ($this->_rowdata['data']['0']['enviar_email']=='S'){
        
                if ($this->_rowdata['data']['0']['tck_estado']=='1'){
                    
                       $ls_mensaje= fn_emailmessage($this->_rowdata['data']['0']['tck_detalle'],$this->_rowdata['data']['0']['est_descripcion']);                    
                    }
                    else
                    {
                        $ls_mensaje= fn_emailmessage($this->_rowdata['data']['0']['tck_detalle'],$this->_rowdata['data']['0']['est_descripcion'],$this->_rowdata['data']['0']['sga_observacion']);
                    }
                
                if ($this->_rowdata['data']['0']['flag_emisor']=='T'){
                    
                    $lstr_correo=explode(",", $this->_rowdata['data']['0']['rpe_email']);
                    
                    if (count($lstr_correo)==0) {$lstr_correo=array($this->_rowdata['data']['0']['rpe_email']);}
                    
                    $ls_from = $this->_rowdata['data']['0']['ema_denominacion'];
        
                    $ls_fromname = $this->_rowdata['data']['0']['per_nombrecompleto'];
        
                }else
                {
                    $lstr_correo=explode(",", $this->_rowdata['data']['0']['ema_denominacion']);
                    
                    if (count($lstr_correo)==0) {$lstr_correo=array($this->_rowdata['data']['0']['ema_denominacion']);}
                    
                    $ls_from = $this->_rowdata['data']['0']['rpe_email'];
        
                    $ls_fromname = $this->_rowdata['data']['0']['rpe_nombrecompleto'];
                }
                
                if ($this->_rowdata['data']['0']['sga_codigo']=='1') {$ls_titulo='Nuevo Ticket de consulta Nro.';}
                
                if ($this->_rowdata['data']['0']['sga_codigo']!='1') {$ls_titulo='Ticket de consulta Nro.';}
                
                if ($this->_rowdata['data']['0']['flag_reasignado']=='S') {$ls_titulo='Ticket Reaignado Nro.';}
                 
                $ls_titulo .= $this->_rowdata['data']['0']['tck_numero'].' - '.$this->_rowdata['data']['0']['tck_titulo'];
                
                $lb_retorno=fn_enviaremail($lstr_correo, $ls_titulo, $ls_mensaje, $ls_from, $ls_fromname);
                
                }                              
        }
        
        return $lb_retorno; 
    }
}
