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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_sau_fatorderisco_classe.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$clsau_fatorderisco = new cl_sau_fatorderisco;
$clsau_fatorderisco->rotulo->label("s105_i_codigo");
$clsau_fatorderisco->rotulo->label("s105_v_descricao");
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
            <td width="4%" align="right" nowrap title="<?=$Ts105_i_codigo?>">
              <?=$Ls105_i_codigo?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		          db_input("s105_i_codigo",10,$Is105_i_codigo,true,"text",4,"","chave_s105_i_codigo");
		          ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?=$Ts105_v_descricao?>">
              <?=$Ls105_v_descricao?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
		          db_input("s105_v_descricao",50,$Is105_v_descricao,true,"text",4,"","chave_s105_v_descricao");
		          ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_sau_fatorderisco.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?
      if (!isset($pesquisa_chave)) {
        if (isset($campos)==false) {
           if (file_exists("funcoes/db_func_sau_fatorderisco.php")==true) {
             require_once("funcoes/db_func_sau_fatorderisco.php");
           } else {
           $campos = "sau_fatorderisco.*";
           }
        }
        if (isset($chave_s105_i_codigo) && (trim($chave_s105_i_codigo) != '')) {

	         $sql = $clsau_fatorderisco->sql_query($chave_s105_i_codigo, $campos, "s105_i_codigo");

        } elseif (isset($chave_s105_v_descricao) && (trim($chave_s105_v_descricao) != '')) {

	         $sql = $clsau_fatorderisco->sql_query(null, $campos, "s105_v_descricao",
                                                 " s105_v_descricao like '$chave_s105_v_descricao%' "
                                                );

        } else {
           $sql = $clsau_fatorderisco->sql_query(null, $campos, 's105_i_codigo', '');
        }

        $repassa = array();
        if (isset($chave_s105_i_codigo)) {
          $repassa = array("chave_s105_i_codigo"=>$chave_s105_i_codigo,"chave_s105_i_codigo"=>$chave_s105_i_codigo);
        }
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
      } else {
        if ($pesquisa_chave!=null && $pesquisa_chave!="") {
          $result = $clsau_fatorderisco->sql_record($clsau_fatorderisco->sql_query($pesquisa_chave));
          if ($clsau_fatorderisco->numrows!=0) {
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$s105_i_codigo',false);</script>";
          } else {
	         echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") n�o Encontrado',true);</script>";
          }
        } else {
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
if (!isset($pesquisa_chave)) {
  ?>
  <script>
  </script>
  <?
}
?>
<script>
js_tabulacaoforms("form2","chave_s105_i_codigo",true,1,"chave_s105_i_codigo",true);
</script>