<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ( !defined( 'METHOD_RETURN_ARRAY' ) ){
    define( 'METHOD_RETURN_ARRAY', 0 );
}
if ( !defined( 'METHOD_RETURN_XML' ) ){
    define( 'METHOD_RETURN_XML', 1 );
}
if ( !defined( 'METHOD_RETURN_JSON' ) ){
    define( 'METHOD_RETURN_JSON', 2 );
}
if ( !defined( 'METHOD_RETURN_AJAX' ) ){
    define( 'METHOD_RETURN_AJAX', 3 );
}
if ( !defined( 'METHOD_RETURN_PLANO' ) ){
    define( 'METHOD_RETURN_PLANO', 4 );
}

function parsearcursor($refstatement){
    
    $ll_fila=0;
    $lstCampoDatabase=array();
    $lstArray=array();
    
    $bRetorno = @oci_execute($refstatement, OCI_DESCRIBE_ONLY);
    
    if (!$bRetorno){return null;};    
     
    $ln_nrocampos= oci_num_fields($refstatement);
    
    for ($ll_fila=1; $ll_fila<=$ln_nrocampos; ++$ll_fila){
        $lstInfoCampo = oci_field_name($refstatement, $ll_fila);
         array_push($lstCampoDatabase, strtolower($lstInfoCampo));        
    }
    
    $bRetorno = @oci_execute($refstatement, OCI_NO_AUTO_COMMIT);

    if (!$bRetorno) {return null;};        
        
    while ($lstRow = oci_fetch_array($refstatement, OCI_NUM +OCI_RETURN_LOBS + OCI_RETURN_NULLS)) {
        $lstItem = array();
        foreach ($lstCampoDatabase as $Key => $Data) {
            $lstItem[strtoupper($Data)] = $lstRow[$Key];
        }
        array_push($lstArray, $lstItem);
    }
    
    oci_free_statement($refstatement);
    
    return $lstArray;
};

function mssqlparsear($result){
    
    $lstArray=array();
		 
    while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) 
    {
        $lstArray[] = $row;
    }
    
    return $lstArray;
}


/** 
 * parsear un cursor de sql server
 */

function sqlsrvparsearcursor($refstatement){
    
    $ll_fila=0;
    
    $lstCampoDatabase=array();
    
    $lstArray=array();
    
    $bRetorno = @sqlsrv_execute($refstatement);
    
    if (!$bRetorno){return null;};    
     
    foreach(sqlsrv_field_metadata($refstatement) as $fieldMetadata){
            array_push($lstCampoDatabase, strtolower($fieldMetadata['Name']));        
    }
    
    $bRetorno = @sqlsrv_execute($refstatement);

    if (!$bRetorno) {return null;};        
        
    while ($lstRow = sqlsrv_fetch_array($refstatement)) {
        $lstItem = array();
        foreach ($lstCampoDatabase as $Key => $Data) {
            $lstItem[strtoupper($Data)] = $lstRow[$Key];
        }
        array_push($lstArray, $lstItem);
    }
    
    sqlsrv_free_stmt($refstatement);
    
    return $lstArray;
};

/*
 * funcion para pasear us sp ejecutado en sql server
 */
function sqlsrvparsearprocedure($refstatement){
    
    $ll_fila=0;
    
    $lstCampoDatabase=array();
    
    $lstArray=array();
    
    foreach(sqlsrv_field_metadata($refstatement) as $fieldMetadata){
            array_push($lstCampoDatabase, strtolower($fieldMetadata['Name']));        
    }
    
    while ($lstRow = sqlsrv_fetch_array($refstatement)) {
        $lstItem = array();
        foreach ($lstCampoDatabase as $Key => $Data) {
            $lstItem[strtoupper($Data)] = $lstRow[$Key];
        }
        array_push($lstArray, $lstItem);
    }
    
    sqlsrv_free_stmt($refstatement);
    
    return $lstArray;
};
/*
/**
 * Valida el ingreso de un valor y determina si es nulo lo reemplaza por un valor por defecto
 * @param   value   $Valor  : Valor a evaluar
 * @param   string  $defecto: De no ser vacio utiliza el valor para ser reemplazado en caso de ser nulo el Valor
 * @return  string  : retorna un valor dependiendo si el parametro Valor es nulo, utilizara el valor por Defecto
 * */

