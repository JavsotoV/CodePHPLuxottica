<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("c:/xamp/htdocs/library/legal/clsgcaArchilog.php");
require_once("c:/xamp/htdocs/library/legal/clsgcaEnviarEmail.php");

/*if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}*/

$ln_pai_codigo =1;//$paramAccion = $Variables ['pai_codigo'];

$luo_archilog = new clsgcaArchilog();

$luo_enviaremail = new clsgcaEnviarEmail();

$rowdata = $luo_archilog->lst_enviaremail(1);

$data = $luo_enviaremail->EditContrato($ln_pai_codigo);

echo $data;

unset($luo_archilog);
unset($luo_enviaremail);







