<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clssegSession
 *
 * @author JAVSOTO
 */
require_once('../utiles/fnUtiles.php');

class clssegSession {
    //put your code here
    private $_per_codigo;
    private $_rol_codigo;
    private $_IPaddress;
    private $_cta_nombre;
    private $_data;
    
    public function get_per_codigo() {
        
        $this->_per_codigo=$_SESSION['per_codigo'];
        
        return $this->_per_codigo;
    }

    public function get_rol_codigo() {
        $this->_rol_codigo=$_SESSION['rol_codigo'];
        
        return $this->_rol_codigo;
    }
    
    public function get_IPaddress() {
        $this->_IPaddress=$_SESSION['IPaddress'];
        
        return $this->_IPaddress;
    }

    function get_cta_nombre() {
        $this->_cta_nombre=$_SESSION['cta_nombre'];
        
        return $this->_cta_nombre;
    }
    
    public function get_data(){
        
        $this->_data =$_SESSION['data'];
        
        return $this->_data;
    }

        
    public  function lst_iniciar($rowdata){
        
        $rowsession = json_decode($rowdata, true);
        
        $_SESSION['data']=$rowdata;
       
      if ($rowsession['data']['0']['ln_retorno']==='1'){ 
        $_SESSION['per_codigo']         = $rowsession['data']['0']['per_codigo'];
        $_SESSION['cta_nombre']         = $rowsession['data']['0']['cta_nombre'];
        $_SESSION['per_nombre']         = $rowsession['data']['0']['per_nombrecompleto'];
        $_SESSION['per_nrodocidentidad']= $rowsession['data']['0']['per_nrodocidentidad'];
        $_SESSION['pai_codigo']         = $rowsession['data']['0']['pai_codigo'];
        $_SESSION['pai_denominacion']   = $rowsession['data']['0']['pai_denominacion'];
        $_SESSION['rol_codigo']         = $rowsession['data']['0']['rol_codigo'];
        $_SESSION['dom_resumen']        = $rowsession['data']['0']['dom_resumen'];
        $_SESSION['userAgent']          = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['SKey']               = uniqid(mt_rand(), true);
        $_SESSION['IPaddress']          = fn_GetIp();
        $_SESSION['LastActivity']       = $_SERVER['REQUEST_TIME']; 
         
      }
    }

        
    public function lst_cerrar(){
       
        @session_start();
        
        foreach ($_SESSION as $key => $value) {
             $value = '';
             unset($_SESSION[$key]);
        }
    
        $_SESSION = array();
       
        unset($_SESSION);
       
        foreach ($_POST as $key => $value) {
            unset($_POST[$key]);
        }
	
        session_destroy();
        
        $_POST = array();
        
        unset($_POST);
        
    }
}
