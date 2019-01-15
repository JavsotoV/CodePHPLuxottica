<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsgcaFormatArray
 *
 * @author JAVSOTO
 */
class clsgcaFormatArray {
    //put your code here
    public function lstContrato(&$lstArrayHeader,&$lstArrayHeaderWith,&$lstArrayFormat){
         $lstArrayHeader=Array( 'con_nroregistro'		=> 'NRO. REGISTRO',
                            'con_codgestion'			=> 'GESTION',
                            'ctr_codinterno'                    => 'CECCO',                            
                            'tda_descripcion'			=> 'LOCAL',
                            'con_direccion'			=> 'DIRECCION',
                            'ubg_denominacion'			=> 'DISTRITO / COMUNA',
                            'imb_descripcion'			=> 'GRUPO INMOBILIARIO',
                            'cna_descripcion'			=> 'CANAL',                                          
                            'con_fechaper'			=> 'FECHA APERTURA',
                            'con_fechafirma'			=> 'FECHA FIRMA',
                            'con_fechai'			=> 'FECHA INICIO',                            
                            'con_fechat'			=> 'FEC. VENCIMIENTO',
             //
                            'ard_nrodocidentidad1'              => 'RUC',
                            'ard_nombrecompleto1'               => 'PROVEEDOR 1',
                            'ard_nrodocidentidad2'              => 'RUC',
                            'ard_nombrecompleto2'               => 'PROVEEDOR 2',  
                            'ard_nrodocidentidad3'              => 'RUC',
                            'ard_nombrecompleto3'               => 'PROVEEDOR 3',      
             //
                            'con_area'				=> 'AREA',
                            'gra_tipodescripcion'		=> 'TIPO GARANTIA',
                            'rta_moneda'			=> 'MONEDA MT2',
                            'con_valormetro'			=> 'VALOR METRO 2',                            
                            'gra_moneda'			=> 'MONEDA GARANTIA',
                            'gra_importe'			=> 'GARANTIA IMPORTE',
                            'rta_importeipc'			=> 'RENTA MINIMA',
                            'rta_porcentaje'			=> 'RENTA VARIABLE',
                            'des_flagrentadiciembre'            => 'RTA. DICIEMBRE',
                            'con_imprentadiciembre'             => 'IMP. RTA. DICIEMBRE',   
                            'gto_tipodescripcion'		=> 'TIPO GASTO COMUN',
                            'gto_moneda'			=> 'MONEDA GASTO COMUN',
                            'gto_importe'			=> 'IMPORTE GASTO COMUN',
                            'des_flagclausalida'		=> 'CLAUSULA SALIDA',
                            'con_plazominsalida'                => 'PLAZO CLAUSULA SALIDA',
                            'des_flagrenovacionaut'             => 'RENOV. AUT.',
                            'con_plazorenovacionaut'            => 'PLAZO.RENOV. AUT',
                            'des_undplazorenovacionaut'         => 'TIEMPO',     
                            'con_plazominrenov'                 => 'PLAZO MIN. RENOV',
                            'rja_descripcion'                   => 'REAJUSTE',
                            'rta_puntop'                        => 'PUNTO PORCENTUAL',
                            'con_destipofondoprom'              => 'TPO FONDO PROMOCION',
                            'con_desbasefondoprom'              => 'BASE',
                            'mon_siglas'                        => 'MON. FONDO PROMOCION',
                            'con_impfondopromo'                 => 'IMPORTE FONDO PROMOCION',
                            'con_porcfondoprom'                 => 'PORCENTAJE',
                            'mon_desingresollave'               => 'MON. DERECHO LLAVE',
                            'con_impingrllave'                  => 'IMPORTE DERECHO LLAVE',
                            'mon_revision'                      => 'MON. FEE. REVISION',
                            'con_importerevision'               => 'IMPORTE FEE. REVISION',
                            'con_observacion'			=> 'OBSERVACION',
                            'sta_descripcion'                   => 'SITUACION');
        
        $lstArrayHeaderWith=Array(10,10,10,120,120,30,20,20,20,20,20,20,20,120,20,120,20,120,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,200,20);
        
        $lstArrayFormat=Array('con_fechaper'    => 'dd/mm/yyyy',   
                           'con_fechai'      => 'dd/mm/yyyy',
                           'con_fechafirma'  => 'dd/mm/yyyy',
                           'con_fechat'      => 'dd/mm/yyyy',            
                           'con_area'        => '#,##0.00',
                           'con_valormetro'  => '#,##0.00',
                           'gra_importe'     => '#,##0.00',
                           'rta_importeipc'  => '#,##0.00',
                           'rta_porcentaje'  => '#,##0.00',
                           'con_imprentadiciembre'  => '#,##0.00',
                           'gto_importe'            => '#,##0.00',
                           'rta_puntop'             => '#,##0.00',
                           'con_impfondopromo'      => '#,##0.00',
                           'con_impingrllave'       => '#,##0.00',
                           'con_importerevision'    => '#,##0.00',
                           'con_porcfondoprom'      => '#,##0.00');
    }
    
