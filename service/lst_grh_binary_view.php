<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 //header( 'Content-type: text/html; charset=utf-8;' );
    //header('Content-Type: application/rtf');
    
    require_once ("../global/clsglbTemplate.php");
    require_once ("../rrhh/clsgrhSolgrhcb.php");
    require_once ("../utiles/fnUtiles.php");
    
    try{
        $Variables = filter_input_array(INPUT_GET, [
                'cdg' => FILTER_VALIDATE_INT
            ]);
        
        if (( $Variables === NULL ) || ( $Variables === false )) {
                throw new Exception('No ha definido los parametros');
        }

        if (in_array(false, $Variables, true)) {
                throw new Exception('Fallo en la validacion de los parametros de envio');
        }
        
        $luo_sol = new clsgrhSolgrhcb();
         
        $rowdata = $luo_sol->lst_listar($Variables['cdg'], '', '$as_criterio', '01/01/1900', '01/01/1900', 1, 30);
        
        $data = json_decode($rowdata,true);
        
        $ln_nrocuota=$data['data']['0']['nrocuota'];
        
        $ln_impcuota = $data['data']['0']['monto'];
        
        if ($ln_nrocuota>0) {$ln_impcuota =$data['data']['0']['monto']/$ln_nrocuota;  }
        
        unset($luo_sol);        
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <title></title>
          <script>
             function getBrowserInfo() {
                var ua= navigator.userAgent, tem, 
                    M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
                    if(/trident/i.test(M[1])){
                        tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
                        return 'IE '+(tem[1] || '');
                }
                    if(M[1]=== 'Chrome'){
                        tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
                        if(tem!= null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
                    }
                    M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
                    if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
                    return M.join(' ');
                };
    
            function Imprime () {
                
                var es_ie = getBrowserInfo();
                           
                if (es_ie.indexOf('IE')>-1){
                     var ficha   = document.getElementById("rptsolicitud");
                     var ventimp = window.open('','popimpr');
                     ventimp.document.write(ficha.innerHTML);
                     ventimp.document.close();
                     ventimp.print();
                     ventimp.close();
                     return true;}
                else{
                    window.print();
                }
            }            
        </script>
    </head>
    <body onload="Imprime();">
         <div id ="rptsolicitud">  
           <p align="right"><img src="../../images/logo/gmo_logo.jpg"></p>
           <br></br>
           <p align="center"><strong>AUTORIZACION  PARA DESCUENTO POR PLANILLA</strong></p>
           <br></br>
           <p align="right"><?php echo $data['data']['0']['fechactual']?></p>
           <br></br>
           <p>Estimado(a) <strong><?php echo $data['data']['0']['nombre_user']?></strong> de acuerdo a su  solicitud realizada con fecha <?php echo $data['data']['0']['freg']?> se autoriza descuento por planilla bajo  la siguiente modalidad. <br>
           <table border="0" aling="center">
            <tr>
                <td width="131" valign="top"><p>Monto Total:</p></td>
                <td width="95" valign="top"><p><?php echo number_format($data['data']['0']['monto'],2)?></p></td>
            </tr>
            <tr>
                <td width="131" valign="top"><p>Nro. Cuotas:</p></td>
                <td width="95" valign="top"><p><?php echo $ln_nrocuota;?></p></td>
            </tr>
            <tr>
                <td width="131" valign="top"><p>Cuota Mensual:</p></td>
                <td width="95" valign="top"><p><?php echo number_format($ln_impcuota,2);?></p></td>
            </tr>
            </table>
            <br>
            Autorizo en forma voluntaria a mi empleador, Opticas GMO Chile S.A, que, a traves del Departamento de Personal y  Remuneraciones, se me efectue el descuento desde mis remuneraciones en forma  mensual del convenio solicitado.</p>
            <p>&nbsp;</p>
            <br></br>
            <p align="center">_____________________________<br>Firma de Trabajador.</p>
          </div>        
        </body>
    
</html>
<?php
} catch (Exception $ex) {
    echo clsViewData::showError( $ex->getCode(), $ex->getMessage() );
}
?>