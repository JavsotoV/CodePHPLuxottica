<?php

    header('Content-type: text/html; charset=utf-8;');
    header('Cache-Control: no-cache');

    require_once ("../utiles/fnUtiles.php");
    require_once ( "../../excel/PHPExcel.php");
    require_once ( "../../excel/PHPExcel/Cell/AdvancedValueBinder.php");
    require_once ( "../../excel/PHPExcel/IOFactory.php");
    require_once ("../logistica/clsmtaImportar.php");
    require_once ('../security/clssegSession.php');
    require_once('../Base/clsViewData.php');


extract($_POST);

$name = $_FILES['bin_blob']['name']; 
$tname = $_FILES['bin_blob']['tmp_name'];
$type = $_FILES['bin_blob']['type'];

$parametros =[];
$rowdata    =[];

$parametros['accion']           = $_POST['accion'];
$parametros['tipfamcod']        = $_POST['tipfamcod'];
$parametros['imp_origen']       = $_POST['imp_origen'];
$parametros['pai_codigo']       = $_POST['pai_codigo'];
$parametros['imp_observacion']  = $_POST['imp_observacion'];

session_start();

$luo_segsesion = new clssegSession();
$user_codigo=$luo_segsesion->get_per_codigo();

if (!isset($user_codigo)){
    
    echo clsViewData::showError('-1', 'Sesion de usuario a terminado');
    
    return;
}

$luo_imp = new clsmtaImportar($user_codigo);

if ($type=='application/vnd.ms-excel')
    {$ext = 'Excel5';
        }
    elseif ($type=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
    {$ext='Excel2007';
        }
    else{
        echo json_encode(['success'=>false,'data'=>'']);
        exit;
    }

$objReader = PHPExcel_IOFactory::createReader($ext);

$objReader->setReadDataOnly(true);
 
$objPHPExcel = $objReader->load($tname);

$objWorksheet = $objPHPExcel->getActiveSheet();

$fil=0;
$col=0;
$filadata=6;
$ln_rowcount=0;

if(!$luo_imp->of_conectar()){return;}
 
foreach ($objWorksheet->getRowIterator() as $row) {
 
    $cellIterator = $row->getCellIterator();
    
    $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,

    $col=0;
    $fil++;
    
    if ($fil>$filadata){
        
        $ln_rowcount++;
        
                foreach ($cellIterator as $cell) {
                         $data[$col] =  $cell->getValue();
                         $col++;
                }
               
                if ($imp_origen==1) {                
                    $parametros['cdg']              = $data[0];
                    $parametros['codigobarras']     = $data[1];  
                    $parametros['codsap']           = $data[2];  
                    $parametros['descripcion']      = $data[3];
                    $parametros['familia']          = $data[4];  
                    $parametros['subfam']           = $data[5];
                    $parametros['grupofam']         = $data[6];  
                    $parametros['alias']            = $data[7];
                    
                    if ($tipfamcod=='C'){
                        $parametros['colores']          = $data[8];
                        $parametros['material']         = $data[9];
                        $parametros['indref']           = $data[10];
                        $parametros['desdediametro']    = $data[11];
                        $parametros['hastadiametro']    = $data[12];
                        $parametros['desdecilindro']    = $data[13];
                        $parametros['hastacilindro']    = $data[14];
                        $parametros['desdeesfera']      = $data[15];
                        $parametros['hastaesfera']      = $data[16];
                       }
                                             
                    if ($tipfamcod=='M'){
                        $parametros['colores']          = $data[8];
                        $parametros['material']         = $data[9];
                        $parametros['altura']           = $data[10];
                        $parametros['calibre']          = $data[11];
                        $parametros['cilindro']         = $data[12];
                        $parametros['diagonal']         = $data[13];
                        $parametros['horizontal']       = $data[14];
                        $parametros['curvabase']        = $data[15];
                        $parametros['largovarilla']     = $data[16];
                }    
                                             
                    if ($tipfamcod=='G') {
                        $parametros['material']         = $data[8];
                        $parametros['colorc']           = $data[9];
                        $parametros['colorm']           = $data[10];
                        $parametros['graduable']        = $data[11];
                        $parametros['sexo']             = $data[12];
                        $parametros['diagonal']         = $data[13];
                        $parametros['horizontal']       = $data[14];
                        $parametros['altura']           = $data[15];
                        $parametros['curvabase']        = $data[16];
                        $parametros['puente']           = $data[17];
                        $parametros['largovarilla']     = $data[18];
                        $parametros['polarized']        = $data[19];                    
                }
                
                    if ($tipfamcod=='L'){
                        $parametros['colores']         = $data[8];
                        $parametros['marca']           = $data[9];
                        $parametros['zonaop']          = $data[10];
                        $parametros['eje']             = $data[11];
                        $parametros['radio']           = $data[12];
                        $parametros['desdeesfera']     = $data[13];
                        $parametros['hastaesfera']     = $data[14];
                        $parametros['curvabase']       = $data[15];
                        $parametros['diametro']        = $data[16];
                        $parametros['cilindro']        = $data[17];
                }                             
            }
            
            if ($imp_origen==2){
                        $parametros['codsap']          = $data[0];
                        $parametros['tarifa']          = $data[1];
                        $parametros['precioiva']       = $data[2];                   
            }            
            
            if ($imp_origen==3) {
                        $parametros['codsap']          = $data[0];
                        $parametros['familia']         = $data[1];
                        $parametros['subfam']          = $data[2];
                        $parametros['grupofam']        = $data[3];
                        $parametros['descatalogado']   = $data[4];
            } 
            
            $luo_imp->loadData($parametros);  
            
            $rowdata = $luo_imp->sp_mta_importar($parametros['accion']);                  
    }      
 }
 
 $luo_imp->of_desconectar();
 
 unset($luo_imp); 

 echo $rowdata;

