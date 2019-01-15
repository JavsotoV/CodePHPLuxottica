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
}
