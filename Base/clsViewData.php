<?php

include_once "fncscript.php";

/**
 * Description of clsViewData
 *
 * @author Reiner
 */
class clsViewData {
   
    public static function redefineDiccionario ( array &$paramLst , $toLower = false ){
        foreach ( $paramLst as $Key => $Data ){
            if (gettype( $Data ) === 'resource' ){
                $DataTmp = $Data;
            } else if ( ( gettype( $Data ) === 'array' ) || ( gettype( $Data ) === 'object' ) ){
                $DataTmp = self::redefineDiccionario ( $Data , $toLower );
            } else {
                //$DataTmp = is_bool( $Data ) ? $Data : utf8_encode( $Data );
                $DataTmp = is_bool( $Data ) ? $Data : ( $Data );
            }
            $DataKey = ( $toLower ) ? strtoupper( $Key ) : strtolower( $Key );
            $bRemove = ( $toLower ) ? ( $Key !=strtoupper( $Key ) ) : ( $Key != strtolower( $Key ) ) ;
            if ( $bRemove ) {
                unset( $paramLst [ $Key ] );
            }
            $paramLst [ $DataKey ] = $DataTmp;
        }
        return $paramLst;
    }
    
    /**
     * Transforma un objeto en un Array
     * @param obecjt        $object
     * @return array
     */
    public static function transformObjetcToArray( $object ){
        if ( is_array( $object ) || is_object( $object)) {
            $result = [];
            foreach ( $object as $key => $value) {
                $result[$key] = self::transformObjetcToArray ( $value );
            }
            return $result;
        }
        return $object;
    }
    
    /**
     * 
     * @param type $aData
     * @param type $redefineIndex
     * @param type $iTotalCount
     * @param type $sMensaje
     * @return type
     */
    public static function viewData ( $aData, $redefineIndex = null, $iTotalCount = null, $sMensaje = '' ){
        
        $lstInfo = [ 'success' => true, 'proceso' => true, 'data' => ( $redefineIndex !== null ? self::redefineDiccionario ( $aData, $redefineIndex ) : $aData ), 'total' => ( $iTotalCount === null ? count ( $aData ) : $iTotalCount ) ];
        if ( $sMensaje !== '' ){
            $lstInfo [ 'msg' ] = $sMensaje;
        }
        return ( jsonEncodeStandar( $lstInfo ) );
    }
    
    public static function showError ( $iError, $sMensaje, $psObserva = '' ){        
        $lstInfo = [ 'success' => false, 'proceso' => false, 'msgError' => $sMensaje, 'codeError' => $iError ];
        if ( $psObserva !== '' ){
            $lstInfo [ 'observa' ] = $psObserva;
        }
        return jsonEncodeStandar( $lstInfo );
    }
    
    public static function treeNodeData ( $aData ){
        if (is_array( $aData ) ){
            return jsonEncodeStandar( $aData );
        } else{
            return self::showError( -10000, 'Error en tipo de estructura' );
        }
        
    }
    
    public static function statusProc ( $mensaje, $lstData = [] ){
        $lstInfo = [ 'success' => true, 'proceso' => true, 'msg' => $mensaje, 'info' => $lstData ]; 
        return ( jsonEncodeStandar( $lstInfo ) );
    }
    
    
}
