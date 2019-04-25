<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgcaEnviarEmail
 *
 * @author JAVSOTO
 */
header( 'Content-type: text/html; charset=utf-8;' );

require_once("../utiles/fnUtiles.php");

class clsgcaEnviarEmail {
    //put your code here
    private $rowdata;
    
    function __construct($rowdata) {
        $this->_rowdata= json_decode($rowdata,true) ;
    }
    
    public function EditContrato(){
        
        $lb_retorno=true;
        
        $ln_fila=0;
        
        $ls_entidad='';
        
        if ($this->_rowdata){
            
            foreach ($this->_rowdata['data'] as $row) {
                
                $ls_from = $row['ema_denominacion'];
                
                $ls_fromname=$row['per_nombre'];
                
                $ls_titulo = 'Contrato: '.$row['pai_denominacion'].' - '.$row['con_nroregistro'];
                
                if ($ln_fila==0){
                    
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
                    $message .= "<p>Se notifica la modificacion del siguiente contrato.</p>\n\r";
                    $message .= "<BR>\n\r";                    
                    $message .= "<table style='border: 1px solid gray;' border='1'>\n\r";
                    $message .= "<tbody><tr>\n\r";
                    $message .= "<td style='background: #d9d9d9 none repeat; border: 1px solid gray;' colspan='3'><strong>CONTRATO MODIFICADO</strong></td></tr>\n\r";
                    $message .= "<tr><td style='dest'>Region</td><td style='dest' colspan='2'><strong>".$row['pai_denominacion']."</strong></td></tr>\n\r";
                    $message .= "<tr><td style='dest'>Nro. Registro</td><td style='dest' colspan='2'><strong>".$row['con_nroregistro']."</strong></td></tr>\n\r";
                    $message .= "<tr><td style='dest'>CECCO</td><td style='dest' colspan='2'><strong>".$row['ctr_codinterno']."</strong></td></tr>\n\r";
                    $message .= "<tr><td style='dest'>Fecha</td><td style='dest' colspan='2'><strong>".$row['log_fecha']."</strong></td></tr>\n\r";
                }
                
                if ($ls_entidad!=$row['log_entidad']){
                    
                    $ls_entidad=$row['log_entidad'];
                    
                    $message .= "<tr><td align='center' colspan='3' style='dest'><strong>".$row['log_entidad']."</strong></td></tr>\n\r";
                    $message .= "<tr><td style='dest'><strong>Atributo</strong></td><td style='dest'><strong>Valor Anterior</strong></td><td style='dest'><strong>Valor Actual</strong></td></tr>\n\r";
                }
                
                $message .= "<tr><td style='dest'>".$row['log_campo'].":</td><td style='dest'>".mb_strtoupper($row['log_valorant'],'utf-8')."</td><td style='dest'>".mb_strtoupper($row['log_valor'],'utf-8')."</td></tr>\n\r";
                        
                $ln_fila++;
            }            
                $message .="</tbody>\n\r";
                $message .="</table>\n\r";
                $message .="</html>";
                
            $lb_retorno=fn_enviaremail($lstr_correo, $ls_titulo, $message, $ls_from, $ls_fromname);            
        }

        return $lb_retorno;
    }
}
