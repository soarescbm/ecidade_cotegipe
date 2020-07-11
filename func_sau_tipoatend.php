<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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
include("classes/db_sau_tipoatend_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clsau_tipoatend = new cl_sau_tipoatend;
$clsau_tipoatend->rotulo->label("sd45_i_codigo");
$clsau_tipoatend->rotulo->label("sd45_v_descricao");
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
            <td width="4%" align="right" nowrap title="<?=$Tsd45_i_codigo?>">
              <?=$Lsd45_i_codigo?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
                       db_input("sd45_i_codigo",10,$Isd45_i_codigo,true,"text",4,"","chave_sd45_i_codigo");
                       ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Tsd45_v_descricao?>">
              <?=$Lsd45_v_descricao?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
                       db_input("sd45_v_descricao",60,$Isd45_v_descricao,true,"text",4,"","chave_sd45_v_descricao");
                       ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="button" id="limpar" value="Limpar" onClick="js_limpar();">
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_sau_tipoatend.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?
      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_sau_tipoatend.php")==true){
             include("funcoes/db_func_sau_tipoatend.php");
           }else{
           $campos = "sau_tipoatend.*";
           }
        }
        if(isset($chave_sd45_i_codigo) && (trim($chave_sd45_i_codigo)!="") ){
                 $sql = $clsau_tipoatend->sql_query("",$campos,"sd45_v_descricao"," sd45_i_codigo = $chave_sd45_i_codigo AND sd45_i_programa = $programa");
        }else if(isset($chave_sd45_v_descricao) && (trim($chave_sd45_v_descricao)!="") ){
                 $sql = $clsau_tipoatend->sql_query("",$campos,"sd45_v_descricao"," sd45_v_descricao like '$chave_sd45_v_descricao%' AND sd45_i_programa = $programa");
        }else{
           $sql = $clsau_tipoatend->sql_query("",$campos,"sd45_v_descricao"," sd45_i_programa = $programa");
        }
        $repassa = array();
        if(isset($chave_sd45_i_codigo)){
          $repassa = array("chave_sd45_i_codigo"=>$chave_sd45_i_codigo,"chave_sd45_i_codigo"=>$chave_sd45_i_codigo);
        }
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clsau_tipoatend->sql_record($clsau_tipoatend->sql_query("","*",""," sd45_i_programa = $programa AND sd45_i_codigo = $pesquisa_chave"));
          if($clsau_tipoatend->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$sd45_v_descricao',false);</script>";
          }else{
                 echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") n�o Encontrado',true);</script>";
          }
        }else{
               echo "<script>".$funcao_js."('',false);</script>";
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
  </script>
  <?
}
?>
<script>
function js_limpar(){
document.form2.chave_sd45_i_codigo.value="";
document.form2.chave_sd45_v_descricao.value="";	
}
js_tabulacaoforms("form2","chave_sd45_v_descricao",true,1,"chave_sd45_v_descricao",true);
</script>