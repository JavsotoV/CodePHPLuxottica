<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once ('../security/clssegSession.php');

if (isset($_POST) && ( count($_POST) )) {
    $Variables = filter_input_array(INPUT_POST);
} else {
    $Variables = filter_input_array(INPUT_GET);
}

$app_modulo = $Variables ['app'];

$luo_session = new clssegSession();

$luo_session->lst_cerrar();

header ("Location:../../".$app_modulo); 

unset($luo_session);