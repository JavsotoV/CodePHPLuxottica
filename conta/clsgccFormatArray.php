<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgccFormatArray
 *
 * @author JAVSOTO
 */
class clsgccFormatArray {
    //put your code here
     public function lstEntidad(&$lstArrayHeader,&$lstArrayHeaderWith,&$lstArrayFormat){
          
         $lstArrayHeader=Array( 'per_nombrecompleto'		=> 'NOMBRE',
                                 'per_nrodocidentidad'          => 'CODIGO',
                                 'codsap'                       => 'COD. SAP',
                                 'ent_nrocaja'                  => 'NRO. CAJA',
                                 'dom_descripcion'              => 'DIRECCION',
                                 'ema_denominacion'             => 'EMAIL',
                                 'rpe_nombrecompleto'           => 'RESPONSABLE',
                                 'rpe_email'                    => 'EMAIL RESP.',
                                 'mon_denominacion'             => 'MONEDA',
                                 'ent_importe'                  => 'IMPORTE');
          
          $lstArrayHeaderWith=Array(50,20,20,20,50,50,50,50,20,20);
          
          $lstArrayFormat=Array('ent_importe'     => '#,##0.00');          
     }
}