function validaNull($Valor, $defecto = '', $type = 'string') {
    if (is_null($Valor)) {
        return (($defecto == '') && ($type == 'string')) ? $Valor : $defecto;
    } else {
        switch ($type) {
            case 'string':
                return ( is_string($Valor) ? $Valor : $defecto );
            case 'int':
                return ( is_numeric($Valor) && !is_nan($Valor) ) ? $Valor : $defecto;
            case 'float':
                return ( is_float($Valor) && !is_nan($Valor) ) ? $Valor : $defecto;
            case 'date':
                $bTipo1 = preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/", $Valor);
                $bTipo2 = preg_match("/^[0-9]{2}.[0-9]{2}.[0-9]{4}$/", $Valor);
                $bTipo3 = preg_match("/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/", $Valor);
                return ( $bTipo1 || $bTipo2 || $bTipo3 ) ? $Valor : $defecto;
            case 'time':
                $bTipo1 = preg_match("/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/", $Valor);
                return ( $bTipo1 ) ? $Valor : $defecto;
            case 'timestamp':
                $bTipo1 = preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4} [0-9]{2}:[0-9]{2}:[0-9]{2}$/", $Valor);
                $bTipo2 = preg_match("/^[0-9]{2}.[0-9]{2}.[0-9]{4} [0-9]{2}:[0-9]{2}:[0-9]{2}$/", $Valor);
                $bTipo3 = preg_match("/^[0-9]{2}-[0-9]{2}-[0-9]{4} [0-9]{2}:[0-9]{2}:[0-9]{2}$/", $Valor);
                return ( $bTipo1 || $bTipo2 || $bTipo3 ) ? $Valor : $defecto;
            default :
                return $Valor;
        }
    }
}

function jsonEncodeStandar ( $parameter ){
    return json_encode( $parameter , JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE );
};


function returnParamQuerySelect($refConection, $paramExportType, $paramQuery, $iTotalCount='', $lstArrayBlobType = NULL ) {
    if ( is_resource ( $paramQuery ) ){
        $xxxxxxxquery = $paramQuery;
    } else {
        $xxxxxxxquery = @ibase_query($refConection, $paramQuery);
    }
            
    if ( !$xxxxxxxquery ) {
        return null;
    }

    $lstCampoDatabase = array();
    $lstCampoBlob = array();
    $i = 0;
    $iNumCampos = ibase_num_fields($xxxxxxxquery);
    for ($i = 0; $i < $iNumCampos; $i++) {
        $lstInfoCampo = ibase_field_info($xxxxxxxquery, $i);
        if ($lstInfoCampo['alias'] != '') {
            $tmpNameTable = $lstInfoCampo['alias'];
        } else {
            $tmpNameTable = $lstInfoCampo['name'];
        }
        array_push ( $lstCampoDatabase , $tmpNameTable );        
        if ( $lstInfoCampo[ 'type'] == 'BLOB' ){
            if ( $lstArrayBlobType [ $tmpNameTable ] == 'BINARY' ){
                $lstCampoBlob [ $tmpNameTable ] = 'B';
            } else {
                $lstCampoBlob [ $tmpNameTable ] = 'T';
            }
        } else {
            $lstCampoBlob [ $tmpNameTable ] = null;
        }
    }

    $lstArray = array();
    if ( is_resource( $xxxxxxxquery ) ){
    while ( $lstRow = ibase_fetch_row( $xxxxxxxquery ) ) {
        $lstItem = array();
        foreach ( $lstCampoDatabase as $Key => $Data) {
            if ( $lstCampoBlob [ $Data ] != null ){
                $blob_data = ibase_blob_info( $lstRow[ $Key ] );
                if ( !$blob_data[ 4 ] ){
                    $blob_hndl = ibase_blob_open( $lstRow[ $Key ] );
                    $bl = ibase_blob_get($blob_hndl, $blob_data[ 0 ] );
                    if ( $lstCampoBlob [ $Data ] == 'T' ){
                        $valor = $bl ;
                    } else {
                        $valor = base64_encode  ( $bl );
                    }
                } else {
                    $valor = null;
                }
            } else {
                $valor = $lstRow[$Key];
            }
            if (is_bool( $valor ) || ( is_numeric( $valor ) ) ){
                $valor = $valor;
            }elseif ( $valor === null ){
                $valor = null;
            } else {
                $valor = utf8_encode( $valor );
            }
            switch ( $paramExportType ) {
                case METHOD_RETURN_ARRAY:
                    $lstItem[strtoupper($Data)] = $valor;                    
                break;
                default :
                    $lstItem[strtolower($Data)] = $valor;
                break;
            }
        }
        array_push( $lstArray, $lstItem );
    }
    @ibase_free_result($xxxxxxxquery);
    }

    switch ($paramExportType) {
        case clsExportType::TYPE_ARRAY:
        case METHOD_RETURN_ARRAY:
            return $lstArray;
        case METHOD_RETURN_XML:
            $xml = new SimpleXMLElement('<xmlretorn/>');
            $lstRetorno = array ( 'proceso' => 'true' , 'data' => $lstArray );
            array_to_xml( $xml, $lstRetorno );
            return $xml->asXML();
        case clsExportType::TYPE_JSON:
        case METHOD_RETURN_JSON:
            $lstRetorno = [ 'success' => true, 'proceso' => true , 'data' => $lstArray ];
            if ($iTotalCount !== '') {
                $lstRetorno [ 'totalCount' ] = $iTotalCount ;
            }            
            return jsonEncodeStandar( $lstRetorno );
        case METHOD_RETURN_AJAX:
        case METHOD_RETURN_PLANO:
            throw new Exception( 'Para implementacion futura', -10000 );
    }   
    
}
