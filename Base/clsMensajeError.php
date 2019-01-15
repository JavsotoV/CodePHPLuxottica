<?php

class clsMensajeError {
    const MENSAJE_EXITO = 'Proceso registrado correctamente';

    public static $isErrorDefine = false;
    public static $codeError = false;
    public static $descError = '';

    private function __construct() {
        self::$codeError = -1;
        self::$isErrorDefine = false;
        self::$descError = '';
    }

    public static function getMensaje($codError=-1, $TituloReferencia = '', $paramRequerido='') {
        $desc = '';

        self::$codeError = $codError;
        self::$isErrorDefine = true;
        switch ($codError) {
             case -1: self::$descError = 'Error en el Ingreso de los Datos.';
                break;
            
            default :
                self::$isErrorDefine = false;
                self::$descError = 'Error de Tipo Desconocido.';
                break;
        }
        if ($codError > 0) {
            if ($TituloReferencia == "")
                self::$descError = self::MENSAJE_EXITO;
            else
                self::$descError = $TituloReferencia;
        }
        return self::$descError;
    }

}
