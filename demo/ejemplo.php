<?php

//Funcion que lee un archivo de texto y lo mete en una cadena 

function leef ($fichero) {

    $texto = file($fichero);

    $tamleef = sizeof($texto);

    for ($n=0;$n<$tamleef;$n++) {$todo= $todo.$texto[$n];}

    return $todo;

}

 
//funcion que genera un rtf 

function rtf($plantilla, $fsalida, $dato,$valor){

    
    $fsalida="../plantilla/".$fsalida;

    //Paso no 1.-Leo una plantilla rtf 

    $txtplantilla = leef($plantilla);

    //echo "plantilla: ".$txtplantilla;exit;

    $matriz=explode("sectd", $txtplantilla);

    $cabecera=$matriz[0]."sectd";

    $inicio=strlen($cabecera);

    $final=strrpos($txtplantilla,"}");

    $largo=$final-$inicio;

    $cuerpo=substr($txtplantilla, $inicio, $largo);

    //Paso no.3 Escribo el fichero 

    $punt = fopen($fsalida, "w");

    fputs($punt, $cabecera);
    
    $despues=str_replace($dato,$valor,$cuerpo);

    /*foreach ($matequivalencias as $dato) {

        $datosql='$row->$dato[1]';

        $datosql= stripslashes ($datosql);

        $datortf='$dato[0]';

        $despues=str_replace($datortf,$datosql,$despues);

    }*/

    fputs($punt,$despues);

    $saltopag="\par \page \par";

    fputs($punt,$saltopag);

    fputs($punt,"}");

    fclose ($punt);

    return $fsalida;
}

$plantilla = "../plantilla/descuento.rtf";

  $campo = Array('#*fechactual*#',
                 '#*nom_user*#',
                 '#*freg*#',
                 '#*monto*#');
  
        $dato = Array('12/02/2018',
                      'jesus',
                      '02/02/2048',
                      '158.63');
  

$salida = rtf( $plantilla, "certificado.rtf", $campo,$dato);

$salida ="<A href='.$salida.'>Obtener RTF</a>"; 

echo '<p>$salida</p>';


?>