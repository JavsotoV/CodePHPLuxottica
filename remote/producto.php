<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../../nusoap-0.9.5/lib/nusoap.php');

function getProd($categoria) {
       
    $data="";
        
        if ($categoria == "libros") {
            $data = join(",", array(
                "El senor de los anillos",
                "Los límites de la Fundacion",
                "The Rails Way"));
        }
        else {
            $data= "No hay productos de esta categoria";
        }
        
        return $data;
    }
      
    $server = new nusoap_server();
    $server->configureWSDL("producto", "urn:producto");
      
    $server->register("getProd",
        array("categoria" => "xsd:string"),
        array("return" => "xsd:string"),
        "urn:producto",
        "urn:producto#getProd",
        "rpc",
        "encoded",
        "Nos da una lista de productos de cada categoría");
      
 $post = file_get_contents('php://input');
$server->service($post);
 