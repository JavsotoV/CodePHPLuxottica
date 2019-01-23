<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Cancela los registros de las variables Session y Post:
 * @param   string  NombreSession   : Session con que inicio el Login el usuario, 
 * @param   string  redirecUrl      : Pagina de redireccionamiento
 * */

error_reporting(0);

require_once("../../phpmail/class.phpmailer.php");


function fn_logout($NombreSession = '', $redirecUrl = '') {
    if ($NombreSession == '')
        session_name();
    else
        session_name($NombreSession);
        @session_start();

    foreach ($_SESSION as $key => $value) {
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
    if ($redirecUrl != '') {
        fn_redirect_rel($redirecUrl);
    }
}

/**
 * Rediracciona a un archivo teniendo como directorio el path donde se llama a la funcion
 * */
function fn_redirect_rel($relative_url) {
    $url = server_url() . dirname($_SERVER['PHP_SELF']) . "/" . $relative_url;
    if (!headers_sent()) {
        header("location: $url");
    } else {
        echo "<meta http-equiv=\"refresh\" content=\"0;url=$url\">\r\n";
    }
}

/**
 * Funcion que retorno el IP desde el que se Conecta el Usuario
 * @return		<string>: retorna el IP (xxx.xxx.xxx.xxx)
 * */

function fn_GetIp() {
    $client_ip = "";
  
     if (getenv('HTTP_CLIENT_IP'))
        $client_ip = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $client_ip = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $client_ip = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $client_ip = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $client_ip = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $client_ip = getenv('REMOTE_ADDR');
    else
        $client_ip="";
    
    
    if (strlen($client_ip)<=3){
        if ( ( isset ( $_SERVER['HTTP_X_FORWARDED_FOR'] )  ) && ( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' ) ) {
        $client_ip = (!empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( (!empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : "0.0.0.0" );
        $entries = preg_split('/[,]/', $_SERVER['HTTP_X_FORWARDED_FOR']);
        reset($entries);
        while (list(, $entry) = each($entries)) {
            $entry = trim($entry);
            if (preg_match("/^([0-9]+.[0-9]+.[0-9]+.[0-9]+)/", $entry, $ip_list)) {
                $private_ip = array(
                    '/^0./',
                    '/^127.0.0.1/',
                    '/^192.168..*/',
                    '/^10.216..*/',
                    '/^172.((1[6-9])|(2[0-9])|(3[0-1]))..*/',
                    '/^10..*/');
                $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

                if ($client_ip != $found_ip) {
                    $client_ip = $found_ip;
                    break;
                }
            }
        }
        } else {
        if (isset($_SERVER['HTTP_CLIENT_IP']) && ($_SERVER['HTTP_CLIENT_IP'] != '') ) { //check ip from share internet
            $client_ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $client_ip = (!empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( (!empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : "0.0.0.0" );
        }
      }    
    }
    return $client_ip;
}

/**
 * Funcion que genera una clave alteatoria formada por caracteres [a..z][0..9][A..Z]
 * @param   int     $longitud	: Tamanio del Texto Generado
 * @return  string      : Cadena alfanumerica.
 * */
function fn_generarclave($longitud) {
    mt_srand((double) microtime() * 1000000);
    $cadena = "";
    for ($i = 1; $i <= $longitud; $i++) {
        if ((rand(1, 3) % 3) == 0)
            $aux = chr(mt_rand(48, 57));
        elseif ((rand(1, 3) % 3) == 1)
            $aux = chr(mt_rand(97, 122));
        elseif ((rand(1, 3) % 3) == 2)
            $aux = chr(mt_rand(65, 90));
        $cadena = $cadena . $aux;
    }
    return $cadena;
}

/**
 * Funcion que genera una metodo de encriptacion Simple
 * @param   string  $cadena		: Cadena de texto a encriptar
 * @return  string      : Cadena de Texto Encriptada
 * */
function fn_encriptar($cadena) {
    mt_srand((double) microtime() * 1000000);
    $semilla1 = mt_rand(65, 90);
    $semilla2 = mt_rand(48, 57);
    $j = strlen($cadena);
    $cadena1 = "";
    for ($i = 0; $i < $j; $i++) {
        $aux = ord(substr($cadena, $i, 1));
        if (($i % 2) == 0) {
            $aux = $aux + $semilla1;
        } else {
            $aux = $aux + $semilla2;
        }
        $aux = $aux ^ 74;
        $cadena1 = $cadena1 . chr($aux);
    }
    $cadena1 = chr($semilla1) . $cadena1;
    $cadena1 = $cadena1 . chr($semilla2);
    return($cadena1);
}

/**
 * Funcion que genera una metodo de encriptacion Simple
 * @param   string  $cadena		: Cadena de texto a encriptar
 * @return  string      (Cadena de Texto Encriptada)
 * */
function fn_desencriptar($cadena) {
    $j = strlen($cadena);
    $semilla1 = ord(substr($cadena, 0, 1));
    $semilla2 = ord(substr($cadena, $j - 1, 1));
    $cadena = substr($cadena, 1, $j - 1);
    $cadena1 = "";

    for ($i = 0; $i < $j - 2; $i++) {
        $aux = ord(substr($cadena, $i, 1));
        $aux = $aux ^ 74;
        if (($i % 2) == 0) {
            $aux = $aux - $semilla1;
        } else {
            $aux = $aux - $semilla2;
        }
        $cadena1.=chr($aux);
    }
    return($cadena1);
}

/**
 * Funcion que retorna el valor en posicion Letra de una Columna en Excel
 * @param	int  $IndexColumna	   (int)	
 * @return	(string)    
 * */
function getNumToColExcel($IndexColumna) {
    $nomColumna = 'A';
    if ($IndexColumna > 0) {
        $valPref = floor($IndexColumna / 26);
        $valSufijo = $IndexColumna % 26;
        $prefijo = '';
        if ($valPref > 0) {
            $prefijo = chr(64 + $valPref);
        }
        $sufijo = chr(65 + $valSufijo);
        $nomColumna = $prefijo . $sufijo;
    }
    return $nomColumna;
}

function fn_formatrowcolumn($lstRowData){
    
    $lstRetorno=array();
    
    $lstrow=array();
    
    $ln_fila=0;
    $ln_numero=1;
    
    foreach($lstRowData as $Key=>$Data){
        
        $ln_nrocampos = $Data['LN_NROATRIBUTO'];
      
        $ln_fila++;
        
        if($ln_fila<=$ln_nrocampos)
        {
            if ($ln_fila==1){
                $lstrow['FILA']=$ln_numero;
                $lstrow['LNA_CODIGO']=$Data['LNA_CODIGO'];}
            
            $lstrow[$Data['ATR_DENOMINACION']]=$Data['DET_VALOR'];
            
            if ($ln_fila==$ln_nrocampos){
                $ln_fila=0;
                $lstRetorno[]=$lstrow;
                $ln_numero++;                
                $ls_cadena='';                
            }
        }        
        
    }
    Return $lstRetorno;
}

/* Generar formato menu para arbol tree*/
function fn_formattree ( $lstMenus ){
    $lstRetorno = array();
    $i=0;
    foreach ($lstMenus as $Key => $Data) {
        if ($Data ['DET_PARENT'] == '0' ) {            
            $lstRetorno [$Data ['NODO_ARBOL']] = $Data;        
            if ($Data ['DET_TIPONODO'] == '1') {
                $lstItems = array_slice($lstMenus, $Key + 1);        
                $items = fn_getChild($lstItems,$Data ['DET_CODIGO'], $Data ['NODO_ARBOL']);
                
                if (count($items) == 0) {
                    unset($lstRetorno [$Data ['NODO_ARBOL']]);
                } else {
                    $lstRetorno [$Data ['NODO_ARBOL']] ['DES_DETALLE'] = $items;
                }
            }
        }/*else {
            break;
        }*/
    }
    return $lstRetorno;
}

/* getchild de un menu*/
function fn_getChild($lstItems, $deepArbol, $nodoArbol) {
    $lstRetorno = array();
    foreach ($lstItems as $Key => $Data) {
        
        if (( $deepArbol == $Data ['DET_PARENT'] ) && ( strpos($Data ['NODO_ARBOL'], $nodoArbol) === 0 )) {
            $lstRetorno [$Data ['NODO_ARBOL']] = $Data;
            if ($Data ['DET_TIPONODO'] == '1') {
                $lstSubItems = array_slice($lstItems, $Key + 1);
                $items = fn_getChild($lstSubItems, $Data ['DET_CODIGO'], $Data ['NODO_ARBOL']);
                if (count($items) == 0) {                    
                    unset($lstRetorno [$Data ['NODO_ARBOL']]);
                } else {
                    $lstRetorno [$Data ['NODO_ARBOL']] ['DES_DETALLE'] = $items;
                }
            }
        }     
    }
    return $lstRetorno;
}

function fn_printListItem($arrayItem, $Nivel, $pathRoot="" , $pathDivisor = '/',$as_expanded=true ){
    $MenuPrint = "";
    foreach ($arrayItem as $Data) {
        $MenuPrint.="{\n";
        switch ($Data["DET_TIPONODO"]) {
            case "1":
                $MenuPrint.="     text:'" . fn_returnStringFormatHTML($Data["DET_DENOMINACION"]) . "', \n";
                $MenuPrint.="     det_codigo:" .$Data["DET_CODIGO"]. ", \n";
                $MenuPrint.="     rol_codigo:'" .$Data["ROL_CODIGO"]. "', \n";
                $MenuPrint.="     det_blob:'0', \n";
                $MenuPrint.="     leaf:false, \n";  
                if ($as_expanded){
                    $MenuPrint.="     expanded:true, \n";
                }else{
                    $MenuPrint.="     expanded:false, \n";}
                    
                $MenuPrint.="     loaded:true, \n";
                $MenuPrint.="     children: [ \n";
                if ($pathRoot == ""){
                    $MenuPrint.=fn_printListItem($Data["DES_DETALLE"], $Nivel++, $pathRoot . $Data["DET_CODIGO"], $pathDivisor,$as_expanded);
                }else{
                    $MenuPrint.=fn_printListItem($Data["DES_DETALLE"], $Nivel++, $pathRoot . $pathDivisor . $Data["DET_CODIGO"], $pathDivisor,$as_expanded );
                }
                $MenuPrint.="     ]\n";
                break;
            case "2" || "3":
                $MenuPrint.="     id:'". $Data["MEN_ITEMID"] . "', \n";
                $MenuPrint.="     tabType:'iframe', \n";
                $MenuPrint.="     text:'" . fn_returnStringFormatHTML($Data["DET_DENOMINACION"]) . "', \n";
                $MenuPrint.="     det_codigo:" . $Data["DET_CODIGO"] . ", \n";                
                $MenuPrint.="     rol_codigo:'" .$Data["ROL_CODIGO"]. "', \n";
                $MenuPrint.="     men_url:'" .$Data["MEN_URL"]. "', \n";
                $MenuPrint.="     det_resumen:'" . $Data["DET_RESUMEN"] . "', \n";
                $MenuPrint.="     det_blob:'".$Data['DET_BLOB']."', \n"; 
                $MenuPrint.="     men_view:'" . $Data ['MEN_VIEW'] . "', \n";
                
                $MenuPrint.="     leaf:true \n";
                break;
           }
        $MenuPrint.="},\n";
    }
    $MenuPrint = substr($MenuPrint, 0, strlen($MenuPrint) - strlen(";\n"));
    return $MenuPrint;
}

/**
 * Funcion que transforma en una cadena no valida ( enie => &Ntilde;&oacute; etc)
 * @param	string   $Cadena              (string)    Cadena que pueda contener caracteres no validos
 * @param   bool     $ConvertComillas     (boolean)   true :Transforma los caracteres especial : " ' 
 * @return	(string)                         Una cadena con formato HTML
 * */
function fn_returnStringFormatHTML($Cadena, $ConvertComillas=false) {
    $lstCharError = array("�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�" , "�");
    $lstConvert = array("&ntilde;", "&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Ntilde;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&ordm;");

    if ($ConvertComillas == true) {
        array_push($lstCharError, "\"");
        array_push($lstCharError, "'");
        array_push($lstConvert, "&quot;");
        array_push($lstConvert, "&apos");
    }
    return str_replace($lstCharError, $lstConvert, $Cadena);
}


function fn_enviaremail($lstr_correo,$as_titulo=null, $as_mensaje=null, $as_from=null,$as_fromname=null){
			
				$mail= new PHPMailer();
				$mail->IsSMTP();
				$mail->SMTPDebug = false;
				$mail->SMTPAuth = false;
				$mail->Host = 'smtp.luxottica.com'; 
				$mail->Port = 25;
				$mail->SingleTo = false;//Se desactiva para enviar mÃ¡s de un email
				$mail->From =$as_from;
                                $mail->FromName = $as_fromname;
				$mail->Subject = $as_titulo;
				$mail->Body = $as_mensaje;
				$mail->IsHTML(true);

				foreach($lstr_correo as $a => $c){
					$mail->AddAddress($c,$a);
				}
				if($mail->Send()){
					$lb_retorno=true;

				}else{
					$lb_retorno=false;
				}
                                
				$mail->ClearAddresses();
		 
                                return $lb_retorno;   
}

/*funcion para validar email*/
function fn_validaremail($as_email){
    
            if (true == filter_var($as_email, FILTER_VALIDATE_EMAIL))
                    return 1;
                    else
                    return 0; 
            
 } 
 
 function fn_emailmessage($as_consulta,$as_estado,$as_respuesta=null){
  
        $message .= "<head><title>Sistema Registro de Ticket - GMO</title></head>\n\r";
	$message .= "<style>\n\r";
	$message .= "TD {font-family : Arial, Helvetica, sans-serif;font-size : 8pt;} \n\r";
	$message .= "INPUT, SELECT, OPTION {font-family : Arial, Helvetica, sans-serif;font-size : 7pt;} \n\r";
	$message .= "BODY, TH {font-family : Arial, Helvetica, sans-serif;font-size : 8pt;} \n\r";
	$message .= ".dest {font-size : 8pt;font-weight : bold;} \n\r";
	$message .= "</style>\n\r";
	$message .= "<BR>\n\r";
	$message .= "<BR>\n\r";
	$message .= "<BR>\n\r";
	$message .= "    <table border=0  style='border: 1px solid Gray;'>\n\r";
	$message .= "              <tr>\n\r";
	$message .= "                    <th colspan='15' style='background: #D9D9D9; border: 1px solid Gray;'>Sistema Registro de Ticket</th>\n\r";
	$message .= "             </tr>\n\r";
	$message .= "            <tr>\n\r";
	$message .= "                <td>\n\r";
	$message .= "    			         <table cellspacing='2' cellpadding='2' bordercolor='#CCCCCC' style='border: 1px solid Gray;'>\n\r";
        $message .= "    			              <tr><td align='left' class='dest'>Consulta:</td><td>".$as_consulta."</td></tr>\n\r";
        $message .= "    			              <tr><td align='left' class='dest'>Estado:</td><td>".$as_estado."</td></tr>\n\r";
        if ($as_respuesta!==null){
            $message .= "    			              <tr><td align='left' class='dest'>Respuesta:</td><td>".$as_respuesta."</td></tr>\n\r";
        }
	$message .= "    			          </table>\n\r";
	$message .= "                </td>\n\r";
	$message .= "            </tr>\n\r";
	$message .= "              <tr>\n\r";
	$message .= "                <td align='center'>\n\r";
	$message .= "    			         <table cellspacing='2' cellpadding='2' bordercolor='#CCCCCC' style='border: 0px solid Gray;'>\n\r";
	$message .= "    			              <tr><td align='center'>Atte.</td>\n\r";
	$message .= "    			              <tr><td align='center'>Sistema Registro de Ticket - GMO</td></tr>\n\r";
	$message .= "    			          </table>\n\r";
	$message .= "                </td>\n\r";
	$message .= "              </tr>\n\r";
	$message .= "    </table>\n\r";
        
        return $message;
 }
 
 function fn_extensionfile(){
     
      return $lstExtension = array(
                    "doc"=>"application/msword",
                    "pdf"=>"application/pdf",
                    "jpg"=>"image/jpeg", 
                    "rar"=>"application/rar", 
                    "xls"=>"application/excel", 
                    "txt"=>"application/plain",
                    "ppt"=>"application/vnd.ms-powerpoint");
 }
