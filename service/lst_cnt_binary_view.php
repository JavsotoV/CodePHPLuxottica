<?php
    header( 'Content-type: text/html; charset=utf-8;' );
    
    require_once ("../contenido/clscntBinary.php");
    require_once ("../utiles/fnUtiles.php");
    
    try {
          $blob=null;
        
        $Variables = filter_input_array(INPUT_GET, [
                'det_codigo'   => FILTER_VALIDATE_INT,
                'bin_filename' => FILTER_UNSAFE_RAW
            ]);

            if (( $Variables === NULL ) || ( $Variables === false )) {
                throw new Exception('No ha definido los parametros');
            }

            if (in_array(false, $Variables, true)) {
                throw new Exception('Fallo en la validacion de los parametros de envio');
            }

            $luo_binary = new clscntBinary();    
                
            $blob=$luo_binary->lst_get_blob($Variables['det_codigo']);
                                                    
            if ($blob == NULL) {
                    throw new Exception('Registro seleccionado no contiene documento PDF ');
             }
            
             $lstExtension= fn_extensionfile();
             
             $ln_pos = strpos($Variables['bin_filename'], '.');
            
             $ls_tipo = strtolower(substr($Variables['bin_filename'],$ln_pos+1));
                                
             header("Content-Type: ".$lstExtension[strtolower($ls_tipo)]);    
                        
             if (strtolower($ls_tipo)!='pdf'){
                
                 if (strpos(strtolower($ls_tipo),'pdf')<1){
                
                        header('Content-disposition:attachment; filename='.$Variables['bin_filename']);   
                }
             }
             
            echo $blob;
              
            unset($luo_binary);
                
    } catch (Exception $ex) {
?>
<style type="text/css">           
            body {
                font-family:Tahoma;              
                font-size: 10px;
            }
            
            body:after {
                content: "<?php echo ( $ex->getMessage() );?>"; 
                font-size: 7em;  
                color: rgba(52, 166, 214, 0.4);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                text-align: center;

                -webkit-pointer-events: none;
                -moz-pointer-events: none;
                -ms-pointer-events: none;
                -o-pointer-events: none;
                pointer-events: none;

                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                -o-user-select: none;
                user-select: none;
            }
        </style>
        <html>
            <head>
                
            </head>
            <body>
                
            </body>
        </html>
<?php
    }
?>