    public function lstRenta(&$lstArrayHeader,&$lstArrayHeaderWith,&$lstArrayFormat){
         $lstArrayHeader=Array( 'con_nroregistro'		=> 'NRO. REGISTRO',
                            'con_codgestion'			=> 'GESTION',
                            'ctr_codinterno'                    => 'CECCO',                            
                            'tda_descripcion'			=> 'LOCAL',
                            'con_direccion'			=> 'DIRECCION',
                            'ubg_denominacion'			=> 'DISTRITO / COMUNA',
                            'imb_descripcion'			=> 'GRUPO INMOBILIARIO',
                            'cna_descripcion'			=> 'CANAL',
                        //    'con_fechaper'			=> 'FECHA APERTURA',                            
                        //    'con_fechafirma'			=> 'FECHA FIRMA',
                        //    'con_fechai'			=> 'FECHA INICIO',
                        //    'con_fechat'			=> 'FEC. VENCIMIENTO',
                        //    'con_area'				=> 'AREA',
                       //     'gra_tipodescripcion'		=> 'TIPO GARANTIA',
                        //    'rta_moneda'			=> 'MONEDA MT2',
                        //    'con_valormetro'			=> 'VALOR METRO 2',                            
                       //     'gra_moneda'			=> 'MONEDA GARANTIA',
                       //     'gra_importe'			=> 'GARANTIA IMPORTE',
                            'rta_fechai'                        => 'FEC.INI.RTA.MIN',    
                            'rta_fechat'                        => 'FEC.TER.RTA.MIN',    
                            'rta_importeipc'			=> 'RENTA MINIMA',
                            'rta_porcentaje'			=> 'RENTA VARIABLE',
                     //       'des_flagrentadiciembre'            => 'RTA. DICIEMBRE',
                     //       'con_imprentadiciembre'             => 'IMP. RTA. DICIEMBRE',   
                     //       'gto_tipodescripcion'		=> 'TIPO GASTO COMUN',
                            'gto_moneda'			=> 'MONEDA GASTO COMUN',
                            'gto_importe'			=> 'IMPORTE GASTO COMUN');
                     //       'des_flagclausalida'		=> 'CLAUSULA SALIDA',
                     //       'con_plazominsalida'                => 'PLAZO CLAUSULA SALIDA',
                     //       'des_flagrenovacionaut'             => 'RENOV. AUT.',  
                     //       'con_plazorenovacionaut'            => 'PLAZO RENOV. AUT',
                     //       'des_undplazorenovacionaut'         => 'TIEMPO',    
                     //       'con_plazominrenov'                 => 'PLAZO MIN. RENOV.',
                     //       'con_observacion'			=> 'OBSERVACION');
        
        $lstArrayHeaderWith=Array(10,10,10,120,120,30,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,200);
        
        $lstArrayFormat=Array('con_fechaper'    => 'dd/mm/yyyy',   
                           'con_fechai'      => 'dd/mm/yyyy',
                           'con_fechafirma'  => 'dd/mm/yyyy',
                           'con_fechat'      => 'dd/mm/yyyy',
                           'rta_fechai'      => 'dd/mm/yyyy',
                           'rta_fechat'      => 'dd/mm/yyyy', 
                           'con_area'        => '#,##0.00',
                           'con_valormetro'  => '#,##0.00',
                           'gra_importe'     => '#,##0.00',
                           'rta_importeipc'  => '#,##0.00',
                           'rta_porcentaje'  => '#,##0.00',
                           'con_imprentadiciembre'  => '#,##0.00',
                           'gto_importe'            => '#,##0.00');
    }
      
    public function lstBinary(&$lstArrayHeader,&$lstArrayHeaderWith,&$lstArrayFormat){
         $lstArrayHeader=Array( 'con_nroregistro'		=> 'NRO. REGISTRO',
                            'con_codgestion'			=> 'GESTION',
                            'ctr_codinterno'                    => 'CECCO',                            
                            'tda_descripcion'			=> 'LOCAL',
                            'con_direccion'			=> 'DIRECCION',
                            'ubg_denominacion'			=> 'DISTRITO / COMUNA',
                            'imb_descripcion'			=> 'GRUPO INMOBILIARIO',
                            'cna_descripcion'			=> 'CANAL',
                            'con_fechaper'			=> 'FECHA APERTURA',                            
                            'con_fechafirma'			=> 'FECHA FIRMA',
                            'con_fechai'			=> 'FECHA INICIO',
                            'con_fechat'			=> 'FEC. VENCIMIENTO',
                            'bin_filename'                      => 'ARCHIVO'
             );
         
         $lstArrayHeaderWith=Array(10,10,10,120,120,30,20,20,20,20,20,20,200);
         
         $lstArrayFormat=Array('con_fechaper'    => 'dd/mm/yyyy',   
                           'con_fechai'      => 'dd/mm/yyyy',
                           'con_fechafirma'  => 'dd/mm/yyyy',
                           'con_fechat'      => 'dd/mm/yyyy', 
                           'rta_fechai'      => 'dd/mm/yyyy',
                           'rta_fechat'      => 'dd/mm/yyyy', 
                           'con_area'        => '#,##0.00',
                           'con_valormetro'  => '#,##0.00',
                           'gra_importe'     => '#,##0.00',
                           'rta_importeipc'  => '#,##0.00',
                           'rta_porcentaje'  => '#,##0.00',
                           'con_imprentadiciembre'  => '#,##0.00',
                           'gto_importe'            => '#,##0.00');
    }
}
