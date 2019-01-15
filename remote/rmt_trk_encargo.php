<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../../nusoap-0.9.5/lib/nusoap.php');
require_once('../traking/clstrkEncargo.php');
require_once('../traking/clstrkSeguimiento.php');

function getEncargoCliente($an_condicion,$an_pai_codigo,$as_doc_cliente){
    
    $luo_traking = new clstrkEncargo();
    
    $rowdata = $luo_traking->lst_encargoxcliente($an_condicion,$an_pai_codigo, $as_doc_cliente);
    
    unset($luo_traking);
    
    return $rowdata;
    
}

function getStatusEncargo($an_pai_codigo,$as_encargo){
    
    $luo_seguimiento = new clstrkSeguimiento();
    
    $rowdata  = $luo_seguimiento->lst_estatusxencargo($an_pai_codigo, $as_encargo);
    
    unset($luo_seguimiento);
    
    return $rowdata;
}

 $server = new nusoap_server();
 
 $server->configureWSDL('Traking Encargo','urn:rmt_trk_encargo');
 
 //------Estructura de un registro ---------------------------------------------
 $server->wsdl->addComplexType(
         'lstRecordEncargo',
         'complexType',
         'struct',
         'all',
         '',
         array(
             'cli_dni'              => array('name'=>'cli_dni',     'type'=>'xsd:string'),
             'cli_nombre'           => array('name'=>'cli_nombre',  'type'=>'xsd:string'),
             'cli_movil'            => array('name'=>'cli_movil',   'type'=>'xsd:string'),
             'cli_email'            => array('name'=>'cli_email',   'type'=>'xsd:string'),
             'num_tran'             => array('name'=>'num_tram',    'type'=>'xsd:string'),
             'fecha'                => array('name'=>'fecha',       'type'=>'xsd:string'),
             'encargo'              => array('name'=>'encargo',     'type'=>'xsd:string'),
             'tda_codigo'           => array('name'=>'tda_codigo',  'type'=>'xsd:string'),
             'tda_descripcion'      => array('name'=>'tda_descripcion','type'=>'xsd:string'),
             'tda_direccion'        => array('name'=>'cli_dni',     'type'=>'xsd:string'),
             'tda_email'            => array('name'=>'tda_email',   'type'=>'xsd:string'),
             'estado'               => array('name'=>'estado',      'type'=>'xsd:string'),
             'agente'               => array('name'=>'agente',      'type'=>'xsd:string'))
         );
 
 //---Record de Ststus de encargo ---------------------------------------------
 $server->wsdl->addComplexType(
         'lstStatus',
         'complextType',
         'struct',
         'all',
         '',
         array(
             'enc_codigo'           => array('name'=>'enc_codigo',          'type'=>'xds:string'),
             'enc_numero'           => array('name'=>'enc_numero',          'type'=>'xds:string'),          
             'est_codigo'           => array('name'=>'est_codigo',          'type'=>'xds:string'), 
             'est_descripcion'      => array('name'=>'est_descripcion',     'type'=>'xds:string'), 
             'seg_fechaestado'      => array('name'=>'seg_fechaestado',     'type'=>'xds:string'),
             'seg_horaestado'       => array('name'=>'seg_horaestado',      'type'=>'xds:string'),
             'seg_fecharegistro'    => array('name'=>'seg_fecharegistro',   'type'=>'xds:string'),
             'seg_horaregistro'     => array('name'=>'seg_horaregistro',    'type'=>'xds:string'),
             'seg_observacion'      => array('name'=>'seg_observacion',     'type'=>'xds:string'))
         );
 
 //---Estructura de un conjunto de registro-------------------------------------
 $server->wsdl->addComplexType(
         'lstEncargoCliente',
         'complexType',
         'array',
         '',
         'SOAP-ENC:Array',
         array(),
         array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:lstRecordEncargo[]')),
         'tns:lstRecordEncargo');
 
 //---Estructa de registro de un seguimiento
 $server->register("getEncargoCliente",
           array('an_condicion' => 'xsd:string',
                 'an_pai_codigo' => 'xsd:string',
                 'as_doc_cliente' => 'xsd:string'),
           array('return' => 'xsd:string'),
           "urn:rmt_trk_encargo",
           "urn:rmt_trk_encargo#getEncargoCliente",
           'rpc',
           'encoded',
           'Listado de encargos de un cliente segun documento de identidad');

 $server->register("getStatusEncargo",
           array("an_pai_codigo" => "xsd:string",
                 "as_encargo"   => "xsd:string"),
           array("return" => "tns:lstEncargoCliente"),
           "urn:rmt_trk_encargo",
           "urn:rmt_trk_encargo#getStatusEncargo",
           "rpc",
           "encoded",
           "Listado de estatus de encargo ingresado");

$post = file_get_contents('php://input');
$server->service($post);