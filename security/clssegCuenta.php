<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clssegCuenta
 *
 * @author JAVSOTO
 */
require_once("../Base/Db.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

class clssegCuenta {
    
    private $_per_codigo;
    private $_cta_nombre;
    private $_cta_password;
    
    function __construct() {
        $this->_per_codigo=0;
    }
    
    
    function set_per_codigo($_per_codigo) {
        $this->_per_codigo = $_per_codigo;
    }

    function set_cta_nombre($_cta_nombre) {
        $this->_cta_nombre = $_cta_nombre;
    }

    function set_cta_password($_cta_password) {
        $this->_cta_password = $_cta_password;
    }

     public function loadData ( $lstParametros ){
        foreach ( $lstParametros as $key => $value) {
            $method = 'set_' . ucfirst(strtolower( $key ) );
            if ( method_exists( $this, $method ) ){
                call_user_func_array(array( $this, $method ), array( $value ));               
            }
        }
    }

}
