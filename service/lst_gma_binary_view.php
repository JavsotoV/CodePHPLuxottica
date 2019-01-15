<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    header( 'Content-type: text/html; charset=utf-8;' );
    
    require_once ("../mda/clsgmaBinary.php");
    require_once ("../utiles/fnUtiles.php");
    
    try {$blob=null;
        
            $Variables = filter_input_array(INPUT_GET, [
                'tck_codigo' => FILTER_VALIDATE_INT,
                'sga_codigo' => FILTER_VALIDATE_INT,
                'bin_filename'=> FILTER_UNSAFE_RAW
            ]);
            
            if (( $Variables === NULL ) || ( $Variables === false )) {
                throw new Exception('No ha definido los parametros');
            }

            if (in_array(false, $Variables, true)) {
                throw new Exception('Fallo en la validacion de los parametros de envio');
            }
            
            $lstExtension = fn_extensionfile();

            $ln_pos = strpos($Variables['bin_filename'], '.');
            
            $ls_tipo = strtolower(substr($Variables['bin_filename'],$ln_pos+1));
            
            $luo_binary = new clsgmaBinary();    
                
            $blob=$luo_binary->lst_get_blob($Variables['tck_codigo'], $Variables['sga_codigo']);
                                                    
            if ($blob == NULL) {
                    throw new Exception('Error obteniendo informacion de documento adjunto');
             }
            
            header("Content-Type:".$lstExtension[$ls_tipo]);             
            
             if (strtolower($ls_tipo)!='pdf'){
                
                 if (strpos(strtolower($ls_tipo),'pdf')<1){
                
                        header('Content-disposition: attachment; filename="'.$Variables['bin_filename'].'"'); 
                 }
             }     
            
            echo $blob;
              
            unset($luo_binary);
              
            }
    catch(Exception $ex){
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
           
