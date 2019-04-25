<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsmtaFormatArray
 *
 * @author JAVSOTO
 */
class clsmtaFormatArray {
    //put your code here
    
     public function lstRegistrodet(&$lstArrayHeader,&$lstArrayHeaderWith,&$lstArrayFormat){
         
         $lstArrayHeader= Array(
             'descripcion'         => 'PRODUCTO',
             'codigobarras'        => 'COD. BARRAS',
             'codsap'              => 'COD. SAP',
             'familia'             => 'FAMILIA',
             'subfam'              => 'SUB. FAMILIA',
             'grupofam'            => 'GRUPO FAMILIA',
             'rgd_cantidad'        => 'CANTIDAD',
             'rgd_fechaven'        => 'FECHA VENCIMIENTO',        
             'rgd_observacion'     => 'OBSERVACION', 
             'local'               => 'COD. LOCAL', 
             'localdescripcion'    => 'NOMBRE LOCAL',       
             'localcodsap'         => 'COD. SAP. LOCAL',
             'pai_denominacion'    => 'REGION' );
         
          $lstArrayHeaderWith=Array(100,20,20,20,20,20,20,30,100,20,100,20,30);
          
          $lstArrayFormat=Array('rgd_fechaven'    => 'dd/mm/yyyy',
                                'codigobarras'    => '@',
                                'codsap'          => '@');
     }
     
     public function lstCatalogo(&$lstArrayHeader,&$lstArrayHeaderWith,&$lstArrayFormat){
         $lstArrayHeader= Array(
             'cdg'                  => 'CDG',       
             'codsap'               => 'COD. SAP',
             'descripcion'          => 'DESCRIPCION',
             'familia'              => 'FAMILIA',
             'subfam'               => 'SUB. FAMILIA',
             'grupofam'             => 'GRUPO FAMILIA',
             'trf_cdg'              => 'TARIFA',
             'trd_precio'           => 'PRECIO',
             'trd_precioiva'        => 'PRECIO IVA');
         
          $lstArrayHeaderWith=Array(20,20,100,15,15,15,20,20);
          
          $lstArrayFormat=Array('codsap'          => '@',
                                'cdg'             => '@',
                                'trd_precio'      => '#,##0.00',
                                'trd_precioiva'   => '#,##0.00');
     }
     
     public function lstTarifaDetalle(&$lstArrayHeader,&$lstArrayHeaderWith,&$lstArrayFormat){
         $lstArrayHeader= Array(
             'trf_cdg'              => 'TARIFA',
             'cdg'                  => 'COD. ART',           
             'codsap'               => 'COD. SAP',
             'trd_precio'           => 'PRECIO',
             'trd_precioiva'        => 'PRECIO IVA');
         
         $lstArrayHeaderWith=Array(15,20,20,20,20);
         
             $lstArrayFormat=Array('cdg'             => '@',
                                   'codsap'          => '@',
                                   'trd_precio'      => '#,##0.00',
                                   'trd_precioiva'   => '#,##0.00');
     }
}
