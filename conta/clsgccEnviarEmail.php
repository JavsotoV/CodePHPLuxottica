<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgccEnviarEmail
 *
 * @author JAVSOTO
 */

header( 'Content-type: text/html; charset=utf-8;' );

require_once("../utiles/fnUtiles.php");


class clsgccEnviarEmail {
    //put your code here
    
    private $_rowdata;
    
    function __construct($rowdata) {
        $this->_rowdata= json_decode($rowdata,true) ;
    }
    
    public function RendicionNotificacion(){
        
        $lb_retorno=true;
        
        $ln_fila=0;
        
        $ls_entidad='';
        
        if ($this->_rowdata){
            
            foreach ($this->_rowdata['data'] as $row) {
                
                $ls_from = $row['ema_emisor'];
                
                $ls_fromname=$row['ema_emisornombre'];
                
                $ls_titulo = 'Rendicion Nro: '.$row['ren_nrorendicion'];
                
                $lstr_correo=explode(",",$row['ema_destinatario']);
                    
                if (count($lstr_correo)==0) {$lstr_correo=array($row['ema_destinatario']);}
                    
                $message .="<html>\n\r";
                $message .= "<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'/></head>\n\r";
                $message .= "<style>\n\r";
                $message .= "TD {font-family : Arial, Helvetica, sans-serif;font-size : 8pt;} \n\r";
                $message .= "INPUT, SELECT, OPTION {font-family : Arial, Helvetica, sans-serif;font-size : 7pt;} \n\r";
                $message .= "BODY, TH {font-family : Arial, Helvetica, sans-serif;font-size : 8pt;} \n\r";
                $message .= ".dest {font-size : 8pt;font-weight : bold;} \n\r";
                $message .= "</style>\n\r";
                $message .= "<BR>\n\r";
                $message .= "<p>RENDICION DE CAJA</p>\n\r";
                $message .= "<BR>\n\r";                    
                $message .= "<table style='border: 1px solid gray;' border='1'>\n\r";
                $message .= "<tbody><tr>\n\r";
                $message .= "<td style='background: #d9d9d9 none repeat; border: 1px solid gray;' colspan='3'><strong>CONTRATO MODIFICADO</strong></td></tr>\n\r";
                $message .= "<tr><td style='dest'>Caja Nro.</td><td style='dest' colspan='2'><strong>".$row['ent_numero']."</strong></td></tr>\n\r";
                $message .= "<tr><td style='dest'>Rendicion Nro.</td><td style='dest' colspan='2'><strong>".$row['ren_nrorendicion']."</strong></td></tr>\n\r";
                $message .= "<tr><td style='dest'>Motivo</td><td style='dest' colspan='2'><strong>".$row['est_descripcion']."</strong></td></tr>\n\r";
                $message .= "<tr><td style='dest'>Observacion</td><td style='dest' colspan='2'><strong>".$row['inc_observacion']."</strong></td></tr>\n\r";
                $message .= "<tr><td style='dest'>Fecha</td><td style='dest' colspan='2'><strong>".$row['inc_fecha']."</strong></td></tr>\n\r";
                $message .="</tbody>\n\r";
                $message .="</table>\n\r";
                $message .="</html>";
                
                if (count($lstr_correo)>0){
                    
                    $lb_retorno=fn_enviaremail($lstr_correo, $ls_titulo, $message, $ls_from, $ls_fromname);                
                }
             }
        }   

        return $lb_retorno;
    }
}
