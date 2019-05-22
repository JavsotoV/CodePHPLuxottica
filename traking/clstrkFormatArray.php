<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clstrkFormatArray
 *
 * @author JAVSOTO
 */
class clstrkFormatArray {
    //put your code here
    
    public function lstImportardet(&$lstArrayHeader,&$lstArrayHeaderWith,&$lstArrayFormat){
        
         $lstArrayHeader= Array(
             'imd_encargo'               => 'ENCARGO',
             'imd_fecha'                 => 'FECHA REPROGRAMACION',
             'imd_motivo'                => 'MOTIVO',
             'imd_tipocristal'           => 'TIPO CRISTAL',
             'imd_suministromontura'     => 'SUMINISTRO MONTURA',
             'pai_denominacion'          => 'REGION');
         
          $lstArrayHeaderWith=Array(40,20,70,40,40,20);
          
           $lstArrayFormat=Array('imd_encargo'  => '@',
                                'imd_fecha'     => 'dd/mm/yyyy');
    }
}
