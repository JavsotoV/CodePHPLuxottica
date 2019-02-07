<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("../Base/DbSql.php");
require_once("../Base/fncscript.php");
require_once("../Base/clsViewData.php");

 $luo_con = new DbSql();
 
     $ls_sql="sp_trk_lst_encargodetalle";
            
     $ls_sqldet="sp_trk_find_fechaprogramada";
     
     $an_pai_codigo=4;
     
     $as_encargo='059/0017994';
     
      if(!$luo_con->createConexion()){print_r(clsViewData::showError($luo_con->getICodeError(), $luo_con->getSMsgError()));}
            
            $stmt=mssql_init($ls_sql,$luo_con->refConexion);
            
            if (!$stmt){
                
                $luo_con->closeConexion();
                
                print_r(clsViewData::showError(-1, 'Error iniciando procedimiento sp_trk_lst_encargodetalle'));
            }
            
            mssql_bind($stmt,'@an_pai_codigo',$an_pai_codigo,SQLINT1,false,false,10);
            
            mssql_bind($stmt,'@as_encargo',$as_encargo,SQLVARCHAR,false,false,20);
            
            $result = $luo_con->sqlsrvExecute($stmt);
            
            mssql_free_statement($stmt);
            
            if (!$result){print_r(clsViewData::showError(-1, 'error ejecutanndo procedimiento sp_trk_lst_encargodetalle'));}
            
            /*------tenemos que colocar la fecha programada para entrega -------*/
            if (($an_pai_codigo==1) || ($an_pai_codigo==4)){
                
                $stmtdet=mssql_init($ls_sqldet,$luo_con->refConexion);
                
                $ln_fila=0;
                $ls_grupo='';
                $ld_fechaprogramada=null;
                
                while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) 
                {
                
                    if ($ls_grupo!=$row['grupo']){
                        
                        $ls_grupo=$row['grupo'];
                        
                        $ld_fechaprogramada=null;
                        
                        mssql_bind($stmtdet,'@as_encargo', $as_encargo, SQLVARCHAR, false, false, 20);
                    
                        mssql_bind($stmtdet,'@as_grupo', $ls_grupo, SQLVARCHAR, false, false, 10);
                    
                        $resultdet=mssql_execute($stmtdet);
                    
                        if (!$resultdet){
                            print_r(clsViewData::showError(-1, 'Error obteniendo detalle de encargo '.$ls_grupo));
                            echo '</br>';
                        
                        }
                    
                        while ($rowdet = mssql_fetch_array($resultdet, MSSQL_ASSOC)) {
                            $ld_fechaprogramada= $rowdet['fechaprogramada'];                    
                        }
                    }
                    
                    $row['fechaprogramada']=$ld_fechaprogramada;
                    
                    $lstArray[] = $row;                    
                    //mssql_free_statement($stmtdet);
                }            
            }else{
                while ($row = mssql_fetch_array($result, MSSQL_ASSOC)) 
                {
                    $lstArray[] = $row;
                }
            }
            
            //$rowdata= clsViewData::viewData(mssqlparsear($result),false);
            
            $rowdata= clsViewData::viewData($lstArray,false);
           
            mssql_free_statement($stmtdet);
            
            $luo_con->closeConexion();
             
            unset($luo_con);
            
                        
            print_r('</br>'.$rowdata);