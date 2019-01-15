<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    ini_set('display_errors',true);

    error_reporting(E_ALL);
    
    require_once('../../nusoap-0.9.5/lib/nusoap.php');
    
    $cliente = new nusoap_client('http://localhost/library/remote/producto.php?wsdl');
        
    $error = $cliente->getError();
    if ($error) {
        echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
        
        exit();
    }
      
    $parametro=array('categoria' => 'libros');
    
    $result = $cliente->call("getProd",$parametro );
      
    if ($cliente->fault) {
        echo "<h2>Fault</h2><pre>";
        print_r($result);
        echo "</pre>";
    }
    else {
        $error = $cliente->getError();
        if ($error) {
            echo "<h2>Error</h2><pre>" . $error . "</pre>";
        }
        else {
            echo "<h2>Libros</h2><pre>";
            echo $result;
            echo "</pre>";
        }
    }