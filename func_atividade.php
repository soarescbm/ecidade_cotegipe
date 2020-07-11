<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
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
include("classes/db_ativid_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clativid = new cl_ativid;
$clativid->rotulo->label("q03_ativ");
$clativid->rotulo->label("q03_descr");

$clrotulo = new rotulocampo;
$clrotulo->label('q71_estrutural');
$clrotulo->label('rh70_estrutural');

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr> 
    <td height="63" align="center" valign="top">
        <table width="35%" border="0" align="center" cellspacing="0">
	     <form name="form2" method="post" action="" >
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tq03_ativ?>">
              <?=$Lq03_ativ?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("q03_ativ",8,$Iq03_ativ,true,"text",4,"","chave_q03_ativ");
		       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tq03_descr?>">
              <?=$Lq03_descr?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("q03_descr",40,$Iq03_descr,true,"text",4,"","chave_q03_descr");
		       ?>
            </td>
          </tr>

    <?

      if(isset($tipo_pesquisa) && $tipo_pesquisa == 'cnpj' ){
    ?>

          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tq71_estrutural?>">
              <?=$Lq71_estrutural?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("q71_estrutural",8,$Iq71_estrutural,true,"text",4,"","chave_q71_estrutural");
		       ?>
            </td>
          </tr>
     <?
      }else{
     ?>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Trh70_estrutural?>">
              <?=$Lrh70_estrutural?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		       db_input("rh70_estrutural",8,$Irh70_estrutural,true,"text",4,"","chave_rh70_estrutural");
		       ?>
            </td>
          </tr>

     <?
      }
     ?>
     

          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?

      $repassa = array("tipo_pesquisa"=>@$tipo_pesquisa);

      $sAnd   = "";
      $sWhere = ""; 
      if (isset($mei)) {
        $sWhere = " not exists (select 1 from atividcnae where atividcnae.q74_ativid = ativid.q03_ativ ) ";
        $sAnd = " and ";
      }
      
      if( isset($tipo_pesquisa) && $tipo_pesquisa == 'cnpj'){

        $data_atual = date('Y-m-d',db_getsession('DB_datausu'));
        $sWhere .= $sAnd."(q03_limite is null or q03_limite >= '$data_atual')";
        if(!isset($pesquisa_chave)){
          if(isset($campos)==false){
             if(file_exists("funcoes/db_func_ativid.php")==true){
               include("funcoes/db_func_ativid.php");
             }else{
             $campos = "ativid.*,cnae.q71_estrutural,cnae.q71_descr";
             }
          }
          if(isset($chave_q03_ativ) && (trim($chave_q03_ativ)!="") ){
             $sql = $clativid->sql_query_cnae($chave_q03_ativ,$campos,"q03_ativ","$sWhere and  q03_ativ = $chave_q03_ativ");
             //die($sql);
          }else if(isset($chave_q03_descr) && (trim($chave_q03_descr)!="") ){
             $sql = $clativid->sql_query_cnae("",$campos,"q03_descr"," q03_descr ilike '$chave_q03_descr%' and  $sWhere");
          }else if(isset($chave_q71_estrutural) && (trim($chave_q71_estrutural)!="") ){
             $sql = $clativid->sql_query_cnae("",$campos,"q71_estrutural"," q71_estrutural ilike '%$chave_q71_estrutural%' and  $sWhere");
          }else{
             $sql = $clativid->sql_query_cnae("",$campos,"q03_ativ","$sWhere");
          }
          db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
        }else{
          if($pesquisa_chave!=null && $pesquisa_chave!=""){
            $result = $clativid->sql_record($clativid->sql_query($pesquisa_chave,"*","","$sWhere and $pesquisa_chave = q03_ativ"));
            if($clativid->numrows!=0){
              db_fieldsmemory($result,0);
              echo "<script>".$funcao_js."('$q03_descr','$q03_horaini','$q03_horafim',false);</script>";
            }else{
             echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") n�o Encontrado',true);</script>";
            }
          }else{
           echo "<script>".$funcao_js."('',false);</script>";
          }
        }

      } else {
      
        $data_atual = date('Y-m-d',db_getsession('DB_datausu'));
        $sWhere .= $sAnd."(q03_limite is null or q03_limite >= '$data_atual')";
        if(!isset($pesquisa_chave)){
          if(isset($campos)==false){
             if(file_exists("funcoes/db_func_ativid.php")==true){
               include("funcoes/db_func_ativid.php");
             }else{
             $campos = "ativid.*,rhcbo.rh70_estrutural,rhcbo.rh70_descr";
             }
          }
          if(isset($chave_q03_ativ) && (trim($chave_q03_ativ)!="") ){
             $sql = $clativid->sql_query_cbo($chave_q03_ativ,$campos,"q03_ativ","$sWhere and  q03_ativ = $chave_q03_ativ");
             //die($sql);
          }else if(isset($chave_q03_descr) && (trim($chave_q03_descr)!="") ){
             $sql = $clativid->sql_query_cbo("",$campos,"q03_descr"," q03_descr ilike '$chave_q03_descr%' and  $sWhere");
          }else if(isset($chave_rh70_estrutural) && (trim($chave_rh70_estrutural)!="") ){
             $sql = $clativid->sql_query_cbo("",$campos,"rh70_estrutural"," rh70_estrutural ilike '%$chave_rh70_estrutural%' and  $sWhere");
          }else{
             $sql = $clativid->sql_query_cbo("",$campos,"q03_ativ","$sWhere");
          }

          db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
        }else{
          if($pesquisa_chave!=null && $pesquisa_chave!=""){
            $result = $clativid->sql_record($clativid->sql_query($pesquisa_chave,"*","","$sWhere and $pesquisa_chave = q03_ativ"));
            if($clativid->numrows!=0){
              db_fieldsmemory($result,0);
              echo "<script>".$funcao_js."('$q03_descr','$q03_horaini','$q03_horafim',false);</script>";
            }else{
             echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") n�o Encontrado',true);</script>";
            }
          }else{
           echo "<script>".$funcao_js."('',false);</script>";
          }
        }


      
      }

      ?>
     </td>
   </tr>
</table>
</body>
</html>
<?
if(!isset($pesquisa_chave)){
  ?>
  <script>
    document.form2.chave_q03_descr.focus();
    document.form2.chave_q03_descr.select();
  </script>
  <?
}
?>