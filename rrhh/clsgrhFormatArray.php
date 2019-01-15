<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgrhFormatArray
 *
 * @author JAVSOTO
 */
class clsgrhFormatArray {
    //put your code here
    
    public function lstsolgrhcb(&$lstArrayHeader,&$lstArrayHeaderWith,&$lstArrayFormat){
        $lstArrayHeader=Array( 'glprofile'          => 'CODIGO',
                               'nombre_user'        => 'SOLICITANTE',
                               'descripcion'        => 'SOLICITUD',
                               'montosol'           => 'IMP. SOLICITADO',
                               'solicitud'          => 'MOTIVO',
                               'des_aprobado'       => 'CONDICION',
                               'observacion'        => 'OBSERVACION',
                               'fdesde'             => 'FECHA INICIO',        
                               'fhasta'             => 'FECHA TERMINO',
                               'monto'              => 'IMP. APROBADO',
                               'des_tpplanm'        => 'TIPO PLAN',
                               'pln_denominacion'   => 'DENOMINACION PLAN',
                               'sede'               => 'SEDE',
                                'nrocupon'          => 'NRO. CUPON',
                                'ubg_descripcion'   => 'UBIGEO',
                                'freg'              => 'FECHA SOLICITUD',
                                'des_motivo'        => 'MOTIVO RECHAZO',
                                'nrocuota'          => 'NRO. CUOTAS');
        
         $lstArrayHeaderWith=Array(10,60,120,20,120,40,120,20,20,20,60,60,80,20,120,20,120,20);
         
           $lstArrayFormat=Array('fdesde'    => 'dd/mm/yyyy',   
                           'fhasta'      => 'dd/mm/yyyy',
                           'freg'  => 'dd/mm/yyyy',
                           'montosol'        => '#,##0.00',
                           'monto'  => '#,##0.00');
        }
}
