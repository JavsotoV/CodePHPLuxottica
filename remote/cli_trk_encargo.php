<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../../nusoap-0.9.5/lib/nusoap.php');

$cliente = new nusoap_client('http://localhost/library/remote/rmt_trk_encargo.php?wsdl');

$cliente->debug();
        
    $error = $cliente->getError();
    if ($error) {
        echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
        
        exit();
    }
      
    $parametro=array('an_condicion' => '1', 'an_pai_codigo'=>'2','as_doc_cliente'=>'18236664');
    
    $result = $cliente->call("getEncargoCliente",$parametro);
 
if($cliente->fault)
{
    echo "FAULT: <p>Code: (".$cliente->faultcode.")</p>";
    echo "String: ".$cliente->faultstring;
}
else
{
    print_r($result); 
}