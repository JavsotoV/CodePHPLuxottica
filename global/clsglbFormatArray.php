<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsglbTiendaFormatArray
 *
 * @author JAVSOTO
 */
class clsglbFormatArray {
    //put your code here
    
    public function lstTienda(&$lstArrayHeader,&$lstArrayHeaderWith,&$lstArrayFormat){
       
        $lstArrayHeader=Array(
            'ubg_descripcion'                   => 'UBIGEO', 
            'tda_descripcion'                   => 'DENOMINACION',
            'ctr_descripcion'                   => 'C. COSTO',
            'pai_denominacion'                  => 'REGION',
            'tda_codinterno'                    => 'COD. INTERNO',
            'cda_descripcion'                   => 'CADENA',
            'tda_email'                         => 'EMAIL',
            'cta_nombre'                        => 'USUARIO');
        
        $lstArrayHeaderWith=Array(100,100,20,20,20,60,30,30);
        
        $lstArrayFormat=Array('con_fechaper'    => 'dd/mm/yyyy');
        
    }
    
    public function lstConfig(&$lstArrayHeader,&$lstArrayHeaderWith,&$lstArrayFormat){
       
        $lstArrayHeader=Array(
            'pai_denominacion'                  => 'REGION',
            'nombre'                            => 'NOMBRE',
            'descripcion'                       => 'DESCRIPCION',
            'local'                             => 'LOCAL',
            'email'                             => 'EMAIL',
            'direccion'                         => 'DIRECCION',
            'cta_nombre'                        => 'USUARIO',
            'ubg_descripcion'                   => 'DISTRITO / COMUNA');
        
        $lstArrayHeaderWith=Array(20,100,100,20,60,80,30,100);
        
        $lstArrayFormat=Array('con_fechaper'    => 'dd/mm/yyyy');
        
    }
}
