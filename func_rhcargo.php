<?php

/**
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_rhcargo_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clrhcargo = new cl_rhcargo;
$clrhcargo->rotulo->label("rh04_codigo");
$clrhcargo->rotulo->label("rh04_descr");
?>
<html xmlns="http://www.w3.org/1999/html">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr> 
    <td height="63" align="center" valign="top">
      <form name="form2" method="post" action="" >
        <fieldset style="width: 35%">
          <legend>Pesquisa de Fun��o</legend>
          <table width="35%" border="0" align="center" cellspacing="0">
            <tr>
              <td width="4%" align="left" nowrap title="<?=$Trh04_codigo?>">
                <?=$Lrh04_codigo?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
             db_input("rh04_codigo",5,$Irh04_codigo,true,"text",4,"","chave_rh04_codigo");
             ?>
              </td>
            </tr>
            <tr>
              <td width="4%" align="left" nowrap title="<?=$Trh04_descr?>">
                <?=$Lrh04_descr?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
             db_input("rh04_descr",40,$Irh04_descr,true,"text",4,"","chave_rh04_descr");
             ?>
              </td>
            </tr>
          </table>
        </fieldset>
        <table width="35%" border="0" align="center" cellspacing="0">
          <tr>
            <td colspan="2" align="center">
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_rhcargo.hide();">
            </td>
          </tr>
        </table>
      </form>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top">
      <fieldset>
        <legend>Resultado da Pesquisa</legend>
      <?
      $where = " rh04_instit = ".db_getsession("DB_instit");
      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_rhcargo.php")==true){
             include("funcoes/db_func_rhcargo.php");
           }else{
           $campos = "rhcargo.*";
           }
        }
        if(isset($chave_rh04_codigo) && (trim($chave_rh04_codigo)!="") ){
	         $sql = $clrhcargo->sql_query($chave_rh04_codigo,db_getsession("DB_instit"),$campos,"rh04_codigo");
        }else if(isset($chave_rh04_descr) && (trim($chave_rh04_descr)!="") ){
	         $sql = $clrhcargo->sql_query("",db_getsession("DB_instit"),$campos,"rh04_descr"," rh04_descr like '$chave_rh04_descr%' and $where");
        }else{
           $sql = $clrhcargo->sql_query("",db_getsession("DB_instit"),$campos,"rh04_codigo","");
        }
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clrhcargo->sql_record($clrhcargo->sql_query($pesquisa_chave,db_getsession("DB_instit")));
          if($clrhcargo->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$rh04_descr',false);</script>";
          }else{
	         echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") n�o Encontrado',true);</script>";
          }
        }else{
	       echo "<script>".$funcao_js."('',false);</script>";
        }
      }
      ?>
     </fieldset>
     </td>
   </tr>
</table>
</body>
</html>
<?
if(!isset($pesquisa_chave)){
  ?>
  <script>
  </script>
  <?
}
?>