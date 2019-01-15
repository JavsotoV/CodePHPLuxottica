<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conf
 *
 * @author jvelasquez
 */


class ConfSql {
    //put your code here
    private $_domain;
    private $_userdb;
    private $_passdb;
    private $_hostdb;
    private $_db;
    private $_charset;
    private $_idsistema;
    
    private static $_instance;
    
    private function __construct() {
        $this->_domain='none';//$domain;
        $this->_userdb='sa';//$user;
        $this->_passdb='gmo';//$password;
        $this->_hostdb='sqlserver2008';//$host;
        $this->_db='New_Interfaces';//$db;
        $this->_charset='ISO8859_1';//$charset; 
        $this->_idsistema=1;//$idsistema;
      
    }
    
    private function __clone(){}
    
    public static function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance=new self();            
        }        
        return self::$_instance;        
    }
    
    public function getDomainDB(){
        $var=$this->_domain;
        return $var;
    }
    
    public function getUserDB(){
        $var=  $this->_userdb;
        return $var;       
    }
    
    public function getHostDB(){
        
        $var=  $this->_hostdb;
        return $var;
    }
    
    public function getPassDB(){
        $var = $this->_passdb;
        return $var;        
    }
    
    public function getDB(){
        $var = $this->_db;
        return $var;        
    }
    
    public function getCharsetDB(){
        $var = $this->_charset;
        return $var;
    }      
    
    public function getIdSistema(){
        $var = $this->_idsistema;
        return $var;
    }
}

